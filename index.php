<?php

session_start();
include_once './app/api/src/core/Database.php'; // Asegúrate de que la ruta sea correcta

// Verificar si el usuario está logueado
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: ./app/views/login.php');
    exit();
}

// Verificar el rol del usuario desde la sesión
$user_id = $_SESSION['user_id'];
// var_dump($_SESSION['user_id']);





// Conectar a la base de datos y obtener los usuarios
$database = new Database();
$conn = $database->getConnection();

// Usando prepared statements para evitar inyección SQL
$usuarios_query = "SELECT e.nombre as nombre, d.nombre AS departamento, r.nombre AS rol, r.id_rol AS id_rol FROM empleado AS e JOIN departamento AS d on e.departamento = d.id_departamento JOIN rol AS r on e.rol = r.id_rol WHERE usuario = :user_id";
    $stmt = $conn->prepare($usuarios_query);
// if ($conn) {
//     echo "Conexión a la base de datos exitosa.";
// } else {
//     echo "Error de conexión.";
// }
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT); // Aseguramos que sea un número entero
$stmt->execute();

$usuarios_result = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener todos los resultados
// var_dump( $usuarios_result);
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
        <header class="fixed w-full flex items-center justify-between h-14 text-white bg-teal-600 z-10">

            <!-- Logo y Avatar con Popup de Opciones -->
            <div @click="openProfile = !openProfile" @click.away="openProfile = false" class="flex items-center justify-start md:justify-center pl-3 w-14 md:w-64 h-14 border-none relative cursor-pointer">
                
                <!-- Contenedor del Perfil con hover -->
                <div class="flex items-center space-x-2 bg-transparent text-white px-3 py-1 rounded-lg hover:bg-gray-700 cursor-pointer transition-all duration-300">
                    <!-- Avatar con Estado -->
                    <div class="relative w-10 h-10">
                        <img src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" alt="Avatar" class="w-full h-full rounded-full border-2 border-white">
                    </div>
                    
                    <!-- Información del Usuario -->
                    <div class="flex flex-col text-sm">
                        <span class="font-semibold"><?php echo $usuarios_result['nombre']; ?></span>
                        <span class="font-semibold text-white text-xs"><?php echo $usuarios_result['departamento'] . "/" . $usuarios_result['rol']; ?></span>
                    </div>
                </div>
            
            </div>

        <!-- Search Bar -->
        <div class="flex justify-between items-center h-14 w-full pr-4 ml-10">
            <div class="bg-white rounded flex items-center w-full max-w-xl mr-4 p-2 shadow-sm border border-gray-200">
                <button class="outline-none focus:outline-none">
                    <svg class="w-5 text-gray-600 h-5 cursor-pointer" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                <input type="search" placeholder="Buscar" class="w-full pl-3 text-sm text-black outline-none bg-transparent" />
            </div>

            <!-- Icons and Logout Button -->
            <ul class="flex items-center">
                <!-- Dark Mode Toggle Button -->
                <li>
                    <button @click="isDark = !isDark" class="p-2 rounded-full bg-green-300 hover:bg-green-400 text-gray-900 transition-colors">
                        <svg x-show="!isDark" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="isDark" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976-2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </button>
                </li>
                <!-- Divider -->
                <li>
                    <div class="block w-px h-6 mx-3 bg-gray-400"></div>
                </li>

                <!-- Logout Button -->
                <li>
                    <a href="./app/views/logout.php" class="flex items-center group">
                        <div class="flex items-center px-4 py-2 rounded-md bg-transparent transition-all duration-300
                                    hover:bg-gradient-to-r hover:from-lime-400 hover:via-emerald-400 hover:to-teal-400, !sidebarOpen ? 'w-fit justify-center' : '']">
                            <svg class="w-5 h-5 mr-2 text-white group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="font-bold text-white group-hover:text-white transition-colors duration-300">Logout</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <!-- ./Header -->

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'w-1/6' : 'w-28'" class="relative bg-slate-200 h-screen p-5 pt-20 transition-all duration-700 flex flex-col space-y-4">
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
        <div class="section-button flex items-center space-x-2 py-2 px-3 rounded-md transition-all duration-300 group
                    hover:bg-gradient-to-r from-lime-400 via-emerald-400 to-teal-400"
            :class="!sidebarOpen ? 'justify-center' : ''">
            <span class="font-bold text-black group-hover:text-white transition-colors duration-300" 
                x-show="sidebarOpen" x-transition>
                <?php echo htmlspecialchars($module['nombre']); ?>
            </span>
        </div>
    <?php endforeach; ?>
</aside>

    <!-- Contenido Principal -->
    <div class="flex-1 p-5 space-y-5">

         <!-- Contenedor Principal -->
         <div class="bg-white rounded-lg p-5 shadow-md flex space-x-4">
            

        </div>
    </div>


    <script>

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
