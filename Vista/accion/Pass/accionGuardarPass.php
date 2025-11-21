<?php
session_start();
require __DIR__ . '/../../../vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../includes');
$dotenv->load();

include_once(__DIR__ . '/../../../Control/ABMUsuario.php');
include_once(__DIR__ . '/../../../Modelo/Usuario.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $abmUsuario = new ABMUsuario();
    
    // Llamamos al método que ahora retorna la variable $resp
    $resultado = $abmUsuario->restablecerPassword($_POST);

    if ($resultado) {
        // Caso Exitoso
        $_SESSION['mensaje_exito'] = "Contraseña reestablecida. Ya puedes iniciar sesión.";
        header('Location: /TrabajoFinalPWD/Vista/login.php');
        exit;
    } else {
        // Caso Error
        $token = $_POST['token'] ?? '';
        header("Location: /TrabajoFinalPWD/Vista/auth/nuevoPass.php?token=" . $token);
        exit;
    }
}
header('Location: /TrabajoFinalPWD/Vista/login.php');
?>