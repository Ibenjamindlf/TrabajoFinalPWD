<?php

class Validador {

    // Verifica que un valor no esté vacío
    public static function noEstaVacio($valor) {
        return !empty($valor);
    }

    // Verifica que un valor sea un número y mayor que cero
    public static function esNumeroPositivo($valor) {
        return (is_numeric($valor) && $valor > 0);
    }

    // Verifica que un valor sea un número y mayor o igual a 1
    public static function esStockValido($valor) {
        return (is_numeric($valor) && $valor >= 1);
    }
}

?>