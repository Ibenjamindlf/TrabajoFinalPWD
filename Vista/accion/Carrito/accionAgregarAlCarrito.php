<?php
require_once __DIR__ . '/../../../Control/Session.php';
require_once __DIR__ . '/../../../Control/ABMCompraProducto.php';

$session = new Session();

if (!$session->activa()) {
    header('Location: /TrabajoFinalPWD/Vista/login.php');
    exit;
}

$idUsuario = $session->getIdUsuario();
$idProducto = $_GET['idProducto'] ?? null;

// Validar Datos
if (!$idProducto) {
    header('Location: /TrabajoFinalPWD/Vista/tienda.php');
    exit;
}

// Llamar al Controlador 
$abmCompraProducto = new ABMCompraProducto();
$exito = $abmCompraProducto->agregarProductoAlCarrito([
    'idUsuario' => $idUsuario,
    'idProducto' => $idProducto,
    'cantidad' => 1
]);

// VERIFICAMOS SI FUE UN PEDIDO AJAX (JAVASCRIPT)
$esAjax = isset($_GET['ajax']) && $_GET['ajax'] == 'true';

if ($exito) {
    if ($esAjax) {
        echo json_encode(['status' => 'success', 'msg' => 'Producto agregado']);
    } else {
        header("Location: /TrabajoFinalPWD/Vista/cart.php");
    }
} else {
    if ($esAjax) {
        echo json_encode(['status' => 'error', 'msg' => 'No se pudo agregar (Stock o Error)']);
    } else {
        header("Location: /TrabajoFinalPWD/Vista/tienda.php?msg=error_agregar");
    }
}
exit;
?>