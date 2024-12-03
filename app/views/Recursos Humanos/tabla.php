<?php
include_once '../../api/src/Core/Database.php';
$database = new Database();
$conn = $database->getConnection();
// Configuración de conexión a la base de datos
header('Content-Type: application/json');

// Obtener parámetros
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// Configurar registros por página y calcular el offset
$registros_por_pagina = 2;
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// Construir consulta con o sin búsqueda
if (!empty($busqueda)) {
    $query = "SELECT e.nombre, e.apellido, e.cedula, e.email,e.salario, t.nombre As turno, d.nombre AS departamento_nombre, r.nombre AS rol_nombre
              FROM empleado e
              JOIN departamento d ON e.departamento = d.id_departamento
              JOIN rol r ON e.rol = r.id_rol
              JOIN turnos t ON e.turno = t.id_turno
              WHERE e.nombre LIKE :busqueda OR e.apellido LIKE :busqueda OR e.cedula LIKE :busqueda 
              OR e.email LIKE :busqueda OR d.nombre LIKE :busqueda OR r.nombre LIKE :busqueda
              LIMIT :offset, :registros_por_pagina";

    $count_query = "SELECT COUNT(*) as total 
                    FROM empleado e
                    JOIN departamento d ON e.departamento = d.id_departamento
                    JOIN rol r ON e.rol = r.id_rol
                    JOIN turnos t ON e.turno = t.id_turno
                    WHERE e.nombre LIKE :busqueda OR e.apellido LIKE :busqueda OR e.cedula LIKE :busqueda 
                    OR e.email LIKE :busqueda OR d.nombre LIKE :busqueda OR r.nombre LIKE :busqueda";
} else {
    $query = "SELECT e.nombre, e.apellido, e.cedula, e.email,e.salario, t.nombre As turno, d.nombre AS departamento_nombre, r.nombre AS rol_nombre
              FROM empleado e
              JOIN departamento d ON e.departamento = d.id_departamento
              JOIN rol r ON e.rol = r.id_rol
              JOIN turnos t ON e.turno = t.id_turno
              LIMIT :offset, :registros_por_pagina";

    $count_query = "SELECT COUNT(*) as total FROM empleado";
}

// Preparar y ejecutar consulta principal
$stmt = $conn->prepare($query);
if (!empty($busqueda)) {
    $stmt->bindValue(':busqueda', "%$busqueda%", PDO::PARAM_STR);
}
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':registros_por_pagina', $registros_por_pagina, PDO::PARAM_INT);
$stmt->execute();
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Preparar y ejecutar consulta de conteo
$count_stmt = $conn->prepare($count_query);
if (!empty($busqueda)) {
    $count_stmt->bindValue(':busqueda', "%$busqueda%", PDO::PARAM_STR);
}
$count_stmt->execute();
$total_row = $count_stmt->fetch(PDO::FETCH_ASSOC);
$total_registros = $total_row['total'];

// Calcular total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Respuesta JSON
header('Content-Type: application/json');
echo json_encode([
    'data' => $resultados,
    'pagina_actual' => $pagina_actual,
    'total_paginas' => $total_paginas,
]);