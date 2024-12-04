<?php
include_once '../../api/src/Core/Database.php'; // Asegúrate de que la ruta sea correcta
$database = new Database();
$conn = $database->getConnection();

// Configuración de conexión a la base de datos
header('Content-Type: application/json');

// Obtener parámetros
session_start();
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// Configurar registros por página y calcular el offset
$registros_por_pagina = 10;
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// Construir consulta con o sin búsqueda
// Construir consulta con o sin búsqueda
if (!empty($busqueda)) {
  $query = "SELECT ee.id_examen_paciente as numExamen,
p.nombre as nombre,
p.apellido as apellido,
p.cedula as cedula,
ex.nombre as examen,
ee.estado as estado
FROM expedientes_examenes as ee
JOIN expedientes_pacientes as ep on ee.id_expediente = ep.id_expediente 
JOIN pacientes as p on ep.paciente = p.id_paciente 
JOIN examenes as ex on ee.examen = ex.id_examen 
WHERE (ee.estado = 'Espera' OR ee.estado = 'Sin Resultado') AND (ee.id_examen_paciente LIKE :busqueda OR p.nombre LIKE :busqueda OR p.apellido LIKE :busqueda OR p.cedula LIKE :busqueda OR ex.nombre LIKE :busqueda OR ee.estado LIKE :busqueda) LIMIT :offset, :registros_por_pagina";

  $count_query = "SELECT COUNT(*) as total
FROM expedientes_examenes as ee
JOIN expedientes_pacientes as ep on ee.id_expediente = ep.id_expediente 
JOIN pacientes as p on ep.paciente = p.id_paciente 
JOIN examenes as ex on ee.examen = ex.id_examen 
WHERE (ee.estado = 'Espera' OR ee.estado = 'Sin Resultado') AND (ee.id_examen_paciente LIKE :busqueda OR p.nombre LIKE :busqueda OR p.apellido LIKE :busqueda OR p.cedula LIKE :busqueda OR ex.nombre LIKE :busqueda OR ee.estado LIKE :busqueda);";

} else {
  $query = "SELECT ee.id_examen_paciente as numExamen,
  p.nombre as nombre,
  p.apellido as apellido,
  p.cedula as cedula,
  ex.nombre as examen,
  ee.estado as estado
  FROM expedientes_examenes as ee
  JOIN expedientes_pacientes as ep on ee.id_expediente = ep.id_expediente 
  JOIN pacientes as p on ep.paciente = p.id_paciente 
  JOIN examenes as ex on ee.examen = ex.id_examen 
  WHERE (ee.estado = 'Espera' OR ee.estado = 'Sin Resultado') LIMIT :offset, :registros_por_pagina";
  

  $count_query = "SELECT COUNT(*) as total
FROM expedientes_examenes as ee
JOIN expedientes_pacientes as ep on ee.id_expediente = ep.id_expediente 
JOIN pacientes as p on ep.paciente = p.id_paciente 
JOIN examenes as ex on ee.examen = ex.id_examen 
WHERE ee.estado = 'Espera' OR ee.estado = 'Sin Resultado';";

}
$stmt = $conn->prepare($query);
if (!empty($busqueda)) {
    $busqueda_param = "%$busqueda%";
    $stmt->bindParam(':busqueda', $busqueda_param, PDO::PARAM_STR);
}
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':registros_por_pagina', $registros_por_pagina, PDO::PARAM_INT);
$stmt->execute();

// Preparar y ejecutar la consulta de conteo
$stmt_count = $conn->prepare($count_query);
if (!empty($busqueda)) {
    $stmt_count->bindParam(':busqueda', $busqueda_param, PDO::PARAM_STR);
}
$stmt_count->execute();
$total_registros = $stmt_count->fetch(PDO::FETCH_ASSOC)['total'];
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Enviar respuesta en formato JSON
echo json_encode([
  'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
  'pagina_actual' => $pagina_actual,
  'total_paginas' => $total_paginas
]);
?>