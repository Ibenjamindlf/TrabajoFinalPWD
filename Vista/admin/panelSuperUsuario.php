<?php
require_once __DIR__ . '/../../Control/Session.php';
require_once __DIR__ . '/../../Control/autenticacion.php';
require_once __DIR__ . '/../../Control/roles.php';

include_once __DIR__ . '/../../Control/ABMUsuarioRol.php';
include_once __DIR__ . '/../../Control/ABMRol.php';

$session = new Session();

// Requiere ser admin (2) o superior (1)
requireAtLeastRole($session, ROLE_SUPERADMIN, '/TrabajoFinalPWD/inicio.php'); // opcional: redirigir a inicio si no tiene permiso

include_once("../../Control/ABMUsuario.php");
$abmUsuario = new ABMUsuario();
$arrayUsuario = $abmUsuario->buscar(NULL);
if ($arrayUsuario != null) {
    $cantUsuarios = count($arrayUsuario);
} else {
    $cantUsuarios = 0;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>    
    <link rel="shortcut icon" href="/TrabajoFinalPWD/Vista/sources/Logo.png" type="image/x-icon">
    <title>Panel SuperAdmin</title>
</head>
<body>
    <?php
        include_once ('../structure/header.php');
    ?>
<main class="bg-gray-100 mt-12 py-20">
    <div class="container mx-auto px-4 mt-12"> <div class="bg-white rounded-lg overflow-hidden shadow-lg">
            
            <div class="p-4 border-b rounded-t-lg bg-blue-600 text-white flex justify-between items-center">
                <h4 class="text-xl font-semibold m-0">Usuarios Registrados</h4>
                
            </div>

            <div class="p-4">
                <?php if ($cantUsuarios > 0): ?>
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-800 text-white text-center">
                            <tr>
                                <th class="border border-gray-300 p-3">ID</th>
                                <th class="border border-gray-300 p-3">Nombre</th>
                                <th class="border border-gray-300 p-3">Mail</th>
                                <th class="border border-gray-300 p-3">Rol</th>
                                <th class="border border-gray-300 p-3">habilitado</th>
                                <th class="border border-gray-300 p-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($arrayUsuario as $unUsuario) { ?>
                                <?php 
                                    $idUsuario = $unUsuario->getId();
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
                                <tr class="odd:bg-gray-100">
                                    <td class="border border-gray-300 p-3 align-middle"><?php echo $unUsuario->getId(); ?></td>
                                    <td class="border border-gray-300 p-3 align-middle"><?php echo $unUsuario->getNombre(); ?></td>
                                    <td class="border border-gray-300 p-3 align-middle"><?php echo $unUsuario->getMail(); ?></td>
                                    <td class="border border-gray-300 p-3 align-middle"><?php echo $rolDisplay; ?></td>
                                    <td class="border border-gray-300 p-3 align-middle">
                                        <?php if($unUsuario->getDeshabilitado()!= null){?>
                                            <span class="text-red-600 font-bold">Deshabilitado</span>
                                        <?php } else { ?>
                                            <span class="text-green-600 font-bold">Habilitado</span>
                                        <?php } ?>

                                    </td>
                                    <td class="border border-gray-300 p-3 align-middle text-center">
                                        <a href="modificarProducto.php?id=<?php echo $unUsuario->getId(); ?>" 
                                           class="py-1 px-3 text-sm rounded-md shadow-sm bg-yellow-500 text-black hover:bg-yellow-600 mt-2 block">
                                            Modificar
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


