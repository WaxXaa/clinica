<?php
class Empleado {
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

    public function crearEmpleado($nombre, $apellido, $departamento,$username, $password, $rol,  $turno, $salario) {
        try {
        $nombre = htmlspecialchars(strip_tags($nombre));
        $apellido = htmlspecialchars(strip_tags($apellido));
        $departamento = htmlspecialchars(strip_tags($departamento));
        $rol = htmlspecialchars(strip_tags($rol));
        $turno = htmlspecialchars(strip_tags($turno));
        $salario = htmlspecialchars(strip_tags($salario));
        $username = htmlspecialchars(strip_tags($username));
        $password = htmlspecialchars(strip_tags($password));
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "CALL registrarEmpleado (:nombre, :apellido, :departamento, :username, :password, :rol,  :turno, :salario);";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':departamento', $departamento);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':turno', $turno);
        $stmt->bindParam(':salario', $salario);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }} catch (PDOException $e) {
            return false;
        }
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

    // Método para obtener los turnos
    public function getTurnos() {
        $query = 'SELECT * FROM turnos';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $turnos = [];
        while ($turno =  $stmt->fetch(PDO::FETCH_ASSOC)) {
          array_push($turnos,$turno);
        }
        $this->db = null;
        return $turnos;
    }
}
?>
