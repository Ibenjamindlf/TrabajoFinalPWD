<?php
require_once __DIR__ . '/../../Control/Session.php';
$session = new Session(); // session_start() interno

// ---- Constantes de roles (evitan los "magic numbers") ----
require_once __DIR__ . '/../../Control/roles.php';

// ---- Estado de sesión / normalización de roles ----
$logueado = $session->activa();
$usuario = $logueado ? $session->getNombreUsuario() : null;
$rawRoles = $logueado ? $session->getRoles() : null;

// Normalizar a array de enteros y tratar "no logueado" como rol público
if ($rawRoles === null || $rawRoles === [] || $rawRoles === '') {
    $roles = [ROLE_PUBLICO];
} else {
    // Si session->getRoles() devuelve un único valor (int o string) o un array
    if (!is_array($rawRoles)) {
        $roles = [(int)$rawRoles];
    } else {
        $roles = array_map('intval', $rawRoles);
    }
}

// Obtener el "mejor" rol (el número más bajo => mayor privilegio)
$minRole = count($roles) ? min($roles) : ROLE_PUBLICO;

// Helper: devuelve true si el usuario puede ver elementos cuyo máximo rol permitido sea $maxRole
// Ejemplo: canView(3) => visible para roles 1,2,3 (superAdmin, admin, cliente)
function canView(int $maxRole) {
    global $minRole;
    return $minRole <= $maxRole;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50">
    <div class="fixed left-0 top-0 w-full z-20">
        <!-- Top banner -->
        <div class="bg-orange-400">
            <div class="max-w-7xl mx-auto py-2 px-4">
                <p class="text-center text-sm font-bold">Envío gratis en compras superiores a $100.000 🚚</p>
            </div>
        </div>

<!-- Main Header -->
<header class="w-full bg-black text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4">
        
        <!-- Top Header -->
        <div class="flex items-center justify-between py-4 border-b">

            <!-- Logo -->
            <div class="flex items-center space-x-4">
                <label for="mobileMenu" class="md:hidden">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </label>

                <a href="/TrabajoFinalPWD/inicio.php" class="flex items-center hover:scale-105 transition">
                    <img class="h-10 w-10" src="/TrabajoFinalPWD/Vista/sources/Logo.png" alt="Logo">
                    <span class="ml-2 text-xl font-bold text-gray-200 hover:text-yellow-400">
                        Vinilos truchos
                    </span>
                </a>
            </div>



        <!-- Navigation Menu -->
<!-- Navigation Menu -->
<nav class="hidden md:flex space-x-8 py-4">
    <!-- Productos y Sobre nosotros son públicos -->
    <?php if (canView(ROLE_PUBLICO)): ?>
        <a href="/TrabajoFinalPWD/Vista/tienda.php" class="text-gray-200 hover:text-orange-400 font-medium">Productos</a>
        <a href="/TrabajoFinalPWD/Vista/about.php" class="text-gray-200 hover:text-orange-400 font-medium">Sobre nosotros</a>
    <?php endif; ?>

    <!-- Carrito: cliente (3) en adelante (1,2,3) -->
    <?php if (canView(ROLE_CLIENTE)): ?>
        <a href="/TrabajoFinalPWD/Vista/cart.php" class="text-gray-200 hover:text-orange-400 font-medium">Carrito</a>
    <?php endif; ?>

    <!-- Mi cuenta / Iniciar sesión -->
    <?php if ($logueado): ?>
        <a href="/TrabajoFinalPWD/Vista/miCuenta.php" class="text-gray-200 hover:text-orange-400 font-medium">Mi cuenta</a>
        <!-- <a href="/TrabajoFinalPWD/Vista/accion/accionLogout.php" class="text-gray-200 hover:text-orange-400 font-medium">Cerrar sesión</a> -->
    <?php else: ?>
        <a href="/TrabajoFinalPWD/Vista/login.php" class="text-gray-200 hover:text-orange-400 font-medium">Iniciar sesión</a>
    <?php endif; ?>

    <!-- Panel productos: admin (2) en adelante (1,2) -->
    <?php if (canView(ROLE_ADMIN)): ?>
        <a href="/TrabajoFinalPWD/Vista/admin/panelAdmin.php" class="text-yellow-400 font-bold">Panel Productos</a>
    <?php endif; ?>

    <!-- Panel usuario: solo superAdmin (1) -->
    <?php if ($minRole === ROLE_SUPERADMIN): ?>
        <a href="/TrabajoFinalPWD/Vista/admin/panelSuperUsuario.php" class="text-yellow-300 font-bold">Panel Usuario</a>
    <?php endif; ?>
</nav>


    </div>
    <?php 
    // ⚠️ Funcion para debug ⚠️
    // print_r($rol);
    // echo $rol[0];
    // echo "nashei";
    // var_dump($_SESSION);
    ?>
</header>

    </div>
    <div class="pt-36">
    </div>

    <input type="checkbox" id="cartToggle" class="peer hidden">
    <input type="checkbox" id="mobileMenu" class="hidden">

    <!-- Mobile Menu -->
    <div class="fixed inset-0 z-30 transform transition-transform duration-300 ease-in-out md:hidden">
        <!-- Mobile menu content here -->
    </div>

    <!-- Cart Drawer (removed usage: kept for compatibility; actual page cart is separate) -->
    <div class="fixed right-0 top-0 z-40 h-full w-80 translate-x-full transform bg-white shadow-lg transition-transform duration-300 ease-in-out peer-checked:translate-x-0">
        <div class="p-6">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Tu Carrito</h2>
                <label for="cartToggle" class="cursor-pointer text-gray-500 hover:text-gray-700">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </label>
            </div>

            <div class="flex flex-col h-full">
                <div class="flex-1">
                    <p class="text-gray-500 text-center py-8">Tu carrito está vacío</p>
                </div>
                
                <div class="border-t pt-4">
                    <div class="flex justify-between mb-4">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">$0.00</span>
                    </div>
                    <button class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition duration-150">
                        Finalizar Compra
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            #cartDrawer {
                width: 100vw;
            }
        }
    </style>

    <script>
        // Mantener contador visible y reactivo: lee localStorage 'cart'
        function updateCartCount() {
            try {
                const cart = JSON.parse(localStorage.getItem('cart') || '[]');
                const totalQty = cart.reduce((s, i) => s + (i.qty || 0), 0);
                const el = document.getElementById('cartCount');
                if (el) el.textContent = totalQty;
            } catch (e) {
                console.error('cart count error', e);
            }
        }
        document.addEventListener('DOMContentLoaded', updateCartCount);
        // actualizar si se cambia localStorage en otra pestaña
        window.addEventListener('storage', (e) => { if (e.key === 'cart') updateCartCount(); });
    </script>
</body>
</html>