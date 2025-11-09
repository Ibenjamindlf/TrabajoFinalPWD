<?php
include_once ("../../Control/ABMProducto.php");
include_once ("../../utilidades/funciones.php");

// $datos = $_POST;
$abmProducto = new ABMProducto();

$seRegistro = $abmProducto->alta(data_submitted());

if ($seRegistro){
    $message = 'Se ingreso correctamente el producto';
    header("Location: ../admin/panelAdmin.php?Message=" . urlencode($message));
    exit;
} else {
    $message = 'Hubo un error al ingresar el producto';
    header("Location: ../admin/panelAdmin.php?Message=" . urlencode($message));
    exit;
}
?>