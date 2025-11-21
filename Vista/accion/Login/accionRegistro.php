<?php

session_start();
require __DIR__ . '/../../../vendor/autoload.php'; 
include_once (__DIR__ . '/../../../utilidades/funciones.php');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../includes');
$dotenv->load();

include_once(__DIR__ . '/../../../Control/ABMUsuario.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $datosFormulario = data_submitted();
    
    $abmUsuario = new ABMUsuario();
    $resultado = $abmUsuario->procesarRegistro($datosFormulario); 
    
    header('Location: ' . $resultado['urlRedireccion']);
    exit;

} else {
    // Si no es POST, redirigir
    header('Location: /TrabajoFinalPWD/Vista/register.php');
    exit;
}


?>