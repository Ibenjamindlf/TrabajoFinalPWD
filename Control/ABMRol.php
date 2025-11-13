<?php
include_once(__DIR__ . '/../Modelo/Rol.php');
include_once(__DIR__ . '/validadores/validadores.php');

class ABMRol {

    // Busca roles por id o descripcion.
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
        $arreglo = Rol::seleccionar($where);
        return $arreglo;
    }


    // Modulo cargarObjeto (SOLO PARA ALTA)
    private function cargarObjeto($param) {
        $objRol = null;

        if (array_key_exists('descripcion', $param)) {
            $objRol = new Rol();
            $objRol->setear(
                null, 
                $param['descripcion']
            );
        }
        return $objRol;
    }


    // Corrobora que la clave primaria (id) esté seteada.
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['id'])){ 
            $resp = true;
        }
        return $resp;
    }


    // Carga un objeto solo con la clave primaria.
    private function cargarObjetoConClave($param){
        $objRol = null;
        if (isset($param['id'])) {
            $objRol = new Rol();
            $objRol->setear($param['id'], null);
        }
        return $objRol;
    }


    // Alta
    public function alta($param){
        $resp = false;
        
        $valido = true;
        $errores = [];
        if (!Validador::noEstaVacio($param['descripcion'])) {
            $valido = false;
            $errores[] = "La descripción no puede estar vacía.";
        }

        if (!$valido) {
            $_SESSION['errores_abm'] = $errores;
            return false;
        }

        // 2. Evitar duplicados
        $busquedaRol = ["descripcion" => $param['descripcion']];
        $existeRol = $this->buscar($busquedaRol);

        if ($existeRol == null) {
            $objRol = $this->cargarObjeto($param);
            if ($objRol != null && $objRol->insertar()){
                $resp = true;
            }
        } else {
            $_SESSION['errores_abm'] = ["Ya existe un rol con esa descripción."];
        }
        return $resp;
    }


    // Modificacion
    public function modificacion($param){
        $resp = false;

        $valido = true;
        $errores = [];
        if (!$this->seteadosCamposClaves($param)) {
            $valido = false;
            $errores[] = "No se proveyó el ID del rol.";
        }
        if (!Validador::noEstaVacio($param['descripcion'])) {
            $valido = false;
            $errores[] = "La descripción no puede estar vacía.";
        }

        $busquedaRol = $this->buscar(["descripcion" => $param["descripcion"]]);
        if ($busquedaRol != null && $busquedaRol[0]->getId() != $param['id']) {
            $valido = false;
            $errores[] = "Ya existe OTRO rol con esa descripción.";
        }

        if (!$valido) {
            $_SESSION['errores_abm'] = $errores;
            return false;
        }

        $lista = $this->buscar(['id' => $param['id']]);
        if (count($lista) > 0) {
            $objRol = $lista[0];
            $objRol->setear($param['id'], $param['descripcion']); 

            if ($objRol->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }


    // Baja
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objRol = $this->cargarObjetoConClave($param);
            if ($objRol != null && $objRol->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }
}

?>