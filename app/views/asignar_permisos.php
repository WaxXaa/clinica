<?php
session_start();
require '../../config/db.php'; 

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

$conn = Database::connect();

$roles_result = $conn->query("SELECT * FROM roles");
$permisos_result = $conn->query("SELECT * FROM permisos");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rol_id = $_POST['rol_id'];
    $permiso_id = $_POST['permiso_id'];

    // Asignar permiso al rol
    $stmt = $conn->prepare("INSERT INTO rol_permiso (rol_id, permiso_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $rol_id, $permiso_id);
    if ($stmt->execute()) {
        echo "<p>Permiso asignado correctamente.</p>";
    } else {
        echo "<p>Error al asignar permiso.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Permisos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-xl font-semibold mb-4">Asignar Permisos a Roles</h1>
    <form method="POST" class="space-y-4">
        <select name="rol_id" required class="p-2 border rounded-md">
            <option value="">Seleccione un Rol</option>
            <?php while ($rol = $roles_result->fetch_assoc()): ?>
                <option value="<?= $rol['id_roles'] ?>"><?= $rol['nombre'] ?></option>
            <?php endwhile; ?>
        </select>

        <select name="permiso_id" required class="p-2 border rounded-md">
            <option value="">Seleccione un Permiso</option>
            <?php while ($permiso = $permisos_result->fetch_assoc()): ?>
                <option value="<?= $permiso['id'] ?>"><?= $permiso['nombre'] ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Asignar Permiso</button>
    </form>
</body>
</html>
