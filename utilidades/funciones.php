<?php

function data_submitted()
{
    $requestData = array();

    if (!empty($_POST)) {
        $requestData = $_POST;
    } elseif (!empty($_GET)) {
        $requestData = $_GET;
    }
    if (!empty($_FILES)) {
        foreach ($_FILES as $indice => $archivo) {
            $requestData[$indice] = $archivo;
        }
    }
    if (count($requestData)) {
        foreach ($requestData as $indice => $valor) {
            // Evitamos alterar arrays (como los de $_FILES)
            if (!is_array($valor) && $valor === "") {
                $requestData[$indice] = 'null';
            }
        }
    }
    return $requestData;
}

// Funcion que sirve para debuguear
function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Función que revisa que el usuario esté autenticado

function isAuth() : void {
    if (!isset($_SESSION['login'])) {
        header('Location: /');
        exit;
    }
}

function isAdmin() : void {

    if(!isset($_SESSION['admin'])) {
        header('Location: /');
        exit;
    }
}

?>