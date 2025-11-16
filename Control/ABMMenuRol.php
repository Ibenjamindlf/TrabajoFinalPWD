<?php 

include_once(__DIR__ . '/../Modelo/MenuRol.php');
include_once(__DIR__ . '/../Modelo/Menu.php');
include_once(__DIR__ . '/../Modelo/Rol.php');
include_once(__DIR__ . '/validadores/validador.php');


class ABMMenuRol {

    // Buscar
    public function buscar($param){
        $where = " true ";
        if ($param != null){
            if (!empty($param['id'])) {
                $where .= " and id = " . $param['id']; 
            }
            if (!empty($param['idMenu'])) {
                $where .= " and idMenu = " . $param['idMenu'];
            }
            if (!empty($param['idRol'])) {
                $where .= " and idRol = " . $param['idRol'];
            }
        }
        $arreglo = MenuRol::seleccionar($where);
        return $arreglo;
    }


    // Funcion cargarObjeto (SOLO PARA ALTA)
    // Crea un objeto con idMenu e idRol.
    private function cargarObjeto($param) {
        $objMenuRol = null;

        if (array_key_exists('idMenu', $param) && array_key_exists('idRol', $param)) {
            $objMenuRol = new MenuRol();
            $objMenuRol->setear(
                null, // ID es null en una alta
                $param['idMenu'],
                $param['idRol']
            );
        }
        return $objMenuRol;
    }


    //Corrobora que la clave primaria (id) esté seteada.
    private function seteadosCamposClaves($param){
        return isset($param['id']);
    }


    //Carga un objeto solo con la clave primaria (id).
    private function cargarObjetoConClave($param){
        $objMenuRol = null;
        if (isset($param['id'])) {
            $objMenuRol = new MenuRol();
            // setear(id, idMenu, idRol)
            $objMenuRol->setear($param['id'], null, null);
        }
        return $objMenuRol;
    }

    //Modulo alta con validaciones
    public function alta($param){
        $resp = false;

        $valido = true;
        $errores = [];
        if (!Validador::esNumeroPositivo($param['idMenu'])) {
            $valido = false;
            $errores[] = "El ID de menú no es válido.";
        }
         if (!Validador::esNumeroPositivo($param['idRol'])) {
            $valido = false;
            $errores[] = "El ID de rol no es válido.";
        }
        if (!$valido) {
            $_SESSION['errores_abm'] = $errores;
            return false;
        }

        $busqueda = [
            "idMenu" => $param['idMenu'],
            "idRol" => $param['idRol']
        ];
        $existe = $this->buscar($busqueda);

        if ($existe == null) {
            $obj = $this->cargarObjeto($param);
            if ($obj != null && $obj->insertar()){
                $resp = true;
            }
        } else {
            $_SESSION['errores_abm'] = ["Ese rol ya tiene ese menú asignado."];
        }
        return $resp;
    }

    // Modificación basado en id de fila
    public function modificacion($param){
        $resp = false;

        $valido = true;
        $errores = [];
        if (!$this->seteadosCamposClaves($param)) {
            $valido = false;
            $errores[] = "No se proveyó el ID de la relación a modificar.";
        }
        if (!Validador::esNumeroPositivo($param['idMenu'])) {
            $valido = false;
            $errores[] = "El ID de menú no es válido.";
        }
         if (!Validador::esNumeroPositivo($param['idRol'])) {
            $valido = false;
            $errores[] = "El ID de rol no es válido.";
        }
        
        $busqueda = [
            "idMenu" => $param['idMenu'],
            "idRol" => $param['idRol']
        ];
        $existe = $this->buscar($busqueda);
        
        if ($existe != null && $existe[0]->getId() != $param['id']) {
             $valido = false;
             $errores[] = "Esa combinación de menú y rol ya existe.";
        }

        if (!$valido) {
            $_SESSION['errores_abm'] = $errores;
            return false;
        }

        $lista = $this->buscar(['id' => $param['id']]);
        if (count($lista) > 0) {
            $obj = $lista[0];
            $obj->setear($param['id'], $param['idMenu'], $param['idRol']);

            if ($obj->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    // Baja Física (DELETE)
    public function baja($param){
        $resp = false;
        
        if ($this->seteadosCamposClaves($param)){
            $obj = $this->cargarObjetoConClave($param);
            if ($obj != null && $obj->eliminar()){
                $resp = true;
            }
        } else {
             $_SESSION['errores_abm'] = ["No se proporcionó el ID de la relación."];
        }
        return $resp;
    }
}


?>