<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>    
    <script src="https://cdn.jsdelivr.net/npm/axios@1.13.2/dist/axios.min.js"></script>
    <link rel="shortcut icon" href="/TrabajoFinalPWD/Vista/sources/Logo.png" type="image/x-icon">
    <title>Login</title>
</head>
<style>
    body {
        background-image: url('https://images6.alphacoders.com/478/478549.jpg');
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }
</style>
<body class="flex flex-col min-h-screen">
<?php
    include_once ('../Vista/structure/header.php');
?>
<main class="flex-grow flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 text-center border-b">
                <img src="/TrabajoFinalPWD/Vista/sources/Isologo.png" alt="Logo" class="mx-auto w-60 h-60 mb-3">
                <h1 class="text-2xl font-semibold text-gray-800">Iniciar sesión</h1>
                <p class="text-sm text-gray-500 mt-1">Accedé a tu cuenta para poder comprar</p>
            </div>

            <form id="loginForm" class="p-6 space-y-4" action="/TrabajoFinalPWD/auth/login.php" method="post" novalidate>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" required
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                           placeholder="tucorreo@ejemplo.com">
                    <p id="emailError" class="mt-1 text-xs text-red-500 hidden">Por favor ingresá un email válido.</p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" required
                               class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                               placeholder="••••••••">
                        <button type="button" id="togglePwd" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            Mostrar
                        </button>
                    </div>
                    <p id="pwdError" class="mt-1 text-xs text-red-500 hidden">La contraseña es obligatoria.</p>
                </div>

                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="form-checkbox h-4 w-4">
                        <span class="ml-2">Recordarme</span>
                    </label>
                    <a href="#" class="text-sm text-orange-600 hover:underline">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="w-full bg-orange-600 text-white py-2 rounded-lg font-medium hover:bg-orange-700 transition">
                    Iniciar sesión
                </button>

                <div class="text-center text-sm text-gray-500">
                    ¿No tenés cuenta?
                    <a href="/TrabajoFinalPWD/Vista/register.php" class="text-orange-600 hover:underline">Crear cuenta</a>
                </div>

                <div class="pt-3">
                    <div class="flex items-center">
                        <hr class="flex-grow border-gray-200">
                        <span class="px-3 text-xs text-gray-400">o</span>
                        <hr class="flex-grow border-gray-200">
                    </div>
                    <div class="mt-3">
                        <a href="#" class="flex items-center justify-center gap-2 py-2 border rounded-lg hover:shadow transition">
                            <img src="https://img.icons8.com/color/512/google-logo.png" alt="Google" class="h-5 w-5">
                            <span class="text-sm">Google</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php
    include_once ('../Vista/structure/footer.php');
?>

<!--<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('loginForm');
    const email = document.getElementById('email');
    const pwd = document.getElementById('password');
    const emailError = document.getElementById('emailError');
    const pwdError = document.getElementById('pwdError');
    const toggle = document.getElementById('togglePwd');

    toggle.addEventListener('click', () => {
        if (pwd.type === 'password') {
            pwd.type = 'text';
            toggle.textContent = 'Ocultar';
        } else {
            pwd.type = 'password';
            toggle.textContent = 'Mostrar';
        }
    });

    form.addEventListener('submit', function (e) {
        let valid = true;
        emailError.classList.add('hidden');
        pwdError.classList.add('hidden');

        if (!email.value || !/^\S+@\S+\.\S+$/.test(email.value)) {
            emailError.classList.remove('hidden');
            valid = false;
        }
        if (!pwd.value) {
            pwdError.classList.remove('hidden');
            valid = false;
        }
        if (!valid) e.preventDefault();
    });
});
</script>-->
</body>
</html>