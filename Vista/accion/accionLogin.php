<?php

include_once(__DIR__ . '/../../Control/Session.php'); 
$session = new Session(); 

require __DIR__ . '/../../vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../includes');
$dotenv->load();

include_once(__DIR__ . '/../../Control/ABMUsuario.php');
include_once(__DIR__ . '/../../Modelo/Usuario.php');
include_once(__DIR__ . '/../../Control/validadores/Validador.php');
include_once(__DIR__ . '/../../Control/ABMUsuarioRol.php');
include_once(__DIR__ . '/../../Control/ABMRol.php');
include_once(__DIR__ . '/../../Modelo/UsuarioRol.php');
include_once(__DIR__ . '/../../Modelo/Rol.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $valido = true;
    $errores = "";
    if (!Validador::esEmailValido($_POST['email'])) {
        $valido = false; $errores = "El formato del email no es válido.";
    }
    if (!$valido) {
        $_SESSION['errores_abm'] = $errores;
        header('Location: /TrabajoFinalPWD/Vista/login.php');
        exit;
    }

    $datosLogin = [
        'mail' => $_POST['email'], 
        'password' => $_POST['password']
    ];


    $abmUsuario = new ABMUsuario();
    $usuarioValidado = $abmUsuario->login($datosLogin); // Llama al login (que devuelve obj o null)

    if ($usuarioValidado != null) {
        
        // El ABM valida al usuario.
        $session->iniciar($usuarioValidado);
        
        header('Location: /TrabajoFinalPWD/Vista/tienda.php');
        exit;

    } else {
        // FALLO
        $_SESSION['errores_abm'] = "Email o contraseña incorrectos, o la cuenta no ha sido confirmada.";
        header('Location: /TrabajoFinalPWD/Vista/login.php');
        exit;
    }

} else {
    // Si no es POST, redirigir
    header('Location: /TrabajoFinalPWD/Vista/login.php');
    exit;
}
?>