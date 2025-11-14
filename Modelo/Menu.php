<?php
include_once ("conector/database.php");

class Menu {
    private $id;
    private $nombre;
    private $descripcion;
    private $link;
    private $idPadre;
    private $deshabilitado;
    private $mensajeOperacion;

    //constructor
    public function __construct() {
        $this->id = "";
        $this->nombre = "";
        $this->descripcion = "";
        $this->link = "";
        $this->idPadre = "";
        $this->deshabilitado = "";
        $this->mensajeOperacion = "";
    }

    //getters
    public function getId() {
        return $this->id;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function getDescripcion() {
        return $this->descripcion;
    }
    public function getLink() {
        return $this->link;
    }
    public function getIdPadre() {
        return $this->idPadre;
    }
    public function getDeshabilitado() {
        return $this->deshabilitado;
    }
    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    //setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    public function setLink($link) {
        $this->link = $link;
    }
    public function setIdPadre($idPadre) {
        $this->idPadre = $idPadre;
    }
    public function setDeshabilitado($deshabilitado) {
        $this->deshabilitado = $deshabilitado;
    }
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    //funcion para setear todos los atributos de la clase
    public function setear($id, $nombre, $descripcion, $link, $idPadre, $deshabilitado) {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setDescripcion($descripcion);
        $this->setLink($link);
        $this->setIdPadre($idPadre);
        $this->setDeshabilitado($deshabilitado);
    }

    //metodo para representar el objeto como cadena
    public function __toString() {
        return "Menu ID: " . $this->getId() . ", Nombre: " . $this->getNombre() . ", Descripcion: " . $this->getDescripcion() . ", Link: " . $this->getLink() . ", ID Padre: " . $this->getIdPadre() . ", Deshabilitado: " . $this->getDeshabilitado();
    }

    /**
     * modulo cargar
     * (funcion para cargar un registro de la tabla productos)
     * @return bool
     */
    public function cargar() {
        $resp = false;
        $base = new database();
        $sql = "SELECT * FROM menu WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['id'], $row['nombre'], $row['descripcion'], $row['link'], $row['idPadre'], $row['deshabilitado']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("Menu->cargar: " . $base->getError());
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
        $sql = "INSERT INTO menu (nombre, descripcion, link, idPadre, deshabilitado) 
        VALUES ('" . $this->getNombre() . "',
         '" . $this->getDescripcion() . "',
          '" . $this->getLink() . "',
           " . $this->getIdPadre() . ",
            " . $this->getDeshabilitado() . ")";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            }else {
            $this->setMensajeOperacion("Menu->insertar: " . $base->getError());
        }
        } else {
            $this->setMensajeOperacion("Menu->insertar: " . $base->getError());
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
        $sql = "UPDATE menu SET 
                nombre = '" . $this->getNombre() . "',
                descripcion = '" . $this->getDescripcion() . "',
                link = '" . $this->getLink() . "',
                idPadre = " . $this->getIdPadre() . ",
                deshabilitado = " . $this->getDeshabilitado() . "
                WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Menu->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->modificar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * modulo estado
     * (funcion encargada de actualizar el estado del borrado logico = cuando stock llegue a 0)
     * @param string|null $param
     * @return bool
     */
    public function estado($param = "" ) {
        $resp = false;
        $base = new database();
        $sql = "UPDATE menu SET deshabilitado = '" . $param . "' WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Menu->estado: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->estado: " . $base->getError());
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
        $sql = "DELETE FROM menu WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Menu->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->eliminar: " . $base->getError());
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
        $sql = "SELECT * FROM menu";
        if ($condicion != "") {
            $sql .= " WHERE " . $condicion;
        }
        $sql .= " ORDER BY id ASC";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $base->Registro()) {
                        $obj = new Menu();
                        $obj->setear($row['id'], $row['nombre'], $row['descripcion'], $row['link'], $row['idPadre'], $row['deshabilitado']);
                        array_push($arreglo, $obj);
                    }
                }
            }
        } else {
            echo "Menu->seleccionar: " . $base->getError();
        }
        return $arreglo;
    }


}