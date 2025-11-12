<?php
include_once ("conector/database.php");

class UsuarioRol {
    private $id;
    private $idUsuario;
    private $idRol;
    private $mensajeOperacion;

    //constructor
    public function __construct() {
        $this->id = "";
        $this->idUsuario = "";
        $this->idRol = "";
        $this->mensajeOperacion = "";
    }

    //getters
    public function getId() {
        return $this->id;
    }
    public function getIdUsuario() {
        return $this->idUsuario;
    }
    public function getIdRol() {
        return $this->idRol;
    }
    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    //setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }
    public function setIdRol($idRol) {
        $this->idRol = $idRol;
    }
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    //funcion para setear todos los atributos de la clase
    public function setear($id, $idUsuario, $idRol) {
        $this->setId($id);
        $this->setIdUsuario($idUsuario);
        $this->setIdRol($idRol);
    }

    //metodo para representar el objeto como cadena
    public function __toString() {
        return "UsuarioRol ID: " . $this->getId() . ", Usuario ID: " . $this->getIdUsuario() . ", Rol ID: " . $this->getIdRol();
    }

    /**
     * Modulo cargar
     * (funcion para cargar un registro de la tabla productos)
     * @return bool
     */
    public function cargar() {
        $resp = false;
        $base = new database();
        $sql = "SELECT * FROM usuarioRol WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['id'], $row['idUsuario'], $row['idRol']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("UsuarioRol->cargar: " . $base->getError());
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
        $sql = "INSERT INTO usuarioRol(idUsuario, idRol) VALUES (" . $this->getIdUsuario() . ", " . $this->getIdRol() . ")";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("UsuarioRol->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("UsuarioRol->insertar: " . $base->getError());
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
        $sql = "UPDATE usuarioRol SET idUsuario = " . $this->getIdUsuario() . ", idRol = " . $this->getIdRol() . " WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("UsuarioRol->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("UsuarioRol->modificar: " . $base->getError());
        }
        return $resp;
    }

    // en esta clase no hay metodo estado debido a que no puede estar deshabilitada una relacion usuario-rol



    /**
     * Modulo eliminar
     * (funcion que permite eliminar un producto de la BD)
     * @return bool
     */
    public function eliminar() {
        $resp = false;
        $base = new database();
        $sql = "DELETE FROM usuarioRol WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("UsuarioRol->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("UsuarioRol->eliminar: " . $base->getError());
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
        $sql = "SELECT * FROM usuarioRol";
        if ($condicion != "") {
            $sql .= " WHERE " . $condicion;
        }
        $sql .= " ORDER BY id ";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $base->Registro()) {
                        $obj = new UsuarioRol();
                        $obj->setear($row['id'], $row['idUsuario'], $row['idRol']);
                        array_push($arreglo, $obj);
                    }
                }
            }
        } else {
            self::setMensajeOperacion("usuarioRol->seleccionar: " . $base->getError());
        }
        return $arreglo;
    }
}