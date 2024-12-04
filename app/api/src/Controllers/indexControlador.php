<?php
class IndexController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function getExamenesPendientesConDetalles() {
      $query = "SELECT ee.id_examen_paciente AS numExamen,
                       CONCAT(p.nombre, ' ', p.apellido) AS nombre,
                       ex.nombre AS examen,
                       ee.estado AS estado
                FROM expedientes_examenes ee
                JOIN expedientes_pacientes ep ON ee.id_expediente = ep.id_expediente 
                JOIN pacientes p ON ep.paciente = p.id_paciente 
                JOIN examenes ex ON ee.examen = ex.id_examen 
                WHERE ee.estado IN ('Espera', 'Sin Resultado')";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
    public function getExamenes() {
        $query = "SELECT id_examen, nombre, descripcion, precio FROM examenes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPacientes() {
        $query = "SELECT id_paciente, nombre, apellido, cedula FROM pacientes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPeticiones() {
        // Adjust to query `expedientes_examenes` or similar, where `estado` exists
        $query = "SELECT ee.id_examen_paciente, ex.nombre AS examen, ee.estado 
                  FROM expedientes_examenes ee
                  JOIN examenes ex ON ee.examen = ex.id_examen
                  WHERE ee.estado IN ('Espera', 'Sin Resultado')";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPacientesPorDepartamento() {
      $query = "SELECT d.nombre AS departamento, COUNT(ep.paciente) AS cantidad
                FROM expedientes_pacientes ep
                JOIN departamento d ON ep.departamento = d.id_departamento
                GROUP BY ep.departamento";
  
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
      return $result; // Retorna directamente los datos
  }
    
}