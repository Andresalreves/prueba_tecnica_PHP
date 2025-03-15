<?php
// app/Controllers/GrupoController.php

require_once __DIR__ . '/../Models/Grupo.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../helpers/helper_view.php';

class GrupoController {
    private $db;
    private $grupo;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->grupo = new Grupo($this->db);
    }

    public function index() {
        // Obtener todos los grupos
        $stmt = $this->grupo->leerTodos();
        $grupos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Pasar los grupos a la vista
        $data = [
            'grupos' => $grupos,
        ];
        // Cargar la vista
        View('grupos', $data);
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Crear un grupo
            $this->grupo->nombre = $_POST['nombre'];
            $this->grupo->descripcion = $_POST['descripcion'];

            if ($this->grupo->crear()) {
                echo json_encode(array("message" => "Grupo creado con éxito."));
            } else {
                echo json_encode(array("message" => "Error al crear el grupo."));
            }
        } else {
            // Mostrar el formulario de creación
            View('crear_grupo');
        }
    }

    public function ViewUpdate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener grupo por ID
            $this->grupo->id = $_POST['id']; // Asignar el ID al modelo
            $stmt = $this->grupo->leerUno(); // Llamar al método leerUno del modelo Grupo
            $grupo = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener los datos del grupo
    
            // Verificar si se encontró el grupo
            if ($grupo) {
                // Pasar el grupo a la vista
                $data = [
                    'grupo' => $grupo,
                ];
    
                // Cargar la vista de edición
                View('editar_grupo', $data);
            } else {
                // Si no se encuentra el grupo, mostrar un mensaje de error
                echo json_encode(array("message" => "Grupo no encontrado."));
            }
        } else {
            // Si no es una solicitud POST, mostrar un mensaje de error
            echo json_encode(array("message" => "Ha ocurrido un error inesperado al intentar modificar ese registro."));
        }
    }

    public function editar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->grupo->id = $_POST['id'];
            $this->grupo->nombre = $_POST['nombre'];
            $this->grupo->descripcion = $_POST['descripcion'];
    
            if ($this->grupo->actualizar()) {
                // mensaje de éxito
                echo json_encode(array("message" => "Grupo actualizado con éxito."));
            } else {
                // Retornar mensaje de error
                http_response_code(500); // Error interno del servidor
                echo json_encode(array("message" => "Error al actualizar el Grupo."));
            }
        } else {
            // Si no es una solicitud POST, retornar un error
            http_response_code(405);
            echo json_encode(array("message" => "Método no permitido."));
        }
    }

    public function Delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->grupo->id = $_POST['id'];
            if ($this->grupo->eliminar()) {
                // mensaje de éxito
                echo json_encode(array("message" => "Grupo Eliminado con éxito."));
            } else {
                // Retornar mensaje de error
                http_response_code(500); // Error interno del servidor
                echo json_encode(array("message" => "Error al Eliminar el grupo."));
            }
        } else {
            // Si no es una solicitud POST, retornar un error
            http_response_code(405);
            echo json_encode(array("message" => "Método no permitido."));
        }
    }
}
?>