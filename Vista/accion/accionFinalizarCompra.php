<?php
session_start();
require __DIR__ . '/../../vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../includes');
$dotenv->load();

include_once(__DIR__ . '/../../Control/ABMUsuario.php');
include_once(__DIR__ . '/../../Control/ABMCompra.php');
include_once(__DIR__ . '/../../Control/ABMCompraProducto.php');
include_once(__DIR__ . '/../../Control/ABMCompraEstado.php');
include_once(__DIR__ . '/../../Clases/Email.php');
include_once(__DIR__ . '/../../Modelo/Usuario.php');


if (!isset($_SESSION['idusuario']) || empty($_SESSION['carrito'])) {
    header('Location: /TrabajoFinalPWD/Vista/tienda.php');
    exit;
}

$idUsuario = $_SESSION['idusuario'];
$carrito = $_SESSION['carrito']; 

$abmUsuario = new ABMUsuario();
$datosUsuario = $abmUsuario->buscar(['id' => $idUsuario]);
$usuarioObj = $datosUsuario[0];

$abmCompra = new ABMCompra();

if ($abmCompra->alta(['idUsuario' => $idUsuario])) {
    

    $compras = $abmCompra->buscar(['idUsuario' => $idUsuario]);
    $ultimaCompra = end($compras); 
    $idCompra = $ultimaCompra->getId();

    $abmCompraProd = new ABMCompraProducto();
    $totalCompra = 0;
    $productosParaEmail = []; 

    foreach ($carrito as $item) {
        
        // Intentamos insertar y descontar stock
        $datosProd = [
            'idCompra' => $idCompra,
            'idProducto' => $item['id'],
            'cantidad' => $item['cantidad']
        ];
        
        if ($abmCompraProd->alta($datosProd)) {
            $subtotal = $item['precio'] * $item['cantidad'];
            $totalCompra += $subtotal;

            $productosParaEmail[] = [
                'nombre' => $item['nombre'],
                'cantidad' => $item['cantidad'],
                'precio' => $item['precio']
            ];
        }
    }

    $abmEstado = new ABMCompraEstado();
    $abmEstado->alta([
        'idCompra' => $idCompra,
        'idEstadoTipo' => 1 
    ]);


    $emailSender = new Email($usuarioObj->getMail(), $usuarioObj->getNombre(), null);
    $emailSender->enviarResumenCompra($productosParaEmail, $totalCompra);

    unset($_SESSION['carrito']); 
    $_SESSION['mensaje_exito'] = "¡Compra realizada con éxito! Revisa tu correo.";
    header('Location: /TrabajoFinalPWD/Vista/tienda.php');
    exit;

} else {
    $_SESSION['errores_abm'] = "Hubo un error al iniciar la compra.";
    header('Location: /TrabajoFinalPWD/Vista/carrito.php');
    exit;
}
?>