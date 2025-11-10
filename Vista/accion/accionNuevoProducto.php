<?php
include_once ("../../Control/ABMProducto.php");
include_once ("../../utilidades/funciones.php");

// $datos = $_POST;
$abmProducto = new ABMProducto();
$datos = data_submitted();

// print_r($datos);
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
    $seRegistro = $abmProducto->alta($datos);

    if ($seRegistro) {
        $message = 'Se ingresó correctamente el producto.';
    } else {
        $message = 'Hubo un error al ingresar el producto.';
    }

} else {
    $message = 'Error al subir la imagen.';
}

// --- Redirección con mensaje ---
header("Location: ../admin/panelAdmin.php?Message=" . urlencode($message));
exit;
?>