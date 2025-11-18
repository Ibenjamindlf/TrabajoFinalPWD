<?php
// Iniciar sesión y cargar dependencias
session_start();
require __DIR__ . '/../../vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../includes');
$dotenv->load();


include_once(__DIR__ . '/../../Control/ABMUsuario.php');
include_once(__DIR__ . '/../../Modelo/Usuario.php');
include_once(__DIR__ . '/../../Clases/Email.php'); 
include_once(__DIR__ . '/../../Control/validadores/Validador.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $valido = true;
    $errores = [];
    
    // Usamos los nombres de tu formulario (name, email, password)
    if (!Validador::noEstaVacio($_POST['name'])) {
        $valido = false; $errores[] = "El nombre es obligatorio.";
    }
    if (!Validador::esEmailValido($_POST['email'])) {
        $valido = false; $errores[] = "El email no es válido.";
    }
    if (!Validador::esPasswordSegura($_POST['password'])) {
        $valido = false; $errores[] = "La contraseña debe tener al menos 8 caracteres.";
    }
    if ($_POST['password'] !== $_POST['confirmPassword']) {
        $valido = false; $errores[] = "Las contraseñas no coinciden.";
    }
    
    if (!$valido) {
        $_SESSION['errores_abm'] = $errores;
        header('Location: /TrabajoFinalPWD/Vista/register.php');
        exit;
    }

    // 6. Generar un Token único
    $token = uniqid();

    // 7. Preparar los datos para el ABM
    $datosUsuario = [
        'nombre' => $_POST['name'],
        'mail' => $_POST['email'],
        'password' => $_POST['password'],
        'token' => $token,
        'confirmado' => 0 // 0 = No confirmado
    ];

    // 8. Intentar dar de alta al usuario
    $abmUsuario = new ABMUsuario();
    if ($abmUsuario->alta($datosUsuario)) {
        
        // ¡ÉXITO! El usuario se creó en la BD.
        
        // 9. ¡AQUÍ SE ENVÍA EL EMAIL!
        $email = new Email($datosUsuario['mail'], $datosUsuario['nombre'], $datosUsuario['token']);
        $email->enviarConfirmacion();

        // 10. Redirigir a la página de éxito (la que ya tienes)
        // (Esta es la página que dice "revisa tu email")
        header('Location: /TrabajoFinalPWD/Vista/auth/confirmarCuenta.php');
        exit;

    } else {
        // FALLO: (ej. email duplicado)
        // El ABM ya guardó el error en $_SESSION['errores_abm']
        header('Location: /TrabajoFinalPWD/Vista/register.php');
        exit;
    }

} else {
    // Si no es POST, redirigir
    header('Location: /TrabajoFinalPWD/Vista/register.php');
    exit;
}
?>