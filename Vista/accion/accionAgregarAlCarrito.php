<?php
require_once '../../Control/Session.php';
require_once '../../Control/autenticacion.php';
require_once __DIR__ . '/../../Control/Session.php';
require_once __DIR__ . '/../../Control/ABMCompra.php';
require_once __DIR__ . '/../../Control/ABMCompraProducto.php';


$s = new Session();

// 1) Verificás que esté logueado:
requireLogin($s);

// 2) Verificás que tenga rol cliente, admin o superior:
requireAtLeastRole($s, ROLE_CLIENTE); // cliente = 3, así permitís 1, 2 y 3

// De aca para abajo, tengo que analizarlo en mi rama, esta aca por que me dio paja borrarlo jaja! 
// Abrazo!

// 3) Tomo el id del producto
$idProducto = $_GET['idProducto'] ?? null;
// echo $idProducto;
// 4) Tomo el id del usuario
$session = new Session();
$idUsuario = $session->getIdUsuario();
//echo $rol;
// 5) Creo el abmCompra y busco si hay una compra con el usuario
$abmCompra = new ABMCompra();
$compraEncontrada = $abmCompra->buscar(['idUsuario' => $idUsuario]);
// print_r(end($compraEncontrada));
// $ultimaCompra = end($compraEncontrada);
// $idUltimaCompra = $ultimaCompra->getFecha();
// echo $idUltimaCompra;
// print_r($compraEncontrada);
// $seEncontroCompra = ($compraEncontrada == null) ? "es null" : "no es null";
// echo $seEncontroCompra;
// 6) Si no hay una compra, creo una
if ($compraEncontrada == null){
    $seCreaCompra = $abmCompra->alta(['idUsuario' => $idUsuario]);
    $compraEncontrada = $abmCompra->buscar(['idUsuario' => $idUsuario]);
    $ultimaCompraEncontrada = end($compraEncontrada);
    $idUltimaCompraEncontrada = $ultimaCompraEncontrada->getId();
    // $compraCreada = ($seCreaCompra) ? "se creo compra" : "no se compro";
    // echo $compraCreada;
    // 7) como se creo una compra, debo crear 
} else {
    // aca se debe buscar la compra
    $ultimaCompraEncontrada = end($compraEncontrada);
    $idUltimaCompraEncontrada = $ultimaCompraEncontrada->getId();
    echo $idUltimaCompraEncontrada;
}

$abmCompraProducto = new ABMCompraProducto();
$seAgregoCompraProducto = $abmCompraProducto->alta(['idCompra' => $idUltimaCompraEncontrada,
                                                    'idProducto' => $idProducto,
                                                    'cantidad' => 1]);
header("location: ../cart.php");
exit



?>
