<?php
include_once ("conector/database.php");

class Usuario {
    private $id;
    private $nombre;
    private $password;
    private $mail;
    private $token;
    private $confirmado;
    private $deshabilitado;
    private $mensajeOperacion; 

    //constructor
    public function __construct() {
        $this->id = "";
        $this->nombre = "";
        $this->password = "";
        $this->mail = "";
        $this->token = "";
        $this->confirmado = "";
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
    public function getToken() {
        return $this->token;
    }
    public function getConfirmado() {
        return $this->confirmado;
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
    public function setToken($token) {
        $this->token = $token;
    }
    public function setConfirmado($confirmado) {
        $this->confirmado = $confirmado;
    }
    public function setDeshabilitado($deshabilitado) {
        $this->deshabilitado = $deshabilitado;
    }
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    //funcion para setear todos los atributos de la clase
    public function setear($id, $nombre, $password, $mail, $token, $confirmado, $deshabilitado) {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setPassword($password);
        $this->setMail($mail);
        $this->setToken($token);
        $this->setConfirmado($confirmado);
        $this->setDeshabilitado($deshabilitado);
    }

    //metodo para representar el objeto como cadena
    public function __toString()
    {
        $id = $this->getId();
        $nombre = $this->getNombre();
        $mail = $this->getMail();
        $token = $this->getToken();
        $confirmado = $this->getConfirmado();
        $deshabilitado = $this->getDeshabilitado();
        return "ID: $id, 
        Nombre: $nombre, 
        Mail: $mail,
        Token: $token, 
        Confirmado: $confirmado, 
        Deshabilitado: $deshabilitado";
    }


    /**
     * Modulo cargar
     * (funcion para cargar un registro de la tabla Usuario)
     * @return bool
     */
    public function cargar() {
        $resp = false;
        $base = new database();
        $id = $this->getId();
        $sql = "SELECT * FROM usuario WHERE id = " . $id;
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['id'], $row['nombre'], $row['password'], $row['mail'], $row['token'], $row['confirmado'], $row['deshabilitado']);
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
        $base = new database();
        $nombre = $this->getNombre();
        $password = $this->getPassword();
        $mail = $this->getMail();
        $token = $this->getToken();
        $confirmado = $this->getConfirmado();
        $deshabilitado = $this->getDeshabilitado();
        $sql = "INSERT INTO usuario (nombre, password, mail, token, confirmado, deshabilitado) 
                VALUES ('$nombre', '$password', '$mail', '$token', '$confirmado', '$deshabilitado')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql) > 0) {
                $resp = true;
            }else {
                $this->setMensajeOperacion("Usuario->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Usuario->insertar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * Modulo modificar
     * (funcion para modificar un usuario en la BD)
     * @return bool
     */
    public function modificar() {
        $resp = false;
        $base = new database();
        $id = $this->getId();
        $nombre = $this->getNombre();
        $password = $this->getPassword();
        $mail = $this->getMail();
        $token = $this->getToken();
        $confirmado = $this->getConfirmado();
        $deshabilitado = $this->getDeshabilitado();
        $sql = "UPDATE usuario SET 
                nombre='$nombre', 
                password='$password', 
                mail='$mail',  
                token='$token',  
                confirmado='$confirmado', 
                deshabilitado='$deshabilitado' 
                WHERE id=$id";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql) > 0) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Usuario->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Usuario->modificar: " . $base->getError());
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
        $id = $this->getId();
        $sql = "UPDATE usuario SET deshabilitado = '$param' WHERE id = $id";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Usuario->estado: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Usuario->estado: " . $base->getError());
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
        $id = $this->getId();
        $sql = "DELETE FROM usuario WHERE id = $id";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql) > 0) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Usuario->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Usuario->eliminar: " . $base->getError());
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
        $sql = "SELECT * FROM usuario";
        if ($condicion != "") {
            $sql .= " WHERE " . $condicion;
        }
        $sql .= " ORDER BY id ";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $base->Registro()) {
                        $obj = new Usuario();
                        $obj->setear($row['id'], $row['nombre'], $row['password'], $row['mail'], $row['token'], $row['confirmado'], $row['deshabilitado']);
                        array_push($arreglo, $obj);
                    }
                }
            }
        } else {
            self::setMensajeOperacion("usuario->seleccionar: " . $base->getError());
        }
        return $arreglo;
    }

}
