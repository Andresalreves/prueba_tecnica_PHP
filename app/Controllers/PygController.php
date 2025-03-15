<?php

require_once __DIR__ . '/../Models/Pyg.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../helpers/helper_view.php';

class PygController {
    private $db;
    private $pyg;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->pyg = new Pyg($this->db);
    }

    public function CreateOrUpdeat(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->pyg->producto_id = $_POST['producto_id'];
            $this->pyg->grupo_id = $_POST['grupo_id'];
            if ($this->pyg->actualizarOCrearProductoGrupo()) {
                // mensaje de éxito
                echo json_encode(array("message" => "Se asigno el producto al grupo exitosamente."));
            } else {
                // Retornar mensaje de error
                http_response_code(500); // Error interno del servidor
                echo json_encode(array("message" => "Error al asignar producto al grupo."));
            }
        } else {
            // Si no es una solicitud POST, retornar un error
            http_response_code(405);
            echo json_encode(array("message" => "Método no permitido."));
        }
    }

    public function obtenerProductosPorGrupo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->pyg->grupo_id = $_POST['id'];
            $stmt = $this->pyg->obtenerProductosPorGrupo();
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Pasar los productos a la vista
            View('VerProductosGrupo', ['productos'=>$productos]);
        } else {
            // Si no es una solicitud POST, mostrar un mensaje de error
            echo json_encode(array("message" => "Ha ocurrido un error inesperado al intentar modificar ese registro."));
        }
    }

}

?>