<?php
class EmployeeModel {
    private $conn;
    private $table = 'empleados';
    public $nombre;
    public $apellido;
    public $puesto;
    public $departamento;
    public $fecha_contratacion;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crearEmpleado() {
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->puesto = htmlspecialchars(strip_tags($this->puesto));
        $this->departamento = htmlspecialchars(strip_tags($this->departamento));
        $this->fecha_contratacion = htmlspecialchars(strip_tags($this->fecha_contratacion));
        
        $query = 'INSERT INTO ' . $this->table . ' (nombre, apellido, puesto, departamento, fecha_contratacion) VALUES (:nombre, :apellido, :puesto, :departamento, :fecha_departamento)';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':puesto', $this->puesto);
        $stmt->bindParam(':departamento', $this->departamento);
        $stmt->bindParam(':fecha_contratacion', $this->fecha_contratacion);

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
