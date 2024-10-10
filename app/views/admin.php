<?php
session_start();

// Verificar si no existe una sesión activa con 'id_usuario'
if (!isset($_SESSION['id'])) {
    header('Location: ./login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Registros</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1rem;
        }
        .menu {
            width: 50%;
            margin: 3rem auto;
            text-align: center;
        }
        .menu a {
            display: block;
            padding: 1rem;
            margin: 1rem 0;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .menu a:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <header>
        <h1>Bienvenido al Sistema de Gestión</h1>
    </header>

    <div class="menu">
        <h2>Seleccione una opción de registro:</h2>
        <a href="registro_usuario.php">Registrar Usuario</a>
        <a href="registro_rol.php">Registrar Rol</a>
        <a href="registro_permiso.php">Registrar Permiso</a>
        <a href="asignar_permisos.php">Asignar Permisos a Roles</a>
        <a href="registro_empleado.php">Registrar Empleado</a>
    </div>
</body>
</html>
