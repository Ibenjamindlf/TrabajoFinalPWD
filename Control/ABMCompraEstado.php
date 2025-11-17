<?php

include_once(__DIR__ . '/../Modelo/compraEstado.php');
include_once(__DIR__ . '/../Modelo/compra.php'); 
include_once(__DIR__ . '/../Modelo/compraEstadoTipo.php'); 
include_once(__DIR__ . '/validadores/Validador.php');

class ABMCompraEstado {

    // Busca en los estados de las compras
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
                $where .= " and idEstadoTipo = " . $param['idEstadoTipo'];
            }

            if (isset($param['fechaFinNull']) && $param['fechaFinNull'] == true) {
                $where .= " and fechaFin IS NULL";
            }
        }
        $arreglo = compraEstado::seleccionar($where);
        return $arreglo;
    }


    //Prepara los datos para la BD
    private function prepararDatos($param) {
        if (isset($param['fechaFin']) && ($param['fechaFin'] === 'null' || $param['fechaFin'] === '')) {
             $param['fechaFin'] = null;
        }
        return $param;
    }


    // Modulo cargarObjeto (SOLO PARA ALTA)
    // Asigna la fechaIni actual y idEstadoTipo.
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


    //Corrobora que la clave primaria (id) esté seteada.
    private function seteadosCamposClaves($param){
        return isset($param['id']);
    }


    // Carga un objeto solo con la clave primaria (id).
    private function cargarObjetoConClave($param){
        $objCompraEstado = null;
        if (isset($param['id'])) {
            $objCompraEstado = new compraEstado();
            $objCompraEstado->setear($param['id'], null, null, null, null);
        }
        return $objCompraEstado;
    }


    //Modulo alta con validaciones
    public function alta($param){
        $resp = false;
        
        $valido = true;
        $errores = [];
        if (!Validador::esNumeroPositivo($param['idCompra'])) {
            $valido = false;
            $errores[] = "El ID de compra no es válido.";
        }
        if (!Validador::esNumeroPositivo($param['idEstadoTipo'])) {
            $valido = false;
            $errores[] = "El ID de estado no es válido.";
        }
        
        // LÓGICA DE NEGOCIO: No debería haber 2 estados activos (con fechaFin NULL) para la misma compra.
        $estadoActual = $this->buscar(['idCompra' => $param['idCompra'], 'fechaFinNull' => true]);
        if (count($estadoActual) > 0) {
            $valido = false;
            $errores[] = "La compra ya tiene un estado activo. Debe finalizar el estado anterior antes de crear uno nuevo.";
        }

        if (!$valido) {
            $_SESSION['errores_abm'] = $errores;
            return false;
        }

        $obj = $this->cargarObjeto($param);
        if ($obj != null && $obj->insertar()){
            $resp = true;
        } else {
             $_SESSION['errores_abm'] = ["No se pudo registrar el estado de la compra."];
        }
        
        return $resp;
    }


    // Modificacion (Permite cambiar fechas, o IDs)
    public function modificacion($param){
        $resp = false;

        $valido = true;
        $errores = [];
        if (!$this->seteadosCamposClaves($param)) {
            $valido = false;
            $errores[] = "No se proveyó el ID del estado de la compra.";
        }
        if (!Validador::esNumeroPositivo($param['idCompra'])) {
            $valido = false;
            $errores[] = "El ID de compra no es válido.";
        }
        if (!Validador::esNumeroPositivo($param['idEstadoTipo'])) {
            $valido = false;
            $errores[] = "El ID de estado no es válido.";
        }
        if (!Validador::noEstaVacio($param['fechaIni'])) {
            $valido = false;
            $errores[] = "La fecha de inicio no puede estar vacía.";
        }
        

        if (!$valido) {
            $_SESSION['errores_abm'] = $errores;
            return false;
        }
        
        $datos = $this->prepararDatos($param);

        $lista = $this->buscar(['id' => $datos['id']]);
        if (count($lista) > 0) {
            $obj = $lista[0];
            $obj->setear(
                $datos['id'], 
                $datos['idCompra'], 
                $datos['idEstadoTipo'], 
                $datos['fechaIni'], 
                $datos['fechaFin'] 
            );

            if ($obj->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    // Baja Física
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $obj = $this->cargarObjetoConClave($param);
            if ($obj != null && $obj->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }
}
?>