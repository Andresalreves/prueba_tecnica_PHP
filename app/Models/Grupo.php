<?php
// app/Models/Grupo.php

class Grupo {
    private $conn;
    private $table = 'grupos';

    public $id;
    public $nombre;
    public $descripcion;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para obtener todos los grupos
    public function leerTodos() {
        $query = "SELECT id, nombre, descripcion FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Método para crear un grupo
    public function crear() {
        $query = "INSERT INTO " . $this->table . " SET nombre=:nombre, descripcion=:descripcion";
        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));

        // Vincular valores
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':descripcion', $this->descripcion);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function leerUno() {
        $query = "SELECT id, nombre, descripcion FROM " . $this->table . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id); // Vincular el ID
        $stmt->execute();
        return $stmt;
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table . " SET nombre=:nombre, descripcion=:descripcion  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincular valores
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':descripcion', $this->descripcion);
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