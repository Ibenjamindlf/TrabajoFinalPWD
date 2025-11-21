<?php

include_once(__DIR__ . '/../../Control/Session.php');


$session = new Session();
$session->cerrar();

header('Location: /TrabajoFinalPWD/Vista/login.php?logout=true');
exit;

?>