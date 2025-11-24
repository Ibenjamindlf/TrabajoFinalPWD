<?php
require_once __DIR__ . '/../../Control/Session.php';
require_once __DIR__ . '/../../Control/autenticacion.php';

$session = new Session();

// Requiere ser admin (2) o superior (1)
requireAtLeastRole($session, ROLE_ADMIN, '/TrabajoFinalPWD/inicio.php'); // opcional: redirigir a inicio si no tiene permiso

// Obtengo todas las compras
// De la tabla "compra" me quedo unicamente con el ID.
include_once("../../Control/ABMcompra.php");
$abmCompra = new ABMCompra();
$compras = $abmCompra->buscar(NULL);
// --
include_once("../../Control/ABMUsuario.php");
$abmUsuario = new ABMUsuario();
// --
include_once("../../Control/ABMCompraEstado.php");
$abmCompraEstado = new ABMCompraEstado();
// --
include_once("../../Control/ABMCompraEstadoTipo.php");
$abmCompraEstadoTipo = new ABMCompraEstadoTipo();
// --
include_once("../../Control/ABMCompraProducto.php");
$abmCompraProducto = new ABMCompraProducto();
// --
include_once("../../Control/ABMProducto.php");
$abmProducto = new ABMProducto();
// | ID Compra | Cliente | Fecha | Estado actual | Productos | Acción 
foreach ($compras as $unaCompra){
    $idUnaCompra = $unaCompra->getid();
    $idCompraUsuario = $unaCompra->getIdUsuario();
    echo "id compra: $idUnaCompra <br>";
    $unUsuario = $abmUsuario->buscar(['id'=>$idCompraUsuario]);
    $nombreUsuario = $unUsuario[0]->getNombre();
    echo "Usuario: " . $nombreUsuario . "<br>";
    $unaCompraEstado = $abmCompraEstado->buscar(['idCompra'=>$idUnaCompra]);
    $fechaIni = $unaCompraEstado[0]->getFechaIni();
    echo "Fecha compra:" . $fechaIni . "<br>";
    $idCompraEstado = $unaCompraEstado[0]->getIdEstadoTipo();
    $unaCompraEstadoTipo = $abmCompraEstadoTipo->buscar(['id'=>$idCompraEstado]);
    $detalleEstado = $unaCompraEstadoTipo[0]->getDescripcion();
    echo "Estado actual:" . $detalleEstado . "<br>";
    $compraItemsVinculadas = $abmCompraProducto->buscar(['idCompra'=>$idUnaCompra]);
    $i = 1;
    foreach ($compraItemsVinculadas as $unaCompraItem){
        $idProducto = $unaCompraItem->getIdProducto();
        $unProducto = $abmProducto->buscar(['id'=>$idProducto]);        
        $nombreUnProducto = $unProducto[0]->getNombre();
        echo "Nombre del producto $i: $nombreUnProducto <br>";
        $cantidadProducto = $unaCompraItem->getCantidad();
        echo "cantidad: $cantidadProducto <br>";
        $i++;
    }
    echo "<br>";
echo "--------------------------------- <br>";}

?>