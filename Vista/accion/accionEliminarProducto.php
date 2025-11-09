<?php
include_once ("../../Control/ABMProducto.php");
include_once ("../../utilidades/funciones.php");

// Nose ni por que deje use las 3 lineas de abajo pero por las dudas no las voy a borrar
// print_r($_GET);
// $idProducto = $_GET['id'];
// print_r($idProducto);
$abmProducto = new ABMProducto();

$seElimino = $abmProducto->baja(data_submitted());

if ($seElimino){
    $message = 'Se elimino correctamente el producto';
    header("Location: ../admin/panelAdmin.php?Message=" . urlencode($message));
    exit;
} else {
    $message = 'Hubo un error al eliminar el usuario';
    header("Location: ../admin/panelAdmin.php?Message=" . urlencode($message));
    exit;
}
?>