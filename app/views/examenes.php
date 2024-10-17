<?php
session_start();
require '../../config/db.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

// Conectar a la base de datos
$conn = Database::connect();

// Obtener los pacientes y tipos de exámenes disponibles
$pacientes_result = $conn->query("SELECT id, nombre FROM pacientes");
$examenes_result = $conn->query("SELECT id, tipo FROM tipos_examenes");

// Obtener lista de exámenes para mostrar
$lista_examenes = $conn->query("
    SELECT e.id, p.nombre AS paciente, t.tipo AS examen, e.urgencia 
    FROM examenes_ordenados e 
    JOIN pacientes p ON e.paciente_id = p.id 
    JOIN tipos_examenes t ON e.examen_id = t.id
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordenar Exámenes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-800 text-white p-6">
            <h2 class="text-xl font-semibold mb-4">Menú</h2>
            <nav class="space-y-4">
                <a href="index.php" class="block px-4 py-2 hover:bg-blue-600 rounded">Volver al Panel</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <header class="flex justify-between bg-blue-600 text-white p-4">
                <h1 class="text-lg">Ordenar Exámenes</h1>
                <div class="flex space-x-4">
                    <button class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-400">Perfil</button>
                    <button class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-400">Home</button>
                    <button class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-400" onclick="location.href='logout.php'">Logout</button>
                </div>
            </header>

            <!-- Contenedor Principal -->
            <div class="flex mt-6">
                <!-- Formulario a la Izquierda -->
                <div class="w-1/2 space-y-4">
                    <!-- Tipo de Examen -->
                    <div>
                        <label class="block text-gray-700">Tipo de Examen</label>
                        <select name="examen_id" required class="w-full p-2 border rounded-md">
                            <option value="">Seleccionar Tipo de Examen</option>
                            <?php while ($examen = $examenes_result->fetch_assoc()): ?>
                                <option value="<?= $examen['id'] ?>"><?= $examen['tipo'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Nivel de Urgencia -->
                    <div>
                        <label class="block text-gray-700">Nivel de Urgencia</label>
                        <input type="text" name="urgencia" placeholder="Nivel de Urgencia" 
                               required class="w-full p-2 border rounded-md">
                    </div>

                    <!-- Paciente -->
                    <div>
                        <label class="block text-gray-700">Paciente</label>
                        <select name="paciente_id" required class="w-full p-2 border rounded-md">
                            <option value="">Seleccionar Paciente</option>
                            <?php while ($paciente = $pacientes_result->fetch_assoc()): ?>
                                <option value="<?= $paciente['id'] ?>"><?= $paciente['nombre'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Botón Agregar -->
                    <div>
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md w-full">
                            Agregar
                        </button>
                    </div>
                </div>

                <!-- Lista de Exámenes a la Derecha -->
                <div class="w-1/2 pl-8">
                    <h2 class="text-lg font-semibold mb-4">Lista de Exámenes para el Paciente</h2>
                    <ul class="space-y-2">
                        <?php if ($lista_examenes->num_rows > 0): ?>
                            <?php while ($examen = $lista_examenes->fetch_assoc()): ?>
                                <li class="bg-gray-200 p-2 rounded">
                                    <strong>Paciente:</strong> <?= $examen['paciente'] ?> | 
                                    <strong>Examen:</strong> <?= $examen['examen'] ?> | 
                                    <strong>Urgencia:</strong> <?= $examen['urgencia'] ?>
                                </li>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <li class="bg-red-200 p-2 rounded">No hay exámenes registrados.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
