<?php
require_once '../../Control/Session.php';
require_once '../../Control/autenticacion.php';

$s = new Session();

// 1) Verificás que esté logueado:
requireLogin($s);

// 2) Verificás que tenga rol cliente, admin o superior:
requireAtLeastRole($s, ROLE_CLIENTE); // cliente = 3, así permitís 1, 2 y 3

// De aca para abajo, tengo que analizarlo en mi rama, esta aca por que me dio paja borrarlo jaja! 
// Abrazo!

// // 3) Tomás el id del producto
// $idProducto = $_GET['idProducto'] ?? null;

// if (!$idProducto) {
//     header("Location: ../tienda.php?error=missingID");
//     exit;
// }
 
// // 4) Agregás al carrito en BD
// require_once '../../Control/ABMCarrito.php';

// $abmC = new ABMCarrito();
// $abmC->agregarProducto($s->getIdUsuario(), $idProducto);

// // 5) Redirigís
// header("Location: ../productos/tienda.php?added=1");
// exit;
?>
