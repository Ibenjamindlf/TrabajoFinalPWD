<?php
include_once("../Control/ABMProducto.php");
$abmProducto = new ABMProducto();
$arrayProductos = $abmProducto->buscar(NULL);
if ($arrayProductos != null) {
    $cantProductos = count($arrayProductos);
} else {
    $cantProductos = 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>    
    <link rel="shortcut icon" href="/TrabajoFinalPWD/Vista/sources/logo.png" type="image/x-icon">
    <title>Tienda</title>
</head>
<body class="flex flex-col min-h-screen bg-gray-50">
<?php
    include_once ('../Vista/structure/header.php');
?>
<main class="flex-grow bg-gray-100 py-12">
    <div class="container mx-auto mt-12 px-4"> <div class="text-center mb-12">
    <?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] === 'no_carrito'): ?>
        <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-2 rounded my-2">
            No tienes un carrito activo. Agrega un producto para crear uno.
        </div>
    <?php elseif ($_GET['msg'] === 'carrito_vacio'): ?>
        <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-2 rounded my-2">
            No tienes productos en el carrito. Agrega uno por favor.
        </div>
    <?php endif; ?>
<?php endif; ?>
            <h2 class="text-3xl font-bold">Nuestros Productos</h2>
            <p class="text-gray-600 mt-2">Explorá nuestros productos destacados</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php if ($cantProductos > 0): ?>
                <?php foreach ($arrayProductos as $unProducto) { ?>
                    
                    <div class="bg-white rounded-lg overflow-hidden h-full shadow-sm border-0 flex flex-col">
                        
                        <img src="/TrabajoFinalPWD/<?php echo $unProducto->getImagen(); ?>" 
                             alt="<?php echo $unProducto->getNombre(); ?>" 
                             class="w-full h-[220px] object-cover">
                        
                        <div class="p-4 flex flex-col justify-between flex-grow">
                            <div>
                                <h5 class="text-xl font-semibold text-gray-900 mb-2">
                                    <?php echo $unProducto->getNombre(); ?>
                                </h5>
                                <p class="text-sm text-gray-500">
                                    <?php echo $unProducto->getDetalle(); ?>
                                </p>
                            </div>
                            <div class="mt-4 text-sm text-gray-700">
                                <?php echo number_format($unProducto->getStock(), 0) ?> unidades disponibles
                            </div>
                            <div class="mt-4">
                                <p class="font-bold text-orange-600 mb-2">
                                    $<?php echo number_format($unProducto->getPrecio(), 2, ',', '.'); ?>
                                </p>
<div class="flex gap-2">
    <button 
        data-product="2" 
        class="w-1/2 flex justify-center items-center bg-orange-600 text-white py-2 rounded-lg hover:bg-orange-700 transition">
        Ver producto
    </button>

    <a 
        href="accion/accionAgregarAlCarrito.php?idProducto=<?php echo $unProducto->getId(); ?>"
        class="w-1/2 flex justify-center items-center bg-gray-900 text-white py-2 rounded-lg hover:bg-gray-800 transition">
        Agregar al carrito
    </a>
</div>

                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php elseif ($cantProductos <= 0): ?>
                <div class="flex justify-center items-center text-center grid col-span-4 mt-12 mb-12"><p class="font-bold uppercase">No hay productos disponibles.</p/></div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
    include_once ('../Vista/structure/footer.php');
?>

<!-- <script>
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
</script> -->
</body>
</html>