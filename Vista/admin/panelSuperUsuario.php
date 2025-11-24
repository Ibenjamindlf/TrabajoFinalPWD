<?php
$Titulo = "Panel Usuarios";
include_once('../structure/header.php');

require_once __DIR__ . '/../../Control/ABMUsuario.php';
require_once __DIR__ . '/../../Control/ABMRol.php';
require_once __DIR__ . '/../../Control/ABMUsuarioRol.php';

$abmUsuario = new ABMUsuario();
$abmUsuarioRol = new ABMUsuarioRol();
$abmRol = new ABMRol();

$usuarios = $abmUsuario->buscar(null);
$roles = $abmRol->buscar(null); // Traer todos los roles
?>

<div class="container mx-auto py-8">
    <h1 class="text-3xl font-semibold text-center mb-8">Panel de Usuarios</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full table-auto border-collapse">
            <thead class="bg-gray-800 text-white text-sm">
                <tr>
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Nombre</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Rol</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">

                <?php foreach ($usuarios as $usuario): ?>
                    <?php 
                        $idUsuario = $usuario->getId();
                        $usuarioRoles = $abmUsuarioRol->buscar(['idUsuario' => $idUsuario]);
                        $rolActual = count($usuarioRoles) > 0 ? $usuarioRoles[0]->getIdRol() : null;
                    ?>

                    <tr class="border-t border-gray-300">
                        <td class="p-3"><?php echo $idUsuario; ?></td>

                        <td class="p-3">
                            <?php echo $usuario->getNombre(); ?>
                        </td>

                        <td class="p-3">
                            <?php echo $usuario->getMail(); ?>
                        </td>

                        <td class="p-3">
                            <form method="POST" action="../accion/Usuarios/accionModificarRol.php">
                                <input type="hidden" name="idusuario" value="<?php echo $idUsuario; ?>">

                                <select name="nuevoRol" class="p-2 border rounded">
                                    <?php foreach ($roles as $rol): ?>
                                        <option value="<?php echo $rol->getId(); ?>"
                                            <?php echo ($rolActual == $rol->getId()) ? 'selected' : ''; ?>>
                                            <?php echo $rol->getDescripcion(); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="text-sm py-1 px-2 rounded bg-yellow-500 hover:bg-yellow-600 text-black">Cambiar</button>
                            </form>
                        </td>

                    </tr>
                    
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<?php include_once('../structure/footer.php'); ?>
