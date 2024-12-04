<?php

class Empleado {
    private $conn;
    private $table = 'empleado';
    public $nombre;
    public $apellido;
    public $puesto;
    public $departamento;
    public $fecha_contratacion;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crearEmpleado($nombre, $apellido,$cedula, $departamento,$username, $password, $rol,  $turno,$email, $salario) {
        try {
        $nombre = htmlspecialchars(strip_tags($nombre));
        $apellido = htmlspecialchars(strip_tags($apellido));
        $cedula = htmlspecialchars(strip_tags($cedula));
        $departamento = htmlspecialchars(strip_tags($departamento));
        $rol = htmlspecialchars(strip_tags($rol));
        $turno = htmlspecialchars(strip_tags($turno));
        $email = htmlspecialchars(strip_tags($email));
        $salario = htmlspecialchars(strip_tags($salario));
        $username = htmlspecialchars(strip_tags($username));
        $password = htmlspecialchars(strip_tags($password));
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "CALL registrarEmpleado (:nombre, :apellido, :cedula, :departamento, :username, :password, :rol, :turno, :email, :salario);";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':departamento', $departamento);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':turno', $turno);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':salario', $salario);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }} catch (PDOException $e) {
            return false;
        }
    }

    public function editarSalario($cedula, $salario) {
        try {
            $salario = htmlspecialchars(strip_tags($salario));
            $cedula = htmlspecialchars(strip_tags($cedula));
            $query = 'UPDATE ' . $this->table . ' SET salario = :salario WHERE cedula = :cedula';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':cedula', $cedula);
            $stmt->bindParam(':salario', $salario);
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function editarTurno($cedula, $turno) {
        try {
            $turno = htmlspecialchars(strip_tags($turno));
            $cedula = htmlspecialchars(strip_tags($cedula));
            $query = 'UPDATE ' . $this->table . ' SET turno = :turno WHERE cedula = :cedula';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':cedula', $cedula);
            $stmt->bindParam(':turno', $turno);
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
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
    // Método para obtener el nombre de un empleado por su correo
    public function getNombreEmpleado($correo) {
        $query = 'SELECT nombre FROM ' . $this->table . ' WHERE email = :correo';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['nombre'] : null;
    }
}
?>
