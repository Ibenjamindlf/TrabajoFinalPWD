<?php
include_once ("conector/database.php");

class Usuario {
    private $id;
    private $nombre;
    private $password;
    private $mail;
    private $deshabilitado;
    private $mensajeOperacion; 

    //constructor
    public function __construct() {
        $this->id = "";
        $this->nombre = "";
        $this->password = "";
        $this->mail = "";
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
    public function getPassword() {
        return $this->password;
    }
    public function getMail() {
        return $this->mail;
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
    public function setPassword($password) {
        $this->password = $password;
    }
    public function setMail($mail) {
        $this->mail = $mail;
    }
    public function setDeshabilitado($deshabilitado) {
        $this->deshabilitado = $deshabilitado;
    }
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    //funcion para setear todos los atributos de la clase
    public function setear($id, $nombre, $password, $mail, $deshabilitado) {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setPassword($password);
        $this->setMail($mail);
        $this->setDeshabilitado($deshabilitado);
    }

    //metodo para representar el objeto como cadena
    public function __toString()
    {
        $id = $this->getId();
        $nombre = $this->getNombre();
        $mail = $this->getMail();
        $deshabilitado = $this->getDeshabilitado();
        return "ID: $id, 
        Nombre: $nombre, 
        Mail: $mail, 
        Deshabilitado: $deshabilitado";
    }


    /**
     * Modulo cargar
     * (funcion para cargar un registro de la tabla Usuario)
     * @return bool
     */
    public function cargar() {
        $resp = false;
        $base = new Database();
        $id = $this->getId();
        $sql = "SELECT * FROM usuario WHERE id = " . $id;
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['id'], $row['nombre'], $row['password'], $row['mail'], $row['deshabilitado']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("Usuario->cargar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * Modulo insertar
     * (funcion para insertar un usuario en la BD)
     * @return bool
     */
    public function insertar() {
        $resp = false;
        $base = new Database();
        $nombre = $this->getNombre();
        $password = $this->getPassword();
        $mail = $this->getMail();
        $deshabilitado = $this->getDeshabilitado();
        $sql = "INSERT INTO usuario (nombre, password, mail, deshabilitado) 
                VALUES ('$nombre', '$password', '$mail', '$deshabilitado')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql) > 0) {
                $resp = true;
            }
        } else {
            $this->setMensajeOperacion("Usuario->insertar: " . $base->getError());
        }
        return $resp;
    }
}
