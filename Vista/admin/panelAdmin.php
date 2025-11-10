<?php
include_once("../../Control/ABMProducto.php");
$abmProducto = new ABMProducto();
$arrayProductos = $abmProducto->buscar(NULL);
if ($arrayProductos != null) {
    $cantProductos = count($arrayProductos);
} else {
    $cantProductos = 0;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>    
    <link rel="shortcut icon" href="/TrabajoFinalPWD/Vista/sources/Logo.png" type="image/x-icon">
    <title>Panel Admin</title>
</head>
<body>
    <?php
        include_once ('../structure/header.php');
    ?>
<main class="bg-gray-100 mt-12 py-20">
    <div class="container mx-auto px-4 mt-12"> <div class="bg-white rounded-lg overflow-hidden shadow-lg">
            
            <div class="p-4 border-b rounded-t-lg bg-blue-600 text-white flex justify-between items-center">
                <h4 class="text-xl font-semibold m-0">Productos Registrados</h4>
                <a href="nuevoProducto.php" class="py-1 px-3 rounded-md shadow-sm text-sm font-bold bg-green-600 text-white hover:bg-green-700">
                    + Agregar Producto
                </a>
            </div>

            <div class="p-4">
                <?php if ($cantProductos > 0): ?>
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-800 text-white text-center">
                            <tr>
                                <th class="border border-gray-300 p-3">ID</th>
                                <th class="border border-gray-300 p-3">Nombre</th>
                                <th class="border border-gray-300 p-3">Stock</th>
                                <th class="border border-gray-300 p-3">Precio</th>
                                <th class="border border-gray-300 p-3">Detalle</th>
                                <th class="border border-gray-300 p-3">Imagen</th>
                                <th class="border border-gray-300 p-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($arrayProductos as $unProducto) { ?>
                                <tr class="odd:bg-gray-100">
                                    <td class="border border-gray-300 p-3 align-middle"><?php echo $unProducto->getId(); ?></td>
                                    <td class="border border-gray-300 p-3 align-middle"><?php echo $unProducto->getNombre(); ?></td>
                                    <td class="border border-gray-300 p-3 align-middle"><?php echo $unProducto->getStock(); ?></td>
                                    <td class="border border-gray-300 p-3 align-middle"><?php echo $unProducto->getPrecio(); ?></td>
                                    <td class="border border-gray-300 p-3 align-middle"><?php echo $unProducto->getDetalle(); ?></td>
                                    <td class="border border-gray-300 p-3 align-middle text-center">
                                        <img src="/TrabajoFinalPWD/<?php echo $unProducto->getImagen(); ?>" 
                                             alt="<?php echo $unProducto->getNombre(); ?>" 
                                             class="w-20 h-20 object-cover rounded-lg inline-block"> </td>

                                    <td class="border border-gray-300 p-3 align-middle text-center">
                                        <a href="modificarProducto.php?id=<?php echo $unProducto->getId(); ?>" 
                                           class="py-1 px-3 text-sm rounded-md shadow-sm bg-yellow-500 text-black hover:bg-yellow-600 mt-2 block">
                                            Modificar
                                        </a>
                                        <a href="../accion/accionEliminarProducto.php?id=<?php echo $unProducto->getId(); ?>" 
                                           class="py-1 px-3 text-sm rounded-md shadow-sm bg-red-600 text-white hover:bg-red-700 mt-2 block">
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="p-4 rounded-md bg-blue-100 text-blue-800 text-center">
                        No hay productos registrados.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </main>    
    <?php
        include_once ('../structure/footer.php');
    ?>
</body>
</html>


