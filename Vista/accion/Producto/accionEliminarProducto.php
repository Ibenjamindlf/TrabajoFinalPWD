<?php
include_once (__DIR__ . '/../../../Control/ABMProducto.php');
include_once (__DIR__ . '/../../../utilidades/funciones.php');

$datos = data_submitted();

$abmProducto = new ABMProducto();
$respuesta = $abmProducto->eliminarProducto($datos);

$mensaje = $respuesta['mensaje'];

header("Location: ../../admin/panelAdmin.php?Message=" . urlencode($mensaje));
exit;
?>