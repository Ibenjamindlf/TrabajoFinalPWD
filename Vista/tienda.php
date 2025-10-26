<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="/TrabajoFinalPWD/Vista/sources/logo.png" type="image/x-icon">
    <title>Tienda</title>
</head>
<body class="flex flex-col min-h-screen bg-gray-50">
<?php
    include_once ('../Vista/structure/header.php');
?>
<main class="flex-grow">
    <section class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-semibold text-gray-800 mb-8 text-center">Productos Destacados</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Product 1 -->
            <div class="bg-white rounded-xl shadow p-4 flex flex-col">
                <img src="https://avatars.githubusercontent.com/u/68124872?v=4" alt="Producto 1" class="w-full h-40 object-cover rounded-md mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Producto 1</h2>
                <p class="text-indigo-600 font-bold mt-1">$12.499</p>
                <p class="text-sm text-gray-500 mt-2 flex-grow">Descripción del producto 1.</p>
                <div class="mt-4 flex gap-2">
                    <button data-product="1" class="view-product w-1/2 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">Ver producto</button>
                    <button data-add="1" class="add-cart w-1/2 bg-gray-900 text-white py-2 rounded-lg hover:bg-gray-800 transition">Agregar</button>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="bg-white rounded-xl shadow p-4 flex flex-col">
                <img src="https://avatars.githubusercontent.com/u/68124872?v=4" alt="Producto 2" class="w-full h-40 object-cover rounded-md mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Producto 2</h2>
                <p class="text-indigo-600 font-bold mt-1">$8.299</p>
                <p class="text-sm text-gray-500 mt-2 flex-grow">Descripción del producto 2.</p>
                <div class="mt-4 flex gap-2">
                    <button data-product="2" class="view-product w-1/2 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">Ver producto</button>
                    <button data-add="2" class="add-cart w-1/2 bg-gray-900 text-white py-2 rounded-lg hover:bg-gray-800 transition">Agregar</button>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="bg-white rounded-xl shadow p-4 flex flex-col">
                <img src="https://avatars.githubusercontent.com/u/68124872?v=4" alt="Producto 3" class="w-full h-40 object-cover rounded-md mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Producto 3</h2>
                <p class="text-indigo-600 font-bold mt-1">$6.750</p>
                <p class="text-sm text-gray-500 mt-2 flex-grow">Descripción del producto 3.</p>
                <div class="mt-4 flex gap-2">
                    <button data-product="3" class="view-product w-1/2 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">Ver producto</button>
                    <button data-add="3" class="add-cart w-1/2 bg-gray-900 text-white py-2 rounded-lg hover:bg-gray-800 transition">Agregar</button>
                </div>
            </div>

            <!-- Product 4 -->
            <div class="bg-white rounded-xl shadow p-4 flex flex-col">
                <img src="https://avatars.githubusercontent.com/u/68124872?v=4" alt="Producto 4" class="w-full h-40 object-cover rounded-md mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Producto 4</h2>
                <p class="text-indigo-600 font-bold mt-1">$2.199</p>
                <p class="text-sm text-gray-500 mt-2 flex-grow">Descripción del producto 4.</p>
                <div class="mt-4 flex gap-2">
                    <button data-product="4" class="view-product w-1/2 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">Ver producto</button>
                    <button data-add="4" class="add-cart w-1/2 bg-gray-900 text-white py-2 rounded-lg hover:bg-gray-800 transition">Agregar</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Modals (one per product) -->
    <div id="modals-container" aria-hidden="true">
        <div id="modal-1" class="product-modal fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50 p-4">
            <div class="bg-white rounded-lg max-w-2xl w-full overflow-y-auto relative" style="max-height: calc(100vh - 4rem);">
                <button class="modal-close absolute top-3 right-3 text-gray-600 hover:text-gray-800">&times;</button>
                <div class="md:flex">
                    <img src="https://avatars.githubusercontent.com/u/68124872?v=4" alt="" class="w-full md:w-1/2 h-64 object-cover">
                    <div class="p-6 md:w-1/2">
                        <h3 class="text-2xl font-semibold">Producto 1</h3>
                        <p class="text-indigo-600 font-bold mt-2">$12.499</p>
                        <p class="text-gray-600 mt-4">Descripción del producto 1.</p>
                        <div class="mt-6 flex gap-2">
                            <button data-add="1" class="modal-add bg-gray-900 text-white py-2 px-4 rounded-lg hover:bg-gray-800 transition">Agregar al carrito</button>
                            <button class="modal-close bg-gray-100 py-2 px-4 rounded-lg hover:bg-gray-200 transition">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="modal-2" class="product-modal fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50 p-4">
            <div class="bg-white rounded-lg max-w-2xl w-full overflow-y-auto relative" style="max-height: calc(100vh - 4rem);">
                <button class="modal-close absolute top-3 right-3 text-gray-600 hover:text-gray-800">&times;</button>
                <div class="md:flex">
                    <img src="https://avatars.githubusercontent.com/u/68124872?v=4" alt="" class="w-full md:w-1/2 h-64 object-cover">
                    <div class="p-6 md:w-1/2">
                        <h3 class="text-2xl font-semibold">Producto 2</h3>
                        <p class="text-indigo-600 font-bold mt-2">$8.299</p>
                        <p class="text-gray-600 mt-4">Descripción del producto 2.</p>
                        <div class="mt-6 flex gap-2">
                            <button data-add="2" class="modal-add bg-gray-900 text-white py-2 px-4 rounded-lg hover:bg-gray-800 transition">Agregar al carrito</button>
                            <button class="modal-close bg-gray-100 py-2 px-4 rounded-lg hover:bg-gray-200 transition">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="modal-3" class="product-modal fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50 p-4">
            <div class="bg-white rounded-lg max-w-2xl w-full overflow-y-auto relative" style="max-height: calc(100vh - 4rem);">
                <button class="modal-close absolute top-3 right-3 text-gray-600 hover:text-gray-800">&times;</button>
                <div class="md:flex">
                    <img src="https://avatars.githubusercontent.com/u/68124872?v=4" alt="" class="w-full md:w-1/2 h-64 object-cover">
                    <div class="p-6 md:w-1/2">
                        <h3 class="text-2xl font-semibold">Producto 3</h3>
                        <p class="text-indigo-600 font-bold mt-2">$6.750</p>
                        <p class="text-gray-600 mt-4">Descripción del producto 3.</p>
                        <div class="mt-6 flex gap-2">
                            <button data-add="3" class="modal-add bg-gray-900 text-white py-2 px-4 rounded-lg hover:bg-gray-800 transition">Agregar al carrito</button>
                            <button class="modal-close bg-gray-100 py-2 px-4 rounded-lg hover:bg-gray-200 transition">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="modal-4" class="product-modal fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50 p-4">
            <div class="bg-white rounded-lg max-w-2xl w-full overflow-y-auto relative" style="max-height: calc(100vh - 4rem);">
                <button class="modal-close absolute top-3 right-3 text-gray-600 hover:text-gray-800">&times;</button>
                <div class="md:flex">
                    <img src="https://avatars.githubusercontent.com/u/68124872?v=4" alt="" class="w-full md:w-1/2 h-64 object-cover">
                    <div class="p-6 md:w-1/2">
                        <h3 class="text-2xl font-semibold">Producto 4</h3>
                        <p class="text-indigo-600 font-bold mt-2">$2.199</p>
                        <p class="text-gray-600 mt-4">Descripción del producto 4.</p>
                        <div class="mt-6 flex gap-2">
                            <button data-add="4" class="modal-add bg-gray-900 text-white py-2 px-4 rounded-lg hover:bg-gray-800 transition">Agregar al carrito</button>
                            <button class="modal-close bg-gray-100 py-2 px-4 rounded-lg hover:bg-gray-200 transition">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast container -->
    <div id="toast-container" class="fixed right-4 bottom-4 z-60 space-y-2"></div>
</main>

<?php
    include_once ('../Vista/structure/footer.php');
?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Mapa de datos de los 4 productos (usado para guardar en localStorage)
    const products = {
        1: { id: 1, name: 'Producto 1', price: 12499, image: 'https://avatars.githubusercontent.com/u/68124872?v=4' },
        2: { id: 2, name: 'Producto 2', price: 8299, image: 'https://avatars.githubusercontent.com/u/68124872?v=4' },
        3: { id: 3, name: 'Producto 3', price: 6750, image: 'https://avatars.githubusercontent.com/u/68124872?v=4' },
        4: { id: 4, name: 'Producto 4', price: 2199, image: 'https://avatars.githubusercontent.com/u/68124872?v=4' },
    };

    function readCart() {
        try { return JSON.parse(localStorage.getItem('cart') || '[]'); }
        catch (e) { return []; }
    }
    function writeCart(cart) {
        localStorage.setItem('cart', JSON.stringify(cart));
        // disparar evento storage para otras pestañas/frames
        window.dispatchEvent(new Event('cartUpdated'));
    }

    function addToCart(id, qty = 1) {
        const p = products[id];
        if (!p) return;
        const cart = readCart();
        const found = cart.find(i => i.id === id);
        if (found) found.qty = (found.qty || 0) + qty;
        else cart.push({ id: p.id, name: p.name, price: p.price, image: p.image, qty });
        writeCart(cart);
    }

    function updateHeaderCount() {
        const cart = readCart();
        const totalQty = cart.reduce((s, i) => s + (i.qty || 0), 0);
        const el = document.getElementById('cartCount');
        if (el) el.textContent = totalQty;
    }

    // open modal buttons
    document.querySelectorAll('.view-product').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-product');
            const modal = document.getElementById('modal-' + id);
            if (modal) modal.classList.remove('hidden');
        });
    });

    // close modal buttons
    document.querySelectorAll('.modal-close').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = btn.closest('.product-modal');
            if (modal) modal.classList.add('hidden');
        });
    });

    // click outside modal to close
    document.querySelectorAll('.product-modal').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.add('hidden');
        });
    });

    // toast helper
    function showToast(message) {
        const container = document.getElementById('toast-container');
        const t = document.createElement('div');
        t.className = 'bg-gray-900 text-white px-4 py-2 rounded shadow';
        t.textContent = message;
        container.appendChild(t);
        setTimeout(() => t.remove(), 2200);
    }

    // botones "Agregar" en cards y modales
    document.querySelectorAll('.add-cart, .modal-add').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = Number(btn.getAttribute('data-add'));
            addToCart(id, 1);
            updateHeaderCount();
            showToast('Producto agregado al carrito');
            // si estaba en modal, cerrarlo
            const modal = btn.closest('.product-modal');
            if (modal) modal.classList.add('hidden');
        });
    });

    // inicializar contador al cargar
    updateHeaderCount();

    // actualizar contador si se modifica en otra pestaña
    window.addEventListener('storage', (e) => { if (e.key === 'cart') updateHeaderCount(); });
    // custom event from writeCart
    window.addEventListener('cartUpdated', updateHeaderCount);
});
</script>
</body>
</html>