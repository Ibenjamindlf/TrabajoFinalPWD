<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>    
    <script src="https://cdn.jsdelivr.net/npm/axios@1.13.2/dist/axios.min.js"></script>
    <link rel="shortcut icon" href="/TrabajoFinalPWD/Vista/sources/Logo.png" type="image/x-icon">
    <title>Recuperar contraseña</title>
</head>
<body class="flex flex-col min-h-screen">
    <?php
    include_once ('../structure/header.php');
    ?>
    <main class="flex-grow flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 text-center border-b">
                <img src="/TrabajoFinalPWD/Vista/sources/Isologo.png" alt="Logo" class="mx-auto w-60 h-60 mb-3">
                <h1 class="text-2xl font-semibold text-gray-800">¿Olvidaste tu contraseña?</h1>
                <p class="text-sm text-gray-500 mt-1">Ingresá tu email y te enviaremos un enlace para restablecerla.</p>
            </div>

            <form id="recoverForm" class="p-6 space-y-4" action="/TrabajoFinalPWD/Vista/auth/procesar_recupero.php" method="post" novalidate>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" required
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                           placeholder="tucorreo@ejemplo.com">
                    <p id="emailError" class="mt-1 text-xs text-red-500 hidden">Por favor ingresá un email válido.</p>
                </div>

                <button type="submit" class="w-full bg-orange-600 text-white py-2 rounded-lg font-medium hover:bg-orange-700 transition">
                    Enviar enlace de recuperación
                </button>

                <div class="text-center text-sm text-gray-500">
                    ¿Ya te acordaste?
                    <a href="/TrabajoFinalPWD/Vista/login.php" class="text-orange-600 hover:underline">Volver a Iniciar sesión</a>
                </div>
            </form>
        </div>
    </div>
    </main>
    <?php
    include_once ('../structure/footer.php');
?>
</body>
</html>