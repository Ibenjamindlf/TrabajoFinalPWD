<?php
include_once(__DIR__ . '/../Modelo/UsuarioRol.php');
include_once(__DIR__ . '/../Modelo/Usuario.php'); 
include_once(__DIR__ . '/../Modelo/Rol.php'); 
include_once(__DIR__ . '/validadores/Validador.php');

class ABMUsuarioRol {

    //Modulo buscar
    public function buscar($param){
        $where = " true ";
        if ($param != null){
            if (!empty($param['id'])) {
                $where .= " and id = " . $param['id']; 
            }
            if (!empty($param['idUsuario'])) {
                $where .= " and idUsuario = " . $param['idUsuario']; 
            }
            if (!empty($param['idRol'])) {
                $where .= " and idRol = " . $param['idRol']; 
            }
        }
        $arreglo = UsuarioRol::seleccionar($where);
        return $arreglo;
    }


    //Modulo cargarObjeto (SOLO PARA ALTA)
    //Crea un objeto con idUsuario e idRol.
    private function cargarObjeto($param) {
        $objUsuarioRol = null;

        if (array_key_exists('idUsuario', $param) && array_key_exists('idRol', $param)) {
            $objUsuarioRol = new UsuarioRol();
            $objUsuarioRol->setear(
                null, 
                $param['idUsuario'],
                $param['idRol']
            );
        }
        return $objUsuarioRol;
    }


    //Corrobora que la clave primaria (id) esté seteada.
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['id'])){
            $resp = true;
        }
        return $resp;
    }


    //Carga un objeto solo con la clave primaria (id).
    private function cargarObjetoConClave($param){
        $objUsuarioRol = null;
        if (isset($param['id'])) {
            $objUsuarioRol = new UsuarioRol();
            $objUsuarioRol->setear($param['id'], null, null);
        }
        return $objUsuarioRol;
    }


    // Alta
    public function alta($param){
        $resp = false;

        $valido = true;
        $errores = [];
        if (!Validador::esNumeroPositivo($param['idUsuario'])) {
            $valido = false;
            $errores[] = "El ID de usuario no es válido.";
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
            "idUsuario" => $param['idUsuario'],
            "idRol" => $param['idRol']
        ];
        $existe = $this->buscar($busqueda);

        if ($existe == null) {
            $obj = $this->cargarObjeto($param);
            if ($obj != null && $obj->insertar()){
                $resp = true;
            }
        } else {
            $_SESSION['errores_abm'] = ["El usuario ya tiene ese rol asignado."];
        }
        return $resp;
    }


    // Modificación
    public function modificacion($param){
        $resp = false;

        $valido = true;
        $errores = [];
        if (!$this->seteadosCamposClaves($param)) { 
            $valido = false;
            $errores[] = "No se proveyó el ID de la relación a modificar.";
        }
        if (!Validador::esNumeroPositivo($param['idUsuario'])) {
            $valido = false;
            $errores[] = "El ID de usuario no es válido.";
        }
         if (!Validador::esNumeroPositivo($param['idRol'])) {
            $valido = false;
            $errores[] = "El ID de rol no es válido.";
        }
        
        $busqueda = [
            "idUsuario" => $param['idUsuario'],
            "idRol" => $param['idRol']
        ];
        $existe = $this->buscar($busqueda);
        
        if ($existe != null && $existe[0]->getId() != $param['id']) {
             $valido = false;
             $errores[] = "Esa combinación de usuario y rol ya existe.";
        }

        if (!$valido) {
            $_SESSION['errores_abm'] = $errores;
            return false;
        }

        $lista = $this->buscar(['id' => $param['id']]);
        if (count($lista) > 0) {
            $obj = $lista[0];
            $obj->setear($param['id'], $param['idUsuario'], $param['idRol']);

            if ($obj->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }


    // Baja
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