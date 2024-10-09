<?php
include_once 'Database.php';
include_once 'Paciente.php';

class PacienteController {
    private $db;
    private $paciente;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->paciente = new Paciente($this->db);
    }

    // Registrar un nuevo paciente
    public function registrarPaciente($nombre, $apellido, $fecha_nacimiento, $historial_medico) {
        $this->paciente->nombre = $nombre;
        $this->paciente->apellido = $apellido;
        $this->paciente->fecha_nacimiento = $fecha_nacimiento;
        $this->paciente->historial_medico = $historial_medico;

        if($this->paciente->registrar()) {
            echo 'Paciente registrado exitosamente.';
        } else {
            echo 'Error al registrar el paciente.';
        }
    }

    // Obtener información de un paciente
    public function obtenerPaciente($id) {
        $this->paciente->id = $id;
        $resultado = $this->paciente->obtener();
        $fila = $resultado->fetch(PDO::FETCH_ASSOC);

        return $fila ? json_encode($fila) : 'Paciente no encontrado.';
    }
}
?>
