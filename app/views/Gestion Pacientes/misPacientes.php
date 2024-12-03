<?php
include_once '../../api/src/Core/Database.php'; // Asegúrate de que la ruta sea correcta
$database = new Database();
$conn = $database->getConnection();

// Configuración de conexión a la base de datos
header('Content-Type: application/json');

// Obtener parámetros
session_start();
$doctor = isset($_GET['doctor']) ? $_GET['doctor'] : '';
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// Configurar registros por página y calcular el offset
$registros_por_pagina = 10;
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// Construir consulta con o sin búsqueda
// Construir consulta con o sin búsqueda
if (!empty($busqueda)) {
  $query = "SELECT p.nombre, p.apellido, p.cedula, ep.causaIngreso, ep.fecha_ingreso, ep.tratamiento, ep.medicamentos
            FROM expedientes_pacientes ep
            JOIN pacientes p ON ep.paciente = p.id_paciente
            WHERE ep.doctor = :doctor AND ep.estado = 'En Atencion' AND (p.nombre LIKE :busqueda OR p.apellido LIKE :busqueda OR p.cedula LIKE :busqueda OR ep.causaIngreso LIKE :busqueda)
            LIMIT :offset, :registros_por_pagina";

  $count_query = "SELECT COUNT(*) as total 
                  FROM expedientes_pacientes ep
                  JOIN pacientes p ON ep.paciente = p.id_paciente
                  WHERE ep.doctor = :doctor AND ep.estado = 'En Atencion' AND (p.nombre LIKE :busqueda OR p.apellido LIKE :busqueda OR p.cedula LIKE :busqueda OR ep.causaIngreso LIKE :busqueda)";
} else {
  $query = "SELECT p.nombre, p.apellido, p.cedula, ep.causaIngreso, ep.fecha_ingreso, ep.tratamiento, ep.medicamentos
            FROM expedientes_pacientes ep
            JOIN pacientes p ON ep.paciente = p.id_paciente
            WHERE ep.doctor = :doctor AND ep.estado = 'En Atencion'
            LIMIT :offset, :registros_por_pagina";

  $count_query = "SELECT COUNT(*) as total 
                  FROM expedientes_pacientes ep
                  JOIN pacientes p ON ep.paciente = p.id_paciente
                  WHERE ep.doctor = :doctor AND ep.estado = 'En Atencion'";
}
$stmt = $conn->prepare($query);
$stmt->bindParam(':doctor', $doctor, PDO::PARAM_INT);
if (!empty($busqueda)) {
    $busqueda_param = "%$busqueda%";
    $stmt->bindParam(':busqueda', $busqueda_param, PDO::PARAM_STR);
}
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':registros_por_pagina', $registros_por_pagina, PDO::PARAM_INT);
$stmt->execute();

// Preparar y ejecutar la consulta de conteo
$stmt_count = $conn->prepare($count_query);
$stmt_count->bindParam(':doctor', $doctor, PDO::PARAM_INT);
if (!empty($busqueda)) {
    $stmt_count->bindParam(':busqueda', $busqueda_param, PDO::PARAM_STR);
}
$stmt_count->execute();
$total_registros = $stmt_count->fetch(PDO::FETCH_ASSOC)['total'];
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Enviar respuesta en formato JSON
echo json_encode([
  'id_doctor' => $doctor,
  'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
  'pagina_actual' => $pagina_actual,
  'total_paginas' => $total_paginas
]);
?>