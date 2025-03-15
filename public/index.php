<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/config.php';

$url = $_SERVER['REQUEST_URI'];
$request_uri = str_replace(BASE_PATH, '', $url);

// Eliminar parámetros de la URL (como ?id=1)
$request_uri = explode('?', $request_uri)[0];

// Pequeño sistema de rutas
$routes = [
    '/' => 'HomeController@index',
    '/productos' => 'ProductoController@index',
    '/productos/crear' => 'ProductoController@crear',
    '/productos/ViewUpdate'=>'ProductoController@ViewUpdate',
    '/productos/editar'=>'ProductoController@editar',
    '/productos/Delete'=>'ProductoController@Delete',
    '/pyg/CreateOrUpdeat'=>'PygController@CreateOrUpdeat',
    '/grupos' => 'GrupoController@index',
    '/grupos/crear' => 'GrupoController@crear',
    '/grupos/ViewUpdate' => 'GrupoController@ViewUpdate',
    '/grupos/editar' => 'GrupoController@editar',
    '/grupos/Delete' => 'GrupoController@Delete',
    '/grupos/ViewProducts' => 'PygController@obtenerProductosPorGrupo',
];

// Verificar si la ruta existe
if (array_key_exists($request_uri, $routes)) {
    
    list($controller_name, $method_name) = explode('@', $routes[$request_uri]);
    // Incluir el controlador
    require_once __DIR__ . '/../app/Controllers/' . $controller_name . '.php'; 
    // Crear una instancia del controlador y llamar al método
    $controller = new $controller_name();
    $controller->$method_name();
} else {
    // Ruta no encontrada
    http_response_code(404);
    echo "Página no encontrada.";
}
?>