<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> 
    <script src="https://cdn.jsdelivr.net/npm/axios@1.13.2/dist/axios.min.js"></script>   
    <link rel="shortcut icon" href="/TrabajoFinalPWD/Vista/sources/Logo.png" type="image/x-icon">
    <title>Registro</title>
</head>
<style>
    body {
        background-image: url('https://www.10wallpaper.com/wallpaper/1920x1080/1609/Vinyl_gramophone_macro-2016_Music_HD_Wallpaper_1920x1080.jpg');
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
                <img src="/TrabajoFinalPWD/Vista/sources/Isologo.png" alt="Logo" class="mx-auto h-60 w-60 mb-3">
                <h1 class="text-2xl font-semibold text-gray-800">Crear cuenta</h1>
                <p class="text-sm text-gray-500 mt-1">Registrate para comprar</p>
            </div>

            <form id="registerForm" class="p-6 space-y-4" action="/TrabajoFinalPWD/auth/register.php" method="post" novalidate>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
                    <input id="name" name="name" type="text" required
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           placeholder="Tu nombre completo">
                    <p id="nameError" class="mt-1 text-xs text-red-500 hidden">Ingresá tu nombre.</p>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" required
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           placeholder="tucorreo@ejemplo.com">
                    <p id="emailError" class="mt-1 text-xs text-red-500 hidden">Ingresá un email válido.</p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" required
                               class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                               placeholder="Mínimo 8 caracteres">
                        <button type="button" id="togglePwd" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            Mostrar
                        </button>
                    </div>
                    <p id="pwdError" class="mt-1 text-xs text-red-500 hidden">La contraseña debe tener al menos 8 caracteres.</p>
                </div>

                <div>
                    <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-1">Confirmar contraseña</label>
                    <div class="relative">
                        <input id="confirmPassword" name="confirmPassword" type="password" required
                               class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                               placeholder="Repetí la contraseña">
                        <button type="button" id="toggleConfirm" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            Mostrar
                        </button>
                    </div>
                    <p id="confirmError" class="mt-1 text-xs text-red-500 hidden">Las contraseñas no coinciden.</p>
                </div>

                <div class="flex items-center">
                    <label class="inline-flex items-center text-sm text-gray-600">
                        <input type="checkbox" name="terms" id="terms" class="form-checkbox h-4 w-4 text-orange-600">
                        <span class="ml-2">Acepto los <a href="#" class="text-orange-600 hover:underline">Términos y Condiciones</a></span>
                    </label>
                </div>
                <p id="termsError" class="mt-1 text-xs text-red-500 hidden">Debés aceptar los términos.</p>

                <button type="submit" class="w-full bg-orange-600 text-white py-2 rounded-lg font-medium hover:bg-orange-700 transition">
                    Crear cuenta
                </button>

                <div class="text-center text-sm text-gray-500">
                    ¿Ya tenés cuenta?
                    <a href="/TrabajoFinalPWD/Vista/login.php" class="text-orange-600 hover:underline">Iniciar sesión</a>
                </div>

                <div class="pt-3">
                    <div class="flex items-center">
                        <hr class="flex-grow border-gray-200">
                        <span class="px-3 text-xs text-gray-400">o registrate con</span>
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
    const form = document.getElementById('registerForm');
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const pwd = document.getElementById('password');
    const confirm = document.getElementById('confirmPassword');
    const terms = document.getElementById('terms');

    const nameError = document.getElementById('nameError');
    const emailError = document.getElementById('emailError');
    const pwdError = document.getElementById('pwdError');
    const confirmError = document.getElementById('confirmError');
    const termsError = document.getElementById('termsError');

    const togglePwd = document.getElementById('togglePwd');
    const toggleConfirm = document.getElementById('toggleConfirm');

    togglePwd.addEventListener('click', () => {
        if (pwd.type === 'password') {
            pwd.type = 'text';
            togglePwd.textContent = 'Ocultar';
        } else {
            pwd.type = 'password';
            togglePwd.textContent = 'Mostrar';
        }
    });

    toggleConfirm.addEventListener('click', () => {
        if (confirm.type === 'password') {
            confirm.type = 'text';
            toggleConfirm.textContent = 'Ocultar';
        } else {
            confirm.type = 'password';
            toggleConfirm.textContent = 'Mostrar';
        }
    });

    form.addEventListener('submit', function (e) {
        let valid = true;
        // ocultar errores previos
        [nameError, emailError, pwdError, confirmError, termsError].forEach(el => el.classList.add('hidden'));

        if (!name.value.trim()) {
            nameError.classList.remove('hidden'); valid = false;
        }
        if (!email.value || !/^\S+@\S+\.\S+$/.test(email.value)) {
            emailError.classList.remove('hidden'); valid = false;
        }
        if (!pwd.value || pwd.value.length < 8) {
            pwdError.classList.remove('hidden'); valid = false;
        }
        if (pwd.value !== confirm.value) {
            confirmError.classList.remove('hidden'); valid = false;
        }
        if (!terms.checked) {
            termsError.classList.remove('hidden'); valid = false;
        }

        if (!valid) e.preventDefault();
    });
});
</script>-->
</body>
</html>