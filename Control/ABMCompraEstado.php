<?php

include_once(__DIR__ . '/../Modelo/compraEstado.php'); 
include_once(__DIR__ . '/../Modelo/compra.php'); 
include_once(__DIR__ . '/../Modelo/CompraEstadoTipo.php');
include_once(__DIR__ . '/validadores/Validador.php');

class ABMCompraEstado {

    /**
     * Busca en los estados de las compras.
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $where = " true ";
        if ($param != null){
            if (!empty($param['id'])) {
                $where .= " and id = " . $param['id'];
            }
            if (!empty($param['idCompra'])) {
                $where .= " and idCompra = " . $param['idCompra'];
            }
            
            if (!empty($param['idEstadoTipo'])) {
                $where .= " and idCET = " . $param['idEstadoTipo'];
            }
            
            if (isset($param['fechaFinNull']) && $param['fechaFinNull'] == true) {
                $where .= " and (fechaFin IS NULL OR fechaFin = '0000-00-00 00:00:00')";
            }
        }
        $arreglo = compraEstado::seleccionar($where);
        return $arreglo;
    }

    
    private function prepararDatos($param) {
        if (isset($param['fechaFin']) && ($param['fechaFin'] === 'null' || $param['fechaFin'] === '')) {
             $param['fechaFin'] = null;
        }
        return $param;
    }

    private function cargarObjeto($param) {
        $objCompraEstado = null;
        if (array_key_exists('idCompra', $param) && array_key_exists('idEstadoTipo', $param)) {
            $objCompraEstado = new compraEstado();
            $fechaActual = date("Y-m-d H:i:s");
            $objCompraEstado->setear(
                null, 
                $param['idCompra'],
                $param['idEstadoTipo'],
                $fechaActual, 
                null 
            );
        }
        return $objCompraEstado;
    }
    
    private function seteadosCamposClaves($param){ return isset($param['id']); }

    private function cargarObjetoConClave($param){
        $objCompraEstado = null;
        if (isset($param['id'])) {
            $objCompraEstado = new compraEstado();
            $objCompraEstado->setear($param['id'], null, null, null, null);
        }
        return $objCompraEstado;
    }

    public function alta($param){
        $resp = false;
        $valido = true;
        $errores = [];
        if (!Validador::esNumeroPositivo($param['idCompra'])) { $valido = false; $errores[] = "El ID de compra no es válido."; }
        if (!Validador::esNumeroPositivo($param['idEstadoTipo'])) { $valido = false; $errores[] = "El ID de estado no es válido."; }
        
        $estadoActual = $this->buscar(['idCompra' => $param['idCompra'], 'fechaFinNull' => true]);
        if (count($estadoActual) > 0) {
            $valido = false;
            $errores[] = "La compra ya tiene un estado activo.";
        }

        if (!$valido) { $_SESSION['errores_abm'] = $errores; return false; }

        $obj = $this->cargarObjeto($param);
        if ($obj != null && $obj->insertar()){ $resp = true; } 
        else { $_SESSION['errores_abm'] = ["No se pudo registrar el estado."]; }
        
        return $resp;
    }

    public function modificacion($param){
        $resp = false;
        $valido = true;
        $errores = [];
        if (!$this->seteadosCamposClaves($param)) { $valido = false; $errores[] = "Falta ID."; }

        if (!$valido) { $_SESSION['errores_abm'] = $errores; return false; }
        
        $datos = $this->prepararDatos($param);
        $lista = $this->buscar(['id' => $datos['id']]);
        if (count($lista) > 0) {
            $obj = $lista[0];
            $obj->setear($datos['id'], $datos['idCompra'], $datos['idEstadoTipo'], $datos['fechaIni'], $datos['fechaFin']);
            if ($obj->modificar()) { $resp = true; }
        }
        return $resp;
    }

    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $obj = $this->cargarObjetoConClave($param);
            if ($obj != null && $obj->eliminar()){ $resp = true; }
        }
        return $resp;
    }
}
?>