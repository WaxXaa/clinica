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

    $stmt = $conn->prepare("INSERT INTO roles (nombre, descripcion) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $descripcion);
    if ($stmt->execute()) {
        echo "<p class='text-green-500'>Rol registrado correctamente.</p>";
    } else {
        echo "<p class='text-red-500'>Error al registrar rol.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Roles</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to bottom, #EAE6E5, #8F8073);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Slight transparency */
            border-radius: 12px;
            padding: 30px;
            width: 500px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #12130F;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 1.75rem;
            font-weight: bold;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .form-input {
            background-color: #EAE6E5;
            border: 1px solid #8F8073;
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 6px;
        }

        .btn-submit {
            background-color: #5B9279;
            transition: background-color 0.3s;
            width: 100%;
            padding: 10px;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #8FCB9B;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Registrar Nuevo Rol</div>

        <form method="POST" class="space-y-4">
            <input 
                type="text" 
                name="nombre" 
                placeholder="Nombre del Rol" 
                required 
                class="form-input"
            >
            <textarea 
                name="descripcion" 
                placeholder="Descripción" 
                class="form-input"
                rows="4"
            ></textarea>
            <button 
                type="submit" 
                class="btn-submit"
            >
                Registrar Rol
            </button>
        </form>
    </div>
</body>
</html>
