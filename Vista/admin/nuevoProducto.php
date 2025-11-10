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
    <title>Ingresar Producto</title>
</head>
<body>
    <?php
        include_once ('../structure/header.php');
    ?>
<main class="bg-light mt-5 py-20">
    <div class="container mt-5">
        <div class="card shadow-lg mx-auto" style="max-width: 600px;">
            <div class="card-header bg-warning text-dark text-center">
                <h4 class="mb-0">Ingresar Producto</h4>
            </div>

            <div class="card-body">
                    <form action="../accion/accionNuevoProducto.php" method="POST" enctype="multipart/form-data">

                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del producto</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="nombre" 
                                name="nombre" 
                                placeholder="Ingrese el nombre del producto"
                                required
                            >
                        </div>

                        <!-- Stock -->
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock del producto</label>
                            <input 
                                type="number" 
                                class="form-control" 
                                id="stock" 
                                name="stock" 
                                placeholder="Ingrese el stock del producto"
                                required
                            >
                        </div>

                        <!-- Precio -->
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio del Producto</label>
                            <input 
                                type="number" 
                                class="form-control" 
                                id="precio" 
                                name="precio" 
                                placeholder="Ingrese el precio del producto"
                                required
                            >
                        </div>

                        <!-- Detalle -->
                        <div class="mb-3">
                            <label for="detalle" class="form-label">Detalle del producto</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="detalle" 
                                name="detalle" 
                                placeholder="Ingrese el detalle del producto"
                                required
                            >
                        </div>

                        <!-- Imagen -->
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen del producto</label>
                            <input 
                                type="file" 
                                class="form-control" 
                                id="imagen" 
                                name="imagen" 
                                accept=".jpg,.jpeg,.png"
                                required
                            >
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="panelAdmin.php" class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                Ingrsar producto
                            </button>
                        </div>
                    </form>
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


