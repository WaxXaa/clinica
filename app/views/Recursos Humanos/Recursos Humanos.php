<?php
session_start();
include_once '../../api/src/Core/Database.php'; // Asegúrate de que la ruta sea correcta
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
    <div id="homeLink" class="section-button flex items-center space-x-2 py-2 px-3 rounded-md transition-all duration-300 group
                hover:bg-gradient-to-r from-lime-400 via-emerald-400 to-teal-400"
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
         <div id="main-container-modulos"class=" bg-white rounded-lg p-5 shadow-md flex space-x-4">
         <h1>Registrar Empleado</h1>
    <form action="../../api/src/Core/App.php" method="POST">
        <input type="hidden" name="registrarEmpleado" value="registrarEmpleado">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="apellido">Apellido:</label><br>
        <input type="text" id="apellido" name="apellido" required><br>

        <label for="departamento">Departamento:</label><br>
        <select id="departamento" name="departamento" required>
            <option value="">Seleccione un departamento</option>
            <?php
            // Obtener los departamentos de la base de datos
            include_once '../../api/src/controllers/recursosHumanosControlador.php';
            $controller = new HumanResourcesController();
            $departamentos = $controller->getDepartamentos();
            foreach ($departamentos as $departamento) {
              echo "<script>console.log('PHP:". $departamento['id_departamento'] . "');</script>";
                echo '<option value="' . $departamento['id_departamento'] . '">' . $departamento['nombre'] . '</option>';
            }
            ?>
        </select><br>

        <label for="rol">Rol:</label><br>
        <select id="rol" name="rol" required>
            <option value="">Seleccione un rol</option>
            <!-- Los roles se cargarán mediante JavaScript -->
        </select><br>

        <label for="username">Nombre de Usuario:</label><br>
        <input type="text" id="username" name="user" required><br>

        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" name="contra" required><br>

        <label for="turno">Turno:</label><br>
        <select id="turno" name="turno" required>
        <option value="">Seleccione un turno</option>
        <?php
            // Obtener los departamentos de la base de datos
            include_once '../../api/src/controllers/recursosHumanosControlador.php';
            $controller = new HumanResourcesController();
            $turnos = $controller->getTurnos();
            foreach ($turnos as $turno) {
              echo "<script>console.log('PHP:". $turno['id_turno'] . "');</script>";
                echo '<option value="' . $turno['id_turno'] . '">' . $turno['nombre'] .' '. $turno['hora_inicio'] .' - '. $turno['hora_fin'].'</option>';
            }
            ?>
        </select><br>

        <label for="salario">Salario:</label><br>
        <input type="number" id="salario" name="salario" step="0.01" required><br><br>

        <input type="submit" value="Registrar Empleado">
    </form>
        </div>
    </div>


    <script>


        // function setup() {
        //     return {
        //         openProfile: false
        //     };
        // }

        // function initializeSidebarToggleButton() {
        //     loadLottieAnimation('lottieToggleButton', './assets/json/menu-left.json');
        //     loadSectionAnimations();
        // }

        // function loadLottieAnimation(elementId, path) {
        //     if (window[elementId] && window[elementId].destroy) {
        //         window[elementId].destroy();
        //     }
        //     window[elementId] = lottie.loadAnimation({
        //         container: document.getElementById(elementId),
        //         renderer: 'svg',
        //         loop: true,
        //         autoplay: false,
        //         path: path
        //     });
        // }

        // function toggleSidebar() {
        //     const newSidebarState = !this.sidebarOpen;
        //     this.sidebarOpen = newSidebarState;
            
        //     const togglePath = newSidebarState ? './assets/json/menu-left.json' : './assets/json/menu-right.json';
        //     loadLottieAnimation('lottieToggleButton', togglePath);
        //     playToggleAnimation(newSidebarState ? 4500 : 4600);
        // }

        // function loadSectionAnimations() {
        //     loadLottieAnimation('homepageAnimation', './assets/json/homepage.json');
        //     loadLottieAnimation('documentAnimation', './assets/json/document.json');
        //     loadLottieAnimation('notificationAnimation', './assets/json/notification.json');
        //     loadLottieAnimation('configurationAnimation', './assets/json/configuration.json');
        // }

        // function playAnimation(buttonId) {
        //     if (window[buttonId]) {
        //         window[buttonId].play();
        //     }
        // }

        // function stopAnimation(buttonId) {
        //     if (window[buttonId]) {
        //         window[buttonId].stop();
        //     }
        // }

        // function playToggleAnimation(duration) {
        //     window.lottieToggleButton.play();
        //     setTimeout(() => {
        //         window.lottieToggleButton.stop();
        //     }, duration);
        // }

        // function stopToggleAnimation() {
        //     window.lottieToggleButton.stop();
        // }




        
      document.querySelector('#departamento').addEventListener('change', (e) => {
            console.log('cargarRoles');
            const departamentoId = document.getElementById('departamento').value;
            
            console.log(departamentoId);
            const rolSelect = document.getElementById('rol');
            rolSelect.innerHTML = '<option value="">Seleccione un rol</option>';
            const url = '../../api/src/Core/App.php';
            const data = JSON.stringify({
                'id_departamento': departamentoId,
                'url': 'getRolesDepartamento'}
            );
            
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
    





    </script>
</body>
</html>
