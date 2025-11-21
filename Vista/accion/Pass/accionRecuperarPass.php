<?php
session_start();
require __DIR__ . '/../../../vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../includes');
$dotenv->load();

include_once(__DIR__ . '/../../../Control/ABMUsuario.php');
include_once(__DIR__ . '/../../../Modelo/Usuario.php');

// 1. Recibimos el token
$token = $_GET['token'] ?? '';

// 2. Instanciamos el ABM
$abmUsuario = new ABMUsuario();

// 3. Verificamos (Toda la lógica pesada está ahora en el ABM)
if ($abmUsuario->verificarToken($token)) {
    
    // Éxito: El token es real, lo mandamos a cambiar la contraseña
    header("Location: /TrabajoFinalPWD/Vista/auth/nuevoPass.php?token=" . $token);
    exit;

} else {
    
    // Error: Token falso, vacío o expirado
    $_SESSION['errores_abm'] = "El enlace de recuperación es inválido o ha expirado.";
    header('Location: /TrabajoFinalPWD/Vista/login.php');
    exit;
}

// $token = $_GET['token'] ?? '';

// if (empty($token)) {
//     $_SESSION['errores_abm'] = "Token no válido.";
//     header('Location: /TrabajoFinalPWD/Vista/login.php');
//     exit;
// }

// // Buscamos si existe un usuario con ese token
// $abmUsuario = new ABMUsuario();
// $usuarios = $abmUsuario->buscar(['token' => $token]);

// if ($usuarios != null && count($usuarios) > 0) {

//     header("Location: /TrabajoFinalPWD/Vista/auth/nuevoPass.php?token=" . $token);
//     exit;
// } else {
//     $_SESSION['errores_abm'] = "El enlace de recuperación es inválido o ha expirado.";
//     header('Location: /TrabajoFinalPWD/Vista/login.php');
//     exit;
// }
?>