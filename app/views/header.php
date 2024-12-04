<?php
$user_id = $_SESSION['user_id'];
$database = new Database();
$conn = $database->getConnection();
$usuarios_query = "SELECT e.nombre as nombre, d.nombre AS departamento, r.nombre AS rol, r.id_rol AS id_rol FROM empleado AS e JOIN departamento AS d on e.departamento = d.id_departamento JOIN rol AS r on e.rol = r.id_rol WHERE usuario = :user_id";
    $stmt = $conn->prepare($usuarios_query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT); // Aseguramos que sea un número entero
$stmt->execute();

$usuarios_result = $stmt->fetch(PDO::FETCH_ASSOC); 
?>
<header class="fixed w-full flex items-center justify-between h-14 text-white bg-teal-600 z-10">

            <!-- Logo y Avatar con Popup de Opciones -->
                
                <!-- Contenedor del Perfil con hover -->
                <div class="flex items-center space-x-2 bg-transparent text-white px-3  rounded-lg hover:bg-[#00756a] cursor-pointer transition-all duration-300">
                    
                    <!-- Información del Usuario -->
                    <div class="flex flex-col text-base">
                        <span class="font-semibold"><?php echo $usuarios_result['nombre']; ?></span>
                        <span class="font-semibold text-white text-xs"><?php echo $usuarios_result['departamento'] . "/" . $usuarios_result['rol']; ?></span>
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
                <!-- Divider -->
                <li>
                    <div class="block w-px h-6 mx-3 bg-gray-400"></div>
                </li>

                <!-- Logout Button -->
                <li>
                    <a href="/clinica/app/views/logout.php" class="flex items-center group">
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
    <script>
      
    </script>