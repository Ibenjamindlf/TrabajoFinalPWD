<?php
include_once ("conector/database.php");

class Producto {
    // Atributos de la clase
    // Por cada columna de la tabla en la base de datos
    private $id;
    private $nombre;
    private $stock;
    private $precio;
    private $detalle;
    private $imagen;
    private $mensajeOperacion;

    // Constructor
    public function __construct() {
        $this->id = "";
        $this->nombre = "";
        $this->stock = "";
        $this->precio = "";
        $this->detalle = "";
        $this->imagen = "";
        $this->mensajeOperacion = "";
    }
    
    //getters
    public function getId() {
        return $this->id;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function getStock() {
        return $this->stock;
    }
    public function getPrecio() {
        return $this->precio;
    }
    public function getdetalle() {
        return $this->detalle;
    }
    public function getimagen() {
        return $this->imagen;
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
    public function setStock($stock) {
        $this->stock = $stock;
    }
    public function setPrecio($precio) {
        $this->precio = $precio;
    }
    public function setdetalle($detalle) {
        $this->detalle = $detalle;
    }
    public function setimagen($imagen) {
        $this->imagen = $imagen;
    }
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }
    
    //funcion para setear todos los atributos de la clase
    public function setear ($id,$nombre, $stock, $precio, $detalle, $imagen) {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setStock($stock);
        $this->setPrecio($precio);
        $this->setdetalle($detalle);
        $this->setimagen($imagen);
    }
    
    //metodo para representar el objeto como cadena
    public function __toString() {
        $id = $this->getId();
        $nombre = $this->getNombre();
        $stock = $this->getStock();
        $precio = $this->getPrecio();
        $detalle = $this->getdetalle();
        $imagen = $this->getimagen();

        return "ID: $id, Nombre: $nombre, Stock: $stock, Precio: $precio, Detalle: $detalle, imagen: $imagen";
    }
    /**
     * Modulo cargar
     * (funcion para cargar un registro de la tabla productos)
     * @return bool
     */
    public function cargar(){
        $resp = false;
        $dataBase = new dataBase();
        $sql = "SELECT * FROM auto WHERE id = ".$this->getid(); 
        if ($dataBase->iniciar()) {
            $res = $dataBase->ejecutar($sql);
            if ($res>-1) {
                if ($res>0) {
                    $row = $dataBase->registro();
                    $this->setear($row['id'], $row['nombre'], $row['stock'], $row['precio'], $row['detalle'], $row['imagen']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("producto->cargar: " . $dataBase->getError());
        }
        return $resp;
    }
    /**
     * Modulo insertar
     * (funcion para insertar un producto en la BD)
     * @return bool
     */
    public function insertar(){
        $resp = false;
        $dataBase = new dataBase();
        $sql = "INSERT INTO producto (nombre, stock, precio, detalle, imagen) 
                        VALUES ('" . $this->getNombre() . "',
                                '" . $this->getStock() . "',
                                '" . $this->getPrecio() . "',
                                '" . $this->getdetalle() . "',
                                '" . $this->getimagen() . "')";
        if ($dataBase->iniciar()) {
            if ($dataBase->ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("producto->insertar: " . $dataBase->getError());
            }
        } else {
            $this->setMensajeOperacion("producto->insertar: " . $dataBase->getError());
        }
        return $resp;
    }
    /**
     * Modulo modificar
     * (funcion para modificar un producto en la BD)
     * @return bool
     */
    public function modificar(){
        $resp = false;
        $dataBase = new dataBase();
        $sql = "UPDATE producto SET 
                    nombre='" . $this->getNombre() . "',
                    stock='" . $this->getStock() . "',
                    precio='" . $this->getPrecio() . "',
                    detalle='" . $this->getdetalle() . "',
                    imagen='" . $this->getimagen() . "'
                WHERE id=" . $this->getId();
        if ($dataBase->iniciar()) {
            if ($dataBase->ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("producto->modificar: " . $dataBase->getError());
            }
        } else {
            $this->setMensajeOperacion("producto->modificar: " . $dataBase->getError());
        }
        return $resp;
    }
    /**
     * Modulo estado
     * (funcion encargada de actualizar el estado del borrado logico = cuando stock llegue a 0)
     * @param string|null $param
     * @return bool
     */
    public function estado($param = ""){
        $resp = false;
        $dataBase = new dataBase();
        $sql = "UPDATE producto SET 
                    stock='" . $param . "'
                WHERE id=" . $this->getId();
        if ($dataBase->iniciar()) {
            if ($dataBase->ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("producto->estado: " . $dataBase->getError());
            }
        } else {
            $this->setMensajeOperacion("producto->estado: " . $dataBase->getError());
        }
        return $resp;
    }
    /**
     * Modulo eliminar
     * (funcion que permite eliminar un producto de la BD)
     * @return bool
     */
    public function eliminar(){
        $resp = false;
        $dataBase = new dataBase();
        $sql = "DELETE FROM producto WHERE id=" . $this->getId();

        if ($dataBase->iniciar()) {
            if ($dataBase->ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("producto->eliminar: " . $dataBase->getError());
            }
        } else {
            $this->setMensajeOperacion("producto->eliminar: " . $dataBase->getError());
        }
        return $resp;
    }
    /**
     * Modulo seleccionar
     * (modulo que permite seleccionar en la BD)
     * @param string $condicion
     * @return array
     */
    public static function seleccionar($condicion = ""){
        $arreglo = array();
        $dataBase = new dataBase();
        $sql = "SELECT * FROM producto ";
        if ($condicion != "") {
            $sql .= " WHERE " . $condicion;
        }
        $sql .= " ORDER BY id ";
        if ($dataBase->Iniciar()) {
            $res = $dataBase->ejecutar($sql);
            if ($res>-1) {
                if ($res>0) {
                    while ($row = $dataBase->registro()) {
                        $obj = new Producto();
                        $obj->setear($row['id'], $row['nombre'], $row['stock'], $row['precio'], $row['detalle'], $row['imagen']);
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