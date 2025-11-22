<?php
require_once __DIR__ . '/../../../Control/Session.php';
require_once __DIR__ . '/../../../Control/ABMCompraProducto.php';

$session = new Session();

if (!$session->activa()) {
    header('Location: /TrabajoFinalPWD/Vista/login.php');
    exit;
}

$idCompraProducto = $_POST['idCompraProducto'] ?? null;

if ($idCompraProducto) {
    $abmCompraProducto = new ABMCompraProducto();
    
    $abmCompraProducto->quitarProductoDelCarrito(['idCompraProducto' => $idCompraProducto]);
}

header("Location: ../../cart.php");
exit;
?>