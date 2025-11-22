<?php

include_once(__DIR__ . '/../Modelo/compra.php'); 
include_once(__DIR__ . '/../Modelo/Usuario.php'); 
include_once(__DIR__ . '/validadores/Validador.php');
include_once(__DIR__ . '/ABMCompraEstado.php');
include_once(__DIR__ . '/ABMCompraProducto.php');
include_once(__DIR__ . '/ABMProducto.php');
include_once(__DIR__ . '/ABMUsuario.php'); 
include_once(__DIR__ . '/../Clases/Email.php');

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

    
    // Busca el id de la compra que está en estado "carrito
    public function obtenerCarritoActivo($idUsuario) {
        
        $compras = $this->buscar(['idUsuario' => $idUsuario]);
        $abmEstado = new ABMCompraEstado();
        
        if (!empty($compras)) {
            $compras = array_reverse($compras);
            
            foreach ($compras as $compra) {
                $estados = $abmEstado->buscar([
                    'idCompra' => $compra->getId(), 
                    'fechaFinNull' => true 
                ]);

                if (!empty($estados)) {
                    $estadoActual = $estados[0];
                    if ($estadoActual->getIdEstadoTipo() == 1) {
                        return $compra->getId(); 
                    }
                }
            }
        }
        return null; 
    }


    //Crea una compra nueva e inicia el estado "Carrito"
    public function crearCarrito($idUsuario) {

        if ($this->alta(['idUsuario' => $idUsuario])) {
            $compras = $this->buscar(['idUsuario' => $idUsuario]);
            $idCompra = end($compras)->getId();

            $abmEstado = new ABMCompraEstado();
            if ($abmEstado->alta(['idCompra' => $idCompra, 'idEstadoTipo' => 1])) {
                return $idCompra;
            }
        }
        return null;
    }



    // Finaliza la compra activa del usuario
    public function finalizarCompra($idUsuario) {
        $exito = false;

        $idCompraActiva = null;
        $idEstadoAnterior = null;
        
        $abmEstado = new ABMCompraEstado();
        $compras = $this->buscar(['idUsuario' => $idUsuario]);

        if (!empty($compras)) {
            $compras = array_reverse($compras);
            foreach ($compras as $c) {
                $est = $abmEstado->buscar(['idCompra' => $c->getId(), 'fechaFinNull' => true]);
                if (!empty($est) && $est[0]->getIdEstadoTipo() == 1) {
                    $idCompraActiva = $c->getId();
                    $idEstadoAnterior = $est[0]->getId();
                    break;
                }
            }
        }

        if ($idCompraActiva != null) {

            $abmCP = new ABMCompraProducto();
            $abmP = new ABMProducto();
            $items = $abmCP->buscar(['idCompra' => $idCompraActiva]);
            
            $productosEmail = [];
            $total = 0;

            foreach ($items as $i) {
                $p = $abmP->buscar(['id' => $i->getIdProducto()]);
                if (!empty($p)) {
                    $objProd = $p[0];
                    $total += ($objProd->getPrecio() * $i->getCantidad());
                    $productosEmail[] = [
                        'nombre' => $objProd->getNombre(), 
                        'cantidad' => $i->getCantidad(), 
                        'precio' => $objProd->getPrecio()
                    ];
                }
            }

            $estadoAntObj = $abmEstado->buscar(['id' => $idEstadoAnterior])[0];
            
            $seCerroEstado = $abmEstado->modificacion([
                'id' => $idEstadoAnterior,
                'idCompra' => $idCompraActiva,
                'idEstadoTipo' => 1,
                'fechaIni' => $estadoAntObj->getFechaIni(),
                'fechaFin' => date("Y-m-d H:i:s")
            ]);

            if ($seCerroEstado) {
                $abmEstado->alta([
                    'idCompra' => $idCompraActiva,
                    'idEstadoTipo' => 3 
                ]);

                $abmUsuario = new ABMUsuario();
                $usuarioObj = $abmUsuario->buscar(['id' => $idUsuario])[0];
                
                try {
                    $emailSender = new Email($usuarioObj->getMail(), $usuarioObj->getNombre(), null);
                    $emailSender->enviarResumenCompra($productosEmail, $total);
                } catch (Exception $e) {
                }

                $exito = true;
            }
        }

        return $exito;
    }
}

?>