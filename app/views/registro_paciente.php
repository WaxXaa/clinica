<?php
session_start();
require '../../config/db.php'; 

// Verify user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

// Conexion dbb
$conn = Database::connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $genero = $_POST['genero'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    $stmt_check = $conn->prepare("SELECT id FROM pacientes WHERE correo = ?");
    $stmt_check->bind_param("s", $correo);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $error = "El correo ya está registrado.";
    } else {
       
        $stmt = $conn->prepare("INSERT INTO pacientes (nombre, apellido, fecha_nacimiento, genero, direccion, telefono, correo) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $nombre, $apellido, $fecha_nacimiento, $genero, $direccion, $telefono, $correo);

        if ($stmt->execute()) {
            $success = "Paciente registrado correctamente.";
        } else {
            $error = "Error al registrar paciente. Por favor, inténtelo de nuevo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Paciente</title>
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
                <h1 class="text-lg">Registrar Paciente</h1>

            <div class="mt-6">
                <!-- Display messages -->
                <?php if (isset($success)): ?>
                    <p class="text-green-500 mb-4"><?= $success ?></p>
                <?php endif; ?>
                <?php if (isset($error)): ?>
                    <p class="text-red-500 mb-4"><?= $error ?></p>
                <?php endif; ?>

                <!-- Registration form -->
                <form method="POST" class="bg-white p-6 rounded shadow-md space-y-4">
                    <div>
                        <label class="block text-gray-700">Nombre:</label>
                        <input type="text" name="nombre" required class="w-full p-2 border rounded-md">
                    </div>
                    <div>
                        <label class="block text-gray-700">Apellido:</label>
                        <input type="text" name="apellido" required class="w-full p-2 border rounded-md">
                    </div>
                    <div>
                        <label class="block text-gray-700">Fecha de Nacimiento:</label>
                        <input type="date" name="fecha_nacimiento" required class="w-full p-2 border rounded-md">
                    </div>
                    <div>
                        <label class="block text-gray-700">Género:</label>
                        <select name="genero" required class="w-full p-2 border rounded-md">
                            <option value="">Seleccionar Género</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700">Dirección:</label>
                        <textarea name="direccion" required class="w-full p-2 border rounded-md"></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700">Teléfono:</label>
                        <input type="text" name="telefono" required class="w-full p-2 border rounded-md">
                    </div>
                    <div>
                        <label class="block text-gray-700">Correo Electrónico:</label>
                        <input type="email" name="correo" required class="w-full p-2 border rounded-md">
                    </div>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
