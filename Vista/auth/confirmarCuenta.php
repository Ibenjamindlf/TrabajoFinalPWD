<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>    
    <script src="https://cdn.jsdelivr.net/npm/axios@1.13.2/dist/axios.min.js"></script>
    <link rel="shortcut icon" href="/TrabajoFinalPWD/Vista/sources/Logo.png" type="image/x-icon">
    <title>Confirmar Cuenta</title>
</head>
<body class="flex flex-col min-h-screen">
    <?php
    include_once ('../structure/header.php');
    ?>
    <main class="flex-grow flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 text-center border-b">
                <img src="/TrabajoFinalPWD/Vista/sources/Isologo.png" alt="Logo" class="mx-auto h-60 w-60 mb-3">
                <h1 class="text-gray-500 mt-1">Solo falta un paso más para activar tu cuenta.</h1>
            </div>

            <div class="p-6 space-y-5 text-center">
                <p class="text-gray-700">
                    Te hemos enviado un <strong>correo electrónico de confirmación</strong>. 
                    Por favor, revisá tu bandeja de entrada (y no olvides la carpeta de spam) y hacé clic en el enlace para activar tu cuenta.
                </p>
                
                <a href="/TrabajoFinalPWD/Vista/login.php" 
                   class="block w-full bg-orange-600 text-white py-2 rounded-lg font-medium hover:bg-orange-700 transition">
                    Ir a Iniciar Sesión
                </a>

                 <p class="text-xs text-gray-500 mt-4">
                    ¿No recibiste el email? 
                    <a href="#" class="text-orange-600 hover:underline">Reenviar correo</a>
                    </p>
            </div>
        </div>
    </div>
    </main>
    <?php
    include_once ('../structure/footer.php');
?>
</body>
</html>