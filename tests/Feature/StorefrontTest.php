<?php

namespace Tests\Feature;

use App\Models\Model_ConfiguracionTienda;
use App\Models\Model_Orden;
use App\Models\Model_Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_catalog_displays_active_products_and_product_detail(): void
    {
        $product = Model_Producto::factory()->create(['name' => 'Producto visible']);
        Model_Producto::factory()->create(['is_active' => false]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Producto visible')
            ->assertDontSee('🥑')
            ->assertDontSee('🥬')
            ->assertDontSee('🍎');

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('Producto visible')
            ->assertSee('Agregar al carrito');
    }

    public function test_product_detail_displays_active_products_from_its_category(): void
    {
        $product = Model_Producto::factory()->create(['category' => 'Bebidas']);
        $related = Model_Producto::factory()->create(['name' => 'Bebida relacionada', 'category' => 'Bebidas']);
        Model_Producto::factory()->create(['name' => 'Producto de otra categoría', 'category' => 'Despensa']);
        Model_Producto::factory()->create(['name' => 'Producto inactivo relacionado', 'category' => 'Bebidas', 'is_active' => false]);

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('Bebida relacionada')
            ->assertDontSee('Producto de otra categoría')
            ->assertDontSee('Producto inactivo relacionado')
            ->assertSee('Productos relacionados en Bebidas')
            ->assertSee('Ver más')
            ->assertSee('href="'.route('products.show', $related).'"', false);

        $this->assertModelExists($related);
    }

    public function test_product_detail_shows_other_active_products_when_its_category_has_no_matches(): void
    {
        $product = Model_Producto::factory()->create(['category' => 'Abarrotes']);
        $alternative = Model_Producto::factory()->create(['name' => 'Producto alternativo', 'category' => 'Bebidas']);

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('Productos que te pueden interesar')
            ->assertSee('Producto alternativo')
            ->assertSee('href="'.route('products.show', $alternative).'"', false);
    }

    public function test_product_detail_keeps_related_section_visible_when_no_other_products_are_available(): void
    {
        $product = Model_Producto::factory()->create(['category' => 'Abarrotes']);

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('Productos que te pueden interesar')
            ->assertSee('Pronto encontrarás más productos aquí')
            ->assertSee(route('home').'#productos');
    }

    public function test_login_page_renders_the_professional_store_branded_form(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Administración de tienda')
            ->assertSee('Iniciar sesión')
            ->assertSee('Ingresar al panel')
            ->assertSee('name="email"', false)
            ->assertSee('name="password"', false)
            ->assertSee('action="'.route('login.store').'"', false)
            ->assertDontSee('data-open-cart', false);
    }

    public function test_public_header_has_a_login_icon_next_to_the_cart(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('aria-label="Iniciar sesión"', false)
            ->assertSee('data-open-cart', false)
            ->assertDontSee('Administración');
    }

    public function test_cart_rejects_quantities_above_available_stock(): void
    {
        $product = Model_Producto::factory()->create(['stock' => 2]);

        $this->from(route('products.show', $product))
            ->post(route('carrito.store', $product), ['quantity' => 3])
            ->assertRedirect(route('products.show', $product))
            ->assertSessionHasErrors('quantity');

        $this->assertSame([], session('cart', []));
    }

    public function test_adding_a_product_returns_to_catalog_with_the_cart_drawer_open(): void
    {
        $product = Model_Producto::factory()->create(['stock' => 3]);

        $this->from(route('products.show', $product))
            ->post(route('carrito.store', $product), ['quantity' => 1])
            ->assertRedirect(route('products.show', $product))
            ->assertSessionHas('cart', [$product->id => 1])
            ->assertSessionHas('cart_open', true);

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('data-open="true"', false)
            ->assertSee($product->name);
    }

    public function test_checkout_creates_order_decrements_stock_and_clears_cart(): void
    {
        $product = Model_Producto::factory()->create(['price' => 12.50, 'stock' => 5]);
        $customer = [
            'customer_name' => 'María Pérez',
            'email' => 'maria@example.com',
            'phone' => '55512345',
            'shipping_address' => 'Calle Principal 123',
            'payment_method' => 'bank_transfer',
        ];

        $this->withSession(['cart' => [$product->id => 2]])
            ->get(route('checkout.create'))
            ->assertOk()
            ->assertSee('Datos de envío y pago');

        Model_ConfiguracionTienda::query()->findOrFail(1)->update(['currency_code' => 'USD']);
        $response = $this->post(route('checkout.store'), $customer);

        $order = Model_Orden::query()->firstOrFail();
        $response->assertRedirect(route('checkout.success', $order));
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'customer_name' => 'María Pérez',
            'total' => 25,
        ]);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'subtotal' => 25,
        ]);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'currency_code' => 'USD',
        ]);
        $this->assertSame(3, $product->fresh()->stock);
        $response->assertSessionMissing('cart');
        $response->assertSessionHas('last_order_id', $order->id);
        Model_ConfiguracionTienda::query()->findOrFail(1)->update(['currency_code' => 'PEN']);
        $this->get(route('checkout.success', $order))
            ->assertOk()
            ->assertSee('María Pérez')
            ->assertSee('Total: $ 25.00');
    }

    public function test_checkout_rejects_stale_cart_when_inventory_is_insufficient(): void
    {
        $product = Model_Producto::factory()->create(['stock' => 1]);

        $this->withSession(['cart' => [$product->id => 2]])
            ->post(route('checkout.store'), [
                'customer_name' => 'Cliente Ejemplo',
                'email' => 'cliente@example.com',
                'phone' => '55512345',
                'shipping_address' => 'Calle Principal 123',
                'payment_method' => 'bank_transfer',
            ])
            ->assertSessionHasErrors('cart');

        $this->assertDatabaseCount('orders', 0);
        $this->assertSame(1, $product->fresh()->stock);
    }

    public function test_admin_dashboard_and_product_management_require_authentication(): void
    {
        $this->get(route('login'))->assertOk();
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $this->get(route('admin.products.index'))->assertRedirect(route('login'));
        $this->get(route('admin.store-settings.edit'))->assertRedirect(route('login'));
    }

    public function test_authenticated_administrator_can_manage_products(): void
    {
        $this->actingAs(User::factory()->create());
        $this->get(route('admin.dashboard'))->assertOk();
        $this->get(route('admin.profile.edit'))->assertOk();
        $this->get(route('admin.products.create'))->assertOk();
        $this->get(route('admin.store-settings.edit'))->assertOk();
        $data = [
            'name' => 'Producto administrativo',
            'description' => 'Descripción del producto',
            'category' => 'Bebidas',
            'price' => '20.50',
            'stock' => 8,
            'is_active' => 1,
        ];

        $this->post(route('admin.products.store'), $data)
            ->assertRedirect(route('admin.products.index'));

        $product = Model_Producto::query()->firstOrFail();
        $this->assertSame('Producto administrativo', $product->name);
        $this->assertSame('Bebidas', $product->category);
        $this->get(route('admin.products.edit', $product))->assertOk();
        $this->get(route('admin.products.index'))->assertOk();

        $this->put(route('admin.products.update', $product), [...$data, 'name' => 'Producto actualizado'])
            ->assertRedirect(route('admin.products.index'));
        $this->assertSame('Producto actualizado', $product->fresh()->name);

        $this->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_product_create_and_edit_forms_show_styled_fields_and_live_preview(): void
    {
        $this->actingAs(User::factory()->create());
        $product = Model_Producto::factory()->create([
            'name' => 'Producto de prueba',
            'category' => 'Bebidas',
            'price' => 15.50,
        ]);

        $this->get(route('admin.products.create'))
            ->assertOk()
            ->assertSee('Crear producto')
            ->assertSee('Información del producto')
            ->assertSee('Precio e inventario')
            ->assertSee('data-product-image-preview', false)
            ->assertSee('data-product-name-preview', false)
            ->assertSee('Crear producto');

        $this->get(route('admin.products.edit', $product))
            ->assertOk()
            ->assertSee('Editar producto')
            ->assertSee('Producto de prueba')
            ->assertSee('Guardar cambios')
            ->assertSee('Si no seleccionas otra imagen, se conservará la actual.');
    }

    public function test_authenticated_administrator_can_update_and_render_escaped_store_identity(): void
    {
        $this->actingAs(User::factory()->create());
        $settings = Model_ConfiguracionTienda::query()->findOrFail(1);
        $storeName = 'Tienda <script>alert(1)</script>';

        $this->from(route('admin.store-settings.edit'))
            ->put(route('admin.store-settings.update'), ['store_name' => $storeName, 'currency_code' => 'USD'])
            ->assertRedirect(route('admin.store-settings.edit'))
            ->assertSessionHas('success');

        $this->assertSame($storeName, $settings->fresh()->store_name);
        $this->assertSame('USD', $settings->fresh()->currency_code);
        Model_Producto::factory()->create();

        $this->get(route('home'))
            ->assertOk()
            ->assertSee($storeName)
            ->assertSee('$')
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_store_identity_rejects_non_image_logo_uploads(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create());
        $settings = Model_ConfiguracionTienda::query()->findOrFail(1);

        $this->put(route('admin.store-settings.update'), [
            'store_name' => 'Mi Tienda',
            'currency_code' => 'PEN',
            'logo' => UploadedFile::fake()->create('logo.pdf', 10, 'application/pdf'),
        ])->assertSessionHasErrors('logo');

        $this->assertNull($settings->fresh()->logo_path);
        Storage::disk('public')->assertDirectoryEmpty('store');
    }

    public function test_store_identity_rejects_unsupported_currency_codes(): void
    {
        $this->actingAs(User::factory()->create());
        $settings = Model_ConfiguracionTienda::query()->findOrFail(1);

        $this->put(route('admin.store-settings.update'), [
            'store_name' => 'Mi Tienda',
            'currency_code' => 'EUR',
        ])->assertSessionHasErrors('currency_code');

        $this->assertSame('PEN', $settings->fresh()->currency_code);
    }
}
