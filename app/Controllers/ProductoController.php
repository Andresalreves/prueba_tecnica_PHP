<?php

require_once __DIR__ . '/../Models/Grupo.php';
require_once __DIR__ . '/../Models/Producto.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../helpers/helper_view.php';

class ProductoController {
    private $db;
    private $producto;
    private $grupo;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->producto = new Producto($this->db);
        $this->grupo = new Grupo($this->db);
    }

    public function index() {
        // Obtener todos los productos
        $stmt = $this->producto->leerTodos();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt_gr = $this->grupo->leerTodos();
        $grupos = $stmt_gr->fetchAll(PDO::FETCH_ASSOC);

        // Pasar los productos a la vista
        $data = [
            'productos' => $productos,
            'grupos' => $grupos,
        ];

        // Cargar la vista
        View('productos', $data);
    }

    public function ViewUpdate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener producto por ID
            $this->producto->id = $_POST['id'];
            $stmt = $this->producto->leerUno();
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // Verificar si se encontró el producto
            if ($producto) {
                // Pasar el producto a la vista
                $data = [
                    'producto' => $producto,
                ];
        
                // Cargar la vista de edición
                View('editar_producto', $data);
            } else {
                // Si no se encuentra el producto, mostrar un mensaje de error
                echo json_encode(array("message" => "Producto no encontrado."));
            }
        }else{
            echo json_encode(array("message" => "Ha ocurrido un error inesperado al intentar modificar ese registro."));
        }
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // crear un producto
            $this->producto->nombre = $_POST['nombre'];
            $this->producto->descripcion = $_POST['descripcion'];
            $this->producto->precio = $_POST['precio'];
            $this->producto->stock = $_POST['stock'];
            $this->producto->estado = 1;
    
            if ($this->producto->crear()) {
                echo json_encode(array("message" => "Producto creado con éxito."));
            } else {
                echo json_encode(array("message" => "Error al crear el producto."));
            }
        } else {
            // formulario de creación
            echo json_encode(array("message" => "No existen datos para crear el producto."));
        }
    }

    public function editar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->producto->id = $_POST['id'];
            $this->producto->nombre = $_POST['nombre'];
            $this->producto->descripcion = $_POST['descripcion'];
            $this->producto->precio = $_POST['precio'];
            $this->producto->stock = $_POST['stock'];
            $this->producto->estado = $_POST['estado'];
    
            if ($this->producto->actualizar()) {
                // mensaje de éxito
                echo json_encode(array("message" => "Producto actualizado con éxito."));
            } else {
                // Retornar mensaje de error
                http_response_code(500); // Error interno del servidor
                echo json_encode(array("message" => "Error al actualizar el producto."));
            }
        } else {
            // Si no es una solicitud POST, retornar un error
            http_response_code(405);
            echo json_encode(array("message" => "Método no permitido."));
        }
    }

    public function Delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->producto->id = $_POST['id'];
            if ($this->producto->eliminar()) {
                // mensaje de éxito
                echo json_encode(array("message" => "Producto Eliminado con éxito."));
            } else {
                // Retornar mensaje de error
                http_response_code(500); // Error interno del servidor
                echo json_encode(array("message" => "Error al Eliminar el producto."));
            }
        } else {
            // Si no es una solicitud POST, retornar un error
            http_response_code(405);
            echo json_encode(array("message" => "Método no permitido."));
        }
    }
}
?>