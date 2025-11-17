<?php

include_once(__DIR__ . '/../Modelo/compra.php'); 
include_once(__DIR__ . '/../Modelo/Usuario.php'); 
include_once(__DIR__ . '/validadores/Validador.php');

class ABMCompra {

    // Busca en las compras
    public function buscar($param){
        $where = " true ";
        if ($param != null){
            if (!empty($param['id'])) {
                $where .= " and id = " . $param['id'];
            }
            if (!empty($param['idUsuario'])) {
                $where .= " and idUsuario = " . $param['idUsuario'];
            }
        }
        $arreglo = compra::seleccionar($where);
        return $arreglo;
    }


    // Modulo cargarObjeto (SOLO PARA ALTA). Asigna la fecha actual y el idUsuario.
    private function cargarObjeto($param) {
        $objCompra = null;
        
        if (array_key_exists('idUsuario', $param)) {
            $objCompra = new compra();
            
            $fechaActual = date("Y-m-d H:i:s");
            
            $objCompra->setear(
                null,
                $fechaActual,
                $param['idUsuario']
            );
        }
        return $objCompra;
    }


    // Corrobora que la clave primaria (id) esté seteada.
    private function seteadosCamposClaves($param){
        return isset($param['id']);
    }


    // Carga un objeto solo con la clave primaria (id).
    private function cargarObjetoConClave($param){
        $objCompra = null;
        if (isset($param['id'])) {
            $objCompra = new compra();
            $objCompra->setear($param['id'], null, null);
        }
        return $objCompra;
    }


    // Alta con validaciones
    public function alta($param){
        $resp = false;
        
        $valido = true;
        $errores = [];
        if (!Validador::esNumeroPositivo($param['idUsuario'])) {
            $valido = false;
            $errores[] = "El ID de usuario no es válido.";
        }

        if (!$valido) {
            $_SESSION['errores_abm'] = $errores;
            return false;
        }

        $objCompra = $this->cargarObjeto($param);
        if ($objCompra != null && $objCompra->insertar()){
            $resp = true;
        } else {
             $_SESSION['errores_abm'] = ["No se pudo registrar la compra."];
        }
        
        return $resp;
    }


    // Modificacion (permite cambiar fecha o usuario)
    public function modificacion($param){
        $resp = false;

        $valido = true;
        $errores = [];
        if (!$this->seteadosCamposClaves($param)) {
            $valido = false;
            $errores[] = "No se proveyó el ID de la compra.";
        }
        if (!Validador::noEstaVacio($param['fecha'])) { 
            $valido = false;
            $errores[] = "La fecha no puede estar vacía.";
        }
        if (!Validador::esNumeroPositivo($param['idUsuario'])) {
            $valido = false;
            $errores[] = "El ID de usuario no es válido.";
        }

        if (!$valido) {
            $_SESSION['errores_abm'] = $errores;
            return false;
        }

        $lista = $this->buscar(['id' => $param['id']]);
        if (count($lista) > 0) {
            $objCompra = $lista[0];
            $objCompra->setear($param['id'], $param['fecha'], $param['idUsuario']);

            if ($objCompra->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    // Este modelo no tiene 'deshabilitado', solo baja física.
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objCompra = $this->cargarObjetoConClave($param);
            if ($objCompra != null && $objCompra->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }
}
?>