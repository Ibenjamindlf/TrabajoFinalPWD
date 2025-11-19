<?php
// include_once("../../Control/ABMProducto.php");
// $abmProducto = new ABMProducto();
// $arrayProductos = $abmProducto->buscar(NULL);
// if ($arrayProductos != null) {
//     $cantProductos = count($arrayProductos);
// } else {
//     $cantProductos = 0;
// }
require_once __DIR__ . '/../../Control/Session.php';
require_once __DIR__ . '/../../Control/autenticacionPrueba.php';
require_once __DIR__ . '/../../Control/roles.php';

$session = new Session();

// Requiere ser admin (2) o superior (1)
requireAtLeastRole($session, ROLE_ADMIN, '/TrabajoFinalPWD/inicio.php'); // opcional: redirigir a inicio si no tiene permiso

include_once(__DIR__ . "/../../Control/ABMProducto.php");

$id = $_GET['id'] ?? null;

// print_r($_GET);

$abmProducto = new ABMProducto();
$producto = null;

if ($id) {
    $producto = $abmProducto->buscar(['id' => $id]);
    if ($producto) {
        $producto = $producto[0];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>    
    <link rel="shortcut icon" href="/TrabajoFinalPWD/Vista/sources/Logo.png" type="image/x-icon">
    <title>Modificar Producto</title>
</head>
<body>
    <?php
        include_once ('../structure/header.php');
    ?>
<main class="bg-gray-100 mt-12 py-12">
    <div class="container mx-auto px-4">
        
        <div class="bg-white rounded-lg shadow-lg mx-auto overflow-hidden max-w-[600px]">
            <div class="p-4 border-b bg-yellow-400 text-black text-center">
                <h4 class="text-xl font-semibold mb-0">Modificar Producto</h4>
            </div>

            <div class="p-6">
                <?php if ($producto): ?>
                    <form action="../accion/accionModificarProducto.php" method="POST" enctype="multipart/form-data" id="formProducto">

                        <div class="mb-4">
                            <label for="id" class="block text-sm font-medium text-gray-700 mb-1">ID Producto</label>
                            <input 
                                type="text" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 bg-gray-100" 
                                id="id" 
                                name="id" 
                                value="<?php echo $producto->getId(); ?>" 
                                readonly
                            >
                            
                        </div>

                        <div class="mb-4">
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del producto</label>
                            <input 
                                type="text" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500" 
                                id="nombre" 
                                name="nombre" 
                                value="<?php echo $producto->getNombre(); ?>" 
                                
                            >
                            <p id="errorNombre" class="text-sm mt-1"></p>
                        </div>

                        <div class="mb-4">
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock del producto</label>
                            <input 
                                type="number" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500" 
                                id="stock" 
                                name="stock" 
                                value="<?php echo $producto->getStock(); ?>" 
                                
                            >
                            <p id="errorStock" class="text-sm mt-1"></p>
                        </div>

                        <div class="mb-4">
                            <label for="precio" class="block text-sm font-medium text-gray-700 mb-1">Precio del Producto</label>
                            <input 
                                type="number" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500" 
                                id="precio" 
                                name="precio" 
                                value="<?php echo $producto->getPrecio(); ?>" 
                                
                            >
                            <p id="errorPrecio" class="text-sm mt-1"></p>
                        </div>

                        <div class="mb-4">
                            <label for="detalle" class="block text-sm font-medium text-gray-700 mb-1">Detalle del producto</label>
                            <input 
                                type="text" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500" 
                                id="detalle" 
                                name="detalle" 
                                value="<?php echo $producto->getdetalle(); ?>" 
                                
                            >
                            <p id="errorDetalle" class="text-sm mt-1"></p>
                        </div>

                        <div class="mb-4">
                            <label for="imagen" class="block text-sm font-medium text-gray-700 mb-1">Imagen del producto</label>
                            <input 
                                type="file" 
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none
                                       file:mr-4 file:py-2 file:px-4 file:rounded-sm file:border-0
                                       file:text-sm file:font-semibold file:bg-black file:text-white
                                       hover:file:bg-gray-700" 
                                id="imagen" 
                                name="imagen"
                                accept=".jpg,.jpeg,.png"
                            >
                            <p id="errorImagen" class="text-sm mt-1"></p>
                        </div>

                        <div class="flex justify-between mt-6">
                            <a href="panelAdmin.php" class="py-2 px-4 rounded-md font-semibold bg-gray-500 text-white hover:bg-gray-600">
                                Cancelar
                            </a>
                            <button type="submit" class="py-2 px-4 rounded-md font-semibold bg-green-600 text-white hover:bg-green-700">
                                Guardar Cambios
                            </button>
                        </div>

                    </form>
                <?php else: ?>
                    <div class="p-4 mb-4 rounded-lg bg-red-100 text-red-700 text-center">
                        No se encontró el producto solicitado.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    </main>
    <?php
        include_once ('../structure/footer.php');
    ?>
    <script src="../sources/js/validadores.js"></script>
    <script src="../sources/js/validadorModificarProducto.js"></script>
</body>
</html>


