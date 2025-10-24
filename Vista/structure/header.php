<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Index Page</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

  <!-- Checkbox escondido para activar el Carrito -->
  <input type="checkbox" id="cartToggle" class="hidden">

  <!-- Navbar -->
  <header class="w-full bg-white shadow-md p-4 fixed top-0 left-0 z-20">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
      <div class="hidden md:flex w-full justify-between items-center">
        <div class="text-lg font-bold"><a href="/TrabajoFinalPWD"><img class="h-8 w-8" src="/TrabajoFinalPWD/Vista/sources/logo.png" alt=""></a></div>
        <nav class="flex space-x-10 font-semibold">
          <a href="/TrabajoFinalPWD" class="text-gray-700 hover:text-gray-900">Inicio</a>
          <a href="/TrabajoFinalPWD/Vista/tienda.php" class="text-gray-700 hover:text-gray-900">Tienda</a>
          <a href="/TrabajoFinalPWD/Vista/about.php" class="text-gray-700 hover:text-gray-900">Sobre nosotros</a>
        </nav>
        <div class="flex space-x-6 items-center">
          <a href="/TrabajoFinalPWD/Vista/login.php" class="text-gray-700 hover:text-gray-900">Iniciar sesión</a>
          <label for="cartToggle" class="cursor-pointer text-gray-700 hover:text-gray-900">
            <!-- Cart Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-2 8h14l-2-8m-5 0V5m0 10a1 1 0 101 1m-5-5a1 1 0 101 1" />
            </svg>
          </label>
        </div>
      </div>

      <div class="md:hidden flex items-center justify-between w-full">
        <div class="text-lg font-bold"><a href="/TrabajoFinalPWD"><img class="h-8 w-8" src="/TrabajoFinalPWD/Vista/sources/logo.png" alt=""></a></div>
      </div>
    </div>
  </header>

  <!-- Carrito Overlay -->
  <div id="cartOverlay" class="fixed inset-0 z-30 bg-black bg-opacity-50 opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out"></div>
  
  <div id="cartDrawer" class="fixed top-0 right-0 h-full w-80 md:w-96 bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out z-40 p-4 md:max-w-xs">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-lg font-bold">Tu Carrito</h2>
      <label for="cartToggle" class="cursor-pointer text-gray-500 hover:text-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </label>
    </div>
    <p class="text-gray-700">Tu carrito está vacío.</p>
  </div>

  <style>
    /* Muestra el Carrito y el overlay cuando el checkbox es chequeado */
    #cartToggle:checked ~ #cartDrawer {
      transform: translateX(0);
    }
    #cartToggle:checked ~ #cartOverlay {
      opacity: 1;
      pointer-events: auto;
    }
    /* Hace que el Carrito ocupe toda la pantalla en pantallas pequeñas */
    @media (max-width: 768px) {
      #cartDrawer {
        width: 100vw;
      }
    }
  </style>

</body>
</html>