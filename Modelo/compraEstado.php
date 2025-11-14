<?php
include_once ("conector/database.php");

class compraEstado {
    private $id;
    private $idCompra;
    private $idEstadoTipo;
    private $fechaIni;
    private $fechaFin;
    private $mensajeOperacion;

    //constructor
    public function __construct() {
        $this->id = "";
        $this->idCompra = "";
        $this->idEstadoTipo = "";
        $this->fechaIni = "";
        $this->fechaFin = "";
        $this->mensajeOperacion = "";
    }

    //getters
    public function getId() {
        return $this->id;
    }
    public function getIdCompra() {
        return $this->idCompra;
    }
    public function getIdEstadoTipo() {
        return $this->idEstadoTipo;
    }
    public function getFechaIni() {
        return $this->fechaIni;
    }
    public function getFechaFin() {
        return $this->fechaFin;
    }
    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    //setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setIdCompra($idCompra) {
        $this->idCompra = $idCompra;
    }
    public function setIdEstadoTipo($idEstadoTipo) {
        $this->idEstadoTipo = $idEstadoTipo;
    }
    public function setFechaIni($fechaIni) {
        $this->fechaIni = $fechaIni;
    }
    public function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
    }
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    //funcion para setear todos los atributos de la clase
    public function setear($id, $idCompra, $idEstadoTipo, $fechaIni, $fechaFin) {
        $this->setId($id);
        $this->setIdCompra($idCompra);
        $this->setIdEstadoTipo($idEstadoTipo);
        $this->setFechaIni($fechaIni);
        $this->setFechaFin($fechaFin);
    }

    //metodo para representar el objeto como cadena
    public function __toString() {
        return "compraEstado [id: " . $this->getId() . 
               ", idCompra: " . $this->getIdCompra() . 
               ", idEstadoTipo: " . $this->getIdEstadoTipo() . 
               ", fechaIni: " . $this->getFechaIni() . 
               ", fechaFin: " . $this->getFechaFin() . "]";
    }

    /**
     * Modulo cargar
     * (funcion para cargar un registro de la tabla productos)
     * @return bool
     */
    public function cargar() {
        $resp = false;
        $base = new database();
        $sql = "SELECT * FROM compraEstado WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['id'], $row['idCompra'], $row['idEstadoTipo'], $row['fechaIni'], $row['fechaFin']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("compraEstado->cargar: " . $base->getError());
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
        $sql = "INSERT INTO compraEstado (idCompra, idEstadoTipo, fechaIni, fechaFin) VALUES (" .
               $this->getIdCompra() . ", " .
               $this->getIdEstadoTipo() . ", '" .
               $this->getFechaIni() . "', ";
        if ($this->getFechaFin() != "") {
            $sql .= "'" . $this->getFechaFin() . "')";
        } else {
            $sql .= "NULL)";
        }
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraEstado->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraEstado->insertar: " . $base->getError());
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
        $sql = "UPDATE compraEstado SET idCompra = " . $this->getIdCompra() .
               ", idEstadoTipo = " . $this->getIdEstadoTipo() .
               ", fechaIni = '" . $this->getFechaIni() . "', ";
        if ($this->getFechaFin() != "") {
            $sql .= "fechaFin = '" . $this->getFechaFin() . "' ";
        } else {
            $sql .= "fechaFin = NULL ";
        }
        $sql .= "WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraEstado->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraEstado->modificar: " . $base->getError());
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
        $sql = "DELETE FROM compraEstado WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraEstado->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraEstado->eliminar: " . $base->getError());
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
        $sql = "SELECT * FROM compraEstado";
        if ($condicion != "") {
            $sql .= " WHERE " . $condicion;
        }
        $sql .= " ORDER BY id ";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $base->Registro()) {
                        $obj = new compraEstado();
                        $obj->setear($row['id'], $row['idCompra'], $row['idEstadoTipo'], $row['fechaIni'], $row['fechaFin']);
                        array_push($arreglo, $obj);
                    }
                }
            }
        } else {
            self::setMensajeOperacion("compraEstado->seleccionar: " . $base->getError());
        }
        
            
        return $arreglo;
    }

}