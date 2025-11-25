<?php

include_once(__DIR__ . '/../Modelo/compraEstado.php'); 
include_once(__DIR__ . '/../Modelo/compra.php'); 
include_once(__DIR__ . '/../Modelo/CompraEstadoTipo.php');
include_once(__DIR__ . '/validadores/Validador.php');

include_once(__DIR__ . '/ABMUsuario.php');
include_once(__DIR__ . '/ABMCompra.php');
include_once(__DIR__ . '/ABMCompraEstadoTipo.php');
include_once(__DIR__ . '/../Clases/Email.php');

class ABMCompraEstado {

    public function buscar($param){
        $where = " true ";
        if ($param != null){
            if (!empty($param['id'])) $where .= " and id = " . $param['id'];
            if (!empty($param['idCompra'])) $where .= " and idCompra = " . $param['idCompra'];
            if (!empty($param['idEstadoTipo'])) $where .= " and idCET = " . $param['idEstadoTipo'];
            if (isset($param['fechaFinNull']) && $param['fechaFinNull'] == true) {
                $where .= " and (fechaFin IS NULL OR fechaFin = '0000-00-00 00:00:00')";
            }
        }
        return compraEstado::seleccionar($where);
    }


    private function prepararDatos($param) {
        if (isset($param['fechaFin']) && ($param['fechaFin'] === 'null' || $param['fechaFin'] === '')) $param['fechaFin'] = null;
        return $param;
    }


    private function cargarObjeto($param) {
        $obj = null;
        if (array_key_exists('idCompra', $param) && array_key_exists('idEstadoTipo', $param)) {
            $obj = new compraEstado();
            $obj->setear(null, $param['idCompra'], $param['idEstadoTipo'], date("Y-m-d H:i:s"), null);
        }
        return $obj;
    }


    private function seteadosCamposClaves($param){ 
        return isset($param['id']); 
    }


    private function cargarObjetoConClave($param){
        $obj = null;
        if (isset($param['id'])) {
            $obj = new compraEstado();
            $obj->setear($param['id'], null, null, null, null);
        }
        return $obj;
    }
    public function alta($param){
        $resp = false;
        if (!Validador::esNumeroPositivo($param['idCompra'])) {
            return false;
        } 
        $obj = $this->cargarObjeto($param);
        
        if ($obj != null && $obj->insertar()) {
            $resp = true;
        } 
        return $resp;
    }


    public function modificacion($param){
        $resp = false;
        if (!$this->seteadosCamposClaves($param)) return false;
        $datos = $this->prepararDatos($param);
        $lista = $this->buscar(['id' => $datos['id']]);
        if (count($lista) > 0) {
            $obj = $lista[0];
            $obj->setear($datos['id'], $datos['idCompra'], $datos['idEstadoTipo'], $datos['fechaIni'], $datos['fechaFin']);
            if ($obj->modificar()) $resp = true;
        }
        return $resp;
    }


    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $obj = $this->cargarObjetoConClave($param);
            if ($obj != null && $obj->eliminar()) $resp = true;
        }
        return $resp;
    }


    /**
     * MÉTODO MAESTRO: Repara, VALIDA REGLAS y Cambia Estado.
     */
    public function cambiarEstado($param){
        $exito = false; 
        $puedoContinuar = true;

        $idCompra = $param['idCompra'];
        $idNuevoEstado = (int)$param['nuevoEstado'];
        $compraEstadoActual = null;

        $estadosActivos = $this->buscar(['idCompra' => $idCompra, 'fechaFinNull' => true]);

        if (empty($estadosActivos)) {
            $todos = $this->buscar(['idCompra' => $idCompra]);
            
            if (!empty($todos)) {
                $ultimo = end($todos);
                $this->modificacion([
                    'id' => $ultimo->getId(),
                    'idCompra' => $idCompra,
                    'idEstadoTipo' => $ultimo->getIdEstadoTipo(),
                    'fechaIni' => $ultimo->getFechaIni(),
                    'fechaFin' => null
                ]);
                $compraEstadoActual = $ultimo; 
            } else {
                $puedoContinuar = false; 
            }
        } else {
            $compraEstadoActual = $estadosActivos[0];
        }

        if ($puedoContinuar) {
            $idActual = (int)$compraEstadoActual->getIdEstadoTipo();
            
            if ($idActual == $idNuevoEstado) {
                $exito = true;
                $puedoContinuar = false; 
            } else {
                $transiciones = [
                    1 => [3, 6],      // CARRITO -> PAGO, CANCELADO
                    3 => [4, 6],      // PAGO -> PREPARACION, CANCELADO
                    4 => [5, 6],      // PREPARACION -> ENVIADO, CANCELADO
                    5 => [7, 6],      // ENVIADO -> ENTREGADO, CANCELADO
                    7 => [8],         // ENTREGADO -> DEVUELTO
                    6 => [],          // CANCELADO -> Fin
                    8 => []           // DEVUELTO -> Fin
                ];

                if (!isset($transiciones[$idActual]) || !in_array($idNuevoEstado, $transiciones[$idActual])) {
                    $puedoContinuar = false;
                }
            }
        }

        if ($puedoContinuar) {
            $cierre = $this->modificacion([
                'id' => $compraEstadoActual->getId(),
                'idCompra' => $idCompra,
                'idEstadoTipo' => $compraEstadoActual->getIdEstadoTipo(), 
                'fechaIni' => $compraEstadoActual->getFechaIni(),
                'fechaFin' => date("Y-m-d H:i:s")
            ]);

            if (!$cierre) {
                $puedoContinuar = false;
            }
        }


        if ($puedoContinuar) {
            $alta = $this->alta([
                'idCompra' => $idCompra,
                'idEstadoTipo' => $idNuevoEstado
            ]);

            if ($alta) {
                $this->notificarCambioEstado($idCompra, $idNuevoEstado);
                $exito = true;
            } else {
                $this->modificacion([
                    'id' => $compraEstadoActual->getId(),
                    'idCompra' => $idCompra,
                    'idEstadoTipo' => $compraEstadoActual->getIdEstadoTipo(),
                    'fechaIni' => $compraEstadoActual->getFechaIni(),
                    'fechaFin' => null
                ]);
            }
        }

        return $exito;
    }


    /**
     * Valida si la transición es lógica y segura.
     */
    public function verificacionTransicionEstado($param){
        $esValido = false;
        
        $idCompra = $param['idCompra'];
        $idNuevoEstado = (int)$param['nuevoEstado'];

        $estadosActivos = $this->buscar(['idCompra'=>$idCompra, 'fechaFinNull'=>true]);
        
        if (!empty($estadosActivos)) {
            $compraEstadoActual = $estadosActivos[0];
            $idActualEstado = (int)$compraEstadoActual->getIdEstadoTipo();

            $transicionesPermitidas = [
                1 => [3, 6],      // CARRITO -> PAGO, CANCELADO
                3 => [4, 6],      // PAGO -> PREPARACION, CANCELADO
                4 => [5, 6],      // PREPARACION -> ENVIADO, CANCELADO
                5 => [7, 6],      // ENVIADO -> ENTREGADO, CANCELADO
                7 => [8],         // ENTREGADO -> DEVUELTO
                6 => [],          // CANCELADO -> Fin
                8 => []           // DEVUELTO -> Fin
            ];

            if (isset($transicionesPermitidas[$idActualEstado])) {
                if (in_array($idNuevoEstado, $transicionesPermitidas[$idActualEstado])) {
                    $esValido = true;
                }
            }
        }

        return $esValido;
    }


    private function notificarCambioEstado($idCompra, $idEstadoTipo) {
        try {
            $abmTipo = new ABMCompraEstadoTipo();
            $tipoArr = $abmTipo->buscar(['id' => $idEstadoTipo]);
            if (empty($tipoArr)) return;
            $descEstado = $tipoArr[0]->getDescripcion();

            $abmCompra = new ABMCompra();
            $compraArr = $abmCompra->buscar(['id' => $idCompra]);
            if (empty($compraArr)) return;
            $idUsuario = $compraArr[0]->getIdUsuario();

            $abmUsuario = new ABMUsuario();
            $usuarioArr = $abmUsuario->buscar(['id' => $idUsuario]);
            
            if (!empty($usuarioArr)) {
                $user = $usuarioArr[0];
                $emailSender = new Email($user->getMail(), $user->getNombre(), null);
                $emailSender->enviarActualizacionEstado($idCompra, $descEstado);
            }
        } catch (Exception $e) {}
    }
}
?>