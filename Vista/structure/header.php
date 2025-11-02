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
                <!-- Top Header with Search -->
                <div class="flex items-center justify-between py-4 border-b">
                    <div class="flex items-center space-x-4">
                        <!-- Mobile menu button -->
                        <label for="mobileMenu" class="md:hidden">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </label>
                        <a href="/TrabajoFinalPWD" class="flex items-center hover:transition hover:duration-150 hover:ease-in-out hover:scale-105">
                            <img class="h-10 w-10" src="/TrabajoFinalPWD/Vista/sources/Logo.png" alt="Logo">
                            <span class="ml-2 text-xl font-bold text-gray-200 hover:text-yellow-400">Vinilos truchos</span>
                        </a>
                    </div>

                    <!-- Search Bar -->
                    <div class="hidden md:flex flex-1 max-w-2xl mx-8">
                        <div class="relative w-full">
                            <input type="text" placeholder="Buscar productos..." class="w-full px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:border-orange-400">
                            <button class="absolute right-3 top-2">
                                <svg class="h-5 w-5 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Right Header Items -->
                    <div class="flex items-center space-x-6">
                        <a href="/TrabajoFinalPWD/Vista/login.php" class="hidden md:flex items-center text-gray-200 hover:text-orange-400">
                            <svg class="h-6 w-6 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Cuenta</span>
                        </a>
                        <a href="/TrabajoFinalPWD/Vista/cart.php" class="flex items-center text-gray-200 hover:text-orange-400">
                            <div class="relative">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span id="cartCount" class="absolute -top-2 -right-2 bg-orange-400 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                            </div>
                            <span class="hidden md:inline ml-1">Carrito</span>
                        </a>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="hidden md:flex space-x-8 py-4">
                    <a href="/TrabajoFinalPWD/Vista/tienda.php" class="text-gray-200 hover:text-orange-400 font-medium">Productos</a>
                    <a href="/TrabajoFinalPWD/Vista/about.php" class="text-gray-200 hover:text-orange-400 font-medium">Sobre nosotros</a>
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