<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Model_Producto extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    protected $table = 'products';

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    protected $fillable = ['name', 'description', 'category', 'price', 'stock', 'image', 'is_active'];

    protected function casts(): array
    {
        return ['price' => 'decimal:2', 'stock' => 'integer', 'is_active' => 'boolean'];
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(Model_OrdenItem::class, 'product_id');
    }
}
