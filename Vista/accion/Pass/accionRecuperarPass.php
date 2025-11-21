<?php
session_start();
require __DIR__ . '/../../vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../includes');
$dotenv->load();

include_once(__DIR__ . '/../../Control/ABMUsuario.php');
include_once(__DIR__ . '/../../Modelo/Usuario.php');

$token = $_GET['token'] ?? '';

if (empty($token)) {
    $_SESSION['errores_abm'] = "Token no válido.";
    header('Location: /TrabajoFinalPWD/Vista/login.php');
    exit;
}

// Buscamos si existe un usuario con ese token
$abmUsuario = new ABMUsuario();
$usuarios = $abmUsuario->buscar(['token' => $token]);

if ($usuarios != null && count($usuarios) > 0) {

    header("Location: /TrabajoFinalPWD/Vista/auth/nuevoPass.php?token=" . $token);
    exit;
} else {
    $_SESSION['errores_abm'] = "El enlace de recuperación es inválido o ha expirado.";
    header('Location: /TrabajoFinalPWD/Vista/login.php');
    exit;
}
?>