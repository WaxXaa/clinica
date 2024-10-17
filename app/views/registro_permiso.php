<?php
session_start();
require '../../config/db.php'; // Conexión a la DB

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

$conn = Database::connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    $stmt = $conn->prepare("INSERT INTO permisos (nombre, descripcion) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $descripcion);
    if ($stmt->execute()) {
        echo "<p>Permiso registrado correctamente.</p>";
    } else {
        echo "<p>Error al registrar permiso.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Permisos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-xl font-semibold mb-4">Registrar Nuevo Permiso</h1>
    <form method="POST" class="space-y-4">
        <input type="text" name="nombre" placeholder="Nombre del Permiso" required class="p-2 border rounded-md w-full">
        <textarea name="descripcion" placeholder="Descripción" class="p-2 border rounded-md w-full"></textarea>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Registrar Perm
