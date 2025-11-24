<?php
require_once __DIR__ . '/../../Control/Session.php';
require_once __DIR__ . '/../../Control/ABMMenuRol.php';

$session = new Session(); // session_start() interno

// ---- Estado de sesión / informacion de roles ----
$logueado = $session->activa();
$usuario = $logueado ? $session->getNombreUsuario() : null;
$rawRoles = $logueado ? $session->getRoles() : [4];
// ---- Informacion del menu dinamico ----
$abmMenuRol = new ABMMenuRol();
    $param['idRol'] = $rawRoles[0];
    $algo = $abmMenuRol->buscar($param);
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
    <nav class="hidden md:flex space-x-8 py-7">
        <!-- Mi cuenta / Iniciar sesión -->
        <?php if ($logueado): ?>
        <a href="/TrabajoFinalPWD/Vista/miCuenta.php" class="text-gray-200 hover:text-orange-400 font-medium">Mi cuenta</a>
        <?php else: ?>
        <a href="/TrabajoFinalPWD/Vista/login.php" class="text-gray-200 hover:text-orange-400 font-medium">Iniciar sesión</a>
        <?php endif; ?>
        <!-- Menu dinamico, dependiendo del rol -->
        <?php
        foreach ($algo as $menuRol) {
        $menu = $menuRol->getObjMenu();
        $nombreMenu = $menu->getNombre();
        $linkMenu = $menu->getLink();
        ?>
        <a href="<?php echo $linkMenu ?>" class="text-gray-200 hover:text-orange-400 font-medium"><?php echo $nombreMenu?></a>
        <?php
        }
        ?>
    </nav>
    </div>
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