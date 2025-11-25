<?php 
require_once __DIR__ . '/../../../Control/ABMUsuarioRol.php';
$abmUsuarioRol = new ABMUsuarioRol();
$seModificoRol = $abmUsuarioRol->cambioRol($_POST);
if ($seModificoRol){
    header("Location: ../../admin/panelSuperUsuario.php?msg=EL-CAMBIO-DE-ROL-FUE-REALIZADO");
    exit;
} else {
    header("Location: ../../admin/panelSuperUsuario.php?msg=HUBO-UN-ERROR-AL-MODIFICAR-EL-ROL");
    exit;
}
?>