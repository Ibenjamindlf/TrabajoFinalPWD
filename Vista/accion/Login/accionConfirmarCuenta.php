<?php

session_start();
require __DIR__ . '/../../vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../includes');
$dotenv->load();

include_once(__DIR__ . '/../../Control/ABMUsuario.php');
include_once(__DIR__ . '/../../Modelo/Usuario.php');
include_once(__DIR__ . '/../../Control/validadores/Validador.php');

$token = $_GET['token'] ?? '';
$errores = [];

if (!Validador::noEstaVacio($token)) {
    $errores[] = "Token no válido.";
}

if (empty($errores)) {

    $abmUsuario = new ABMUsuario();
    $usuariosEncontrados = $abmUsuario->buscar(['token' => $token]);

    if ($usuariosEncontrados != null && count($usuariosEncontrados) > 0) {
        $usuario = $usuariosEncontrados[0]; 
        
        $usuario->setConfirmado(1);
        $usuario->setToken(null);   // Borramos el token


        if ($usuario->modificar()) {

            $_SESSION['mensaje_exito'] = "¡Tu cuenta ha sido confirmada exitosamente!";
        } else {
            $errores[] = "No se pudo confirmar tu cuenta. Inténtalo más tarde.";
        }
        
    } else {
        $errores[] = "Token no válido o la cuenta ya ha sido confirmada.";
    }
}

if (!empty($errores)) {
     $_SESSION['mensaje_error'] = $errores;
}

header('Location: /TrabajoFinalPWD/Vista/login.php');
exit;
?>