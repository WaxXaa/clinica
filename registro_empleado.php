<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Empleado</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-semibold mb-4">Registrar Empleado</h2>
        <form action="procesar_empleado.php" method="post" class="space-y-4">
            <input type="text" name="nombre_empleado" placeholder="Nombre del Empleado" required class="w-full p-2 border rounded-md">
            <input type="text" name="puesto_empleado" placeholder="Puesto" required class="w-full p-2 border rounded-md">
            <input type="number" name="salario_empleado" placeholder="Salario" required class="w-full p-2 border rounded-md">
            <button type="submit" class="bg-yellow-500 text-white w-full py-2 rounded-md hover:bg-yellow-600">Registrar Empleado</button>
        </form>
    </div>
</body>
</html>
