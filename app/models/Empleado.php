<?php
class EmployeeModel {
    private $conn;
    private $table = 'employees';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear un nuevo empleado
    public function createEmployee($nombre, $email, $roleId) {
        $query = 'INSERT INTO ' . $this->table . ' (nombre, email, role_id) VALUES (:nombre, :email, :role_id)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role_id', $roleId);
        return $stmt->execute();
    }

    // Obtener un empleado por su ID
    public function getEmployeeById($employeeId) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $employeeId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener todos los empleados
    public function getAllEmployees() {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para asignar un rol a un empleado
    public function assignRoleToEmployee($employeeId, $roleId) {
        $query = 'UPDATE ' . $this->table . ' SET role_id = :role_id WHERE id = :employee_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':employee_id', $employeeId);
        $stmt->bindParam(':role_id', $roleId);
        return $stmt->execute();
    }
}
?>
