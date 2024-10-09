<?php
class Paciente {
    private $conn;
    private $table = 'pacientes';

    public $id;
    public $nombre;
    public $apellido;
    public $fecha_nacimiento;
    public $historial_medico;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Registrar un nuevo paciente
    public function registrar() {
        $query = 'INSERT INTO ' . $this->table . ' SET nombre = :nombre, apellido = :apellido, fecha_nacimiento = :fecha_nacimiento, historial_medico = :historial_medico';
        
        $stmt = $this->conn->prepare($query);

        // Limpieza de datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->fecha_nacimiento = htmlspecialchars(strip_tags($this->fecha_nacimiento));
        $this->historial_medico = htmlspecialchars(strip_tags($this->historial_medico));

        // Enlazar parámetros
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':fecha_nacimiento', $this->fecha_nacimiento);
        $stmt->bindParam(':historial_medico', $this->historial_medico);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Obtener información de un paciente
    public function obtener() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        return $stmt;
    }
}
?>
