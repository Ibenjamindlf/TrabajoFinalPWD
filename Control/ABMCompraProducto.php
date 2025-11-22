<?php 

include_once(__DIR__ . '/../Modelo/compraProducto.php'); 
include_once(__DIR__ . '/../Modelo/compra.php'); 
include_once(__DIR__ . '/../Modelo/Productos.php'); 
include_once(__DIR__ . '/validadores/Validador.php');
include_once(__DIR__ . '/ABMProducto.php');
include_once(__DIR__ . '/ABMCompra.php');

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


    // Elimina un ítem del carrito y DEVUELVE el stock al producto.
    public function quitarProductoDelCarrito($param) {
        $exito = false;
        $idCompraProducto = $param['idCompraProducto'] ?? null;

        if ($idCompraProducto) {
            // Buscamos el ítem del carrito antes de borrarlo
            // (Necesitamos saber qué producto es y cuánta cantidad tenía)
            $items = $this->buscar(['id' => $idCompraProducto]);
            
            if (!empty($items)) {
                $itemCarrito = $items[0];
                $idProducto = $itemCarrito->getIdProducto();
                $cantidadADevolver = $itemCarrito->getCantidad();

                // Buscamos el Producto original para devolver el stock
                $abmProducto = new ABMProducto();
                $prodList = $abmProducto->buscar(['id' => $idProducto]);

                if (!empty($prodList)) {
                    $producto = $prodList[0];
                    
                    // Devolvemos el stock
                    $nuevoStock = $producto->getStock() + $cantidadADevolver;
                    $producto->estado($nuevoStock); //
                }

                // Lo borramos físicamente del carrito
                if ($this->baja(['id' => $idCompraProducto])) {
                    $exito = true;
                }
            }
        }
        return $exito;
    }



    // Función Maestra para agregar al carrito
    // Manejamos carrito, crear carrito, verificar stock, sumar cantidad o insertar de nuevo
    public function agregarProductoAlCarrito($param) {
        $idUsuario = $param['idUsuario'];
        $idProducto = $param['idProducto'];
        $cantidad = $param['cantidad'];

        $abmCompra = new ABMCompra();
        $abmProducto = new ABMProducto();

        // Obtenemos o creamos Carrito
        $idCompraActiva = $abmCompra->obtenerCarritoActivo($idUsuario);
        if ($idCompraActiva == null) {
            $idCompraActiva = $abmCompra->crearCarrito($idUsuario);
            if ($idCompraActiva == null) return false; // Falló crear compra
        }

        //  Verificar Stock Global
        $prodArr = $abmProducto->buscar(['id' => $idProducto]);
        if (empty($prodArr)) return false; // Producto no existe
        $productoObj = $prodArr[0];

        if ($productoObj->getStock() < $cantidad) return false; // Sin stock

        // Verificar si el producto ya está en el carrito
        $itemsEnCarrito = $this->buscar([
            'idCompra' => $idCompraActiva,
            'idProducto' => $idProducto
        ]);

        if (!empty($itemsEnCarrito)) {

            $item = $itemsEnCarrito[0];
            $nuevaCantidad = $item->getCantidad() + $cantidad;

            $exito = $this->modificacion([
                'id' => $item->getId(),
                'idCompra' => $idCompraActiva,
                'idProducto' => $idProducto,
                'cantidad' => $nuevaCantidad
            ]);
        } else {
            $exito = $this->alta([
                'idCompra' => $idCompraActiva,
                'idProducto' => $idProducto,
                'cantidad' => $cantidad
            ]);
        }

        // Descontar Stock
        if ($exito) {
            $nuevoStock = $productoObj->getStock() - $cantidad;
            $productoObj->estado($nuevoStock);
        }

        return $exito;
    }


    // Suma 1 a la cantidad del ítem en el carrito.
    // Verifica stock antes de sumar.
    public function sumarCantidad($param) {
        $resp = false; 
        $id = $param['id'];
        $itemArr = $this->buscar(['id' => $id]);
        
        if (!empty($itemArr)) {
            $item = $itemArr[0];
            
            // Buscamos el producto para ver si hay stock
            $abmProd = new ABMProducto();
            $prodArr = $abmProd->buscar(['id' => $item->getIdProducto()]);
            
            // Verificamos que el producto exista y tenga stock
            if (!empty($prodArr)) {
                $prod = $prodArr[0];
                
                if ($prod->getStock() >= 1) {
                    $nuevaCant = $item->getCantidad() + 1;
                    $item->setCantidad($nuevaCant);
                    
                    // Si se modifica el ítem en el carrito, descontamos el stock global
                    if ($item->modificar()) {
                        $prod->estado($prod->getStock() - 1);
                        $resp = true; 
                    }
                }
            }
        }
        
        return $resp;
    }

    // Resta 1 a la cantidad. Si llega a 0, elimina el ítem.
    // Devuelve stock al producto.

    public function restarCantidad($param) {
        $resp = false; 
        $id = $param['id'];
        $itemArr = $this->buscar(['id' => $id]);
        
        if (!empty($itemArr)) {
            $item = $itemArr[0];
            $nuevaCant = $item->getCantidad() - 1;

            // Siempre devolvemos 1 al stock global
            $abmProd = new ABMProducto();
            $prodArr = $abmProd->buscar(['id' => $item->getIdProducto()]);
            
            if (!empty($prodArr)) {
                $prod = $prodArr[0];
                $prod->estado($prod->getStock() + 1); 
            }

            // Decidimos si modificamos o borramos
            if ($nuevaCant > 0) {
                $item->setCantidad($nuevaCant);
                if ($item->modificar()) {
                    $resp = true;
                }
            } else {
                if ($this->baja(['id' => $id])) {
                    $resp = true;
                }
            }
        }
        
        return $resp; 
    }


}

?>