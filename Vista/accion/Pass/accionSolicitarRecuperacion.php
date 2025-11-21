<?php
session_start();
require __DIR__ . '/../../vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../includes');
$dotenv->load();

include_once(__DIR__ . '/../../Control/ABMUsuario.php');
include_once(__DIR__ . '/../../Modelo/Usuario.php');
include_once(__DIR__ . '/../../Clases/Email.php'); 
include_once(__DIR__ . '/../../Control/validadores/Validador.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (Validador::esEmailValido($_POST['email'])) {
        
        $abmUsuario = new ABMUsuario();
        $usuarios = $abmUsuario->buscar(['mail' => $_POST['email']]);

        // Si el usuario existe, generamos token y enviamos mail
        if ($usuarios != null && count($usuarios) > 0) {
            $usuario = $usuarios[0];
            
            // Generamos token
            $token = uniqid();
            $usuario->setToken($token);
            
            // Guardamos el token en la BD
            if ($usuario->modificar()) {
                // Enviamos el email
                $email = new Email($usuario->getMail(), $usuario->getNombre(), $token);
                $email->enviarInstrucciones();
            }
        }
        
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