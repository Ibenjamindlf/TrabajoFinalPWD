<?php

session_start();
require __DIR__ . '/../../../vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../includes');
$dotenv->load();

include_once(__DIR__ . '/../../../Control/ABMUsuario.php');

$token = $_GET['token'] ?? '';

$abmUsuario = new ABMUsuario();
$abmUsuario->confirmarCuentaPorToken($token); 

header('Location: /TrabajoFinalPWD/Vista/login.php');
exit;

?>