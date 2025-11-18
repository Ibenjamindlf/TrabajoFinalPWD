<?php
// Inicio validacion para la pagina segura
require_once __DIR__ . '/../Control/Session.php';

$session = new Session();
// $session->iniciar(); // inicia session_start() si no está iniciada

if (!$session->validar()) {
    // Si NO hay session activa lo redirige
    header("Location: login.php");
    exit;
}
// Fin validacion pagina segura
// Si hay session activa ejecuta normalmente el codigo
include_once('../Vista/structure/header.php');
?>
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
        <div id="empty" class="text-center text-gray-500 py-12">No hay productos en el carrito.</div>
        <div id="items" class="space-y-4 hidden"></div>
        <div id="summary" class="mt-6 hidden">
            <div class="flex justify-between items-center">
                <div class="text-lg font-medium">Total</div>
                <div id="totalPrice" class="text-xl font-bold text-orange-600">$0</div>
            </div>
            <div class="mt-4">
                <a href="/TrabajoFinalPWD/Vista/tienda.php" class="inline-block mr-2 bg-gray-100 px-4 py-2 rounded hover:bg-gray-200">Seguir Comprando</a>
                <button id="checkoutBtn" class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">Finalizar Compra</button>
            </div>
        </div>
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