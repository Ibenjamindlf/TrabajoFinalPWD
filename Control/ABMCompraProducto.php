<?php 

include_once(__DIR__ . '/../Modelo/compraProducto.php'); 
include_once(__DIR__ . '/../Modelo/compra.php'); 
include_once(__DIR__ . '/../Modelo/Producto.php'); 
include_once(__DIR__ . '/validadores/Validador.php');

include_once(__DIR__ . '/ABMProducto.php');

class ABMCompraProducto {

    // Busca en los items de las compras.
    public function buscar($param){
        $where = " true ";
        if ($param != null){
            if (!empty($param['id'])) {
                $where .= " and id = " . $param['id'];
            }
            if (!empty($param['idCompra'])) {
                $where .= " and idCompra = " . $param['idCompra']; 
            }
            if (!empty($param['idProducto'])) {
                $where .= " and idProducto = " . $param['idProducto'];
            }
        }
        $arreglo = compraProducto::seleccionar($where);
        return $arreglo;
    }


    // Modulo cargarObjeto (SOLO PARA ALTA)
    private function cargarObjeto($param) {
        $obj = null;
        
        if (array_key_exists('idCompra', $param) && array_key_exists('idProducto', $param) && array_key_exists('cantidad', $param)) {
            $obj = new compraProducto();
            
            $obj->setear(
                null, 
                $param['idCompra'],
                $param['idProducto'],
                $param['cantidad']
            );
        }
        return $obj;
    }


    // Corrobora que la clave primaria (id) esté seteada.
    private function seteadosCamposClaves($param){
        return isset($param['id']);
    }


    // Carga un objeto solo con la clave primaria (id).
    private function cargarObjetoConClave($param){
        $obj = null;
        if (isset($param['id'])) {
            $obj = new compraProducto();
            $obj->setear($param['id'], null, null, null);
        }
        return $obj;
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
        if (!Validador::esNumeroPositivo($param['idProducto'])) {
            $valido = false;
            $errores[] = "El ID de producto no es válido.";
        }
        if (!Validador::esStockValido($param['cantidad'])) {
            $valido = false;
            $errores[] = "La cantidad debe ser 1 o más.";
        }
        
        // Stock a verificar
        $producto = null;
        if ($valido) {
            $abmProd = new ABMProducto();
            $productoArr = $abmProd->buscar(['id' => $param['idProducto']]);

            if ($productoArr == null) {
                $valido = false;
                $errores[] = "El producto que intentas agregar no existe.";
            } else {
                $producto = $productoArr[0]; 
                if ($producto->getStock() < $param['cantidad']) {
                    $valido = false;
                    $errores[] = "No hay stock suficiente. Stock disponible: " . $producto->getStock();
                }
            }
        }
        
        $existe = $this->buscar(['idCompra' => $param['idCompra'], 'idProducto' => $param['idProducto']]);
        if ($existe != null) {
            $valido = false;
            $errores[] = "Ese producto ya está en la compra (modifique la cantidad en lugar de agregarlo).";
        }

        if (!$valido) {
            $_SESSION['errores_abm'] = $errores;
            return false;
        }

        $obj = $this->cargarObjeto($param);
        if ($obj != null && $obj->insertar()){
            
            // Si la inserción fue exitosa, descontamos el stock del producto
            $nuevoStock = $producto->getStock() - $param['cantidad'];

            $producto->estado($nuevoStock);
            
            $resp = true;
        } else {
             $_SESSION['errores_abm'] = ["No se pudo agregar el producto a la compra."];
        }
        
        return $resp;
    }


    // Funcion modificacion (Permite cambiar cantidad, o IDs)
    public function modificacion($param){
        $resp = false;

        $valido = true;
        $errores = [];
        if (!$this->seteadosCamposClaves($param)) {
            $valido = false;
            $errores[] = "No se proveyó el ID del item de la compra.";
        }
        if (!Validador::esNumeroPositivo($param['idCompra'])) {
            $valido = false;
            $errores[] = "El ID de compra no es válido.";
        }
        if (!Validador::esNumeroPositivo($param['idProducto'])) {
            $valido = false;
            $errores[] = "El ID de producto no es válido.";
        }
        if (!Validador::esStockValido($param['cantidad'])) {
            $valido = false;
            $errores[] = "La cantidad debe ser 1 o más.";
        }
        
        $existe = $this->buscar(['idCompra' => $param['idCompra'], 'idProducto' => $param['idProducto']]);
        if ($existe != null && $existe[0]->getId() != $param['id']) {
             $valido = false;
             $errores[] = "Esa combinación de producto y compra ya existe en otra fila.";
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
                $param['idCompra'], 
                $param['idProducto'], 
                $param['cantidad']
            );

            if ($obj->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }


    // Funcion baja
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