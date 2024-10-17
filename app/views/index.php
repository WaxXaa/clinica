<?php
session_start();
require '../../config/db.php'; // Asegúrate de que la ruta sea correcta

// Verificar si el usuario está logueado
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

// Verificar el rol del usuario desde la sesión
$role = $_SESSION['role'];

// Conectar a la base de datos y obtener los usuarios
$conn = Database::connect();
$usuarios_query = "SELECT correo_electronico FROM usuarios";
$usuarios_result = $conn->query($usuarios_query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles.css"> <!-- Asegúrate de tener tu CSS -->
</head>
<body class="bg-gray-100 min-h-screen">

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-800 text-white min-h-screen p-6">
            <h2 class="text-xl font-semibold mb-4">Menú</h2>
            <nav class="space-y-4">
                <a href="registro_usuario.php" class="block px-4 py-2 bg-blue-700 rounded hover:bg-blue-600">Usuarios</a>
                <a href="roles_permisos.php" class="block px-4 py-2 hover:bg-blue-600">Roles y permisos</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Recursos Humanos</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Farmacia</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Inventario</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Pacientes</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Finanzas</a>
                <a href="examenes.php" class="block px-4 py-2 hover:bg-blue-600">Exámenes</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Seguridad y Privacidad</a>
                <a href="logout.php" class="block px-4 py-2 hover:bg-blue-600">Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <header class="flex justify-between bg-blue-600 text-white p-4">
                <h1 class="text-lg">Panel General</h1>
                <div class="flex space-x-4">
                    <button class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-400">Perfil</button>
                    <button class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-400">Home</button>
                    <button class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-400" onclick="location.href='logout.php'">Logout</button>
                </div>
            </header>

            <div class="p-6 grid grid-cols-3 gap-6">
                <div class="bg-green-500 p-4 rounded shadow-md text-white text-center">
                    Pacientes Atendidos
                </div>
                <div class="bg-green-500 p-4 rounded shadow-md text-white text-center">
                    Resumen de Finanzas
                </div>
                <div class="bg-green-500 p-4 rounded shadow-md text-white text-center">
                    Administrar Usuarios
                </div>
            </div>

            <h2 class="text-lg mt-6">Lista de Usuarios</h2>
            <ul class="space-y-2">
                <?php
                if ($usuarios_result->num_rows > 0) {
                    // Mostrar usuarios reales
                    while ($usuario = $usuarios_result->fetch_assoc()) {
                        echo "<li class='bg-gray-200 p-2 rounded'>{$usuario['correo_electronico']}</li>";
                    }
                } else {
                    echo "<li class='bg-red-200 p-2 rounded'>No hay usuarios registrados.</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</body>
</html>
