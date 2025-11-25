<?php
session_start();
require_once __DIR__ . '/../../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../includes');
$dotenv->load();

require_once __DIR__ . '/../../../Control/Session.php';
require_once __DIR__ . '/../../../Control/ABMCompraEstado.php';

$session = new Session();
if (!$session->activa()) {
    header('Location: /TrabajoFinalPWD/Vista/login.php');
    exit;
}

$datosEnvio = $_POST ?? null;
$mensaje = "";

if ($datosEnvio != null) {
    $abmCompraEstado = new ABMCompraEstado();

    if ($abmCompraEstado->cambiarEstado($datosEnvio)) {
        $mensaje = "EL-CAMBIO-DE-ESTADO-FUE-REALIZADO";
    } else {
        $mensaje = "ERROR-NO-SE-PUDO-CAMBIAR-EL-ESTADO";
    }
} else {
    $mensaje = "ERROR-FALTAN-DATOS";
}

header("Location: ../../admin/panelEnviosPruebas.php?msg=" . urlencode($mensaje));
exit;
