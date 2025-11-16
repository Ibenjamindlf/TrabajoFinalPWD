<?php

include_once(__DIR__ . '/../Modelo/CompraEstadoTipo.php');
include_once(__DIR__ . '/validadores/Validador.php');

class ABMCompraEstadoTipo {

    //Busca en los tipos de estado de compra
    public function buscar($param){
        $where = " true ";
        if ($param != null){
            if (!empty($param['id'])) {
                $where .= " and id = " . $param['id'];
            }
            if (!empty($param['descripcion'])) {
                $where .= " and descripcion = '" . $param['descripcion'] . "'";
            }
        }
        $arreglo = CompraEstadoTipo::seleccionar($where);
        return $arreglo;
    }


    //Modulo cargarObjeto (SOLO PARA ALTA)
    private function cargarObjeto($param) {
        $obj = null;
        
        if (array_key_exists('descripcion', $param) && array_key_exists('detalle', $param)) {
            $obj = new CompraEstadoTipo();
            
            $obj->setear(
                null, 
                $param['descripcion'],
                $param['detalle']
            );
        }
        return $obj;
    }

    // Corrobora que la clave primaria (id) esté seteada.
    private function seteadosCamposClaves($param){
        return isset($param['id']);
    }


    //Carga un objeto solo con la clave primaria (id).
    private function cargarObjetoConClave($param){
        $obj = null;
        if (isset($param['id'])) {
            $obj = new CompraEstadoTipo();
            $obj->setear($param['id'], null, null);
        }
        return $obj;
    }


    //Modulo alta con validaciones (Espera 'descripcion' y 'detalle')
    public function alta($param){
        $resp = false;
        
        $valido = true;
        $errores = [];
        if (!Validador::noEstaVacio($param['descripcion'])) {
            $valido = false;
            $errores[] = "La descripción no puede estar vacía.";
        }
        if (!Validador::noEstaVacio($param['detalle'])) {
            $valido = false;
            $errores[] = "El detalle no puede estar vacío.";
        }

        if (!$valido) {
            $_SESSION['errores_abm'] = $errores;
            return false;
        }

        $existe = $this->buscar(['descripcion' => $param['descripcion']]);
        
        if ($existe == null) {
            $obj = $this->cargarObjeto($param);
            if ($obj != null && $obj->insertar()){
                $resp = true;
            }
        } else {
            $_SESSION['errores_abm'] = ["Ya existe un tipo de estado con esa descripción."];
        }
        
        return $resp;
    }


    // Funcion modificacion
    public function modificacion($param){
        $resp = false;

        $valido = true;
        $errores = [];
        if (!$this->seteadosCamposClaves($param)) {
            $valido = false;
            $errores[] = "No se proveyó el ID del tipo de estado.";
        }
        if (!Validador::noEstaVacio($param['descripcion'])) {
            $valido = false;
            $errores[] = "La descripción no puede estar vacía.";
        }
        if (!Validador::noEstaVacio($param['detalle'])) {
            $valido = false;
            $errores[] = "El detalle no puede estar vacío.";
        }
        
        $existe = $this->buscar(['descripcion' => $param['descripcion']]);
        if ($existe != null && $existe[0]->getId() != $param['id']) {
             $valido = false;
             $errores[] = "Ya existe OTRO tipo de estado con esa descripción.";
        }


        if (!$valido) {
            $_SESSION['errores_abm'] = $errores;
            return false;
        }

        $lista = $this->buscar(['id' => $param['id']]);
        if (count($lista) > 0) {
            $obj = $lista[0];
            $obj->setear(
                $param['id'], 
                $param['descripcion'], 
                $param['detalle']
            );

            if ($obj->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }


    // Modulo baja (Física)
    // Este modelo no tiene 'deshabilitado', solo baja física.
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