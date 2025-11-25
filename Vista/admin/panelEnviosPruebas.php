<?php
require_once __DIR__ . '/../../Control/Session.php';
require_once __DIR__ . '/../../Control/autenticacion.php';
require_once __DIR__ . '/../../Control/roles.php';

$session = new Session();
requireAtLeastRole($session, ROLE_ADMIN, '/TrabajoFinalPWD/inicio.php');

include_once("../../Control/ABMcompra.php");
include_once("../../Control/ABMUsuario.php");
include_once("../../Control/ABMCompraEstado.php");
include_once("../../Control/ABMCompraEstadoTipo.php");
include_once("../../Control/ABMCompraProducto.php");
include_once("../../Control/ABMProducto.php");

$abmCompra = new ABMCompra();
$abmUsuario = new ABMUsuario();
$abmCompraEstado = new ABMCompraEstado();
$abmCompraEstadoTipo = new ABMCompraEstadoTipo();
$abmCompraProducto = new ABMCompraProducto();
$abmProducto = new ABMProducto();

$compras = $abmCompra->buscar(NULL);
$estadosDisponibles = $abmCompraEstadoTipo->buscar(NULL); // para el select de cambio de estado

function badgeClassByEstado($estado)
{
    $e = strtoupper($estado);
    if (strpos($e, 'PAGO') !== false) return 'bg-green-100 text-green-800';
    if (strpos($e, 'CARRITO') !== false) return 'bg-yellow-100 text-yellow-800';
    if (strpos($e, 'PREPAR') !== false || strpos($e, 'PREPARACION') !== false) return 'bg-blue-100 text-blue-800';
    if (strpos($e, 'ENVIADO') !== false) return 'bg-indigo-100 text-indigo-800';
    if (strpos($e, 'FINALIZ') !== false) return 'bg-gray-100 text-gray-800';
    return 'bg-gray-100 text-gray-800';
}
$mensaje = isset($_GET['msg']) ? $_GET['msg'] : null;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de Envíos</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="shortcut icon" href="/TrabajoFinalPWD/Vista/sources/Logo.png" type="image/x-icon">
</head>

<body class="bg-gray-100 min-h-screen">
    <?php include_once('../structure/header.php'); ?>

    <main class="container mx-auto px-4 py-10">
        <?php if ($mensaje !== null): ?>
            <div class="text-center mb-4 p-4 rounded-lg <?php echo (strpos($mensaje, 'ERROR') !== false)
                                                            ? 'bg-red-100 text-red-700 border border-red-300'
                                                            : 'bg-green-100 text-green-700 border border-green-300'; ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 border-b bg-blue-600 text-white flex items-center justify-between">
                <h2 class="text-lg font-semibold">Panel de Envíos / Compras</h2>
                <div class="text-sm">Total: <span class="font-bold"><?php echo $compras ? count($compras) : 0; ?></span></div>
            </div>

            <div class="p-4">
                <?php if ($compras && count($compras) > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto border-collapse">
                            <thead class="bg-gray-800 text-white text-sm">
                                <tr>
                                    <th class="p-3 text-left">ID</th>
                                    <th class="p-3 text-left">Cliente</th>
                                    <th class="p-3 text-left">Fecha</th>
                                    <th class="p-3 text-left">Estado actual</th>
                                    <th class="p-3 text-left">Productos</th>
                                    <th class="p-3 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                <?php foreach ($compras as $unaCompra):
                                    $idUnaCompra = $unaCompra->getid();
                                    $idCompraUsuario = $unaCompra->getIdUsuario();
                                    $unUsuario = $abmUsuario->buscar(['id' => $idCompraUsuario]);
                                    $nombreUsuario = $unUsuario && count($unUsuario) > 0 ? $unUsuario[0]->getNombre() : '—';

                                    // Buscamos solo el estado que tiene fechaFin en NULL (el activo)
                                    $unaCompraEstado = $abmCompraEstado->buscar([
                                        'idCompra' => $idUnaCompra,
                                        'fechaFinNull' => true
                                    ]);
                                    $fechaIni = $unaCompraEstado && count($unaCompraEstado) > 0 ? $unaCompraEstado[0]->getFechaIni() : $unaCompra->getFecha();
                                    $idCompraEstado = $unaCompraEstado && count($unaCompraEstado) > 0 ? $unaCompraEstado[0]->getIdEstadoTipo() : null;
                                    $unaCompraEstadoTipo = $idCompraEstado ? $abmCompraEstadoTipo->buscar(['id' => $idCompraEstado]) : null;
                                    $detalleEstado = $unaCompraEstadoTipo && count($unaCompraEstadoTipo) > 0 ? $unaCompraEstadoTipo[0]->getDescripcion() : 'SIN ESTADO';
                                    $compraItems = $abmCompraProducto->buscar(['idCompra' => $idUnaCompra]);
                                ?>
                                    <tr class="odd:bg-gray-50">
                                        <td class="p-3 align-center"><?php echo htmlspecialchars($idUnaCompra); ?></td>
                                        <td class="p-3 align-center"><?php echo htmlspecialchars($nombreUsuario); ?></td>
                                        <td class="p-3 align-center"><?php echo htmlspecialchars($fechaIni); ?></td>
                                        <td class="p-3 align-center">
                                            <div class="flex items-center gap-3">
                                                <span class="px-2 py-1 text-xs rounded-full <?php echo badgeClassByEstado($detalleEstado); ?>">
                                                    <?php echo htmlspecialchars($detalleEstado); ?>
                                                </span>

                                                <!-- Form para cambiar estado -->
                                                <form action="../accion/Envios/accionModificarEstado.php" method="post" class="flex items-center gap-2">
                                                    <input type="hidden" name="idCompra" value="<?php echo htmlspecialchars($idUnaCompra); ?>">
                                                    <select name="nuevoEstado" class="border rounded px-2 py-1 text-sm">
                                                        <?php foreach ($estadosDisponibles as $estadoOpt):
                                                            $selected = ($estadoOpt->getId() == $idCompraEstado) ? 'selected' : '';
                                                        ?>
                                                            <option value="<?php echo $estadoOpt->getId(); ?>" <?php echo $selected; ?>>
                                                                <?php echo htmlspecialchars($estadoOpt->getDescripcion()); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <button type="submit" class="text-sm py-1 px-2 rounded bg-yellow-500 hover:bg-yellow-600 text-black">Cambiar</button>
                                                </form>
                                            </div>
                                        </td>

                                        <td class="p-3 align-top">
                                            <ul class="space-y-2">
                                                <?php
                                                if ($compraItems && count($compraItems) > 0):
                                                    foreach ($compraItems as $item):
                                                        $idProducto = $item->getIdProducto();
                                                        $unProducto = $abmProducto->buscar(['id' => $idProducto]);
                                                        $nombreUnProducto = $unProducto && count($unProducto) > 0 ? $unProducto[0]->getNombre() : 'Producto eliminado';
                                                        $cantidadProducto = $item->getCantidad();
                                                ?>
                                                        <li class="flex items-center gap-3">
                                                            <span class="text-xs px-2 py-1 bg-gray-100 rounded"><?php echo htmlspecialchars($cantidadProducto); ?>x</span>
                                                            <span class="text-sm"><?php echo htmlspecialchars($nombreUnProducto); ?></span>
                                                        </li>
                                                    <?php
                                                    endforeach;
                                                else:
                                                    ?>
                                                    <li class="text-gray-500">Sin productos</li>
                                                <?php endif; ?>
                                            </ul>
                                        </td>

                                        <td class="p-3 align-top text-center">
                                            <a href="verCompra.php?id=<?php echo $idUnaCompra; ?>" class="inline-block px-3 py-1 rounded bg-blue-500 hover:bg-blue-600 text-white text-sm mb-2">Ver</a>
                                            <a href="../accion/Compra/eliminarCompra.php?id=<?php echo $idUnaCompra; ?>" class="inline-block px-3 py-1 rounded bg-red-600 hover:bg-red-700 text-white text-sm"
                                                onclick="return confirm('¿Eliminar compra #<?php echo $idUnaCompra; ?>? Esta acción no se puede deshacer.');">Eliminar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="p-6 text-center text-gray-600">
                        No hay compras registradas.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include_once('../structure/footer.php'); ?>
</body>

</html>