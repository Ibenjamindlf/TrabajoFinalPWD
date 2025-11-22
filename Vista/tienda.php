<?php
// 1. Iniciar sesión
session_start();

// 2. Lógica del Modal de Éxito
$activarModalJS = false;
if (isset($_SESSION['compra_realizada'])) {
    $activarModalJS = true;
    unset($_SESSION['compra_realizada']);
}

// 3. Cargar Productos
include_once("../Control/ABMProducto.php");
$abmProducto = new ABMProducto();
$arrayProductos = $abmProducto->buscar(NULL);
$cantProductos = ($arrayProductos != null) ? count($arrayProductos) : 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>    
    <link rel="shortcut icon" href="/TrabajoFinalPWD/Vista/sources/logo.png" type="image/x-icon">
    <title>Tienda</title>
</head>
<body class="flex flex-col min-h-screen bg-gray-50">

<?php include_once ('../Vista/structure/header.php'); ?>

<?php if ($activarModalJS): ?>
    <div id="flag-compra-exitosa" style="display:none;"></div>
<?php endif; ?>

<main class="flex-grow bg-gray-100 py-12">
    <div class="container mx-auto mt-12 px-4"> 
        
        <div class="text-center mb-12">
            <?php if (isset($_GET['msg'])): ?>
                <?php if ($_GET['msg'] === 'no_carrito'): ?>
                    <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-2 rounded my-2 inline-block">
                        No tienes un carrito activo. Agrega un producto para crear uno.
                    </div>
                <?php elseif ($_GET['msg'] === 'carrito_vacio'): ?>
                    <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-2 rounded my-2 inline-block">
                        No tienes productos en el carrito. Agrega uno por favor.
                    </div>
                 <?php elseif ($_GET['msg'] === 'error_agregar'): ?>
                    <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-2 rounded my-2 inline-block">
                        Error al agregar el producto (Stock insuficiente o error interno).
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <h2 class="text-3xl font-bold mt-4">Nuestros Productos</h2>
            <p class="text-gray-600 mt-2">Explorá nuestros productos destacados</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php if ($cantProductos > 0): ?>
                <?php foreach ($arrayProductos as $unProducto) { ?>
                    
                    <div class="bg-white rounded-lg overflow-hidden h-full shadow-sm border-0 flex flex-col">
                        
                        <img src="/TrabajoFinalPWD/<?php echo $unProducto->getImagen(); ?>" 
                             alt="<?php echo $unProducto->getNombre(); ?>" 
                             class="w-full h-[220px] object-cover">
                        
                        <div class="p-4 flex flex-col justify-between flex-grow">
                            <div>
                                <h5 class="text-xl font-semibold text-gray-900 mb-2">
                                    <?php echo $unProducto->getNombre(); ?>
                                </h5>
                                <p class="text-sm text-gray-500">
                                    <?php echo $unProducto->getDetalle(); ?>
                                </p>
                            </div>
                            <div class="mt-4 text-sm text-gray-700">
                                <?php echo number_format($unProducto->getStock(), 0) ?> unidades disponibles
                            </div>
                            <div class="mt-4">
                                <p class="font-bold text-orange-600 mb-2">
                                    $<?php echo number_format($unProducto->getPrecio(), 2, ',', '.'); ?>
                                </p>
                                
                                <div class="flex gap-2">
                                    <button 
                                        data-product="<?php echo $unProducto->getId(); ?>" 
                                        class="w-1/2 flex justify-center items-center bg-orange-600 text-white py-2 rounded-lg hover:bg-orange-700 transition">
                                        Ver producto
                                    </button>

                                    <button 
                                        type="button"
                                        onclick="agregarConAjax(<?php echo $unProducto->getId(); ?>)"
                                        class="w-1/2 flex justify-center items-center bg-gray-900 text-white py-2 rounded-lg hover:bg-gray-800 transition cursor-pointer">
                                        Agregar al carrito
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php elseif ($cantProductos <= 0): ?>
                <div class="col-span-full flex justify-center items-center text-center mt-12 mb-12">
                    <p class="font-bold uppercase text-gray-500">No hay productos disponibles.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php 
    include_once ('../Vista/structure/footer.php'); 
    
    include_once ('../Vista/structure/modal_compra.php');
?>

<div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2"></div>

<script src="sources/js/tienda.js"></script>

</body>
</html>