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

// Obtener los usuarios (pacientes) y roles disponibles
$pacientes_result = $conn->query("SELECT Cedula, Nombre FROM Usuarios");
$roles_result = $conn->query("SELECT Id_Rol, Nombre FROM Rol");

// Obtener lista de servicios para mostrar
$lista_servicios = $conn->query("
    SELECT s.Num_Servicio, u.Nombre AS paciente, r.Nombre AS rol, s.FEntrada, s.FSalida
    FROM Servicio s
    JOIN Usuarios u ON s.Num_Identificacion = u.Cedula
    JOIN Rol r ON s.Id_Rol = r.Id_Rol
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordenar Servicios</title>
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
                <h1 class="text-lg">Ordenar Servicios</h1>
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
                    <!-- Tipo de Rol -->
                    <div>
                        <label class="block text-gray-700">Tipo de Rol</label>
                        <select name="rol_id" required class="w-full p-2 border rounded-md">
                            <option value="">Seleccionar Rol</option>
                            <?php while ($rol = $roles_result->fetch_assoc()): ?>
                                <option value="<?= $rol['Id_Rol'] ?>"><?= $rol['Nombre'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Fecha de Entrada -->
                    <div>
                        <label class="block text-gray-700">Fecha de Entrada</label>
                        <input type="date" name="fentrada" required class="w-full p-2 border rounded-md">
                    </div>

                    <!-- Fecha de Salida -->
                    <div>
                        <label class="block text-gray-700">Fecha de Salida</label>
                        <input type="date" name="fsalida" required class="w-full p-2 border rounded-md">
                    </div>

                    <!-- Paciente -->
                    <div>
                        <label class="block text-gray-700">Paciente</label>
                        <select name="paciente_id" required class="w-full p-2 border rounded-md">
                            <option value="">Seleccionar Paciente</option>
                            <?php while ($paciente = $pacientes_result->fetch_assoc()): ?>
                                <option value="<?= $paciente['Cedula'] ?>"><?= $paciente['Nombre'] ?></option>
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

                <!-- Lista de Servicios a la Derecha -->
                <div class="w-1/2 pl-8">
                    <h2 class="text-lg font-semibold mb-4">Lista de Servicios para el Paciente</h2>
                    <ul class="space-y-2">
                        <?php if ($lista_servicios->num_rows > 0): ?>
                            <?php while ($servicio = $lista_servicios->fetch_assoc()): ?>
                                <li class="bg-gray-200 p-2 rounded">
                                    <strong>Paciente:</strong> <?= $servicio['paciente'] ?> | 
                                    <strong>Rol:</strong> <?= $servicio['rol'] ?> | 
                                    <strong>Fecha Entrada:</strong> <?= $servicio['FEntrada'] ?> | 
                                    <strong>Fecha Salida:</strong> <?= $servicio['FSalida'] ?>
                                </li>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <li class="bg-red-200 p-2 rounded">No hay servicios registrados.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<!-- test endddd -->