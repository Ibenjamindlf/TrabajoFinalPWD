<?php
require_once __DIR__ . '/../Control/Session.php';
require_once __DIR__ . '/../Control/autenticacion.php';
require_once __DIR__ . '/../Control/roles.php';

$session = new Session();
requireLogin($session); // redirige a login si no hay sesión

include_once('../Vista/structure/header.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="shortcut icon" href="/TrabajoFinalPWD/Vista/sources/Logo.png" type="image/x-icon">
    <title>Mi Cuenta</title>
</head>

<body class="flex flex-col min-h-screen bg-gray-100">

<main class="flex-grow flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">

            <!-- Header -->
            <div class="p-6 text-center border-b">
                <img src="/TrabajoFinalPWD/Vista/sources/Isologo.png" 
                     alt="Logo" class="mx-auto w-40 h-40 mb-3">
                <h1 class="text-2xl font-semibold text-gray-800">Mi Cuenta</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Hola <span class="font-medium text-gray-700">
                        <?= htmlspecialchars($_SESSION['nombreusuario'] ?? 'Usuario'); ?>
                    </span>
                </p>
            </div>

            <!-- Contenido -->
            <div class="p-6 space-y-6 text-center">
                <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                    <p class="text-yellow-700">
                        Acá se verá tu cuenta…  
                        <span class="font-semibold">por ahora no hay nada jaja 😅</span>
                    </p>
                </div>

                <!-- Botón cerrar sesión -->
                <a href="/TrabajoFinalPWD/Vista/accion/accionLogout.php"
                   class="block w-full bg-red-600 text-white py-2 rounded-lg font-medium hover:bg-red-700 transition">
                    Cerrar sesión
                </a>
            </div>

        </div>
    </div>
</main>

<?php include_once('../Vista/structure/footer.php'); ?>
</body>
</html>
