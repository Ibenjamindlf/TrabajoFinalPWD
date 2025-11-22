<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../Control/Session.php';
require_once __DIR__ . '/../../Control/ABMCompraProducto.php';
require_once __DIR__ . '/../../Control/ABMProducto.php';

$session = new Session();
$response = ['success' => false, 'msg' => ''];

// Validar sesión
if (!$session->activa()) {
    echo json_encode(['success' => false, 'msg' => 'Sesión expirada']);
    exit;
}

// Leer JSON de entrada
$input = json_decode(file_get_contents('php://input'), true);
$accion = $input['accion'] ?? '';
$idItem = $input['id'] ?? 0;

if ($idItem && $accion) {
    $abmCP = new ABMCompraProducto();
    $resultado = false;

    // Enrutamos a los métodos del ABM
    switch ($accion) {
        case 'sumar':
            $resultado = $abmCP->sumarCantidad(['id' => $idItem]);
            break;
        case 'restar':
            $resultado = $abmCP->restarCantidad(['id' => $idItem]);
            break;
        case 'quitar':
            $resultado = $abmCP->quitarProductoDelCarrito(['idCompraProducto' => $idItem]);
            break;
    }

    if ($resultado) {
        // Si salió bien, recalculamos datos para actualizar la vista
        $items = $abmCP->buscar(['id' => $idItem]);
        $nuevaCantidad = 0;
        $nuevoSubtotal = 0;
        
        if (!empty($items)) {
            $item = $items[0];
            $nuevaCantidad = $item->getCantidad();
            
            $abmProd = new ABMProducto();
            $prod = $abmProd->buscar(['id' => $item->getIdProducto()])[0];
            $nuevoSubtotal = $prod->getPrecio() * $nuevaCantidad;
        }

        $response = [
            'success' => true,
            'cantidad' => $nuevaCantidad,
            'subtotal' => number_format($nuevoSubtotal, 2, ',', '.'),
            'eliminado' => empty($items)
        ];
    } else {
        $response['msg'] = 'No se pudo realizar la acción (Stock insuficiente o error)';
    }
}

echo json_encode($response);
exit;
?>