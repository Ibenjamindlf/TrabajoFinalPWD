<?php
// include_once("../../Control/ABMProducto.php");
// $abmProducto = new ABMProducto();
// $arrayProductos = $abmProducto->buscar(NULL);
// if ($arrayProductos != null) {
//     $cantProductos = count($arrayProductos);
// } else {
//     $cantProductos = 0;
// }

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
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
    <title>Modificar Producto</title>
</head>
<body>
    <?php
        include_once ('../structure/header.php');
    ?>
<main class="bg-light mt-5 py-20">
    <div class="container mt-5">
        <div class="card shadow-lg mx-auto" style="max-width: 600px;">
            <div class="card-header bg-warning text-dark text-center">
                <h4 class="mb-0">Modificar Producto</h4>
            </div>

            <div class="card-body">
                <?php if ($producto): ?>
                    <form action="../accion/accionModificarProducto.php" method="POST">

                        <!-- ID Usuario -->
                        <div class="mb-3">
                            <label for="id" class="form-label">ID Producto</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="id" 
                                name="id" 
                                value="<?php echo $producto->getId(); ?>" 
                                readonly
                            >
                        </div>

                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del producto</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="nombre" 
                                name="nombre" 
                                value="<?php echo $producto->getNombre(); ?>" 
                                required
                            >
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock del producto</label>
                            <input 
                                type="number" 
                                class="form-control" 
                                id="stock" 
                                name="stock" 
                                value="<?php echo $producto->getStock(); ?>" 
                                required
                            >
                        </div>

                        <!-- Correo -->
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio del Producto</label>
                            <input 
                                type="number" 
                                class="form-control" 
                                id="precio" 
                                name="precio" 
                                value="<?php echo $producto->getPrecio(); ?>" 
                                required
                            >
                        </div>

                        <!-- Deshabilitado -->
                        <div class="mb-3">
                            <label for="detalle" class="form-label">Detalle del producto</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="detalle" 
                                name="detalle" 
                                value="<?php echo $producto->getdetalle(); ?>" 
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen del producto</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="imagen" 
                                name="imagen" 
                                value="<?php echo $producto->getimagen(); ?>" 
                                required
                            >
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="panelAdmin.php" class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                Guardar Cambios
                            </button>
                        </div>

                    </form>
                <?php else: ?>
                    <div class="alert alert-danger text-center">
                        No se encontró el producto solicitado.
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


