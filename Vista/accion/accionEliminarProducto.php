<?php
include_once ("../../Control/ABMProducto.php");
include_once ("../../utilidades/funciones.php");

$datos = data_submitted();
$abmProducto = new ABMProducto();

$producto = $abmProducto->buscar(['id'=>$datos['id']]);

if ($producto){
    $producto = $producto[0];

    $rutaImg = $producto->getimagen();
    $rutaFisica = "../../" . $rutaImg;

        unlink($rutaFisica);

    $seElimino = $abmProducto->baja($datos);
}

if ($seElimino) {
    $message = 'Se elimino correctamente el producto';
} else {
    $message = 'Hubo un error al eliminar el usuario';
}

header("Location: ../admin/panelAdmin.php?Message=" . urlencode($message));
exit;
?>