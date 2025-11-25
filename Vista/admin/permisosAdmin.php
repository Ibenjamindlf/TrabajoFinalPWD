<?php
require_once __DIR__ . '/../../Control/Session.php';
require_once __DIR__ . '/../../Control/autenticacion.php';
require_once __DIR__ . '/../../Control/roles.php';

// Solo admins pueden entrar
$session = new Session();
requireAtLeastRole($session, ROLE_ADMIN, '/TrabajoFinalPWD/inicio.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="shortcut icon" href="/TrabajoFinalPWD/Vista/sources/logo.png" type="image/x-icon">
    <title>Panel Administrativo</title>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <?php include_once('../structure/header.php'); ?>

    <main class="flex-grow container mx-auto px-4 py-12">

        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900">Panel de Administración</h1>
            <p class="text-gray-600 mt-2">Accedé a las herramientas de gestión del sistema</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 justify-center">

            <!-- Panel Productos -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 flex flex-col text-center">
                <div class="p-6 flex-grow">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">Panel de Productos</h2>
                    <p class="text-gray-600 text-sm">
                        Gestioná los productos: agregar nuevos, modificar, eliminar o revisar stock.
                    </p>
                </div>
                <div class="p-4 bg-gray-50 border-t">
                    <a href="panelAdmin.php"
                       class="block text-center w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">
                        Ir al panel
                    </a>
                </div>
            </div>

            <!-- Panel Envíos -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 flex flex-col text-center">
                <div class="p-6 flex-grow">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">Panel de Envíos</h2>
                    <p class="text-gray-600 text-sm">
                        Controlá y actualizá los estados de las compras y envíos a los clientes.
                    </p>
                </div>
                <div class="p-4 bg-gray-50 border-t">
                    <a href="panelEnviosPruebas.php"
                       class="block text-center w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">
                        Ir al panel
                    </a>
                </div>
            </div>

            <!-- Panel Usuarios (por si lo agregás después) -->
            <!-- <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 flex flex-col">
                <div class="p-6 flex-grow">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">Panel de Usuarios</h2>
                    <p class="text-gray-600 text-sm">
                        Administrá usuarios, roles y permisos en el sistema.
                    </p>
                </div>
                <div class="p-4 bg-gray-50 border-t">
                    <a href="panelUsuarios.php"
                       class="block text-center w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">
                        Ir al panel
                    </a>
                </div>
            </div> -->

        </div>
    </main>

    <?php include_once('../structure/footer.php'); ?>

</body>
</html>
