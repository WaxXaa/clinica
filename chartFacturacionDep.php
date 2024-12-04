<?php
include_once './app/api/src/core/Database.php';
header('Content-Type: application/json');

$database = new Database();
$conn = $database->getConnection();

$query = "
  SELECT d.nombre AS departamento, 
       SUM(e.precio) + (COUNT(ep.id_expediente) * 120) AS total_facturado
  FROM expedientes_examenes ee
  JOIN expedientes_pacientes ep ON ee.id_expediente = ep.id_expediente
  JOIN examenes e ON ee.id_examen_paciente = e.id_examen
  JOIN departamento d ON ep.departamento = d.id_departamento
  GROUP BY ep.departamento;
";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retorna directamente los datos
echo json_encode($result); // Retorna los datos en formato JSON
?>