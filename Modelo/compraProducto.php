<?php
include_once ("conector/database.php");

class compraProducto {
    private $id;
    private $idCompra;
    private $idProducto;
    private $cantidad;
    private $mensajeOperacion;

    //constructor
    public function __construct() {
        $this->id = "";
        $this->idCompra = "";
        $this->idProducto = "";
        $this->cantidad = "";
        $this->mensajeOperacion = "";
    }

    //getters
    public function getId() {
        return $this->id;
    }
    public function getIdCompra() {
        return $this->idCompra;
    }
    public function getIdProducto() {
        return $this->idProducto;
    }
    public function getCantidad() {
        return $this->cantidad;
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
    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }
    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    //funcion para setear todos los atributos de la clase
    public function setear($id, $idCompra, $idProducto, $cantidad) {
        $this->setId($id);
        $this->setIdCompra($idCompra);
        $this->setIdProducto($idProducto);
        $this->setCantidad($cantidad);
    }

    //metodo para representar el objeto como cadena
    public function __toString() {
        return "CompraProducto ID: " . $this->getId() . ", Compra ID: " . $this->getIdCompra() . ", Producto ID: " . $this->getIdProducto() . ", Cantidad: " . $this->getCantidad();
    }

    /**
     * Modulo cargar
     * (funcion para cargar un registro de la tabla compraProducto)
     * @return bool
     */    
    public function cargar() {
        $resp = false;
        $base = new database();
        $sql = "SELECT * FROM compraProducto WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['id'], $row['idCompra'], $row['idProducto'], $row['cantidad']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("compraProducto->cargar: " . $base->getError());
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
        $sql = "INSERT INTO compraProducto(idCompra, idProducto, cantidad) VALUES (" . $this->getIdCompra() . ", " . $this->getIdProducto() . ", " . $this->getCantidad() . ")";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraProducto->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraProducto->insertar: " . $base->getError());
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
        $sql = "UPDATE compraProducto SET idCompra = " . $this->getIdCompra() . ", idProducto = " . $this->getIdProducto() . ", cantidad = " . $this->getCantidad() . " WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraProducto->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraProducto->modificar: " . $base->getError());
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
        $sql = "DELETE FROM compraProducto WHERE id = " . $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraProducto->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraProducto->eliminar: " . $base->getError());
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
        $sql = "SELECT * FROM compraProducto";
        if ($condicion != "") {
            $sql .= " WHERE " . $condicion;
        }
        $sql .= " ORDER BY id ";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $base->Registro()) {
                        $obj = new compraProducto();
                        $obj->setear($row['id'], $row['idCompra'], $row['idProducto'], $row['cantidad']);
                        array_push($arreglo, $obj);
                    }
                }
            }
        } else {
            self::setMensajeOperacion("compraProducto->seleccionar: " . $base->getError());
        }
        return $arreglo;
    }
}