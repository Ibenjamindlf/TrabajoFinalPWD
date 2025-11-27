<?php
$Titulo = "Panel Usuarios";

require_once __DIR__ . '/../../Control/ABMUsuario.php';
require_once __DIR__ . '/../../Control/ABMRol.php';
require_once __DIR__ . '/../../Control/ABMUsuarioRol.php';
require_once __DIR__ . '/../../Control/Session.php';

$sesion = new Session();
$esRolPermitdo = $sesion->requiereRol([1,2]); // Solo rol 1 puede ver esto

if (!$esRolPermitdo){
    header("Location: /TrabajoFinalPWD/Vista/login.php");
    exit;
}

include_once('../structure/header.php');
$abmUsuario = new ABMUsuario();
$abmUsuarioRol = new ABMUsuarioRol();
$abmRol = new ABMRol();

$usuarios = $abmUsuario->buscar(null);
$roles = $abmRol->buscar(null); // Traer todos los roles

$mensaje = isset($_GET['msg']) ? $_GET['msg'] : null;
?>

<div class="container mx-auto py-8">
    <?php if ($mensaje !== null): ?>
        <div class="text-center mb-4 p-4 rounded-lg <?php echo (strpos($mensaje, 'ERROR') !== false) 
                ? 'bg-red-100 text-red-700 border border-red-300' 
                : 'bg-green-100 text-green-700 border border-green-300'; ?>">
            <?php echo htmlspecialchars($mensaje); ?>
        </div>
    <?php endif; ?>
    <h1 class="text-3xl font-semibold text-center mb-8">Panel de Usuarios</h1>
<div class="w-3/4 mx-auto">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
    <table class="w-full table-fixed"> <!-- table-fixed reduce el reflow y evita que una columna crezca demasiado -->
        <thead class="bg-gray-900 text-white text-xs uppercase">
            <tr>
                <th class="py-2 px-3 text-left">ID</th>
                <th class="py-2 px-3 text-left">Nombre</th>
                <th class="py-2 px-3 text-left">Email</th>
                <th class="py-2 px-3 text-center">Rol | Acción</th>
            </tr>
        </thead>

        <tbody class="text-gray-800 text-sm divide-y divide-gray-200">

            <?php foreach ($usuarios as $usuario): ?>
                <?php 
                    $idUsuario = $usuario->getId();
                    $usuarioRoles = $abmUsuarioRol->buscar(['idUsuario' => $idUsuario]);
                    $rolActual = count($usuarioRoles) > 0 ? $usuarioRoles[0]->getIdRol() : null;
                ?>

                <tr class="hover:bg-gray-50 transition">
                    <td class="py-2 px-2 font-medium whitespace-nowrap"><?php echo $idUsuario; ?></td>

                    <!-- Usamos truncate para evitar que el contenido rompa la tabla -->
                    <td class="py-2 px-2 whitespace-nowrap truncate" title="<?php echo $usuario->getNombre(); ?>">
                        <?php echo $usuario->getNombre(); ?>
                    </td>

                    <td class="py-2 px-2 whitespace-nowrap truncate" title="<?php echo $usuario->getMail(); ?>">
                        <?php echo $usuario->getMail(); ?>
                    </td>

                    <td class="py-2 px-2 text-center">
                        <form method="POST" action="../accion/Usuarios/accionModificarRol.php" class="flex items-center justify-center gap-1">
                            <input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>">

                            <select name="nuevoRol"
                                class="px-1 py-1 border border-gray-300 rounded-md text-sm bg-white focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-gray-700 transition w-1/2">
                                <?php foreach ($roles as $rol): ?>
                                    <option value="<?php echo $rol->getId(); ?>"
                                        <?php echo ($rolActual == $rol->getId()) ? 'selected' : ''; ?>>
                                        <?php echo $rol->getDescripcion(); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <button type="submit"
                                class="text-sm py-1 px-2 rounded-md bg-yellow-500 hover:bg-yellow-600 text-black font-medium shadow-sm transition">
                                Cambiar
                            </button>
                        </form>
                    </td>
                </tr>

            <?php endforeach; ?>

        </tbody>
    </table>
</div>
</div>

</div>

<?php include_once('../structure/footer.php'); ?>
