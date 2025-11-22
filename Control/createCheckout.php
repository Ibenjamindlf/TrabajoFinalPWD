<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../includes');
$dotenv->load();

include_once(__DIR__ . '/ABMCompra.php');
include_once(__DIR__ . '/ABMCompraProducto.php');
include_once(__DIR__ . '/ABMCompraEstado.php');
include_once(__DIR__ . '/ABMProducto.php');
include_once(__DIR__ . '/Session.php');

$session = new Session();
if (!$session->activa()) { header('Location: /TrabajoFinalPWD/Vista/login.php'); exit; }
$idUsuario = $session->getIdUsuario();

// 1. Buscar Carrito
$abmCompra = new ABMCompra();
$abmCompraEstado = new ABMCompraEstado();
$compras = $abmCompra->buscar(['idUsuario' => $idUsuario]);
$idCompraActiva = null;

if (!empty($compras)) {
    $compras = array_reverse($compras);
    foreach ($compras as $c) {
        $est = $abmCompraEstado->buscar(['idCompra' => $c->getId(), 'fechaFinNull' => true]);
        if (!empty($est) && $est[0]->getIdEstadoTipo() == 1) {
            $idCompraActiva = $c->getId();
            break;
        }
    }
}

if (!$idCompraActiva) { header('Location: /TrabajoFinalPWD/Vista/tienda.php'); exit; }

// 2. Calcular Total
$abmCP = new ABMCompraProducto();
$abmP = new ABMProducto();
$items = $abmCP->buscar(['idCompra' => $idCompraActiva]);
$total = 0;

foreach ($items as $i) {
    $p = $abmP->buscar(['id' => $i->getIdProducto()]);
    if (!empty($p)) $total += ($p[0]->getPrecio() * $i->getCantidad());
}

if ($total <= 0) { header('Location: /TrabajoFinalPWD/Vista/tienda.php'); exit; }

// 3. Stripe
\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

try {
    $sessionStripe = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'mode' => 'payment',
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => ['name' => "Pedido #$idCompraActiva"],
                'unit_amount' => intval($total * 100),
            ],
            'quantity' => 1,
        ]],
        'success_url' => $_ENV['APP_URL'] . '/Vista/accion/Carrito/accionFinalizarCompra.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url'  => $_ENV['APP_URL'] . '/Vista/cart.php?msg=cancelado',
    ]);
    header("Location: " . $sessionStripe->url);
    exit;
} catch (Exception $e) {
    echo "Error Stripe: " . $e->getMessage();
}
?>