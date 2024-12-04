
<?php
include_once './app/api/src/core/Database.php';
header('Content-Type: application/json');

$database = new Database();
$conn = $database->getConnection();
$query = "SELECT d.nombre AS departamento, ROUND(AVG(e.salario), 2) AS promedio_salario FROM empleado e JOIN departamento d ON e.departamento = d.id_departamento GROUP BY e.departamento;";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retorna directamente los datos
echo json_encode($result); // Retorna los datos en formato JSON
?>