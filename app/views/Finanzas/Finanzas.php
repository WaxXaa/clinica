<?php
session_start();
include_once '../../api/src/Core/Database.php'; // Asegúrate de que la ruta sea correcta
include_once '../../api/src/controllers/indexControlador.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: ../login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
$database = new Database();
$conn = $database->getConnection();

$usuarios_query = "SELECT e.nombre as nombre, d.nombre AS departamento, r.nombre AS rol, r.id_rol AS id_rol FROM empleado AS e JOIN departamento AS d on e.departamento = d.id_departamento JOIN rol AS r on e.rol = r.id_rol WHERE usuario = :user_id";
$stmt = $conn->prepare($usuarios_query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT); // Aseguramos que sea un número entero
$stmt->execute();
$usuarios_result = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener todos los resultados
$user_role = $usuarios_result['id_rol'];
$user_department = $usuarios_result['departamento'];
$controller = new IndexController($conn);

// Fetch data for dashboard
try {
    $examenes = $controller->getExamenes();
    $pacientes = $controller->getPacientes();
    $peticiones = $controller->getPeticiones();
} catch (PDOException $e) {
    die('Error fetching dashboard data: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finanzas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.5/lottie.min.js"></script>
    <style>
        .lottie-animation {
            width: 30px;
            height: 30px;
        }
    </style>
</head>
<body class="flex justify-start items-start h-screen bg-[#EAFCF3] text-white" x-data="{ sidebarOpen: true, isDark: false, openProfile: false, openStatus: false }" x-init="initializeSidebarToggleButton()">
    <!-- Header -->
    <?php include_once '../../views/header.php'; ?>
    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'w-1/6' : 'w-28'" class="relative h-screen p-5 pt-20 transition-all duration-700 flex flex-col space-y-4">
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
            $stmt->bindParam(':role', $user_role);
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
        <div id="main-container-modulos" class=" rounded-lg p-5 shadow-md grid grid-cols-2 gap-4">
                <!-- Exámenes Table -->
                <div class="bg-white p-5 rounded-md shadow-md h-96 overflow-y-scroll">
                    <h2 class="text-xl font-bold mb-4">Costo de los Examenes que realiza el Hospital</h2>
                    <table class="w-full border border-gray-300">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">ID</th>
                                <th class="border px-4 py-2">Nombre</th>
                                <th class="border px-4 py-2">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($examenes as $examen): ?>
                            <tr>
                                <td class="border px-4 py-2"><?php echo htmlspecialchars($examen['id_examen'] ?? 'N/A'); ?></td>
                                <td class="border px-4 py-2"><?php echo htmlspecialchars($examen['nombre'] ?? 'N/A'); ?></td>
                                <td class="border px-4 py-2"><?php echo htmlspecialchars($examen['precio'] ?? 'N/A'); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

<!--actualizar precio-->


        <div id="peticiones h-96 overflow-y-scroll">
            <h2 class="text-2xl font-bold ">Peticiones de Insumos</h2>
            <!-- Mostrar mensajes -->
            <?php if (isset($success_transferir_insumo)): ?>
                <p id="success-message" style="color: green;"><?= htmlspecialchars($success_transferir_insumo) ?></p>
            <?php endif; ?>
            <?php if (isset($error_transferir_insumo)): ?>
                <p id="error-message" style="color: red;"><?= htmlspecialchars($error_transferir_insumo) ?></p>
            <?php endif; ?>
            <?php
            $stmt = $conn->prepare("SELECT p.id_peticion as id_peticion, i.nombre as nombre, i.id_insumo as id_insumo, p.cantidad as cantidad, d.nombre as departamento, d.id_departamento as id_departamento, p.fecha_peticion as fecha FROM peticiones_insumos as p JOIN insumos as i on p.insumo = i.id_insumo JOIN departamento as d on p.id_departamento = d.id_departamento WHERE p.estado = 'Pendiente' AND p.id_departamento = 3");
            $stmt->execute();
            $peticiones = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($peticiones) === 0) {
                echo '<p>No hay peticiones pendientes.</p>';
            }
            ?>
            <?php foreach ($peticiones as $peticion): ?>
                <div class="bg-white shadow rounded-lg p-4 flex flex-col space-y-4">
                    <h3 class="text-xl font-bold">Petición #<?php echo htmlspecialchars($peticion['id_peticion']); ?></h3>
                    <p class="text-gray-700"><?php echo htmlspecialchars($peticion['nombre']); ?></p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">el departamento <?php echo htmlspecialchars($peticion['departamento']); ?> esta pidiento <?php echo htmlspecialchars($peticion['cantidad']); ?> <?php echo htmlspecialchars($peticion['nombre']); ?></span>
                        <span class="text-sm text-gray-500">Fecha de peticion: <?php echo htmlspecialchars($peticion['fecha']); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        


                    <div id="grafico-pacientes" class="bg-white rounded-lg p-5 shadow-md">
                        <h2 class="text-xl font-bold">facturacion por Departamento</h2>
                        <canvas id="chart" style="max-width: 400px; max-height: 400px;"></canvas>
                    </div>
                    <div id="grafico-salario" class="bg-white rounded-lg p-5 shadow-md">
                        <h2 class="text-xl font-bold">Promedio Salario por Departamento</h2>
                        <canvas id="chart2" style="max-width: 400px; max-height: 400px;"></canvas>
                    </div>



    
        
    </div>
    <div id="grafico-activos" class="w-full bg-white rounded-lg p-5 shadow-md">
                        <h2 class="text-xl font-bold">Monto en Activos por Departamento en $dolares</h2>
                        <canvas id="chart3" class="w-full" style="max-height: 500px;"></canvas>
                    </div>
    </div>
    <script>

fetch('../../../chartFacturacionDep.php')
    .then(response => response.json())
    .then(data => {
        const labels = data.map(item => item.departamento);
        const chartData = data.map(item => item.total_facturado);

        const ctx = document.getElementById('chart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Facturado',
                    data: chartData,
                    backgroundColor: [
                        '#ff6384', '#36a2eb', '#ffcd56', '#4bc0c0',
                        '#9966ff', '#ff9f40', '#c9cbcf', '#ff9ff3',
                        '#00d2d3', '#54a0ff', '#5f27cd', '#1dd1a1',
                        '#ff6b6b', '#48dbfb', '#f368e0', '#00d2d3',
                        '#8395a7', '#222f3e', '#ee5253', '#0abde3',
                        '#10ac84'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    })
    .catch(error => console.error('Error fetching chart data:', error));


fetch('../../../chartActivosDep.php')
.then(response => response.json())
.then(data => {
    const labels = data.map(item => item.departamento);
    const chartData = data.map(item => item.total_insumos);

    const ctx = document.getElementById('chart3').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Monto en Activos',
                data: chartData,
                backgroundColor: [
                    '#ff6384', '#36a2eb', '#ffcd56', '#4bc0c0',
                    '#9966ff', '#ff9f40', '#c9cbcf', '#ff9ff3',
                    '#00d2d3', '#54a0ff', '#5f27cd', '#1dd1a1',
                    '#ff6b6b', '#48dbfb', '#f368e0', '#00d2d3',
                    '#8395a7', '#222f3e', '#ee5253', '#0abde3',
                    '#10ac84'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
})
.catch(error => console.error('Error fetching chart data:', error));
</script>
    <script>
    // Obtener los datos desde PHP
    fetch('../../../chartSalario.php')
                        .then(response => response.json())
                        .then(data => {
                            const labels = data.map(item => item.departamento);
                            const chartData = data.map(item => item.promedio_salario);

                            const ctx = document.getElementById('chart2').getContext('2d');
                            const chart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Promedio Salario',
                                        data: chartData,
                                        backgroundColor: [
                                            '#ff6384', '#36a2eb', '#ffcd56', '#4bc0c0',
                                            '#9966ff', '#ff9f40', '#c9cbcf', '#ff9ff3',
                                            '#00d2d3', '#54a0ff', '#5f27cd', '#1dd1a1',
                                            '#ff6b6b', '#48dbfb', '#f368e0', '#00d2d3',
                                            '#8395a7', '#222f3e', '#ee5253', '#0abde3',
                                            '#10ac84'
                                        ]
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                }
                            });
                        })
                        .catch(error => console.error('Error fetching chart data:', error));


    </script>

</body>
</html>
