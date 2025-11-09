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
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
    <title>Panel Admin</title>
</head>
<body>
    <?php
        include_once ('../structure/header.php');
    ?>
<main class="bg-light mt-5 py-20">
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Productos Registrados</h4>
                <a href="nuevoProducto.php" class="btn btn-success btn-sm fw-bold">
                    + Agregar Producto
                </a>
            </div>

            <div class="card-body">
                <?php if ($cantProductos > 0): ?>
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Stock</th>
                                <th>Precio</th>
                                <th>Detalle</th>
                                <th>Imagen</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($arrayProductos as $unProducto) { ?>
                                <tr>
                                    <td><?php echo $unProducto->getId(); ?></td>
                                    <td><?php echo $unProducto->getNombre(); ?></td>
                                    <td><?php echo $unProducto->getStock(); ?></td>
                                    <td><?php echo $unProducto->getPrecio(); ?></td>
                                    <td><?php echo $unProducto->getDetalle(); ?></td>
                                    <td><?php echo $unProducto->getImagen(); ?></td>
                                    <td class="text-center">
                                        <a href="modificarProducto.php?id=<?php echo $unProducto->getId(); ?>" class="btn btn-warning btn-sm mt-2">
                                            Modificar
                                        </a>
                                        <a href="../accion/accionEliminarProducto.php?id=<?php echo $unProducto->getId(); ?>" class="btn btn-danger btn-sm mt-2">
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info text-center">
                        No hay productos registrados.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>
</main>
    <?php
        include_once ('../structure/footer.php');
    ?>
</body>
</html>


