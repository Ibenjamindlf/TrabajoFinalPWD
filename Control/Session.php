<?php
include_once ("../Modelo/Usuario.php");



class Session {
    

    // Constructor que inicia la sesion si no está iniciada
    public function __construct()
    {
        if (session_start() === PHP_SESSION_NONE) {
            session_start();
        }
    }


    // Inicia sesión con los valores de usuario y contraseña

    public function iniciar($nombreUsuario, $psw) {
        $resultado = false;
        $where = "usnombre = '$nombreUsuario' AND uspass = '$psw'";

        $usuarios = Usuario::seleccionar($where);

        if (count($usuarios) > 0) {
            $usuario = $usuarios[0];

            // Guardamos datos de sesion
            $_SESSION['idUsuario'] = $usuario->getIdUsuario();
            $_SESSION['nombreUsuario'] = $usuario->getNombreUsuario();
            $_SESSION['usMail'] = $usuario->getUsMail();
            $_SESSION['activa'] = true;

            $resultado = true;
        }

        return $resultado;
    }

    // Valida si la sesión actual tiene usuario y psw válido

    public function validar() {

        if ($this->activa()) {

            if (isset($_SESSION['nombreUsuario']) && isset($_SESSION['rol'])) {
                return true;
            }
        }
        return false;
    }


    // Devuelve true o false si la sesión está activa o no
    public function activa() {
        return (isset($_SESSION['activa']) && $_SESSION['activa'] === true);
    }


    // Devuelve el usuario logueado
    public function getUsuario() {

        if ($this->activa()) {
            return $_SESSION['nombreUsuario'];
        }
        return null;
    }

    // Cierra la sesión Actual
    public function cerrar() {
        $_SESSION = [];

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

}

?>

