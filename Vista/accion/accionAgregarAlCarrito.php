<?php
require_once __DIR__ . '/../../Control/Session.php';
require_once __DIR__ . '/../../Control/ABMCompra.php';
require_once __DIR__ . '/../../Control/ABMCompraProducto.php';
require_once __DIR__ . '/../../Control/ABMCompraEstado.php';

$session = new Session();

// 1. Verificar sesión
if (!$session->activa()) {
    header('Location: /TrabajoFinalPWD/Vista/login.php');
    exit;
}

$idUsuario = $session->getIdUsuario();
$idProducto = $_GET['idProducto'] ?? null;

if (!$idProducto) {
    header('Location: /TrabajoFinalPWD/Vista/tienda.php');
    exit;
}

// 2. Buscar si hay un carrito ABIERTO (Estado 1)
$abmCompra = new ABMCompra();
$abmCompraEstado = new ABMCompraEstado();

$comprasUsuario = $abmCompra->buscar(['idUsuario' => $idUsuario]);
$idCompraActiva = null;

if (!empty($comprasUsuario)) {
    // Recorremos para encontrar la que tenga estado 1 activo
    // (Usamos array_reverse para ver las más recientes primero)
    $comprasUsuario = array_reverse($comprasUsuario);
    foreach ($comprasUsuario as $compra) {
        $estados = $abmCompraEstado->buscar([
            'idCompra' => $compra->getId(), 
            'fechaFinNull' => true
        ]);

        if (!empty($estados) && $estados[0]->getIdEstadoTipo() == 1) {
            $idCompraActiva = $compra->getId();
            break;
        }
    }
}

// 3. Si no hay carrito activo, creamos uno nuevo
if ($idCompraActiva == null) {
    // A. Crear Compra
    if ($abmCompra->alta(['idUsuario' => $idUsuario])) {
        $compras = $abmCompra->buscar(['idUsuario' => $idUsuario]);
        $nuevaCompra = end($compras);
        $idCompraActiva = $nuevaCompra->getId();

        // B. Asignarle estado "Iniciada" (1)
        $abmCompraEstado->alta([
            'idCompra' => $idCompraActiva,
            'idEstadoTipo' => 1
        ]);
    } else {
        header('Location: /TrabajoFinalPWD/Vista/tienda.php?msg=error_compra');
        exit;
    }
}

// 4. Agregar el producto
$abmCompraProducto = new ABMCompraProducto();
$exito = $abmCompraProducto->alta([
    'idCompra' => $idCompraActiva,
    'idProducto' => $idProducto,
    'cantidad' => 1
]);

if ($exito) {
    header("Location: /TrabajoFinalPWD/Vista/cart.php");
} else {
    header("Location: /TrabajoFinalPWD/Vista/tienda.php?msg=error_agregar");
}
exit;

?>
