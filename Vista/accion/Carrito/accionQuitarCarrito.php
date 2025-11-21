<?php
require_once __DIR__ . '/../../Control/ABMCompraProducto.php';
$abmCompraProducto = new ABMCompraProducto();
$datos = $_POST;
// print_r($datos);
$idCompraProducto = $datos['idProducto'];
// echo $idCompraProducto;
$abmCompraProducto->baja($datos);
header("location: ../cart.php");
exit;
?>