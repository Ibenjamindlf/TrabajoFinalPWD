<?php
session_start();
require __DIR__ . '/../../vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../includes');
$dotenv->load();

include_once(__DIR__ . '/../../Control/ABMUsuario.php');
include_once(__DIR__ . '/../../Control/ABMCompra.php');
include_once(__DIR__ . '/../../Control/ABMCompraProducto.php');
include_once(__DIR__ . '/../../Control/ABMCompraEstado.php');
include_once(__DIR__ . '/../../Control/ABMProducto.php');
include_once(__DIR__ . '/../../Clases/Email.php');
include_once(__DIR__ . '/../../Modelo/Usuario.php');

if (!isset($_SESSION['idusuario'])) { header('Location: /TrabajoFinalPWD/Vista/login.php'); exit; }
$idUsuario = $_SESSION['idusuario'];

// 1. Buscar Carrito (Estado 1)
$abmCompra = new ABMCompra();
$abmEstado = new ABMCompraEstado();
$abmCP = new ABMCompraProducto();
$abmP = new ABMProducto();

$compras = $abmCompra->buscar(['idUsuario' => $idUsuario]);
$idCompraActiva = null;
$idEstadoAnterior = null;

if (!empty($compras)) {
    $compras = array_reverse($compras);
    foreach ($compras as $c) {
        $est = $abmEstado->buscar(['idCompra' => $c->getId(), 'fechaFinNull' => true]);
        if (!empty($est) && $est[0]->getIdEstadoTipo() == 1) {
            $idCompraActiva = $c->getId();
            $idEstadoAnterior = $est[0]->getId();
            break;
        }
    }
}

if (!$idCompraActiva) { header('Location: /TrabajoFinalPWD/Vista/tienda.php'); exit; }

// 2. Preparar Email
$items = $abmCP->buscar(['idCompra' => $idCompraActiva]);
$prodEmail = [];
$total = 0;

foreach ($items as $i) {
    $p = $abmP->buscar(['id' => $i->getIdProducto()]);
    if (!empty($p)) {
        $obj = $p[0];
        $total += ($obj->getPrecio() * $i->getCantidad());
        $prodEmail[] = ['nombre' => $obj->getNombre(), 'cantidad' => $i->getCantidad(), 'precio' => $obj->getPrecio()];
    }
}

// 3. Cambiar Estado (Cerrar 1, Abrir 3)
$estAnt = $abmEstado->buscar(['id' => $idEstadoAnterior])[0];
$abmEstado->modificacion([
    'id' => $idEstadoAnterior,
    'idCompra' => $idCompraActiva,
    'idEstadoTipo' => 1,
    'fechaIni' => $estAnt->getFechaIni(),
    'fechaFin' => date("Y-m-d H:i:s") // CERRAR
]);

$abmEstado->alta([
    'idCompra' => $idCompraActiva,
    'idEstadoTipo' => 3 // 3 = PAGO ACEPTADO
]);

// 4. Enviar Mail
$abmU = new ABMUsuario();
$u = $abmU->buscar(['id' => $idUsuario])[0];
$mail = new Email($u->getMail(), $u->getNombre(), null);
$mail->enviarResumenCompra($prodEmail, $total);

$_SESSION['mensaje_exito'] = "¡Compra finalizada con éxito!";
header('Location: /TrabajoFinalPWD/Vista/tienda.php');
exit;
?>