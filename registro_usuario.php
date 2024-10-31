<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-800 text-white min-h-screen p-6">
            <h2 class="text-xl font-semibold mb-4">Admin Menu</h2>
            <nav class="space-y-4">
                <a href="#" class="block px-4 py-2 bg-blue-700 rounded hover:bg-blue-600">Usuarios</a>
                <a href="./app/views/roles_permisos.php" class="block px-4 py-2 hover:bg-blue-600">Roles y permisos</a>
                <a href="#" class="block px-4 py-2 hover:bg-blue-600">Recursos Humanos</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Top Navigation -->
            <header class="flex justify-between bg-blue-600 text-white p-4">
                <h1 class="text-lg">Usuarios</h1>
                <div class="flex space-x-4">
                    <button class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-400">Perfil</button>
                    <button class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-400">Home</button>
                    <button class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-400">Logout</button>
                </div>
            </header>

            <!-- User Form -->
            <div class="p-6">
                <h2 class="text-xl mb-4">Crear o Actualizar Usuario</h2>
                <form action="procesar_usuario.php" method="post" class="space-y-4">
                    <input type="text" name="nombre" placeholder="Nombre" required class="w-full p-2 border rounded-md">
                    <input type="email" name="correo" placeholder="Correo Electrónico" required class="w-full p-2 border rounded-md">
                    <select name="rol" class="w-full p-2 border rounded-md">
                        <option value="admin">Administrador</option>
                        <option value="medico">Médico</option>
                    </select>
                    <button type="submit" class="bg-green-500 text-white w-full py-2 rounded-md hover:bg-green-600">Guardar Usuario</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
