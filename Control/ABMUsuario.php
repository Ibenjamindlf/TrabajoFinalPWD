<?php

include_once (__DIR__ . '/../Modelo/Usuario.php');
include_once (__DIR__ . '/validadores/Validador.php');


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
            // Hasheamos la contraseña antes de guardarla.
            $hashedPassword = password_hash($param['password'], PASSWORD_DEFAULT);
            
            $objUsuario->setear(
                null, 
                $param['nombre'],
                $hashedPassword, 
                $param['mail'],
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
            // setear() espera 5 parámetros
            $objUsuario->setear($param['id'], null, null, null, null);
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

        // 1. Validaciones
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
            
            // 3. Seteamos los nuevos datos
            $objUsuario->setNombre($param['nombre']);
            $objUsuario->setMail($param['mail']);

            // *** ¡SEGURIDAD! ***
            // Solo actualizamos el password SI el usuario escribió uno nuevo
            if (!empty($param['password'])) {
                $hashedPassword = password_hash($param['password'], PASSWORD_DEFAULT);
                $objUsuario->setPassword($hashedPassword);
            }
            
            // (No tocamos 'deshabilitado' aquí, para eso está bajaLogica)

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



    // Función de LOGIN
    public function login($param) {
        if (empty($param['nombre']) || empty($param['password'])) {
            return false;
        }

        $lista = $this->buscar(['nombre' => $param['nombre']]);

        if (count($lista) > 0) {
            $objUsuario = $lista[0];
            

            $deshabilitado = $objUsuario->getDeshabilitado();
            if ($deshabilitado == null || $deshabilitado == '0000-00-00 00:00:00') {
                
                if (password_verify($param['password'], $objUsuario->getPassword())) {
                    
                    
                    session_start(); 
                    $_SESSION['idusuario'] = $objUsuario->getId();
                    $_SESSION['nombreusuario'] = $objUsuario->getNombre();
                    
                    
                    return true;
                }
            }
        }
        
        return false;
    }





}

?>