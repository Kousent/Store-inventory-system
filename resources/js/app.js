const initializeCartDrawer = () => {
    const drawer = document.querySelector('[data-cart-drawer]');
    const overlay = document.querySelector('[data-cart-overlay]');
    const openButton = document.querySelector('[data-open-cart]');

    if (!drawer || !overlay) {
        return;
    }

    const setOpen = (isOpen) => {
        drawer.classList.toggle('invisible', !isOpen);
        drawer.classList.toggle('translate-x-full', !isOpen);
        overlay.classList.toggle('invisible', !isOpen);
        overlay.classList.toggle('opacity-0', !isOpen);
        overlay.classList.toggle('opacity-100', isOpen);
        overlay.setAttribute('aria-hidden', String(!isOpen));
        document.body.classList.toggle('overflow-hidden', isOpen);
    };

    openButton?.addEventListener('click', () => setOpen(true));
    overlay.addEventListener('click', () => setOpen(false));
    drawer.querySelectorAll('[data-close-cart]').forEach((button) => {
        button.addEventListener('click', () => setOpen(false));
    });
    drawer.querySelectorAll('[data-quantity-step]').forEach((button) => {
        button.addEventListener('click', () => {
            const form = button.closest('form');
            const input = form?.querySelector('input[name="quantity"]');

            if (!form || !input) {
                return;
            }

            const nextQuantity = Number(input.value) + Number(button.dataset.quantityStep);
            const maxQuantity = Number(input.max);

            if (nextQuantity < Number(input.min) || (maxQuantity > 0 && nextQuantity > maxQuantity)) {
                return;
            }

            input.value = String(nextQuantity);
            form.requestSubmit();
        });
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setOpen(false);
        }
    });

    if (overlay.dataset.open === 'true') {
        setOpen(true);
    }
};

const initializeAdminSidebar = () => {
    const sidebar = document.querySelector('[data-admin-sidebar]');
    const overlay = document.querySelector('[data-admin-overlay]');

    if (!sidebar || !overlay) {
        return;
    }

    const setOpen = (isOpen) => {
        sidebar.classList.toggle('-translate-x-full', !isOpen);
        overlay.classList.toggle('hidden', !isOpen);
    };

    document.querySelector('[data-toggle-admin-sidebar]')?.addEventListener('click', () => setOpen(true));
    sidebar.querySelector('[data-close-admin-sidebar]')?.addEventListener('click', () => setOpen(false));
    overlay.addEventListener('click', () => setOpen(false));
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setOpen(false);
        }
    });
};

const initializeQuantityControls = () => {
    document.querySelectorAll('[data-quantity-control]').forEach((control) => {
        control.querySelectorAll('[data-step]').forEach((button) => {
            button.addEventListener('click', () => {
                const input = control.querySelector('input[type="number"]');

                if (!input) {
                    return;
                }

                const nextQuantity = Number(input.value) + Number(button.dataset.step);
                const maxQuantity = Number(input.max);

                if (nextQuantity >= Number(input.min) && (!maxQuantity || nextQuantity <= maxQuantity)) {
                    input.value = String(nextQuantity);
                }
            });
        });
    });
};

const initializeProductFormPreview = () => {
    const form = document.querySelector('[data-product-image]');

    if (!form) {
        return;
    }

    const nameInput = document.querySelector('[data-product-name]');
    const categoryInput = document.querySelector('#product-category');
    const priceInput = document.querySelector('[data-product-price]');
    const stockInput = document.querySelector('[data-product-stock]');
    const imageInput = document.querySelector('[data-product-image]');
    const previewImage = document.querySelector('[data-product-image-preview]');
    const imagePlaceholder = document.querySelector('[data-product-image-placeholder]');
    const fileName = document.querySelector('[data-image-file-name]');
    const defaultFileName = fileName?.textContent ?? '';
    const defaultPreviewSource = previewImage?.getAttribute('src') ?? '';
    const defaultPreviewAlt = previewImage?.alt ?? 'Vista previa del producto';
    let currentImageUrl = null;

    const updateTextPreview = () => {
        const previewName = document.querySelector('[data-product-name-preview]');
        const previewCategory = document.querySelector('[data-product-category-preview]');
        const previewPrice = document.querySelector('[data-product-price-preview]');
        const previewStock = document.querySelector('[data-product-stock-preview]');

        if (previewName) {
            previewName.textContent = nameInput?.value.trim() || 'Nombre del producto';
        }
        if (previewCategory) {
            previewCategory.textContent = categoryInput?.value.trim() || 'Categoría';
        }
        if (previewPrice) {
            const price = Number(priceInput?.value);
            previewPrice.textContent = Number.isFinite(price) ? price.toFixed(2) : '0.00';
        }
        if (previewStock) {
            const stock = Number(stockInput?.value);
            previewStock.textContent = `${Number.isFinite(stock) ? stock : 0} unidades`;
        }
    };

    [nameInput, categoryInput, priceInput, stockInput].forEach((input) => {
        input?.addEventListener('input', updateTextPreview);
    });

    imageInput?.addEventListener('change', () => {
        const image = imageInput.files?.[0];

        if (currentImageUrl) {
            URL.revokeObjectURL(currentImageUrl);
            currentImageUrl = null;
        }

        if (!image) {
            if (previewImage) {
                previewImage.src = defaultPreviewSource;
                previewImage.alt = nameInput?.value.trim() || defaultPreviewAlt;
                previewImage.hidden = !defaultPreviewSource;
            }
            if (imagePlaceholder) {
                imagePlaceholder.hidden = Boolean(defaultPreviewSource);
            }
            if (fileName) {
                fileName.textContent = defaultFileName;
            }
            return;
        }

        currentImageUrl = URL.createObjectURL(image);

        if (previewImage) {
            previewImage.src = currentImageUrl;
            previewImage.alt = nameInput?.value.trim() || 'Vista previa del producto';
            previewImage.hidden = false;
        }
        if (imagePlaceholder) {
            imagePlaceholder.hidden = true;
        }
        if (fileName) {
            fileName.textContent = image.name;
        }
    });

    nameInput?.addEventListener('input', () => {
        if (previewImage && !previewImage.hidden) {
            previewImage.alt = nameInput.value.trim() || 'Vista previa del producto';
        }
    });

    updateTextPreview();
};

document.addEventListener('DOMContentLoaded', () => {
    initializeCartDrawer();
    initializeAdminSidebar();
    initializeQuantityControls();
    initializeProductFormPreview();
});
