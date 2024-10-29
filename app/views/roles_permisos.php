<?php
session_start();
require '../../config/db.php'; 


if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

$role = $_SESSION['role'];


if ($role !== 'RS01') {
    echo "No tienes permiso para acceder a esta página.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles y Permisos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex">
        <aside class="w-64 bg-blue-800 text-white min-h-screen p-6">
            <h2 class="text-xl font-semibold mb-4">Menú de Roles y Permisos</h2>
            <nav class="space-y-4">
                <a href="asignar_permisos.php" class="block px-4 py-2 bg-blue-700 rounded hover:bg-blue-600">Asignar Permisos</a>
                <a href="registro_permiso.php" class="block px-4 py-2 hover:bg-blue-600">Registro de Permisos</a>
                <a href="registro_rol.php" class="block px-4 py-2 hover:bg-blue-600">Registro de Roles</a>
                <a href="index.php" class="block px-4 py-2 hover:bg-blue-600">Volver al Panel</a>
            </nav>
        </aside>

        <div class="flex-1 p-6">
            <header class="flex justify-between bg-blue-600 text-white p-4">
                <h1 class="text-lg">Gestión de Roles y Permisos</h1>
                <button class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-400" onclick="location.href='logout.php'">Logout</button>
            </header>

            <div class="mt-6">
                <p class="text-gray-700">Selecciona una acción del menú para gestionar roles y permisos.</p>
            </div>
        </div>
    </div>
</body>
</html>
