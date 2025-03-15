<?php

class Pyg {
    private $conn;
    private $table = 'producto_grupo';

    public $id;
    public $producto_id;
    public $grupo_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function actualizarOCrearProductoGrupo() {
        // Sanitizar los datos de entrada
        $this->producto_id = htmlspecialchars(strip_tags($this->producto_id));
        $this->grupo_id = htmlspecialchars(strip_tags($this->grupo_id));

        // Verificar si el producto_id ya existe en la tabla producto_grupo
        $query = "SELECT * FROM " . $this->table . " WHERE producto_id = :producto_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':producto_id', $this->producto_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Si existe, actualizar el registro
            $query = "UPDATE " . $this->table . " SET grupo_id = :grupo_id WHERE producto_id = :producto_id";
        } else {
            // Si no existe, crear un nuevo registro
            $query = "INSERT INTO " . $this->table . " (producto_id, grupo_id) VALUES (:producto_id, :grupo_id)";
        }

        // Preparar y ejecutar la consulta
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':producto_id', $this->producto_id);
        $stmt->bindParam(':grupo_id', $this->grupo_id);

        // Ejecutar la consulta y manejar errores
        if ($stmt->execute()) {
            return true;
        } else {
            // Si hay un error, puedes logearlo o manejarlo de otra manera
            error_log("Error en actualizarOCrearProductoGrupo: " . implode(" ", $stmt->errorInfo()));
            return false;
        }
    }

    public function obtenerProductosPorGrupo() {
        // Sanitizar el grupo_id
        $grupo_id = htmlspecialchars(strip_tags($this->grupo_id));

        // Consulta SQL con JOIN para obtener los productos asociados al grupo_id
        $query = "
            SELECT p.*,g.nombre as nombre_grupo,g.descripcion as descripcion
            FROM producto_grupo pg
            LEFT JOIN productos p ON pg.producto_id = p.id
            LEFT JOIN grupos g ON g.id = pg.grupo_id
            WHERE pg.grupo_id = :grupo_id
        ";
        // Preparar la consulta
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':grupo_id', $grupo_id);

        // Ejecutar la consulta
        $stmt->execute();

        // Retornar los resultados
        return $stmt;
    }
}
?>