<?php
include_once __DIR__ . '/../Modelo/Usuario.php';
include_once ("ABMUsuarioRol.php"); 

class Session {
    
    /**
     * Constructor que inicia la sesion si no está iniciada
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Inicia la sesión para un usuario VALIDADO.
     * Recibe el objeto Usuario y carga sus datos en $_SESSION.
     * @param Usuario $objUsuario
     */
    public function iniciar($objUsuario) {
        if ($objUsuario != null) {
            $_SESSION['idusuario'] = $objUsuario->getId();
            $_SESSION['nombreusuario'] = $objUsuario->getNombre();
            
            // Cargamos sus roles en la sesión
            $abmUR = new ABMUsuarioRol();
            $rolesUsuario = $abmUR->buscar(['idUsuario' => $objUsuario->getId()]);
            
            $rolesParaSesion = [];
            if ($rolesUsuario != null) {
                foreach ($rolesUsuario as $rol) {
                    $rolesParaSesion[] = $rol->getIdRol();
                }
            }
            $_SESSION['roles'] = $rolesParaSesion;
            
            // Seteamos la sesión como activa
            $_SESSION['activa'] = true;
        }
    }

    /**
     * Valida si la sesión actual está activa y tiene los datos mínimos.
     * @return bool
     */
    public function validar() {
        // Comprueba si está activa Y si tiene un id y roles
        return ($this->activa() && 
                isset($_SESSION['idusuario']) && 
                isset($_SESSION['roles'])
               );
    }

    /**
     * Devuelve true o false si la sesión está activa o no
     * @return bool
     */
    public function activa() {
        return (isset($_SESSION['activa']) && $_SESSION['activa'] === true);
    }

    /**
     * Devuelve el nombre del usuario logueado
     * @return string|null
     */
    public function getNombreUsuario() {
        if ($this->activa()) {
            return $_SESSION['nombreusuario'];
        }
        return null;
    }

    /**
     * Devuelve el ID del usuario logueado
     * @return int|null
     */
    public function getIdUsuario() {
        if ($this->activa()) {
            return $_SESSION['idusuario'];
        }
        return null;
    }

    /**
     * Devuelve el array de IDs de roles del usuario
     * @return array|null
     */
    public function getRoles() {
        if ($this->activa()) {
            return $_SESSION['roles'];
        }
        return null;
    }

    /**
     * Cierra la sesión Actual
     */
    public function cerrar() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset(); // Limpia todas las variables
            session_destroy(); // Destruye la sesión
        }
    }

    /**
 * Verifica si el usuario logueado tiene un rol específico
 * @param array $rolBuscado
 * @return bool
 */
public function verificarRol($rolesRequeridos) {
    if (!$this->validar()){
        $rolExito = false;
    } else {
        $rolExito = in_array($_SESSION['roles'][0],$rolesRequeridos);
    }
    return $rolExito;
}

/**
 * Protege una página permitiendo solo usuarios con un rol específico.
 * Si no tiene el rol → redirige al login o a error.
 */
public function requiereRol($rolesRequeridos) {
    $esRolRequerido = true;
    if (!$this->verificarRol($rolesRequeridos)) {
        $esRolRequerido = false;
    }
    return $esRolRequerido;
}

}
?>

