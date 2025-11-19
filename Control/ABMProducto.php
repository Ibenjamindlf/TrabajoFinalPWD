<?php
include_once(__DIR__ . '/../Modelo/Productos.php');
include_once(__DIR__ . '/validadores/Validador.php');

class ABMProducto {

    // Permite buscar un obj Producto
    public function buscar($param) {
        $where = " true ";

        if ($param != null) {

            if (isset($param['id'])) {
                $where .= " and id = " . $param['id'];
            }

            if (isset($param['nombre'])) {
                $where .= " and nombre = '" . $param['nombre'] . "'";
            }

            if (isset($param['stock'])) {
                $where .= " and stock = " . $param['stock'];
            }

            if (isset($param['precio'])) {
                $where .= " and precio = " . $param['precio'];
            }
        }

        $arreglo = Producto::seleccionar($where);

        if (empty($arreglo)) {
            $arreglo = null;
        }

        return $arreglo;
    }


    // Espera un arreglo asociativo con los datos del producto
    private function cargarObjeto($param) {
        $objProducto = null;

        if (
            array_key_exists('nombre', $param) &&
            array_key_exists('stock', $param) &&
            array_key_exists('precio', $param) &&
            array_key_exists('detalle', $param) &&
            array_key_exists('imagen', $param)
        ) {

            $objProducto = new Producto();
            $objProducto->setear(null, $param['nombre'], $param['stock'], $param['precio'], $param['detalle'], $param['imagen']);
        }

        return $objProducto;
    }


    // Corrobora que dentro del array asociativo está seteada la clave primaria
    private function seteadosCamposClaves($param) {
        $resp = false;

        if (isset($param['id'])) {
            $resp = true;
        }

        return $resp;
    }


    // Espera un arreglo asociativo con la clave primaria
    private function cargarObjetoConClave($param) {
        $objProducto = null;

        if (isset($param['id'])) {
            $objProducto = new Producto();

            $objProducto->setear($param['id'], null, null, null, null, null);
        }

        return $objProducto;
    }


    // Permite modificar un objeto Producto
    public function modificacion($param) {
        $resp = false;

        $valido = true;
        $errores = []; 

        if (!$this->seteadosCamposClaves($param)) {
            $valido = false;
            $errores[] = "No se ha proporcionado el ID del producto a modificar.";
        }
        
        if (!Validador::noEstaVacio($param['nombre']) || 
            !Validador::noEstaVacio($param['detalle']) || 
            !Validador::noEstaVacio($param['imagen'])) {
            
            $valido = false;
            $errores[] = "El nombre, detalle e imagen no pueden estar vacíos.";
        }

        if (!Validador::esStockValido($param['stock'])) {
            $valido = false;
            $errores[] = "El stock debe ser un número mayor o igual a 1.";
        }

        if (!Validador::esNumeroPositivo($param['precio'])) {
            $valido = false;
            $errores[] = "El precio debe ser un número positivo.";
        }

        $busquedaProducto = $this->buscar(["nombre" => $param["nombre"]]);
        
        if ($busquedaProducto != null && $busquedaProducto[0]->getId() != $param['id']) {
            $valido = false;
            $errores[] = "Ya existe OTRO producto con ese nombre.";
        }
        
        if (!$valido) {
            $_SESSION['errores_abm'] = $errores;
            return false; 
        }
        
        $lista = $this->buscar(['id' => $param['id']]);
        $objProducto = $lista[0]; 
                
        $objProducto->setear(
            $param['id'],
            $param['nombre'],
            $param['stock'],
            $param['precio'],
            $param['detalle'],
            $param['imagen']
        );
                
        if ($objProducto->modificar()){
            $resp = true;
        }
        
        return $resp;
    }


    // Permite eliminar un objeto Producto
    public function baja($param) {
        $resp = false;

        if ($this->seteadosCamposClaves($param)) {
            $objProducto = $this->cargarObjetoConClave($param);

            if ($objProducto != null && $objProducto->eliminar()) {
                $resp = true;
            }
        }

        return $resp;
    }


    // Permite agregar un objeto Producto
    public function alta($param) {
        $resp = false;

        $valido = true;
        $errores = [];

        if (!Validador::noEstaVacio($param['nombre']) || !Validador::noEstaVacio($param['detalle']) || !Validador::noEstaVacio($param['imagen'])) {
            $valido = false;
            $errores[] = "El nombre, detalle e imagen no pueden estar vacíos.";
        }

        if (!Validador::esStockValido($param['stock'])) {
            $valido = false;
            $errores[] = "El stock debe ser un número mayor o igual a 1.";
        }

        if (!Validador::esNumeroPositivo($param['precio'])) {
            $valido = false;
            $errores[] = "El precio debe ser un número positivo.";
        }

        if (!$valido) {
            $_SESSION['errores_abm'] = $errores;
            return false;
        }

        $busquedaProducto = ["nombre" => $param["nombre"]];
        $existeProducto = $this->buscar($busquedaProducto);

        if ($existeProducto == null) {
            $objProducto = $this->cargarObjeto($param);

            if ($objProducto != null && $objProducto->insertar()) {
                $resp = true;
            }
        } else {
            $_SESSION['errores_abm'] = ["Ya existe un producto con ese nombre."];
        }

        return $resp;
    }
}

?>