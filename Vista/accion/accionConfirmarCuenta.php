<?php
// 1. Iniciar sesión y cargar dependencias
session_start();
require __DIR__ . '/../../vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../includes');
$dotenv->load();

// 2. Incluir tus clases
include_once(__DIR__ . '/../../Control/ABMUsuario.php');
include_once(__DIR__ . '/../../Modelo/Usuario.php');
include_once(__DIR__ . '/../../Control/validadores/Validador.php');

$token = $_GET['token'] ?? '';
$errores = [];

// 3. Validar el token
if (!Validador::noEstaVacio($token)) {
    $errores[] = "Token no válido.";
}

if (empty($errores)) {
    // 4. Buscar al usuario por el token
    $abmUsuario = new ABMUsuario();
    $usuariosEncontrados = $abmUsuario->buscar(['token' => $token]);

    if ($usuariosEncontrados != null && count($usuariosEncontrados) > 0) {
        $usuario = $usuariosEncontrados[0]; 
        
        // 5. Actualizar el usuario
        $usuario->setConfirmado(1);
        $usuario->setToken(null);   // Borramos el token

        // 6. Guardar en la BD (usando el Modelo/Usuario.php corregido)
        if ($usuario->modificar()) {
            // ¡Éxito! Guardamos el mensaje en la sesión
            $_SESSION['mensaje_exito'] = "¡Tu cuenta ha sido confirmada exitosamente!";
        } else {
            $errores[] = "No se pudo confirmar tu cuenta. Inténtalo más tarde.";
        }
        
    } else {
        $errores[] = "Token no válido o la cuenta ya ha sido confirmada.";
    }
}

// 7. Si hubo errores, guardarlos en la sesión
if (!empty($errores)) {
     $_SESSION['mensaje_error'] = $errores;
}

// 8. REDIRIGIR a la Vista (la que creamos que lee la sesión)
header('Location: /TrabajoFinalPWD/Vista/login.php');
exit;
?>