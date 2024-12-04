<?php
session_start();
include_once './app/api/src/controllers/indexControlador.php';
include_once './app/api/src/core/Database.php'; // Asegúrate de que la ruta sea correcta
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: ./app/views/login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
$database = new Database();
$conn = $database->getConnection();

$usuarios_query = "SELECT e.nombre as nombre, d.nombre AS seguro, r.nombre AS rol, r.id_rol AS id_rol, e.id_empleado AS id_empleado FROM empleado AS e JOIN departamento AS d on e.departamento = d.id_departamento JOIN rol AS r on e.rol = r.id_rol WHERE usuario = :user_id;";
$stmt = $conn->prepare($usuarios_query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT); // Aseguramos que sea un número entero
$stmt->execute();
$usuarios_result = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener todos los resultados
$user_role = $usuarios_result['id_rol'];
$id_empleado = $usuarios_result['id_empleado'];
$_SESSION['id_empleado'] = $id_empleado;

// Controller initialization
$controller = new IndexController($conn);

// Fetch data for dashboard
try {
    $examenes = $controller->getExamenes();
    $pacientes = $controller->getPacientes();
    $peticiones = $controller->getPeticiones();
} catch (PDOException $e) {
    die('Error fetching dashboard data: ' . $e->getMessage());
}

// Fetch data for pie chart
    $departamento = $controller->getPacientesPorDepartamento();


        $labels[] = $departamento;
        // $data[] = $departamento['cantidad'];


?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        .lottie-animation {
            width: 30px;
            height: 30px;
        }
    </style>
</head>
<body class="flex justify-start items-start h-screen bg-[#EAFCF3] text-white" x-data="{ sidebarOpen: true, isDark: false, openProfile: false, openStatus: false }" x-init="initializeSidebarToggleButton()">
    <!-- Header -->
    <?php include_once './app/views/header.php'; ?>
    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'w-1/6' : 'w-28'" class="relative h-screen p-5 pt-20 transition-all duration-700 flex flex-col space-y-4">
    <div id="homeLink" class="section-button flex items-center space-x-2 py-2 px-3 rounded-md transition-all duration-300 group
                hover:bg-gradient-to-r from-lime-400 via-emerald-400 to-teal-400"
        :class="!sidebarOpen ? 'justify-center' : ''">
        <a href="./index.php">
        <span class="font-bold text-black group-hover:text-white transition-colors duration-300" 
            x-show="sidebarOpen" x-transition>
            Inicio
        </span>
        </a>
        
    </div>
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
    <div id="<?php echo $module['nombre']; ?>" class="section-button flex items-center space-x-2 py-2 px-3 rounded-md transition-all duration-300 group
                hover:bg-gradient-to-r from-lime-400 via-emerald-400 to-teal-400"
        :class="!sidebarOpen ? 'justify-center' : ''">
        <a href="<?php echo './app/views/' . $module['nombre'] . '/'. $module['nombre'] . '.php'?>">
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
        <div id="main-container-modulos" class="bg-white rounded-lg p-5 shadow-md flex space-x-4">
            <div class="bg-[#F8FFFE] flex-1 p-5 space-y-5">
                <h1 class="text-2xl font-bold">Dashboard</h1>

                <!-- Exámenes Table -->
                <div class="bg-white p-5 rounded-md shadow-md h-96 overflow-y-scroll">
                    <h2 class="text-xl font-bold mb-4">Exámenes</h2>
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

                <!-- Pacientes Table -->
                <div class="bg-white p-5 rounded-md shadow-md h-96 overflow-y-scroll">
                    <h2 class="text-xl font-bold mb-4">Pacientes Registrados</h2>
                    <table class="w-full border border-gray-300">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">ID</th>
                                <th class="border px-4 py-2">Nombre</th>
                                <th class="border px-4 py-2">Apellido</th>
                                <th class="border px-4 py-2">Cédula</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pacientes as $paciente): ?>
                            <tr>
                                <td class="border px-4 py-2"><?php echo htmlspecialchars($paciente['id_paciente'] ?? 'N/A'); ?></td>
                                <td class="border px-4 py-2"><?php echo htmlspecialchars($paciente['nombre'] ?? 'N/A'); ?></td>
                                <td class="border px-4 py-2"><?php echo htmlspecialchars($paciente['apellido'] ?? 'N/A'); ?></td>
                                
                                <td class="border px-4 py-2"><?php echo htmlspecialchars($paciente['cedula'] ?? 'N/A'); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Peticiones Table -->
                
                <div class="flex justify-evenly mt-10 " >

                <div id="grafico-pacientes" class="bg-[#F8FFFE] rounded-lg p-5 shadow-md">
                    <h2 class="text-xl font-bold">Pacientes por Departamento</h2>
                    <canvas id="chart" style="max-width: 400px; max-height: 400px;"></canvas>
                </div>
                <div id="grafico-salario" class="bg-[#F8FFFE] rounded-lg p-5 shadow-md">
                    <h2 class="text-xl font-bold">AVG Salario por Departamento</h2>
                    <canvas id="chart2" style="max-width: 400px; max-height: 400px;"></canvas>
                </div>

                </div>
                <!-- Pie Chart -->
                <!-- Exámenes en Realización -->
            <div class="bg-[#F8FFFE] p-5 rounded-md shadow-md">
                <h2 class="text-xl font-bold mb-4">Exámenes en Realización</h2>
                <table class="w-full border border-gray-300">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">Nombre del Examen</th>
                            <th class="border px-4 py-2">Nombre del Paciente</th>
                            <th class="border px-4 py-2">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Obtener los datos de las peticiones pendientes
                        $peticionesPendientes = $controller->getExamenesPendientesConDetalles();

                        if (!empty($peticionesPendientes)) {
                            foreach ($peticionesPendientes as $peticion) {
                                echo "<tr>
                                        <td class='border px-4 py-2'>" . htmlspecialchars($peticion['examen']) . "</td>
                                        <td class='border px-4 py-2'>" . htmlspecialchars($peticion['nombre']) . "</td>
                                        <td class='border px-4 py-2'>" . htmlspecialchars($peticion['estado']) . "</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr>
                                    <td colspan='3' class='border px-4 py-2 text-center'>No hay exámenes en realización.</td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
    <script>
    // Obtener los datos desde PHP
    fetch('./chartSalario.php')
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
  
        fetch('./chart.php')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.departamento);
                const chartData = data.map(item => item.cantidad);

                const ctx = document.getElementById('chart').getContext('2d');
                const chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Pacientes',
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



        function setup() {
            return {
                openProfile: false
            };
        }

        function initializeSidebarToggleButton() {
            loadLottieAnimation('lottieToggleButton', './assets/json/menu-left.json');
            loadSectionAnimations();
        }

        function loadLottieAnimation(elementId, path) {
            if (window[elementId] && window[elementId].destroy) {
                window[elementId].destroy();
            }
            window[elementId] = lottie.loadAnimation({
                container: document.getElementById(elementId),
                renderer: 'svg',
                loop: true,
                autoplay: false,
                path: path
            });
        }

        function toggleSidebar() {
            const newSidebarState = !this.sidebarOpen;
            this.sidebarOpen = newSidebarState;
            
            const togglePath = newSidebarState ? './assets/json/menu-left.json' : './assets/json/menu-right.json';
            loadLottieAnimation('lottieToggleButton', togglePath);
            playToggleAnimation(newSidebarState ? 4500 : 4600);
        }

        function loadSectionAnimations() {
            loadLottieAnimation('homepageAnimation', './assets/json/homepage.json');
            loadLottieAnimation('documentAnimation', './assets/json/document.json');
            loadLottieAnimation('notificationAnimation', './assets/json/notification.json');
            loadLottieAnimation('configurationAnimation', './assets/json/configuration.json');
        }

        function playAnimation(buttonId) {
            if (window[buttonId]) {
                window[buttonId].play();
            }
        }

        function stopAnimation(buttonId) {
            if (window[buttonId]) {
                window[buttonId].stop();
            }
        }

        function playToggleAnimation(duration) {
            window.lottieToggleButton.play();
            setTimeout(() => {
                window.lottieToggleButton.stop();
            }, duration);
        }

        function stopToggleAnimation() {
            window.lottieToggleButton.stop();
        }

    </script>
</body>
</html>
