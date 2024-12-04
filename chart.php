<?php
include_once './app/api/src/core/Database.php';
header('Content-Type: application/json');

$database = new Database();
$conn = $database->getConnection();
$query = "SELECT d.nombre AS departamento, COUNT(ep.paciente) AS cantidad FROM expedientes_pacientes ep JOIN departamento d ON ep.departamento = d.id_departamento GROUP BY ep.departamento;";
  
      $stmt = $conn->prepare($query);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
      // Retorna directamente los dato
      echo json_encode($result); // Retorna los datos en formato JSON