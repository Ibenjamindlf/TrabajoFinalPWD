<?php
include_once ("../../Control/abmProducto.php");
include_once ("../../utilidades/funciones.php");

// $datos = $_POST;
$abmProducto = new ABMProducto();

// print_r($datos);
$seModifico = $abmProducto->modificacion(data_submitted());


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