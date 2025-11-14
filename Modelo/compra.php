<?php
include_once ("conector/database.php");

class compra {
    private $id;
    private $fecha;
    private $idUsuario;
    private $mensajeOperacion;


    //constructor
    public function __construct() {
        $this->id = "";
        $this->fecha = "";
        $this->idUsuario = "";
        $this->mensajeOperacion = "";
    }

    //getters
    public function getId() {
        return $this->id;
    }
    public function getFecha() {
        return $this->fecha;
    }
    public function getIdUsuario() {
        return $this->idUsuario;
    }
    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    //setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    //funcion para setear todos los atributos de la clase
    public function setear($id, $fecha, $idUsuario) {
        $this->setId($id);
        $this->setFecha($fecha);
        $this->setIdUsuario($idUsuario);
    }

    //metodo para representar el objeto como cadena
    public function __toString() {
        return "Compra ID: " . $this->getId() . ", Fecha: " . $this->getFecha() . ", Usuario ID: " . $this->getIdUsuario();
    }

    /**
     * Modulo cargar
     * (funcion para cargar un registro de la tabla productos)
     * @return bool
     */
    public function cargar() {
        $resp = false;
        $base = new database();
        $sql = "SELECT * FROM compra WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['id'], $row['fecha'], $row['idUsuario']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("compra->cargar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * modulo insertar
     *(funcion para insertar un producto en la BD)
     * @return bool
     */    public function insertar() {
        $resp = false;
        $base = new database();
        $sql = "INSERT INTO compra(fecha, idUsuario) VALUES ('" . $this->getFecha() . "', " . $this->getIdUsuario() . ")";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compra->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compra->insertar: " . $base->getError());
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
        $sql = "UPDATE compra SET fecha = '" . $this->getFecha() . "', idUsuario = " . $this->getIdUsuario() . " WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compra->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compra->modificar: " . $base->getError());
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
        $sql = "DELETE FROM compra WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compra->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compra->eliminar: " . $base->getError());
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
        $sql = "SELECT * FROM compra";
        if ($condicion != "") {
            $sql .= " WHERE " . $condicion;
        }
        $sql .= " ORDER BY id ";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $base->Registro()) {
                        $obj = new compra();
                        $obj->setear($row['id'], $row['fecha'], $row['idUsuario']);
                        array_push($arreglo, $obj);
                    }
                }
            }
        } else {
            self::setMensajeOperacion("compra->seleccionar: " . $base->getError());
        }
        return $arreglo;
    }
}