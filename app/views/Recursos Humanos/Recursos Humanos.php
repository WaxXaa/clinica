<?php
session_start();
 // Asegúrate de que la ruta sea correcta
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
include_once '../../api/src/Core/Database.php';
$database = new Database();
$conn = $database->getConnection();

$usuarios_query = "SELECT e.nombre as nombre, d.nombre AS departamento, r.nombre AS rol, r.id_rol AS id_rol FROM empleado AS e JOIN departamento AS d on e.departamento = d.id_departamento JOIN rol AS r on e.rol = r.id_rol WHERE usuario = :user_id";
$stmt = $conn->prepare($usuarios_query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT); // Aseguramos que sea un número entero
$stmt->execute();
$usuarios_result = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener todos los resultados
$user_rol = $usuarios_result['id_rol'];
include_once '../../api/src/controllers/recursosHumanosControlador.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar with Header</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.5/lottie.min.js"></script>
    <style>
        .lottie-animation {
            width: 30px;
            height: 30px;
        }
    </style>
</head>
<body class="flex justify-start items-start h-screen bg-slate-200 text-white" x-data="{ sidebarOpen: true, isDark: false, openProfile: false, openStatus: false }" x-init="initializeSidebarToggleButton()">
    <!-- Header -->
    <?php include_once '../../views/header.php'; ?>
    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'w-1/6' : 'w-28'" class="relative bg-slate-200 h-screen p-5 pt-20 transition-all duration-700 flex flex-col space-y-4">
        <!-- modulo de inicio-->
        <div id="homeLink" class="section-button flex items-center space-x-2 py-2 px-3 rounded-md transition-all duration-300 group hover:bg-gradient-to-r from-lime-400 via-emerald-400 to-teal-400"
            :class="!sidebarOpen ? 'justify-center' : ''">
            <a href="../../../index.php">
                <span class="font-bold text-black group-hover:text-white transition-colors duration-300" 
                    x-show="sidebarOpen" x-transition>
                    Inicio
                </span>
            </a>
        </div>
        <!-- Aquí se cargan los módulos -->
        <?php 
            $stmt = $conn->prepare("
                SELECT m.nombre, m.descripcion
                FROM modulos m
                JOIN modulo_rol mr ON m.id_modulo = mr.id_modulo
                WHERE mr.id_rol = :role
            ");
            $stmt->bindParam(':role', $user_rol);
            $stmt->execute();
            $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);   
        ?>
        <?php foreach ($modules as $module): ?>
            <div id="<?php echo $module['nombre']; ?>" class="section-button flex items-center space-x-2 py-2 px-3 rounded-md transition-all duration-300 group hover:bg-gradient-to-r from-lime-400 via-emerald-400 to-teal-400"
                :class="!sidebarOpen ? 'justify-center' : ''">
                <a href="<?php echo '../' . $module['nombre'] . '/'. $module['nombre'] . '.php'?>">
                    <span class="font-bold text-black group-hover:text-white transition-colors duration-300" 
                        x-show="sidebarOpen" x-transition>
                        <?php echo htmlspecialchars($module['nombre']); ?>
                    </span>
                </a>
            </div>
        <?php endforeach; ?>
    </aside>

    <!-- Contenido Principal -->
    <div class="flex-1 p-5 space-y-5 mt-10 text-black">
        <!-- Contenedor Principal -->
        <div id="main-container-modulos" class="bg-white rounded-lg p-5 shadow-md grid grid-cols-2 gap-4">
        <?php
        
        $controller = new HumanResourcesController();
        $roles_con_PHR1 = $controller->getRolesByPermission('PHR1');

        // Verificar si el rol del usuario actual está en la lista de roles con PHR1
        if (in_array($user_rol, $roles_con_PHR1)) {
        // Mostrar la sección de registro de empleado
        ?>
            <div id="registro-empleado" class="bg-gray-100 p-4 rounded-lg shadow">
            <h1 class="text-xl font-bold mb-4">Registrar Empleado</h1>
            <form action="../../api/src/Core/App.php" method="POST">
                <input type="hidden" name="registrarEmpleado" value="registrarEmpleado">
                <label for="nombre" class="block font-medium">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="border rounded-md p-2 w-full mb-2" required>
                
                <label for="apellido" class="block font-medium">Apellido:</label>
                <input type="text" id="apellido" name="apellido" class="border rounded-md p-2 w-full mb-2" required>
                
                <label for="cedula" class="block font-medium">Cédula:</label>
                <input type="text" id="cedula" name="cedula" class="border rounded-md p-2 w-full mb-2" required>
                
                <label for="departamento" class="block font-medium">Departamento:</label>
                <select id="departamento" name="departamento" class="border rounded-md p-2 w-full mb-2" required>
                    <option value="">Seleccione un departamento</option>
                    <?php
                        include_once '../../api/src/controllers/recursosHumanosControlador.php';
                        $controller = new HumanResourcesController();
                        $departamentos = $controller->getDepartamentos();
                        foreach ($departamentos as $departamento) {
                            echo '<option value="' . $departamento['id_departamento'] . '">' . $departamento['nombre'] . '</option>';
                        }
                    ?>
                </select>
                
                <label for="rol" class="block font-medium">Rol:</label>
                <select id="rol" name="rol" class="border rounded-md p-2 w-full mb-2" required>
                    <option value="">Seleccione un rol</option>
                </select>
                
                <label for="username" class="block font-medium">Nombre de Usuario:</label>
                <input type="text" id="username" name="user" class="border rounded-md p-2 w-full mb-2" required>
                
                <label for="password" class="block font-medium">Contraseña:</label>
                <input type="password" id="password" name="contra" class="border rounded-md p-2 w-full mb-2" required>
                
                <label for="email" class="block font-medium">Email:</label>
                <input type="email" id="email" name="email" class="border rounded-md p-2 w-full mb-2" required>
                
                <label for="turno" class="block font-medium">Turno:</label>
                <select id="turno" name="turno" class="border rounded-md p-2 w-full mb-2" required>
                    <option value="">Seleccione un turno</option>
                    <?php
                        $turnos = $controller->getTurnos();
                        foreach ($turnos as $turno) {
                            echo '<option value="' . $turno['id_turno'] . '">' . $turno['nombre'] . ' ' . $turno['hora_inicio'] . ' - ' . $turno['hora_fin'] . '</option>';
                        }
                    ?>
                </select>
                
                <label for="salario" class="block font-medium">Salario:</label>
                <input type="number" id="salario" name="salario" step="0.01" class="border rounded-md p-2 w-full mb-4" required>
                
                <input class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded cursor-pointer w-full" type="submit" value="Registrar Empleado">
            </form>
        </div>
        <?php
        }
        ?>
        <?php
        $controller = new HumanResourcesController();
        $roles_con_PHR1 = $controller->getRolesByPermission('PHR2');

        // Verificar si el rol del usuario actual está en la lista de roles con PHR1
        if (in_array($user_rol, $roles_con_PHR1)) {
        // Mostrar la sección de registro de empleado
        ?>
    
    <div id="lista-empleados" class="overflow-x-auto bg-gray-100 p-4 rounded-lg shadow">
        <div class="flex items-center mb-4">
            <input 
                type="text" 
                id="busqueda" 
                class="border rounded-lg px-4 py-2 w-full" 
                placeholder="Buscar..." 
                oninput="buscar()" 
            />
        </div>
        <div id="tabla-container" class="overflow-x-auto">
            <table class="table-auto min-w-full border border-gray-200 text-sm">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Apellido</th>
                        <th class="px-4 py-2">Cédula</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Departamento</th>
                        <th class="px-4 py-2">Rol</th>
                        <th class="px-4 py-2">Turno</th>
                        <th class="px-4 py-2">Salario</th>
                    </tr>
                </thead>
                <tbody id="tabla-body">
                    <!-- Contenido cargado dinámicamente -->
                </tbody>
            </table>
        </div>
        <div id="paginacion-container" class="flex items-center justify-between mt-4">
            <!-- Contenido de paginación -->
        </div>
    </div>
    <?php
        }
        ?>
        <?php
        $controller = new HumanResourcesController();
        $roles_con_PHR1 = $controller->getRolesByPermission('PHR3');

        // Verificar si el rol del usuario actual está en la lista de roles con PHR1
        if (in_array($user_rol, $roles_con_PHR1)) {
        // Mostrar la sección de registro de empleado
        ?>
    <div id="editar-salario" class="bg-gray-100 p-4 rounded-lg shadow">
        <h1 class="text-xl font-bold mb-4">Editar Salario</h1>
        <form action="../../api/src/Core/App.php" method="POST">
            <input type="hidden" name="editarSalario" value="editarSalario">
            <label for="editar-sal-ced" class="block font-medium">Cédula del empleado:</label>
            <input placeholder="Ingrese la cédula" type="text" name="cedula-salario" id="editar-sal-ced" class="border rounded-md p-2 w-full mb-2" required>
            
            <label for="salario" class="block font-medium">Nuevo Salario:</label>
            <input placeholder="Ingrese el nuevo salario" type="number" name="salario-editar" id="salario" step="0.01" class="border rounded-md p-2 w-full mb-4" required>
            
            <input class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded cursor-pointer w-full" type="submit" value="Actualizar Salario">
        </form>
    </div>
<?php
        }
        ?>
        <?php
        $controller = new HumanResourcesController();
        $roles_con_PHR1 = $controller->getRolesByPermission('PHR4');

        // Verificar si el rol del usuario actual está en la lista de roles con PHR1
        if (in_array($user_rol, $roles_con_PHR1)) {
        // Mostrar la sección de registro de empleado
        ?>
    <div id="editar-turno" class="bg-gray-100 p-4 rounded-lg shadow">
        <h1 class="text-xl font-bold mb-4">Editar Turno</h1>
        <form action="../../api/src/Core/App.php" method="POST">
            <input type="hidden" name="editarTurno" value="editarTurno">
            <label for="editar-turno-ced" class="block font-medium">Cédula del empleado:</label>
            <input placeholder="Ingrese la cédula" type="text" name="cedula-turno" id="editar-turno-ced" class="border rounded-md p-2 w-full mb-2" required>
            
            <label for="turno" class="block font-medium">Turno:</label>
            <select id="turno" name="turno" class="border rounded-md p-2 w-full mb-4" required>
                <option value="">Seleccione un turno</option>
                <?php
                    $turnos = $controller->getTurnos();
                    foreach ($turnos as $turno) {
                        echo '<option value="' . $turno['id_turno'] . '">' . $turno['nombre'] . ' ' . $turno['hora_inicio'] . ' - ' . $turno['hora_fin'] . '</option>';
                    }
                ?>
            </select>
            
            <input class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded cursor-pointer w-full" type="submit" value="Actualizar Turno">
        </form>
    </div>
    <?php
        }
        ?>
        <?php
        $controller = new HumanResourcesController();
        $roles_con_PHR1 = $controller->getRolesByPermission('PHR5');

        // Verificar si el rol del usuario actual está en la lista de roles con PHR1
        if (in_array($user_rol, $roles_con_PHR1)) {
        // Mostrar la sección de registro de empleado
        ?>
        <div id="enviar-correo" class="bg-gray-100 p-4 rounded-lg shadow">
            <h1 class="text-xl font-bold mb-4">Enviar Correo Electrónico</h1>
            <form action="../../api/src/Core/App.php" method="POST">
                <input type="hidden" name="enviarCorreo" value="enviarCorreo">
                
                <label for="destinatario" class="block font-medium">Correo Destino:</label>
                <input type="email" id="destinatario" name="destinatario" class="border rounded-md p-2 w-full mb-2" required>
                
                <label for="asunto" class="block font-medium">Asunto:</label>
                <input type="text" id="asunto" name="asunto" class="border rounded-md p-2 w-full mb-2" required>
                
                <label for="mensaje" class="block font-medium">Mensaje:</label>
                <textarea id="mensaje" name="mensaje" rows="5" class="border rounded-md p-2 w-full mb-4" required></textarea>
                
                <input class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded cursor-pointer w-full" type="submit" value="Enviar Correo">
            </form>
        </div>
        <?php
        }
        ?>

</div>
    </div>

    <script>
        if (document.getElementById('departamento')) {
            document.querySelector('#departamento').addEventListener('change', (e) => {
            console.log('cargarRoles');
            const departamentoId = document.getElementById('departamento').value;

            console.log(departamentoId);
            const rolSelect = document.getElementById('rol');
            rolSelect.innerHTML = '<option value="">Seleccione un rol</option>';
            const url = '../../api/src/Core/App.php';
            const data = JSON.stringify({
                'id_departamento': departamentoId,
                'url': 'getRolesDepartamento'
            });

            fetch(url, {
                method: 'POST',
                body: data
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                data.forEach(rol => {
                    const option = document.createElement('option');
                    option.value = rol.id_rol;
                    option.textContent = rol.nombre;
                    rolSelect.appendChild(option);
                });
            });
        });
        }
        


        document.addEventListener('DOMContentLoaded', cargarDatos);

    
    let paginaActual = 1;
    function cargarDatos() {
        const tablaBody = document.getElementById('tabla-body');
    const paginacionContainer = document.getElementById('paginacion-container');
    const busqueda = document.getElementById('busqueda').value;

    fetch(`tabla.php?pagina=${paginaActual}&busqueda=${encodeURIComponent(busqueda)}`)
        .then(response => {
            console.log('response', response);
            return response.json()})
        .then(data => {
            const tablaBody = document.getElementById('tabla-body');
            tablaBody.innerHTML = '';

            // Renderiza las filas
            data.data.forEach(fila => {
                const row = `
                    <tr>
                        <td class="border px-4 py-2">${fila.nombre}</td>
                        <td class="border px-4 py-2">${fila.apellido}</td>
                        <td class="border px-4 py-2">${fila.cedula}</td>
                        <td class="border px-4 py-2">${fila.email}</td>
                        <td class="border px-4 py-2">${fila.departamento_nombre}</td>
                        <td class="border px-4 py-2">${fila.rol_nombre}</td>
                        <td class="border px-4 py-2">${fila.turno}</td>
                        <td class="border px-4 py-2">${fila.salario}</td>
                    </tr>`;
                tablaBody.innerHTML += row;
            });

            // Actualiza la paginación
            const paginacion = document.getElementById('paginacion-container');
            paginacion.innerHTML = '';
            for (let i = 1; i <= data.total_paginas; i++) {
                paginacion.innerHTML += `
                    <button onclick="irPagina(${i})" class="px-2 py-1 border ${i === data.pagina_actual ? 'bg-gray-300' : ''}">
                        ${i}
                    </button>`;
            }
        })
        .catch(error => {
            console.error('Error al cargar datos:', error);
        });
}

    function buscar() {
        console.log('buscar');
        paginaActual = 1; // Reinicia a la primera página
        cargarDatos();
    }

    function irPagina(pagina) {
        paginaActual = pagina;
        cargarDatos();
    }
    console.log('cargarDatos');
    // Cargar primera página al inicio
    cargarDatos();
    </script>
</body>
</html>
