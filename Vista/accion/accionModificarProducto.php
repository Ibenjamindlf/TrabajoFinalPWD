<?php
include_once ("../../Control/abmProducto.php");
include_once ("../../utilidades/funciones.php");

$datos = data_submitted();
$abmProducto = new ABMProducto();

$hayImg = $datos['imagen']['name'];
// Si el usuario cambio la foto
if ($hayImg != null){

    $producto = $abmProducto->buscar(['id' => $datos['id']]);

    $producto = $producto[0];

    $rutaImg = $producto->getimagen();

    $rutaFisica = "../../" . $rutaImg;

    unlink($rutaFisica);

    // Configuracion del directorio de destino
    $uploadDir = "../sources/img/";

    // Datos del archivo subido
    $archivo = $datos['imagen'];
    $nombreArchivo = basename($archivo['name']); // basename() evita path traversal
    $rutaDestino = $uploadDir . $nombreArchivo;

    // --- Mover archivo subido ---
    if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {

        // Guardamos la ruta RELATIVA que se usará desde la web (por ejemplo, para mostrar imagen en el front)
        $datos['imagen'] = "Vista/sources/img/" . $nombreArchivo;

        // --- Insertar producto en BD ---
        $seModifico = $abmProducto->modificacion($datos);

    } else {
        $message = 'Error al subir la imagen.';
    }
} else {
    $producto = $abmProducto->buscar(['id' => $datos['id']]);
    if ($producto) {
        $rutaImg = $producto[0]->getImagen();
    }
    // echo $rutaImg;
    $datos['imagen'] = $rutaImg;
    // print_r($datos);
    $seModifico = $abmProducto->modificacion($datos);
}
if ($seModifico) {
    $message = 'Se modifico correctamente el producto.';
} else {
    $message = 'Hubo un error al modifico el producto.';
}
// --- Redirección con mensaje ---
header("Location: ../admin/panelAdmin.php?Message=" . urlencode($message));
exit;
?>