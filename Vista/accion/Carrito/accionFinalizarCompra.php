<?php
require __DIR__ . '/../../../vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../includes');
$dotenv->load();
include_once(__DIR__ . '/../../../Control/ABMCompra.php');
include_once(__DIR__ . '/../../../Control/Session.php');

$session = new Session();

$idUsuario = $session->getIdUsuario();

if (!$session->activa()) {
    header('Location: /TrabajoFinalPWD/Vista/login.php');
    exit;
}

$abmCompra = new ABMCompra();
$exito = $abmCompra->finalizarCompra($idUsuario);

if ($exito) {
    unset($_SESSION['carrito']); 

    $_SESSION['compra_realizada'] = true;
    $_SESSION['mensaje_exito'] = "¡Pago exitoso! Te enviamos el detalle por correo.";
    header('Location: /TrabajoFinalPWD/Vista/tienda.php');
} else {

    $_SESSION['errores_abm'] = "No se pudo finalizar la compra o el carrito estaba vacío.";
    header('Location: /TrabajoFinalPWD/Vista/tienda.php');
}
exit;
?>