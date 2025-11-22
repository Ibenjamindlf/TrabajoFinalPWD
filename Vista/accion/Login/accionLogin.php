<?php
include_once(__DIR__ . '/../../../Control/Session.php'); 
$session = new Session(); 

require __DIR__ . '/../../../vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../includes');
$dotenv->load();


include_once(__DIR__ . '/../../../Control/ABMUsuario.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    
    $datosLogin = [
        'mail' => $_POST['email'] ?? null, 
        'password' => $_POST['password'] ?? null
    ];

    $abmUsuario = new ABMUsuario();
    $resultado = $abmUsuario->procesarLogin($datosLogin); 
    
    header('Location: ' . $resultado['urlRedireccion']);
    exit;

} else {
    // Si no es POST, redirigir
    header('Location: /TrabajoFinalPWD/Vista/login.php');
    exit;
}


?>