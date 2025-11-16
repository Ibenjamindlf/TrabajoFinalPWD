<?php
include_once ("conector/database.php");

class MenuRol {
    private $id;
    private $idMenu;
    private $idRol;
    private $mensajeOperacion;

    //constructor
    public function __construct() {
        $this->id = "";
        $this->idMenu = "";
        $this->idRol = "";
        $this->mensajeOperacion = "";
    }
    
    //getters
    public function getId() {
        return $this->id;
    }
    public function getIdMenu() {
        return $this->idMenu;
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
    public function setIdMenu($idMenu) {
        $this->idMenu = $idMenu;
    }
    public function setIdRol($idRol) {
        $this->idRol = $idRol;
    }
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    //funcion para setear todos los atributos de la clase
    public function setear($id, $idMenu, $idRol) {
        $this->setId($id);
        $this->setIdMenu($idMenu);
        $this->setIdRol($idRol);
    }

    //metodo para representar el objeto como cadena
    public function __toString() {
        return "MenuRol ID: " . $this->getId() . ", Menu ID: " . $this->getIdMenu() . ", Rol ID: " . $this->getIdRol();
    }

    /**
     * Modulo cargar
     * (funcion para cargar un registro de la tabla productos)
     * @return bool
     */
    public function cargar() {
        $resp = false;
        $base = new database();
        $sql = "SELECT * FROM menurol WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['id'], $row['idMenu'], $row['idRol']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("MenuRol->cargar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * Modulo insertar
     * (funcion para insertar un producto en la BD)
     * @return bool
     */
    public function insertar() {
        $resp = false;
        $base = new database();
        $sql = "INSERT INTO menurol(idMenu, idRol) VALUES (" . $this->getIdMenu() . ", " . $this->getIdRol() . ")";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql) > 0) {
                $resp = true;
            }
        } else {
            $this->setMensajeOperacion("MenuRol->insertar: " . $base->getError());
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
        $sql = "UPDATE menurol SET 
            idMenu = " . $this->getIdMenu() . ",
            idRol = " . $this->getIdRol() . " 
        WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql) > 0) {
                $resp = true;
            } else {
            $this->setMensajeOperacion("MenuRol->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("MenuRol->modificar: " . $base->getError());
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
        $sql = "DELETE FROM menurol WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql) > 0) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("MenuRol->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("MenuRol->eliminar: " . $base->getError());
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
        $sql = "SELECT * FROM menurol";
        if ($condicion != "") {
            $sql .= " WHERE " . $condicion;
        }
        $sql .= " ORDER BY id ";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $base->Registro()) {
                        $obj = new MenuRol();
                        $obj->setear($row['id'], $row['idMenu'], $row['idRol']);
                        array_push($arreglo, $obj);
                    }
                }
            }
        } else {
            self::setMensajeOperacion("MenuRol->seleccionar: " . $base->getError());
        }
        return $arreglo;
    }
    
}   