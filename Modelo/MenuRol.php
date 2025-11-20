<?php
include_once ("conector/database.php");

class MenuRol {
    private $id;
    private $objMenu;
    private $objRol;
    private $mensajeOperacion;

    //constructor
    public function __construct() {
        $this->id = "";
        $this->objMenu = null;
        $this->objRol = null;
        $this->mensajeOperacion = "";
    }
    
    //getters
    public function getId() {
        return $this->id;
    }
    public function getObjMenu() {
        return $this->objMenu;
    }
    public function getObjRol() {
        return $this->objRol;
    }
    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    //setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setObjMenu($objMenu) {
        $this->objMenu = $objMenu;
    }
    public function setObjRol($objRol) {
        $this->objRol = $objRol;
    }
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    //funcion para setear todos los atributos de la clase
    public function setear($id, $objMenu, $objRol) {
        $this->setId($id);
        $this->setObjMenu($objMenu);
        $this->setObjRol($objRol);
    }

    //metodo para representar el objeto como cadena
    public function __toString() {
        return "MenuRol ID: " . $this->getId() . ", Menu: " . $this->getObjMenu() . ", Rol: " . $this->getObjRol();
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

                    $objMenu = new Menu();
                    $objMenu->setId($row['idMenu']);
                    $objMenu->cargar();

                    $objRol = new Rol();
                    $objRol->setId($row['idRol']);
                    $objRol->cargar();

                    $this->setear($row['id'], $objMenu, $objRol);
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

        $idMenu = $this->getObjMenu()->getId();
        $idRol = $this->getObjRol()->getId();
        $sql = "INSERT INTO menurol(idMenu, idRol) VALUES (" . $idMenu() . ", " . $idRol . ")";
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

        $idMenu = $this->getObjMenu()->getId();
        $idRol = $this->getObjRol()->getId();

        $sql = "UPDATE menurol SET 
            idMenu = " . $idMenu . ",
            idRol = " . $idRol . " 
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

                        $objMenu = new Menu();
                        $objMenu->setId($row['idMenu']);
                        $objMenu->cargar();

                        $objRol = new Rol();
                        $objRol->setId($row['idRol']);
                        $objRol->cargar();

                        $obj->setear($row['id'], $objMenu, $objRol);
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