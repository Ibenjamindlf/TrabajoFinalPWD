<?php
include_once ("../../Control/abmProducto.php");

$datos = $_POST;
$abmProducto = new ABMProducto();

print_r($datos);
$seModifico = $abmProducto->modificacion($datos);


if ($seModifico){
    $message = 'Se modifico correctamente el producto';
    header("Location: ../admin/panelAdmin.php?Message=" . urlencode($message));
    exit;
} else {
    $message = 'Hubo un error al modificar el producto';
    header("Location: ../admin/panelAdmin.php?Message=" . urlencode($message));
    exit;
}
?>