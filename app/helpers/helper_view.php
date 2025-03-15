<?php

function View($view_name, $data = []) {

    extract($data);

    $view_path = RAIZ. '/Views/' . $view_name . '.php';

    // Verificar si el archivo de la vista existe antes de incluirlo
    if (file_exists($view_path)) {
        include $view_path;
    } else {
        echo "Error: La vista '$view_name' no existe en '$view_path'.";
    }
}