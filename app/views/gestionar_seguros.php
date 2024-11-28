<?php
session_start();
require '../../config/db.php'; 

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

// Conexion db
$conn = Database::connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addSeguro'])) {
    $nombre = $_POST['nombre_seguro'];
    $descripcion = $_POST['descripcion_seguro'];
    $stmt = $conn->prepare("INSERT INTO seguros (nombre, descripcion) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $descripcion);
    if ($stmt->execute()) {
        $successMessage = "Seguro agregado correctamente.";
    } else {
        $errorMessage = "Error al agregar el seguro: " . $stmt->error;
    }
    $stmt->close();
}

// Obtener la lista de seguros
$seguros = $conn->query("SELECT * FROM seguros");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Seguros</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-800 text-white min-h-screen p-6">
            <h2 class="text-xl font-semibold mb-4">Menú</h2>
            <nav class="space-y-4">
                <a href="admin.php" class="block px-4 py-2 bg-blue-700 rounded hover:bg-blue-600">Volver al Panel</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <header class="flex justify-between bg-blue-600 text-white p-4">
                <h1 class="text-lg">Gestionar Seguros</h1>
                <div class="flex space-x-4">
                    <button class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-400" onclick="location.href='perfil.php'">Perfil</button>
                    <button class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-400" onclick="location.href='logout.php'">Logout</button>
                </div>
            </header>

            <div class="p-6">
                <!-- Mensajes -->
                <?php if (isset($successMessage)) { ?>
                    <div class="bg-green-500 text-white p-4 rounded mb-4">
                        <?= $successMessage ?>
                    </div>
                <?php } elseif (isset($errorMessage)) { ?>
                    <div class="bg-red-500 text-white p-4 rounded mb-4">
                        <?= $errorMessage ?>
                    </div>
                <?php } ?>

                <!-- Formulario para agregar seguros -->
                <form method="POST" class="bg-white p-6 rounded shadow-md">
                    <h2 class="text-lg font-semibold mb-4">Agregar Nuevo Seguro</h2>
                    <div class="mb-4">
                        <label for="nombre_seguro" class="block text-gray-700">Nombre del Seguro</label>
                        <input type="text" id="nombre_seguro" name="nombre_seguro" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="descripcion_seguro" class="block text-gray-700">Descripción</label>
                        <textarea id="descripcion_seguro" name="descripcion_seguro" class="w-full p-2 border rounded" rows="3" required></textarea>
                    </div>
                    <button type="submit" name="addSeguro" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-400">Agregar Seguro</button>
                </form>

                <!-- Lista de seguros -->
                <h2 class="text-lg font-semibold mt-8 mb-4">Lista de Seguros</h2>
                <table class="w-full bg-white rounded shadow-md">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="p-2">ID</th>
                            <th class="p-2">Nombre</th>
                            <th class="p-2">Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($seguro = $seguros->fetch_assoc()) { ?>
                            <tr class="border-t">
                                <td class="p-2"><?= $seguro['id_seguro'] ?></td>
                                <td class="p-2"><?= $seguro['nombre'] ?></td>
                                <td class="p-2"><?= $seguro['descripcion'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
