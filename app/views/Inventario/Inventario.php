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

$usuarios_query = "SELECT e.nombre as nombre, d.nombre AS departamento, d.id_departamento as id_departamento, r.nombre AS rol, r.id_rol AS id_rol FROM empleado AS e JOIN departamento AS d on e.departamento = d.id_departamento JOIN rol AS r on e.rol = r.id_rol WHERE usuario = :user_id";
$stmt = $conn->prepare($usuarios_query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT); // Aseguramos que sea un número entero
$stmt->execute();
$usuarios_result = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener todos los resultados
$user_rol = $usuarios_result['id_rol'];
$user_department = $usuarios_result['departamento'];
$user_department_id = $usuarios_result['id_departamento'];
include_once '../../api/src/controllers/recursosHumanosControlador.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
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
        <div id="main-container-modulos" class=" rounded-lg p-5 shadow-md flex space-x-4">
        <?php
if (isset($_POST['transferir'])) {
    $id_insumo = $_POST['insumo'];
    $id_departamento = $_POST['departamento'];
    $cantidad = $_POST['cantidad'];
    $id_peticion = $_POST['peticion'];

    try {
        // Conexión a la base de datos
    
        // Preparar la llamada al procedimiento almacenado
        $stmt = $conn->prepare("CALL transferirInsumo(:id_insumo, :id_departamento, :cantidad, :id_peticion, @codigo_estado, @mensaje)");

        // Enlazar parámetros de entrada
        $stmt->bindParam(':id_insumo', $id_insumo, PDO::PARAM_INT);
        $stmt->bindParam(':id_departamento', $id_departamento, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':id_peticion', $id_peticion, PDO::PARAM_INT);

        // Ejecutar el procedimiento
        $stmt->execute();

        // Obtener los valores de salida
        $result = $conn->query("SELECT @codigo_estado AS codigo_estado, @mensaje AS mensaje")->fetch(PDO::FETCH_ASSOC);

        $codigo_estado = (int)$result['codigo_estado'];
        $mensaje = $result['mensaje'];

        // Manejar el resultado basado en el código de estado
        switch ($codigo_estado) {
            case 1:
                // Éxito: Insumo transferido
                $success_transferir_insumo = $mensaje;
                break;
            case 2:
                // Cantidad insuficiente en el inventario general
                $error_transferir_insumo = $mensaje;
                break;
            case -1:
                // Error en la transacción
                $error_transferir_insumo = $mensaje;
                break;
            default:
                // Error no esperado
                $error_transferir_insumo = 'Ha ocurrido un error inesperado.';
                break;
        }
    } catch (PDOException $e) {
        // Manejo de errores de conexión u otros errores
        $error_transferir_insumo = 'Error: ' . $e->getMessage();
    }
}
// Manejar la solicitud de pedir insumo
if (isset($_POST['pedir'])) {
    // Obtener y validar los datos del formulario
    $id_insumo = isset($_POST['insumo']) ? (int)$_POST['insumo'] : 0;
    $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 0;

    // Validación básica
    if ($id_insumo > 0 && $cantidad > 0) {
        try {
            // Preparar la llamada al procedimiento almacenado
            $stmt = $conn->prepare("CALL pedirInsumo(:p_Cantidad, :p_id_insumo, :p_departamento, @p_codigo_estado, @p_mensaje)");

            // Enlazar los parámetros de entrada
            $stmt->bindParam(':p_Cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':p_id_insumo', $id_insumo, PDO::PARAM_INT);
            $stmt->bindParam(':p_departamento', $user_department_id, PDO::PARAM_INT);

            // Ejecutar el procedimiento
            $stmt->execute();

            // Obtener los valores de salida
            $resultado = $conn->query("SELECT @p_codigo_estado AS codigo_estado, @p_mensaje AS mensaje")->fetch(PDO::FETCH_ASSOC);

            $codigo_estado = isset($resultado['codigo_estado']) ? (int)$resultado['codigo_estado'] : -1;
            $mensaje = isset($resultado['mensaje']) ? $resultado['mensaje'] : 'Error desconocido.';

            // Manejar el resultado basado en el código de estado
            if ($codigo_estado === 1) {
                // Éxito
                $success_pedir_insumo = $mensaje;
            } else {
                // Error
                $error_pedir_insumo = $mensaje;
            }
        } catch (PDOException $e) {
            // Manejo de errores de conexión u otros errores
            $error_pedir_insumo = 'Error al procesar la solicitud: ' . $e->getMessage();
        }
    } else {
        // Datos inválidos
        $error_pedir_insumo = 'Por favor, seleccione un insumo válido y una cantidad mayor que cero.';
    }
}
?>
<?php
        
        $controller = new HumanResourcesController();
        $roles_con_PHR1 = $controller->getRolesByPermission('PIV2');

        // Verificar si el rol del usuario actual está en la lista de roles con PHR1
        if (in_array($user_rol, $roles_con_PHR1)) {
        // Mostrar la sección de registro de empleado
        ?>
        <div id="peticiones">
            <h2 class="text-2xl font-bold">Peticiones de Insumos</h2>
            <!-- Mostrar mensajes -->
            <?php if (isset($success_transferir_insumo)): ?>
                <p id="success-message" style="color: green;"><?= htmlspecialchars($success_transferir_insumo) ?></p>
            <?php endif; ?>
            <?php if (isset($error_transferir_insumo)): ?>
                <p id="error-message" style="color: red;"><?= htmlspecialchars($error_transferir_insumo) ?></p>
            <?php endif; ?>
            <?php
            $stmt = $conn->prepare("SELECT p.id_peticion as id_peticion, i.nombre as nombre, i.id_insumo as id_insumo, p.cantidad as cantidad, d.nombre as departamento, d.id_departamento as id_departamento, p.fecha_peticion as fecha FROM peticiones_insumos as p JOIN insumos as i on p.insumo = i.id_insumo JOIN departamento as d on p.id_departamento = d.id_departamento WHERE p.estado = 'Pendiente' AND p.id_departamento != 3");
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
                    <form action="" method="post">
                        <input type="hidden" name="transferir" value="tansferir">
                        <input type="hidden" name="peticion" value="<?php echo htmlspecialchars($peticion['id_peticion']); ?>">
                        <input type="hidden" name="insumo" value= "<?php echo htmlspecialchars($peticion['id_insumo']); ?>">
                        <input type="hidden" name="cantidad" value="<?php echo htmlspecialchars($peticion['cantidad']); ?>">
                        <input type="hidden" name="departamento" value="<?php echo htmlspecialchars($peticion['id_departamento']); ?>">
                        <button class="bg-green-500 text-white px-4 py-2 rounded-lg" type="submit">Aceptar Peticion</button>
                    </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
        }
        ?>
        <?php
        
        $controller = new HumanResourcesController();
        $roles_con_PHR1 = $controller->getRolesByPermission('PIV3');

        // Verificar si el rol del usuario actual está en la lista de roles con PHR1
        if (in_array($user_rol, $roles_con_PHR1)) {
        // Mostrar la sección de registro de empleado
        ?>
        <!-- Formulario para Solicitar Insumos -->
        <div id="solicitar-insumo" class="bg-white rounded-lg p-5 shadow-md">
            <h2 class="text-xl font-bold mb-4">Solicitar Insumo</h2>

            <!-- Mostrar mensajes de éxito o error -->
            <?php if (isset($success_pedir_insumo)): ?>
                <p class="text-green-500 mb-4"><?= htmlspecialchars($success_pedir_insumo) ?></p>
            <?php endif; ?>
            <?php if (isset($error_pedir_insumo)): ?>
                <p class="text-red-500 mb-4"><?= htmlspecialchars($error_pedir_insumo) ?></p>
            <?php endif; ?>

            <form action="" method="post" class="flex flex-col space-y-4">
                <input type="hidden" name="pedir" value="pedir">

                <!-- Campo de Selección de Insumo -->
                <div>
                    <label for="insumo" class="block text-sm font-medium text-gray-700">Insumo:</label>
                    <select name="insumo" id="insumo" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Seleccione un insumo</option>
                        <?php
                        // Obtener la lista de insumos para el desplegable
                        $insumos_query = "SELECT ip.id_insumo as id_insumo, i.nombre as nombre FROM insumos_departamento as ip JOIN insumos as i on ip.id_insumo = i.id_insumo where ip.id_departamento = :departamento ORDER BY nombre ASC";
                        $insumos_stmt = $conn->prepare($insumos_query);
                        $insumos_stmt->bindParam(':departamento', $user_department_id, PDO::PARAM_INT);
                        $insumos_stmt->execute();
                        $insumos = $insumos_stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($insumos as $insumo):
                        ?>
                            <option value="<?= htmlspecialchars($insumo['id_insumo']) ?>"><?= htmlspecialchars($insumo['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Campo de Cantidad -->
                <div>
                    <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad:</label>
                    <input type="number" name="cantidad" id="cantidad" min="1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Ingrese la cantidad">
                </div>

                <!-- Botón de Envío -->
                <div>
                    <button type="submit" name="pedir" value="pedirInsumo" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Solicitar Insumo
                    </button>
                </div>
            </form>
        </div>
        <?php
        }
        ?>
        <div>
    </div>


</body>
</html>