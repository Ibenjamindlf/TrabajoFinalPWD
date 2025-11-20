<?php
require_once __DIR__ . '/../Control/Session.php';
require_once __DIR__ . '/../Control/ABMCompra.php';
require_once __DIR__ . '/../Control/ABMCompraProducto.php';
require_once __DIR__ . '/../Control/ABMProducto.php';
require_once __DIR__ . '/../Control/ABMCompraEstado.php';

$session = new Session();
if (!$session->activa()) { header('Location: /TrabajoFinalPWD/Vista/login.php'); exit; }

$idUsuario = $session->getIdUsuario();

// Buscar carrito activo
$abmCompra = new ABMCompra();
$abmCompraEstado = new ABMCompraEstado();
$compras = $abmCompra->buscar(['idUsuario' => $idUsuario]);
$idCompraActiva = null;

if (!empty($compras)) {
    $compras = array_reverse($compras);
    foreach ($compras as $compra) {
        $estados = $abmCompraEstado->buscar(['idCompra' => $compra->getId(), 'fechaFinNull' => true]);
        if (!empty($estados) && $estados[0]->getIdEstadoTipo() == 1) {
            $idCompraActiva = $compra->getId();
            break;
        }
    }
}

$comprasProductos = [];
if ($idCompraActiva != null) {
    $abmCompraProducto = new ABMCompraProducto();
    $comprasProductos = $abmCompraProducto->buscar(['idCompra' => $idCompraActiva]);
}
$abmProducto = new ABMProducto();

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
<main class="flex-grow max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-2xl font-semibold mb-6">Tu carro de compras</h1>
    <div class="bg-white rounded-xl shadow p-6">
        <?php if (empty($comprasProductos)): ?>
            <div class="text-center text-gray-500 py-12">
                <p class="mb-4">Tu carrito está vacío.</p>
                <a href="/TrabajoFinalPWD/Vista/tienda.php" class="text-orange-600 hover:underline">Ir a la tienda</a>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php $precioTotal = 0; ?>
                <?php foreach ($comprasProductos as $item): ?>
                    <?php 
                        $prodArr = $abmProducto->buscar(['id' => $item->getIdProducto()]);
                        if (empty($prodArr)) continue; 
                        $producto = $prodArr[0];
                        $subtotal = $producto->getPrecio() * $item->getCantidad();
                        $precioTotal += $subtotal;
                    ?>
                    <div class="flex items-center gap-4 p-4 border rounded-lg bg-gray-50">
                        <img src="/TrabajoFinalPWD/<?php echo $producto->getImagen(); ?>" class="w-20 h-20 object-cover rounded border">
                        <div class="flex-1">
                            <h3 class="font-medium"><?= $producto->getNombre(); ?></h3>
                            <p class="text-gray-500 text-sm">Cantidad: <?= $item->getCantidad(); ?></p>
                            <p class="text-orange-600 font-bold">$<?= number_format($subtotal, 2); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mt-6 border-t pt-4 flex justify-between items-center">
                <div class="text-xl font-bold">Total: $<?php echo number_format($precioTotal, 2); ?></div>
                
                <form method="POST" action="../Control/createCheckout.php">
                    <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700 transition">
                        Pagar con Stripe
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php include_once ('../Vista/structure/footer.php'); ?>
</body>
</html>