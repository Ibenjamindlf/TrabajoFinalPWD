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
require_once __DIR__ . '/../../Control/autenticacion.php';
require_once __DIR__ . '/../../Control/roles.php';

$session = new Session();

// Requiere ser admin (2) o superior (1)
requireAtLeastRole($session, ROLE_SUPERADMIN, '/TrabajoFinalPWD/inicio.php'); // opcional: redirigir a inicio si no tiene permiso

include_once(__DIR__ . "/../../Control/ABMUsuario.php");
include_once(__DIR__ . "/../../Control/ABMRol.php");
include_once(__DIR__ . "/../../Control/ABMUsuarioRol.php");

$id = $_GET['id'] ?? null;

// print_r($_GET);

$abmUsuario = new ABMUsuario();
$Usuario = null;

if ($id) {
    $Usuario = $abmUsuario->buscar(['id' => $id]);
    if ($Usuario) {
        $Usuario = $Usuario[0];
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
    <title>Modificar Usuario</title>
</head>
<body>
    <?php
        include_once ('../structure/header.php');
    ?>
<main class="bg-gray-100 mt-12 py-12">
    <div class="container mx-auto px-4">
        
        <div class="bg-white rounded-lg shadow-lg mx-auto overflow-hidden max-w-[600px]">
            <div class="p-4 border-b bg-yellow-400 text-black text-center">
                <h4 class="text-xl font-semibold mb-0">Modificar Usuario</h4>
            </div>

            <div class="p-6">
                <?php if ($Usuario): ?>
                    <form action="../accion/accionModificarProducto.php" method="POST" enctype="multipart/form-data" id="formModUsuario">

                        <div class="mb-4">
                            <label for="id" class="block text-sm font-medium text-gray-700 mb-1">ID Usuario</label>
                            <input 
                                type="text" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 bg-gray-100" 
                                id="id" 
                                name="id" 
                                value="<?php echo $Usuario->getId(); ?>" 
                                readonly
                            >
                            
                        </div>

                        <div class="mb-4">
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del usuario</label>
                            <input 
                                type="text" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500" 
                                id="nombre" 
                                name="nombre" 
                                value="<?php echo $Usuario->getNombre(); ?>" 
                                readonly
                                
                            >
                            <p id="errorNombre" class="text-sm mt-1"></p>
                        </div>

                        <div class="mb-4">
                            <label for="mail" class="block text-sm font-medium text-gray-700 mb-1">email</label>
                            <input 
                                type="email" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500" 
                                id="mail" 
                                name="mail" 
                                value="<?php echo $Usuario->getMail(); ?>" 
                                readonly
                            >
                            <p id="errorMail" class="text-sm mt-1"></p>
                        </div>

                        <div class="mb-4">
                            <?php 
                                    $arrayRoles = Rol::seleccionar();

                                    $idUsuario = $Usuario->getId();
                                    $abmUsuarioRol = new ABMUsuarioRol();
                                    $arrayUsuarioRol = $abmUsuarioRol->buscar(['idUsuario' => $idUsuario]);
                                    $cantUsuarioRol = count($arrayUsuarioRol);
                                    $rolDisplay = "";
                                    if ($cantUsuarioRol > 0) {
                                        foreach ($arrayUsuarioRol as $usuarioRol) {
                                            $idRol = $usuarioRol->getIdRol();
                                            $abmRol = new ABMRol();
                                            $objRol = new Rol();
                                            $objRol->setId($idRol);
                                            $objRol->cargar($objRol);

                                            $rolDescripcion = $objRol->getDescripcion();
                                            $rolDisplay .= "-- ". $rolDescripcion . " --";
                                        }
                                    } else {
                                        $rolDisplay = "Sin rol asignado";
                                    }
                                    ?>
                            <label for="roles" class="block text-sm font-medium text-gray-700 mb-1">Roles</label>
                            <input 
                                type="text" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500" 
                                id="rol" 
                                name="rol" 
                                value="<?php echo $rolDisplay; ?>" 
                                
                            >
                            <p id="errorPrecio" class="text-sm mt-1"></p>
                        </div>

                        <div class="mb-4">
                            <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                            <input 
                                type="text" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500" 
                                id="estado" 
                                name="estado" 
                                <?php if($Usuario->getDeshabilitado()!= null):?>
                                            value="Deshabilitado";
                                <?php else: ?>
                                            value="Habilitado";
                                <?php endif;?>
                                
                            >
                            <p id="errorDetalle" class="text-sm mt-1"></p>
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
                        No se encontró el Usuario solicitado.
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


