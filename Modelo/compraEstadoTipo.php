<?php
include_once ("conector/database.php");

class CompraEstadoTipo {    
    private $id;
    private $descripcion;
    private $detalle;
    private $mensajeOperacion;

    //constructor
    public function __construct() {
        $this->id = "";
        $this->descripcion = "";
        $this->detalle = "";
        $this->mensajeOperacion = "";
    }

    //getters
    public function getId() {
        return $this->id;
    }
    public function getDescripcion() {
        return $this->descripcion;
    }
    public function getDetalle() {
        return $this->detalle;
    }
    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    //setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    public function setDetalle($detalle) {
        $this->detalle = $detalle;
    }
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    //funcion para setear todos los atributos de la clase
    public function setear($id, $descripcion, $detalle) {
        $this->setId($id);
        $this->setDescripcion($descripcion);
        $this->setDetalle($detalle);
    }

    //metodo para representar el objeto como cadena
    public function __toString() {
        return "CompraEstadoTipo ID: " . $this->getId() . ", Descripcion: " . $this->getDescripcion() . ", Detalle: " . $this->getDetalle();
    }

    /**
     * Modulo cargar
     * (funcion para cargar un registro de la tabla productos)
     * @return bool
     */
    public function cargar() {
        $resp = false;
        $base = new database();
        $sql = "SELECT * FROM compraEstadoTipo WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['id'], $row['descripcion'], $row['detalle']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("CompraEstadoTipo->cargar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * modulo insertar
     *(funcion para insertar un producto en la BD)
     * @return bool
     */
    public function insertar() {
        $resp = false;
        $base = new database();
        $sql = "INSERT INTO compraEstadoTipo(descripcion, detalle) VALUES ('" . $this->getDescripcion() . "', '" . $this->getDetalle() . "')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraEstadoTipo->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraEstadoTipo->insertar: " . $base->getError());
        }
        return $resp;
    }

    
    /**
     * Modulo modificar
     * (funcion para modificar un producto en la BD)
     * @return bool
     */
    public function modificar() {
        $resp = false;
        $base = new database();
        $sql = "UPDATE compraEstadoTipo SET descripcion='" . $this->getDescripcion() . "', detalle='" . $this->getDetalle() . "' WHERE id=" . $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            }
        } else {
            $this->setMensajeOperacion("CompraEstadoTipo->modificar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * Modulo eliminar
     * (funcion que permite eliminar un producto de la BD)
     * @return bool
     */
    public function eliminar() {
        $resp = false;
        $base = new database();
        $sql = "DELETE FROM compraEstadoTipo WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraEstadoTipo->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraEstadoTipo->eliminar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * Modulo seleccionar
     * (modulo que permite seleccionar en la BD)
     * @param string $condicion
     * @return array
     */
    public static function seleccionar($condicion = "") {
        $arreglo = array();
        $base = new database();
        $sql = "SELECT * FROM compraEstadoTipo";
        if ($condicion != "") {
            $sql .= " WHERE " . $condicion;
        }
        $sql .= " ORDER BY id ";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $base->Registro()) {
                        $obj = new CompraEstadoTipo();
                        $obj->setear($row['id'], $row['descripcion'], $row['detalle']);
                        array_push($arreglo, $obj);
                    }
                }
            }
        } else {
            self::setMensajeOperacion("CompraEstadoTipo->seleccionar: " . $base->getError());
        }
        return $arreglo;
    }
}