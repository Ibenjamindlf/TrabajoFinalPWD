<?php
include_once ("conector/database.php");

class Rol {
    private $id;
    private $descripcion;
    private $mensajeOperacion;

    //constructor
    public function __construct() {
        $this->id = "";
        $this->descripcion = "";
        $this->mensajeOperacion = "";
    }

    //getters
    public function getId() {
        return $this->id;
    }
    public function getDescripcion() {
        return $this->descripcion;
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
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    //funcion para setear todos los atributos de la clase
    public function setear($id, $descripcion) {
        $this->setId($id);
        $this->setDescripcion($descripcion);
    }

    //metodo para representar el objeto como cadena
    public function __toString() {
        return "Rol ID: " . $this->getId() . ", Descripcion: " . $this->getDescripcion();
    }

    /**
     * Modulo cargar
     * (funcion para cargar un registro de la tabla productos)
     * @return bool
     */
    public function cargar() {
        $resp = false;
        $base = new database();
        $sql = "SELECT * FROM rol WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['id'], $row['descripcion']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("Rol->cargar: " . $base->getError());
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
        $sql = "INSERT INTO rol (descripcion) VALUES ('" . $this->getDescripcion() . "')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Rol->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Rol->insertar: " . $base->getError());
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
        $sql = "UPDATE rol SET descripcion = '" . $this->getDescripcion() . "' WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Rol->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Rol->modificar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * Modulo estado
     * (funcion encargada de actualizar el estado del borrado logico = cuando stock llegue a 0)
     * @param string|null $param
     * @return bool
     */
    public function estado($param = "") {
        $resp = false;
        $base = new database();
        $sql = "UPDATE rol SET descripcion = '" . $param . "' WHERE id = " . $this->getId();
        
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Rol->estado: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Rol->estado: " . $base->getError());
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
        $sql = "DELETE FROM rol WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Rol->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Rol->eliminar: " . $base->getError());
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
        $sql = "SELECT * FROM rol";
        if ($condicion != "") {
            $sql .= " WHERE " . $condicion;
        }
        $sql .= " ORDER BY id ";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $base->Registro()) {
                        $obj = new Rol();
                        $obj->setear($row['id'], $row['descripcion']);
                        array_push($arreglo, $obj);
                    }
                }
            }
        } else {
            self::setMensajeOperacion("producto->seleccionar: " . $dataBase->getError());
        }
        return $arreglo;
    }
}