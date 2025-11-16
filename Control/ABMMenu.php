<?

include_once(__DIR__ . '/../Modelo/Menu.php');
include_once(__DIR__ . '/validadores/validador.php');


class ABMMenu {

    // Busca en los menús
    public function buscar($param){
        $where = " true ";
        if ($param != null){
            if (!empty($param['id'])) {
                $where .= " and id = " . $param['id'];
            }
            if (!empty($param['nombre'])) {
                $where .= " and nombre = '" . $param['nombre'] . "'";
            }
            if (isset($param['idPadre'])) {
                if ($param['idPadre'] == 'null') {
                    $where .= " and idPadre IS NULL";
                } else {
                    $where .= " and idPadre = " . $param['idPadre'];
                }
            }
        }
        $arreglo = Menu::seleccionar($where);
        return $arreglo;
    }


    // Prepara los datos para un alta (con valores NULL y defaults)
    // CORREGIDO para que link (NOT NULL) guarde '#' por defecto.
    private function prepararDatos($param) {
        $param['idPadre'] = !empty($param['idPadre']) ? $param['idPadre'] : null;
        
        // CORRECCIÓN: Si el link está vacío, usamos '#', la bd no permite NULL
        $param['link'] = !empty($param['link']) ? $param['link'] : '#';
        return $param;
    }



    // Cargar obj solo para alta
    private function cargarObjeto($param) {
        $objMenu = null;
        
        if (array_key_exists('nombre', $param) && array_key_exists('descripcion', $param)) {
            
            $datos = $this->prepararDatos($param);
            
            $objMenu = new Menu();
            $objMenu->setear(
                null, // ID
                $datos['nombre'],
                $datos['descripcion'],
                $datos['link'],
                $datos['idPadre'],
                null  // deshabilitado (empieza habilitado)
            );
        }
        return $objMenu;
    }


    // Corrobora que la clave id este seteada
    private function seteadosCamposClaves($param){
        return isset($param['id']);
    }


    // Cargar un onj solo con la clave id
    private function cargarObjetoConClave($param){
        $objMenu = null;
        if (isset($param['id'])) {
            $objMenu = new Menu();
            $objMenu->setear($param['id'], null, null, null, null, null);
        }
        return $objMenu;
    }


    // Alta con validación
    public function alta($param){
        $resp = false;
        
        $valido = true;
        $errores = [];
        if (!Validador::noEstaVacio($param['nombre'])) {
            $valido = false;
            $errores[] = "El nombre no puede estar vacío.";
        }

        if (!empty($param['idPadre']) && !is_numeric($param['idPadre'])) {
            $valido = false;
            $errores[] = "El ID Padre debe ser un número.";
        }

        if (!$valido) {
            $_SESSION['errores_abm'] = $errores;
            return false;
        }

        $datos = $this->prepararDatos($param);
        $existe = $this->buscar([
            'nombre' => $datos['nombre'], 
            'idPadre' => $datos['idPadre'] ?? 'null'
        ]);

        if ($existe == null) {
            $objMenu = $this->cargarObjeto($param);
            if ($objMenu != null && $objMenu->insertar()){
                $resp = true;
            }
        } else {
            $_SESSION['errores_abm'] = ["Ya existe un menú con ese nombre bajo el mismo padre."];
        }
        return $resp;
    }


    // modificación con validación
    public function modificacion($param){
        $resp = false;

        $valido = true;
        $errores = [];
        if (!$this->seteadosCamposClaves($param)) {
            $valido = false;
            $errores[] = "No se proveyó el ID del menú.";
        }
        if (!Validador::noEstaVacio($param['nombre'])) {
            $valido = false;
            $errores[] = "El nombre no puede estar vacío.";
        }
        if (!empty($param['idPadre']) && !is_numeric($param['idPadre'])) {
            $valido = false;
            $errores[] = "El ID Padre debe ser un número.";
        }

        $datos = $this->prepararDatos($param);
        $existe = $this->buscar([
            'nombre' => $datos['nombre'], 
            'idPadre' => $datos['idPadre'] ?? 'null'
        ]);
        
        if ($existe != null && $existe[0]->getId() != $param['id']) {
             $valido = false;
             $errores[] = "Ya existe OTRO menú con ese nombre bajo el mismo padre.";
        }

        if (!$valido) {
            $_SESSION['errores_abm'] = $errores;
            return false;
        }

        $lista = $this->buscar(['id' => $param['id']]);
        if (count($lista) > 0) {
            $objMenu = $lista[0];
            $deshabilitadoActual = $objMenu->getDeshabilitado();
            
            $objMenu->setear(
                $param['id'], 
                $datos['nombre'], 
                $datos['descripcion'], 
                $datos['link'], 
                $datos['idPadre'], 
                $deshabilitadoActual
            );

            if ($objMenu->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    // Baja Lógica (UPDATE)
    public function bajaLogica($param) {
        $resp = false;
        
        if (!$this->seteadosCamposClaves($param)) {
            $_SESSION['errores_abm'] = ["No se proveyó el ID de menú."];
            return false;
        }

        $lista = $this->buscar(['id' => $param['id']]);
        
        if (count($lista) > 0) {
            $objMenu = $lista[0];
            $estadoActual = $objMenu->getDeshabilitado();
            
            $nuevoEstado = (is_null($estadoActual) || $estadoActual == '0000-00-00 00:00:00') 
                            ? date("Y-m-d H:i:s") // Deshabilitar
                            : null; // Habilitar

            if ($objMenu->estado($nuevoEstado)) {
                $resp = true;
            }
        }
        return $resp;
    }

    // Baja física (DELETE)
    public function bajaFisica($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objMenu = $this->cargarObjetoConClave($param);
            if ($objMenu != null && $objMenu->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }


}

?>