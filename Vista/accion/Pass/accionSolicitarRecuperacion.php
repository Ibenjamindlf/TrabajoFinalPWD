<?php
session_start();
require __DIR__ . '/../../../vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../includes');
$dotenv->load();

include_once(__DIR__ . '/../../../Control/ABMUsuario.php');
include_once(__DIR__ . '/../../../Modelo/Usuario.php');
include_once(__DIR__ . '/../../../Clases/Email.php'); 
include_once(__DIR__ . '/../../../Control/validadores/Validador.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = $_POST['email'] ?? '';
    
    $abmUsuario = new ABMUsuario();
    
    // Llamamos a la nueva función que usa uniqid() internamente
    $esValido = $abmUsuario->iniciarRecuperacion($email);

    if ($esValido) {
        $_SESSION['mensaje_exito'] = "Si el correo existe, recibirás las instrucciones en breve.";
        header('Location: /TrabajoFinalPWD/Vista/login.php'); 
        exit;
    } else {
        $_SESSION['errores_abm'] = "Email inválido.";
        header('Location: /TrabajoFinalPWD/Vista/auth/recuperarPass.php');
        exit;
    }
}
header('Location: /TrabajoFinalPWD/Vista/login.php');
?>