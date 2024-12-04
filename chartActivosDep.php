<?php
include_once './app/api/src/core/Database.php';
header('Content-Type: application/json');

$database = new Database();
$conn = $database->getConnection();
$query = "SELECT d.nombre AS departamento, SUM(id.cantidad * i.costo) AS total_insumos 
      FROM inventario_departamento id
      JOIN insumos i ON id.id_insumo = i.id_insumo
      JOIN departamento d ON id.id_departamento = d.id_departamento
      GROUP BY id.id_departamento;";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retorna directamente los datos
echo json_encode($result); // Retorna los datos en formato JSON