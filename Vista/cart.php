<?php
require_once __DIR__ . '/../Control/Session.php';
require_once __DIR__ . '/../Control/autenticacion.php';
require_once __DIR__ . '/../Control/roles.php';
require_once __DIR__ . '/../Control/ABMCompra.php';
require_once __DIR__ . '/../Control/ABMCompraProducto.php';
require_once __DIR__ . '/../Control/ABMProducto.php';

$session = new Session();
requireLogin($session); // redirige a login si no hay sesión
$idUsuario = $session->getIdUsuario();

$abmCompra = new ABMCompra();
$compras = $abmCompra->buscar(['idUsuario' => $idUsuario]);
if (empty($compras)) {
    header("Location: /TrabajoFinalPWD/Vista/tienda.php?msg=no_carrito");
    exit;
}

$ultimaCompra = end($compras);
$idUltimaCompra = $ultimaCompra->getID();

$abmCompraProducto = new ABMCompraProducto();
$comprasProductos = $abmCompraProducto->buscar(['idCompra' => $idUltimaCompra]);
// print_r($comprasProductos);
if (empty($comprasProductos)) {
    header("Location: /TrabajoFinalPWD/Vista/tienda.php?msg=carrito_vacio");
    exit;
}
$abmProducto = new ABMProducto();


include_once('../Vista/structure/header.php');
?>
<!-- resto de la vista carrito -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>    
    <link rel="shortcut icon" href="/TrabajoFinalPWD/Vista/sources/logo.png" type="image/x-icon">
    <title>Carrito</title>
</head>
<body class="flex flex-col min-h-screen bg-gray-50">
<?php include_once ('../Vista/structure/header.php'); ?>

<main class="flex-grow max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-2xl font-semibold mb-6">Tu carro de compras</h1>

    <div id="cart-root" class="bg-white rounded-xl shadow p-6">

        <?php if (empty($comprasProductos)): ?>
            <div class="text-center text-gray-500 py-12">
                No hay productos en el carrito.
            </div>
        <?php else: ?>

            <div id="items" class="space-y-4">
                <?php $precioTotal = 0;?>
                <?php foreach ($comprasProductos as $unaCompraItem): ?>
                    <?php 
                        $idProducto = $unaCompraItem->getIdProducto();
                        $producto = $abmProducto->buscar(['id' => $idProducto])[0];
                    ?>

                    <div class="flex items-center gap-4 p-4 border rounded-lg shadow-sm bg-gray-50">
                        <img 
                            src="/TrabajoFinalPWD/<?php echo $producto->getImagen(); ?>" 
                            alt="<?= $producto->getNombre(); ?>" 
                            class="w-20 h-20 object-cover rounded-md border"
                        >

                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-800">
                                <?= $producto->getNombre(); ?>
                            </h3>
                            <p class="text-orange-600 font-semibold text-xl">
                                $<?= number_format($producto->getPrecio(), 0, ',', '.'); ?>
                                <?php $precioTotal = $precioTotal + $producto->getPrecio()?>
                            </p>
                        </div>

                        <form method="POST" action="accion/accionQuitarCarrito.php">
                            <?php // print_r($unaCompraItem);
                            // echo ($unaCompraItem->getId());?>
                            <input type="hidden" name="id" value="<?= $unaCompraItem->getId(); ?>">
                            <button 
                                class="text-red-600 hover:text-red-800 font-semibold"
                                type="submit"
                            >
                                Quitar
                            </button>
                        </form>
                    </div>

                <?php endforeach; ?>
            </div>

            <div id="summary" class="mt-6">
                <div class="flex justify-between items-center">
                    <div class="text-lg font-medium">Total</div>
                    <div id="totalPrice" class="text-xl font-bold text-orange-600">
                        $<?php echo $precioTotal ?>
                    </div>
                </div>

<div class="mt-4 flex items-center gap-2">
    <a href="/TrabajoFinalPWD/Vista/tienda.php" 
       class="inline-block bg-gray-100 px-4 py-2 rounded hover:bg-gray-200">
        Seguir Comprando
    </a>

    <form method="POST" action="../Control/createCheckout.php" class="inline-flex">
        <input type="hidden" name="precioTotal" value="<?= $precioTotal; ?>">

        <button 
            type="submit"
            class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700"
        >
            Finalizar Compra
        </button>
    </form>
</div>

            </div>

        <?php endif; ?>

    </div>
</main>


<?php include_once ('../Vista/structure/footer.php'); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    function readCart() {
        try { return JSON.parse(localStorage.getItem('cart') || '[]'); }
        catch (e) { return []; }
    }
    function writeCart(cart) {
        localStorage.setItem('cart', JSON.stringify(cart));
        window.dispatchEvent(new Event('cartUpdated'));
    }
    function render() {
        const cart = readCart();
        const empty = document.getElementById('empty');
        const itemsEl = document.getElementById('items');
        const summary = document.getElementById('summary');
        if (!cart || cart.length === 0) {
            empty.classList.remove('hidden');
            itemsEl.classList.add('hidden');
            summary.classList.add('hidden');
            return;
        }
        empty.classList.add('hidden');
        itemsEl.classList.remove('hidden');
        summary.classList.remove('hidden');
        itemsEl.innerHTML = '';
        let total = 0;
        cart.forEach(item => {
            total += (item.price || 0) * (item.qty || 1);
            const row = document.createElement('div');
            row.className = 'flex items-center gap-4';
            row.innerHTML = `
                <img src="${item.image}" class="w-20 h-20 object-cover rounded" alt="${item.name}">
                <div class="flex-1">
                    <div class="font-medium text-gray-800">${item.name}</div>
                    <div class="text-sm text-gray-500">$${(item.price || 0).toLocaleString()}</div>
                </div>
                <div class="flex items-center gap-2">
                    <button class="qty-decrease px-2 py-1 bg-gray-100 rounded">-</button>
                    <div class="px-3">${item.qty}</div>
                    <button class="qty-increase px-2 py-1 bg-gray-100 rounded">+</button>
                    <button class="remove ml-4 text-red-500">Eliminar</button>
                </div>
            `;
            // attach handlers after append
            itemsEl.appendChild(row);
            const idx = cart.indexOf(item);
            row.querySelector('.qty-increase').addEventListener('click', () => {
                cart[idx].qty = (cart[idx].qty || 0) + 1;
                writeCart(cart);
                render();
            });
            row.querySelector('.qty-decrease').addEventListener('click', () => {
                cart[idx].qty = Math.max(1, (cart[idx].qty || 1) - 1);
                writeCart(cart);
                render();
            });
            row.querySelector('.remove').addEventListener('click', () => {
                cart.splice(idx, 1);
                writeCart(cart);
                render();
            });
        });
        document.getElementById('totalPrice').textContent = '$' + total.toLocaleString();
    }

    render();
    // react to updates from other pages/tabs
    window.addEventListener('storage', (e) => { if (e.key === 'cart') render(); });
    window.addEventListener('cartUpdated', render);

    // Checkout button (placeholder)
    document.getElementById('checkoutBtn').addEventListener('click', () => {
        alert('Aquí iría el flujo de pago. (Demo)');
    });
});
</script>
</body>
</html>