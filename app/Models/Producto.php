<?php
class Producto {
    private $conn;
    private $table = 'productos';

    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $stock;
    public $fecha_creacion;
    public $estado;

    public function __construct($db) {
        $this->conn = $db;
    }

    //Obtener productos
    public function leerTodos() {
        $query = "SELECT p.*, pg.* FROM productos p LEFT JOIN producto_grupo pg ON p.id = pg.producto_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Método para crear un producto
    public function crear() {
        $query = "INSERT INTO " . $this->table . " SET nombre=:nombre, descripcion=:descripcion, precio=:precio, stock=:stock, estado=:estado";
        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->stock = htmlspecialchars(strip_tags($this->stock));
        $this->estado = htmlspecialchars(strip_tags($this->estado));

        // Vincular valores
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':precio', $this->precio);
        $stmt->bindParam(':stock', $this->stock);
        $stmt->bindParam(':estado', $this->estado);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function leerUno() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id); // Vincular el ID
        $stmt->execute();
        return $stmt;
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table . " SET nombre=:nombre, descripcion=:descripcion, precio=:precio, stock=:stock, estado=:estado WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->stock = htmlspecialchars(strip_tags($this->stock));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincular valores
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':precio', $this->precio);
        $stmt->bindParam(':stock', $this->stock);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function eliminar() {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>