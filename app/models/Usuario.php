<?php
class UserModel {
    private $conn;
    private $table = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear un nuevo usuario
    public function createUser($nombre, $email, $password, $roleId) {
        $query = 'INSERT INTO ' . $this->table . ' (nombre, email, password, role_id) VALUES (:nombre, :email, :password, :role_id)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
        $stmt->bindParam(':role_id', $roleId);
        return $stmt->execute();
    }

    // Obtener usuario por ID
    public function getUserById($id) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener todos los usuarios
    public function getAllUsers() {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar información de usuario
    public function updateUser($id, $nombre, $email, $roleId) {
        $query = 'UPDATE ' . $this->table . ' SET nombre = :nombre, email = :email, role_id = :role_id WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role_id', $roleId);
        return $stmt->execute();
    }

    // Desactivar usuario
    public function deactivateUser($id) {
        $query = 'UPDATE ' . $this->table . ' SET activo = 0 WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Activar usuario
    public function activateUser($id) {
        $query = 'UPDATE ' . $this->table . ' SET activo = 1 WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
