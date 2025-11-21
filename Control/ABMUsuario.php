<?php

include_once (__DIR__ . '/../Modelo/Usuario.php');
include_once (__DIR__ . '/validadores/Validador.php');
include_once (__DIR__ . '/../Clases/Email.php');

class ABMUsuario {


    // Modulo Buscar
    public function buscar($param){
        $where = " true ";
        if ($param != null){
            if (!empty($param['id'])) {
                $where .= " and id = " . $param['id'];
            }
            if (!empty($param['nombre'])) {
                $where .= " and nombre = '" . $param['nombre'] . "'";
            }
            if (!empty($param['mail'])) {
                $where .= " and mail = '" . $param['mail'] . "'";
            }
            if (!empty($param['token'])) {
                $where .= " and token = '" . $param['token'] . "'";
            }
            if (!empty($param['password'])) {
                 $where .= " and password = '" . $param['password'] . "'";
            }
        }
        $arreglo = Usuario::seleccionar($where);
        return $arreglo;
    }


    // Cargar el objeto y hashea la contraseña
    private function cargarObjeto($param) {
        $objUsuario = null;

        if (
            array_key_exists('nombre', $param) &&
            array_key_exists('password', $param) &&
            array_key_exists('mail', $param)
        ) {
            $objUsuario = new Usuario();

            // *** ¡SEGURIDAD! ***
            $hashedPassword = password_hash($param['password'], PASSWORD_DEFAULT);
            
            $objUsuario->setear(
                null, // id
                $param['nombre'],
                $hashedPassword, 
                $param['mail'],
                $param['token'] ?? null, 
                $param['confirmado'] ?? 0, 
                null                      
            );
        }
        return $objUsuario;
    }


    // Corrobora que dentro del array asociativo está seteada la clave primaria
    private function seteadosCamposClaves($param) {
        $resp = false;

        if (isset($param['id'])) {
            $resp = true;
        }

        return $resp;
    }

    // Cargar un objeto solo con la clave primaria
    private function cargarObjetoConClave($param){
        $objUsuario = null;
        if (isset($param['id'])) {
            $objUsuario = new Usuario();
            $objUsuario->setear($param['id'], null, null, null, null, null, null);
        }
        return $objUsuario;
    } 


    // Alta
    public function alta($param){
        $resp = false;
        $valido = true;
        $errores = [];

        if (!Validador::noEstaVacio($param['nombre'])) {
            $valido = false;
            $errores[] = "El nombre no puede estar vacío.";
        }
        if (!Validador::esEmailValido($param['mail'])) {
            $valido = false;
            $errores[] = "El formato del email no es válido.";
        }
        if (!Validador::esPasswordSegura($param['password'])) {
            $valido = false;
            $errores[] = "La contraseña debe tener al menos 8 caracteres.";
        }

        if (!$valido) {
            $_SESSION['errores_abm'] = $errores;
            return false;
        }
        
        // Evita duplicados
        $existeUsuario = $this->buscar(["mail" => $param['mail']]);

        if ($existeUsuario == null) {
            $objUsuario = $this->cargarObjeto($param); 
            if ($objUsuario != null && $objUsuario->insertar()) {
                $resp = true;
            } else {
                 $_SESSION['errores_abm'] = ["Error al insertar en la BD."];
            }
        } else {
             $_SESSION['errores_abm'] = ["Ya existe un usuario con ese email."];
        }

        return $resp;
    }



    // Modificacion
    public function modificacion($param){
        $resp = false;
        $valido = true;
        $errores = [];

        if (!$this->seteadosCamposClaves($param)) {
            $valido = false;
            $errores[] = "No se proveyó el ID de usuario.";
        }
        if (!Validador::noEstaVacio($param['nombre'])) {
            $valido = false;
            $errores[] = "El nombre no puede estar vacío.";
        }
        if (!Validador::esEmailValido($param['mail'])) {
            $valido = false;
            $errores[] = "El formato del email no es válido.";
        }
        if (!empty($param['password']) && !Validador::esPasswordSegura($param['password'])) {
             $valido = false;
             $errores[] = "La contraseña debe tener al menos 8 caracteres.";
        }

        if (!$valido) {
            $_SESSION['errores_abm'] = $errores;
            return false;
        }

        $lista = $this->buscar(['id' => $param['id']]);

        if (count($lista) > 0) {
            $objUsuario = $lista[0];
            
            $objUsuario->setNombre($param['nombre']);
            $objUsuario->setMail($param['mail']);

            // *** ¡SEGURIDAD! ***
            if (!empty($param['password'])) {
                $hashedPassword = password_hash($param['password'], PASSWORD_DEFAULT);
                $objUsuario->setPassword($hashedPassword);
            }
            

            if ($objUsuario->modificar()) {
                $resp = true;
            } else {
                 $_SESSION['errores_abm'] = ["Error al modificar en la BD."];
            }
        } else {
            $_SESSION['errores_abm'] = ["No se encontró el usuario a modificar."];
        }
        
        return $resp;
    }



    // Baja Lógica
    public function bajaLogica($param) {
        $resp = false;
        
        if (!$this->seteadosCamposClaves($param)) {
            $_SESSION['errores_abm'] = ["No se proveyó el ID de usuario."];
            return false;
        }

        $lista = $this->buscar(['id' => $param['id']]);
        
        if (count($lista) > 0) {
            $objUsuario = $lista[0];
            $estadoUsuario = $objUsuario->getDeshabilitado();
            
            $nuevoEstado = null; 
            
            if ($estadoUsuario == null || $estadoUsuario == '0000-00-00 00:00:00') {
                $nuevoEstado = date("Y-m-d H:i:s"); // Deshabilitar
            } else {
                $nuevoEstado = null; 
            }

            if ($objUsuario->estado($nuevoEstado)) {
                $resp = true;
            }
        }
        return $resp;
    }

    // Baja Física
    public function bajaFisica($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objUsuario = $this->cargarObjetoConClave($param);
            if ($objUsuario != null && $objUsuario->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }


    /* Función de LOGIN (Refactorizada)
     * Verifica al usuario y DEVUELVE EL OBJETO USUARIO si es exitoso.
     * Ya no maneja la sesión.
     */
    public function login($param) {
        
        if (empty($param['mail']) || empty($param['password'])) {
            return null; // Devuelve null si falla
        }

        $lista = $this->buscar(['mail' => $param['mail']]);

        if ($lista != null && count($lista) > 0) {
            $objUsuario = $lista[0];
            
            $deshabilitado = $objUsuario->getDeshabilitado();
            if ($deshabilitado == null || $deshabilitado == '0000-00-00 00:00:00') {
                
                if ($objUsuario->getConfirmado() == 1) {

                    if (password_verify($param['password'], $objUsuario->getPassword())) {
                        
                        // ¡ÉXITO! Devolvemos el objeto usuario
                        return $objUsuario;
                    }
                }
            }
        }
        
        // Si falla cualquier paso, devuelve null
        return null;
    }

    /**
     * Maneja el proceso de solicitar recuperación de contraseña.
     * Retorna true si el formato del email es válido (independientemente de si existe o no).
     * Retorna false solo si el email es inválido.
     */
    public function iniciarRecuperacion($email) {
        // 1. Validar formato
        if (!Validador::esEmailValido($email)) {
            return false;
        }

        // 2. Buscar usuario
        $usuarios = $this->buscar(['mail' => $email]);

        if ($usuarios != null && count($usuarios) > 0) {
            $usuario = $usuarios[0];
            
            // 3. Generar token con uniqid() como pediste
            $token = uniqid(); 
            $usuario->setToken($token);
            
            // 4. Guardar y Enviar
            if ($usuario->modificar()) {
                // Importar clase Email si hace falta
                if (!class_exists('Email')) {
                    include_once(__DIR__ . '/../Clases/Email.php');
                }
                
                $mailer = new Email($usuario->getMail(), $usuario->getNombre(), $token);
                $mailer->enviarInstrucciones();
            }
        }
        
        return true;
    }


   /**
     * Verifica si un token de recuperación es válido y existe.
     * @param string $token
     * @return bool
     */
    public function verificarToken($token) {
        $enviado = false;
        // Validación básica
        if (empty($token)) {
            return $enviado;
        }

        // Usamos el método buscar que ya tienes
        $usuarios = $this->buscar(['token' => $token]);

        // Si devuelve al menos un usuario, el token es válido
        if ($usuarios != null && count($usuarios) > 0) {
            $enviado = true;
        }
        return $enviado;
    }

    /**
     * Finaliza el proceso de recuperación: valida y guarda la nueva password.
     * @param array $datos (Debe contener: token, password, confirm_password)
     * @return bool Devuelve true si se guardó correctamente, false si hubo error.
     */
    public function restablecerPassword($datos) {
        $resp = false; // Inicializamos la variable de respuesta
        
        $token = $datos['token'] ?? '';
        $pass = $datos['password'] ?? '';
        $confirm = $datos['confirm_password'] ?? '';

        // 1. Validaciones básicas
        if ($pass !== $confirm) {
            $_SESSION['errores_abm'] = "Las contraseñas no coinciden.";
            return $resp;
        }

        if (!Validador::esPasswordSegura($pass)) {
            $_SESSION['errores_abm'] = "La contraseña debe tener al menos 8 caracteres.";
            return $resp;
        }

        // 2. Buscar usuario por token
        $usuarios = $this->buscar(['token' => $token]);

        if ($usuarios != null && count($usuarios) > 0) {
            $usuario = $usuarios[0];

            // 3. Encriptar contraseña y borrar token
            $newHash = password_hash($pass, PASSWORD_DEFAULT);
            $usuario->setPassword($newHash);
            $usuario->setToken(null); 

            // 4. Intentar modificar en BD
            if ($usuario->modificar()) {
                $resp = true;
            } else {
                $_SESSION['errores_abm'] = "Error al guardar la nueva contraseña en la base de datos.";
            }
        } else {
            $_SESSION['errores_abm'] = "El enlace de recuperación es inválido o ha expirado.";
        }

        return $resp;
    }

}

?>