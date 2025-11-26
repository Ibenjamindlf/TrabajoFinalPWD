<?php
require_once __DIR__ . '/../../../Control/Session.php';
require_once __DIR__ . '/../../../Control/ABMCompraEstado.php';


require_once __DIR__ . '/../../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../includes');
$dotenv->load();

$session = new Session();

if (!$session->activa()) {
    header('Location: /TrabajoFinalPWD/Vista/login.php');
    exit;
}

$datosEnvio = $_POST ?? null;

if ($datosEnvio != null) {
    $abmCompraEstado = new ABMCompraEstado();
    $esTransicionValida = $abmCompraEstado->verificacionTransicionEstado($datosEnvio);
    if ($esTransicionValida){
        $seModifico = $abmCompraEstado->cambiarEstado($datosEnvio);
            if ($seModifico){
                header("Location: ../../admin/panelEnviosPruebas.php?msg=EL-CAMBIO-DE-ESTADO-FUE-REALIZADO");
                exit;
            } else {
                header("Location: ../../admin/panelEnviosPruebas.php?msg=HUBO-UN-ERROR-AL-MODIFICAR-EL-ESTADO");
                exit;
            }
    } else {
        header("Location: ../../admin/panelEnviosPruebas.php?msg=ERROR-EL-CAMBIO-DE-ESTADO-NO-ES-VALIDO");
        exit;
    }
}
// header("Location: ../../admin/panelEnviosPruebas.php");
// exit;
?>