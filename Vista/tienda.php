<?php
include_once("../Control/ABMProducto.php");
$abmProducto = new ABMProducto();
$arrayProductos = $abmProducto->buscar(NULL);
if ($arrayProductos != null) {
    $cantProductos = count($arrayProductos);
} else {
    $cantProductos = 0;
}
?>s
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>    
    <link rel="shortcut icon" href="/TrabajoFinalPWD/Vista/sources/logo.png" type="image/x-icon">
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
    <title>Tienda</title>
</head>
<body class="flex flex-col min-h-screen bg-gray-50">
<?php
    include_once ('../Vista/structure/header.php');
?>
<main class="bg-light py-5">
    <div class="container mt-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary">Nuestros Productos</h2>
            <p class="text-muted">Explorá nuestros productos destacados</p>
        </div>

        <div class="row g-4">
            <?php if ($cantProductos > 0): ?>
                <?php foreach ($arrayProductos as $unProducto) { ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="/TrabajoFinalPWD/<?php echo $unProducto->getImagen(); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo $unProducto->getNombre(); ?>" 
                                 style="height: 220px; object-fit: cover; border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
                            
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title fw-semibold text-dark">
                                        <?php echo $unProducto->getNombre(); ?>
                                    </h5>
                                    <p class="card-text text-muted small">
                                        <?php echo $unProducto->getDetalle(); ?>
                                    </p>
                                </div>
                                <div class="mt-3">
                                    <p class="fw-bold text-success mb-2">
                                        $<?php echo number_format($unProducto->getPrecio(), 2, ',', '.'); ?>
                                    </p>
                                    <!-- <a href="verProducto.php?id=<?php echo $unProducto->getId(); ?>" 
                                       class="btn btn-primary w-100 fw-semibold">
                                        Ver más
                                    </a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    No hay productos disponibles por el momento.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>
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