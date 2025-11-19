<?php
session_start();
require __DIR__ . '/../../vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../includes');
$dotenv->load();

include_once(__DIR__ . '/../../Control/ABMUsuario.php');
include_once(__DIR__ . '/../../Modelo/Usuario.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $pass = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($pass !== $confirm || strlen($pass) < 8) {
        $_SESSION['errores_abm'] = "Las contraseñas no coinciden o son muy cortas.";
        header("Location: /TrabajoFinalPWD/Vista/auth/nuevoPass.php?token=" . $token);
        exit;
    }

    $abmUsuario = new ABMUsuario();
    $usuarios = $abmUsuario->buscar(['token' => $token]);

    if ($usuarios != null && count($usuarios) > 0) {
        $usuario = $usuarios[0];

        // 1. Hasheamos la nueva contraseña
        $newHash = password_hash($pass, PASSWORD_DEFAULT);
        
        // 2. Seteamos el hash directamente (Modelo/Usuario.php setPassword NO hashea, solo asigna)
        $usuario->setPassword($newHash);
        
        // 3. Borramos el token para que no se use de nuevo
        $usuario->setToken(null); 

        // 4. Guardamos
        if ($usuario->modificar()) {
            $_SESSION['mensaje_exito'] = "Contraseña reestablecida. Ya puedes iniciar sesión.";
            header('Location: /TrabajoFinalPWD/Vista/login.php');
        } else {
            $_SESSION['errores_abm'] = "Error al guardar.";
            header("Location: /TrabajoFinalPWD/Vista/auth/nuevoPass.php?token=" . $token);
        }

    } else {
        $_SESSION['errores_abm'] = "Token inválido.";
        header('Location: /TrabajoFinalPWD/Vista/login.php');
    }
}
?>