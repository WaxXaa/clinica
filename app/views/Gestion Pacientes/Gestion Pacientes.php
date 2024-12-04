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

$usuarios_query = "SELECT e.nombre as nombre,d.id_departamento, d.nombre AS seguro, r.nombre AS rol, r.id_rol AS id_rol, e.id_empleado AS id_empleado FROM empleado AS e JOIN departamento AS d on e.departamento = d.id_departamento JOIN rol AS r on e.rol = r.id_rol WHERE usuario = :user_id;";
$stmt = $conn->prepare($usuarios_query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT); // Aseguramos que sea un número entero
$stmt->execute();
$usuarios_result = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener todos los resultados
$user_rol = $usuarios_result['id_rol'];
$departamento = $usuarios_result['id_departamento'];
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
    .fade-out {
            transition: opacity 1s ease-out;
            opacity: 0;
        }
  </style>
</head>
<body class="flex justify-start items-start bg-[#EAFCF3] h-screen text-white" x-data="{ sidebarOpen: true, isDark: false, openProfile: false, openStatus: false }" x-init="initializeSidebarToggleButton()">
  <!-- Header -->
  <?php include_once '../../views/header.php'; ?>
  <!-- Sidebar -->
  <aside :class="sidebarOpen ? 'w-1/6' : 'w-28'" class="relative top-0 left-0 h-screen p-5 pt-20 transition-all duration-700 flex flex-col space-y-4">
    <!-- modulo de inicio-->
    <div id="homeLink" class="section-button flex items-center space-x-2 py-2 px-3 rounded-md transition-all duration-300 group hover:bg-gradient-to-r from-lime-400 via-emerald-400 to-teal-400" :class="!sidebarOpen ? 'justify-center' : ''">
      <a href="../../../index.php">
        <span class="font-bold text-black group-hover:text-white transition-colors duration-300" x-show="sidebarOpen" x-transition>
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
      <div id="<?php echo $module['nombre']; ?>" class="section-button flex items-center space-x-2 py-2 px-3 rounded-md transition-all duration-300 group hover:bg-gradient-to-r from-lime-400 via-emerald-400 to-teal-400" :class="!sidebarOpen ? 'justify-center' : ''">
        <a href="<?php echo '../' . $module['nombre'] . '/'. $module['nombre'] . '.php'?>">
          <span class="font-bold text-black group-hover:text-white transition-colors duration-300" x-show="sidebarOpen" x-transition>
            <?php echo htmlspecialchars($module['nombre']); ?>
          </span>
        </a>
      </div>
    <?php endforeach; ?>
  </aside>

  <!-- Contenido Principal -->
  <div class="flex-1 text-black h-[96%]" style="position: relative; top: 30px;">
    <!-- Contenedor Principal con scroll -->
    <div id="main-container-modulos" class="overflow-y-auto h-full rounded-lg p-5 shadow-md grid grid-cols-2 gap-4">
      <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['registrarPaciente'])) {
          $nombre = $_POST['nombre'];
          $apellido = $_POST['apellido'];
          $cedula = $_POST['cedula'];
          $fecha_nacimiento = $_POST['fecha_nacimiento'];
          $genero = $_POST['genero'];
          $direccion = $_POST['direccion'];
          $telefono = $_POST['telefono'];
          $correo = $_POST['correo'];
          $descripcion = $_POST['descripcion'];
          $seguro = $_POST['seguro'];
          $numero_seguro = $_POST['numero_seguro'];

          $stmt_check = $conn->prepare("SELECT id_paciente FROM pacientes WHERE correo = :correo");
          $stmt_check->bindParam(":correo", $correo);
          $stmt_check->execute();

          if ($stmt_check->rowCount() > 0) {
            $error = "El correo ya está registrado.";
          } else {
            $stmt = $conn->prepare("INSERT INTO pacientes (nombre, apellido, cedula, fecha_nacimiento, sexo, direccion, telefono, correo, observaciones, id_seguro, numero_seguro) VALUES (:nombre, :apellido, :cedula, :fecha_nacimiento, :genero, :direccion, :telefono, :correo, :observaciones, :seguro, :numero_seguro);");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':cedula', $cedula);
            $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
            $stmt->bindParam(':genero', $genero);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':observaciones', $descripcion);
            $stmt->bindParam(':seguro', $seguro);
            $stmt->bindParam(':numero_seguro', $numero_seguro);

            if ($stmt->execute()) {
              $success_registrar_paciente = "Paciente registrado correctamente.";
            } else {
              $error_registrar_paciente = "Error al registrar paciente. Por favor, inténtelo de nuevo.";
            }
          }
        }
        elseif (isset($_POST['registrarIngreso'])) {
          $cedula = $_POST['cedula'];
          $causa_ingreso = $_POST['causa_ingreso'];
          $departamentoIngreso = $_POST['departamento'];
          $cedula = trim($cedula);
          $causa_ingreso = trim($causa_ingreso);
          try {
            //code...
            $stmt_check = $conn->prepare("SELECT id_paciente FROM pacientes WHERE cedula = :cedula");
            $stmt_check->bindParam(":cedula", $cedula);
            $stmt_check->execute();
            if ($stmt_check->rowCount() > 0) {
              $paciente = $stmt_check->fetch(PDO::FETCH_ASSOC);
              $id_paciente = $paciente['id_paciente'];
              $stmt_check = $conn->prepare("SELECT * FROM Expediente WHERE paciente = :id_paciente AND (estado = 'Ingresado' OR estado = 'En Atencion')");
              $stmt_check->bindParam(":id_paciente", $id_paciente);

              $paciente = $stmt_check->fetch(PDO::FETCH_ASSOC);
              if ($stmt_check->rowCount() > 0) {
                  $error = "El paciente ya se encuentra ingresado o en atención.";
              } else {
  
                // Registrar el ingreso del paciente
                $stmt = $conn->prepare("CALL registrarIngresoPaciente(:departamento,:id_paciente, :causa_ingreso)");
                $stmt->bindParam(':id_paciente', $id_paciente);
                $stmt->bindParam(':causa_ingreso', $causa_ingreso);
                $stmt->bindParam(':departamento', $departamentoIngreso);
    
                if ($stmt->execute()) {
                    $success_registrar_ingreso = "Ingreso del paciente registrado correctamente.";
                } else {
                    $error_registrar_ingreso = "Error al registrar el ingreso del paciente. Por favor, inténtelo de nuevo.";
                }
              }
            }else {
              $error = "Paciente no encontrado.";
          }
          } catch (PDOException $e) {
            $error_registrar_ingreso = 'Error: ' . $e->getMessage();
          }
          // Verificar si el paciente existe
            
        } elseif (isset($_POST['atender-paciente'])) {
          $id_doctor = $_SESSION['id_empleado']; // Asumiendo que $id_empleado contiene el ID del doctor

          try {
              // Preparar la llamada al procedimiento almacenado
              $stmt = $conn->prepare("CALL asignarDoctor(:id_doctor, @codigo_estado, @mensaje, @datos_paciente)");

              // Enlazar parámetros
              $stmt->bindParam(':id_doctor', $id_doctor, PDO::PARAM_INT);

              // Ejecutar el procedimiento
              $stmt->execute();

              // Obtener los valores de salida
              $select = $conn->query("SELECT @codigo_estado AS codigo_estado, @mensaje AS mensaje, @datos_paciente AS datos_paciente");
              $result = $select->fetch(PDO::FETCH_ASSOC);

              $codigo_estado = (int)$result['codigo_estado'];
              $mensaje = $result['mensaje'];
              $datos_paciente = $result['datos_paciente'];

              // Manejar el resultado basado en el código de estado
              switch ($codigo_estado) {
                  case 1:
                      // Éxito: Doctor asignado al paciente
                      $success_asignar_doctor = $mensaje . ' ' . $datos_paciente;
                      break;
                  case 2:
                      // No hay pacientes por atender
                      $error_asignar_doctor = $mensaje;
                      break;
                  case 3:
                      // El doctor no existe
                      $error_asignar_doctor = $mensaje;
                      break;
                  default:
                      // Error no esperado
                      $error_asignar_doctor = 'Ha ocurrido un error inesperado.';
                      break;
              }
          } catch (PDOException $e) {
              // Registro del error (opcional)
              $error_asignar_doctor = 'Ha ocurrido un error inesperado.' . $e->getMessage();
          }
        }
        elseif (isset($_POST['traspaso-paciente'])) {
          $cedula_paciente = $_POST['cedula'];
          $departamentoTraspaso = $_POST['departamento'];
          $cedula_paciente = trim($cedula_paciente);
          $id_doctor = $_SESSION['id_empleado'];
          try {
              // Preparar la llamada al procedimiento almacenado
            $stmt = $conn->prepare("CALL TraspasarAtencion(:id_doctor, :departamento, :cedula_paciente, @codigo_estado, @mensaje)");

            // Enlazar parámetros de entrada
            $stmt->bindParam(':id_doctor', $id_doctor, PDO::PARAM_INT);
            $stmt->bindParam(':departamento', $departamentoTraspaso, PDO::PARAM_INT);
            $stmt->bindParam(':cedula_paciente', $cedula_paciente, PDO::PARAM_INT);

            // Ejecutar el procedimiento
            $stmt->execute();

            // Obtener los valores de salida
            $result = $conn->query("SELECT @codigo_estado AS codigo_estado, @mensaje AS mensaje")->fetch(PDO::FETCH_ASSOC);

            $codigo_estado = (int)$result['codigo_estado'];
            $mensaje = $result['mensaje'];

            // Manejar el resultado basado en el código de estado
            switch ($codigo_estado) {
              case 1:
                // Éxito: Atención traspasada
                $success_traspasar_atencion = $mensaje;
                break;
              case 2:
              case 3:
              case -1:
                // Errores específicos
                $error_traspasar_atencion = $mensaje;
                break;
              default:
                // Error no esperado
                $error_traspasar_atencion = 'Ha ocurrido un error inesperado.';
                break;
            }
          } catch (PDOException $e) {
          // Manejo de errores de conexión u otros errores
           $error_traspasar_atencion = 'Error: ' . $e->getMessage();
          }
        }
        elseif(isset($_POST['alta-paciente'])){
          $cedula_paciente = $_POST['cedula'];
          $cedula_paciente = trim($cedula_paciente);
          $id_doctor = $_SESSION['id_empleado'];
          try {
              // Preparar la llamada al procedimiento almacenado
            $stmt = $conn->prepare("CALL darAltaPaciente(:id_doctor, :cedula_paciente, @codigo_estado, @mensaje)");

            // Enlazar parámetros de entrada
            $stmt->bindParam(':id_doctor', $id_doctor, PDO::PARAM_INT);
            $stmt->bindParam(':cedula_paciente', $cedula_paciente, PDO::PARAM_INT);

            // Ejecutar el procedimiento
            $stmt->execute();

            // Obtener los valores de salida
            $result = $conn->query("SELECT @codigo_estado AS codigo_estado, @mensaje AS mensaje")->fetch(PDO::FETCH_ASSOC);

            $codigo_estado = (int)$result['codigo_estado'];
            $mensaje = $result['mensaje'];

            // Manejar el resultado basado en el código de estado
            switch ($codigo_estado) {
                case 1:
                    // Éxito: Atención traspasada
                    $success_alta_paciente = $mensaje;
                    break;
                case 2:
                case 3:
                case -1:
                    // Error en la transacción
                    $error_alta_paciente = $mensaje;
                    break;
                default:
                    // Error no esperado
                    $error_alta_paciente = 'Ha ocurrido un error inesperado.';
                    break;
            }
          } catch (PDOException $e) {
          // Manejo de errores de conexión u otros errores
           $error_alta_paciente = 'Error: ' . $e->getMessage();
          }
        }
        elseif(isset($_POST['recetar-tratamiento'])){
          $cedula_paciente = $_POST['cedula'];
          $tratamiento = $_POST['receta-tratamiento'];
          $cedula_paciente = trim($cedula_paciente);
          $id_doctor = $_SESSION['id_empleado'];
          try {
              // Preparar la llamada al procedimiento almacenado
            $stmt = $conn->prepare("CALL actualizarTratamiento(:id_doctor, :cedula_paciente,:tratamiento, @codigo_estado, @mensaje)");

            // Enlazar parámetros de entrada
            $stmt->bindParam(':id_doctor', $id_doctor, PDO::PARAM_INT);
            $stmt->bindParam(':cedula_paciente', $cedula_paciente, PDO::PARAM_INT);
            $stmt->bindParam(':tratamiento', $tratamiento, PDO::PARAM_STR);

            // Ejecutar el procedimiento
            $stmt->execute();

            // Obtener los valores de salida
            $result = $conn->query("SELECT @codigo_estado AS codigo_estado, @mensaje AS mensaje")->fetch(PDO::FETCH_ASSOC);

            $codigo_estado = (int)$result['codigo_estado'];
            $mensaje = $result['mensaje'];

            // Manejar el resultado basado en el código de estado
            switch ($codigo_estado) {
                case 1:
                    // Éxito: Atención traspasada
                    $success_recetar_tratamiento = $mensaje;
                    break;
                case 2:
                case 3:
                case -1:
                    // Error en la transacción
                    $error_recetar_tratamiento = $mensaje;
                    break;
                default:
                    // Error no esperado
                    $error_recetar_tratamiento = 'Ha ocurrido un error inesperado.';
                    break;
            }
          } catch (PDOException $e) {
          // Manejo de errores de conexión u otros errores
           $error_recetar_tratamiento = 'Error: ' . $e->getMessage();
          }
        }
        elseif(isset($_POST['recetar-medicamento'])){
          $cedula_paciente = $_POST['cedula'];
          $medicamento = $_POST['receta-medicamento'];
          $cedula_paciente = trim($cedula_paciente);
          $id_doctor = $_SESSION['id_empleado'];
          try {
              // Preparar la llamada al procedimiento almacenado
            $stmt = $conn->prepare("CALL actualizarMedicamentos(:id_doctor, :cedula_paciente,:medicamento, @codigo_estado, @mensaje)");

            // Enlazar parámetros de entrada
            $stmt->bindParam(':id_doctor', $id_doctor, PDO::PARAM_INT);
            $stmt->bindParam(':cedula_paciente', $cedula_paciente, PDO::PARAM_INT);
            $stmt->bindParam(':medicamento', $medicamento, PDO::PARAM_STR);
            // Ejecutar el procedimiento
            $stmt->execute();

            // Obtener los valores de salida
            $result = $conn->query("SELECT @codigo_estado AS codigo_estado, @mensaje AS mensaje")->fetch(PDO::FETCH_ASSOC);

            $codigo_estado = (int)$result['codigo_estado'];
            $mensaje = $result['mensaje'];

            // Manejar el resultado basado en el código de estado
            switch ($codigo_estado) {
                case 1:
                    // Éxito: Atención traspasada
                    $success_recetar_medicamento = $mensaje;
                    break;
                case 2:
                case 3:
                case -1:
                    // Error en la transacción
                    $error_recetar_medicamento = $mensaje;
                    break;
                default:
                    // Error no esperado
                    $error_recetar_medicamento = 'Ha ocurrido un error inesperado.';
                    break;
            }
          } catch (PDOException $e) {
          // Manejo de errores de conexión u otros errores
           $error_recetar_medicamento = 'Error: ' . $e->getMessage();
          }
        }
        elseif(isset($_POST['asignar-examen'])){
          $cedula_paciente = $_POST['cedula'];
          $examen = $_POST['examen'];
          $cedula_paciente = trim($cedula_paciente);
          $id_doctor = $_SESSION['id_empleado'];
          try {
              // Preparar la llamada al procedimiento almacenado
            $stmt = $conn->prepare("CALL asignarExamen(:id_doctor, :cedula_paciente,:examen, @codigo_estado, @mensaje)");

            // Enlazar parámetros de entrada
            $stmt->bindParam(':id_doctor', $id_doctor, PDO::PARAM_INT);
            $stmt->bindParam(':cedula_paciente', $cedula_paciente, PDO::PARAM_INT);
            $stmt->bindParam(':examen', $examen, PDO::PARAM_STR);
            // Ejecutar el procedimiento
            $stmt->execute();

            // Obtener los valores de salida
            $result = $conn->query("SELECT @codigo_estado AS codigo_estado, @mensaje AS mensaje")->fetch(PDO::FETCH_ASSOC);

            $codigo_estado = (int)$result['codigo_estado'];
            $mensaje = $result['mensaje'];

            // Manejar el resultado basado en el código de estado
            switch ($codigo_estado) {
                case 1:
                    // Éxito: Atención traspasada
                    $success_asignar_examen = $mensaje;
                    break;
                case 2:
                case 3:
                case -1:
                    // Error en la transacción
                    $error_asignar_examen = $mensaje;
                    break;
                default:
                    // Error no esperado
                    $error_asignar_examen = 'Ha ocurrido un error inesperado.';
                    break;
            }
          } catch (PDOException $e) {
          // Manejo de errores de conexión u otros errores
           $error_asignar_examen = 'Error: ' . $e->getMessage();
          }
        }
      }
      ?>
      <?php
        
        $controller = new HumanResourcesController();
        $roles_con_PHR1 = $controller->getRolesByPermission('PGP1');

        // Verificar si el rol del usuario actual está en la lista de roles con PHR1
        if (in_array($user_rol, $roles_con_PHR1)) {
        // Mostrar la sección de registro de empleado
        ?>
      <div id="registro-paciente" class="bg-[#F8FFFE] p-5 rounded-lg shadow-md shadow-green-400/50">
        <h2 class="text-2xl font-semibold mb-4">Registrar Paciente</h2>
        <div class="mt-6">
          <!-- Display messages -->
          <?php if (isset($success_registrar_paciente)): ?>
            <p id="success-message" class="text-green-700 text-lg mb-4"><?= htmlspecialchars($success_registrar_paciente) ?></p>
        <?php endif; ?>
        <?php if (isset($error_registrar_paciente)): ?>
            <p id="error-message" class="text-red-700 text-lg mb-4"><?= htmlspecialchars($error_registrar_paciente) ?></p>
        <?php endif; ?>

          <!-- Registration form -->
          <form method="POST" class=" p-6 space-y-4">
          <input type="hidden" name="registrarPaciente" value="registrarPaciente">
            <div>
              <label class="block text-gray-700">Nombre:</label>
              <input type="text" name="nombre" required class="w-full p-2 border rounded-md">
            </div>
            <div>
              <label class="block text-gray-700">Apellido:</label>
              <input type="text" name="apellido" required class="w-full p-2 border rounded-md">
            </div>
            <div>
              <label class="block text-gray-700">Cédula:</label>
              <input type="text" name="cedula" required class="w-full p-2 border rounded-md">
            </div>
            <div>
              <label class="block text-gray-700">Fecha de Nacimiento:</label>
              <input type="date" name="fecha_nacimiento" required class="w-full p-2 border rounded-md">
            </div>
            <script>
              document.addEventListener('DOMContentLoaded', function() {
                const fechaNacimientoInput = document.querySelector('input[name="fecha_nacimiento"]');
                const today = new Date().toISOString().split('T')[0];
                fechaNacimientoInput.setAttribute('max', today);

                fechaNacimientoInput.addEventListener('input', function() {
                  if (this.value > today) {
                    this.value = today;
                  }
                });
              });
            </script>
            <div>
              <label class="block text-gray-700">Género:</label>
              <select name="genero" required class="w-full p-2 border rounded-md">
                <option value="">Seleccionar Género</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
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
            <div>
              <label class="block text-gray-700">Observaciones:</label>
              <textarea placeholder="describa al paciente, alergias, condición..." name="descripcion" required class="w-full p-5 border rounded-md"></textarea>
            </div>
            <div>
              <label for="seguro" class="block text-gray-700">Seguro</label>
              <select name="seguro" id="seguro" require class="w-full p-2 border rounded-md">
                <option value="">Seleccione un Seguro</option>
                <?php
                $query = 'SELECT * FROM seguros;';
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $seguros = [];
                while ($seguro =  $stmt->fetch(PDO::FETCH_ASSOC)) {
                  array_push($seguros, $seguro);
                }
                foreach ($seguros as $seguro) {
                  echo '<option value="' . $seguro['id_seguro'] . '">' . $seguro['nombre'] . '</option>';
                }
                ?>
              </select>
            </div>
            <div>
              <label for="">Número de Seguro</label>
              <input maxlength="50" type="text" name="numero_seguro" id="numero_seguro" required class="w-full p-2 border rounded-md">
            </div>
            <br>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Registrar</button>
          </form>
        </div>
      </div>
      <?php
        }
      ?>
      <?php
        
        $controller = new HumanResourcesController();
        $roles_con_PHR1 = $controller->getRolesByPermission('PGP2');

        // Verificar si el rol del usuario actual está en la lista de roles con PHR1
        if (in_array($user_rol, $roles_con_PHR1)) {
        // Mostrar la sección de registro de empleado
        ?>
      <div id="lista-pacientes" class="bg-[#F8FFFE] p-4 rounded-lg  shadow-md shadow-green-400/50">
        <h2 class="text-2xl font-semibold mb-4">Pacientes registrados</h2>
        <div class="flex items-center mb-4">
          <input 
            type="text" 
            id="busqueda-pacientes-registrados" 
            class="border rounded-lg px-4 py-2 w-full" 
            placeholder="Buscar..." 
            oninput="buscarPacientesRegistrados()" 
          />
        </div>
        <div id="tabla-container-pacientes-registrados" class="overflow-x-auto">
          <table class="table-auto min-w-full border border-gray-200 text-sm">
            <thead class="bg-gray-200">
              <tr>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Apellido</th>
                <th class="px-4 py-2">Cédula</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Telefono</th>
                <th class="px-4 py-2">Seguro</th>
                <th class="px-4 py-2">Numero Seguro</th>
              </tr>
            </thead>
            <tbody id="tabla-body-pacientes-registrados">
              <!-- Contenido cargado dinámicamente -->
            </tbody>
          </table>
        </div>
        <div id="paginacion-container-pacientes-registrados" class="flex items-center justify-between mt-4">
          <!-- Contenido de paginación -->
        </div>
      </div>
      <?php
        }
      ?>
      <?php
        
        $controller = new HumanResourcesController();
        $roles_con_PHR1 = $controller->getRolesByPermission('PGP3');

        // Verificar si el rol del usuario actual está en la lista de roles con PHR1
        if (in_array($user_rol, $roles_con_PHR1)) {
        // Mostrar la sección de registro de empleado
        ?>
      <div id="registro-ingreso" class="bg-[#F8FFFE] p-4 rounded-lg  shadow-md shadow-green-400/50">
      <h2 class="text-2xl font-semibold mb-4">Ingreso de Paciente</h2>
          <!-- Display messages -->
          <!-- Display messages -->
        <?php if (isset($success_registrar_ingreso)): ?>
            <p id="success-message" class="text-green-700 text-lg mb-4"><?= htmlspecialchars($success_registrar_ingreso) ?></p>
        <?php endif; ?>
        <?php if (isset($error_registrar_ingreso)): ?>
            <p id="error-message" class="text-red-700 text-lg mb-4"><?= htmlspecialchars($error_registrar_ingreso) ?></p>
        <?php endif; ?>

          <!-- Ingreso form -->
          <form method="POST" class="bg-white p-6 rounded space-y-4">
            <input type="hidden" name="registrarIngreso" value="registrarIngreso">
            <div>
              <label class="block text-gray-700">Cédula del Paciente:</label>
              <input id="cedula-ingreso"type="text" name="cedula" required class="w-full p-2 border rounded-md">
            </div>
            <label for="departamento" class="block font-medium">Departamento:</label>
                <select id="departamento" name="departamento" class="border rounded-md p-2 w-full mb-2" required>
                    <option value="">Seleccione un departamento</option>
                    <?php
                        include_once '../../api/src/controllers/recursosHumanosControlador.php';
                        $controller = new HumanResourcesController();
                        $departamentos = $controller->getDepartamentos();
                        foreach ($departamentos as $departamento) {
                            if (!in_array($departamento['id_departamento'], [1, 2, 3, 5, 7])) {
                              echo '<option value="' . $departamento['id_departamento'] . '">' . $departamento['nombre'] . '</option>';
                            }
                        }
                    ?>
                </select>
            <textarea name="causa_ingreso" placeholder="Causa de Ingreso"class="w-full p-2 border rounded-md" required></textarea>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Registrar Ingreso</button>
          </form>
      </div>
      <?php
        }
        ?>
        <?php
        
        $controller = new HumanResourcesController();
        $roles_con_PHR1 = $controller->getRolesByPermission('PGP4');

        // Verificar si el rol del usuario actual está en la lista de roles con PHR1
        if (in_array($user_rol, $roles_con_PHR1)) {
        // Mostrar la sección de registro de empleado
        ?>
      <div id="atencion-paciente" class="bg-[#F8FFFE] p-4 rounded-lg  shadow-md shadow-green-400/50">
        <h2 class="text-2xl font-semibold mb-4">Atender Paciente</h2>
        <!-- Display messages -->
        <?php if (isset($success_asignar_doctor)): ?>
            <p id="success-message" class="text-green-700 text-lg mb-4"><?= htmlspecialchars($success_asignar_doctor) ?></p>
        <?php endif; ?>
        <?php if (isset($error_asignar_doctor)): ?>
            <p id="error-message" class="text-red-700 text-lg mb-4"><?= htmlspecialchars($error_asignar_doctor) ?></p>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <input type="hidden" name="atender-paciente" value="atender-paciente">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Atender Paciente</button>
        </form>
        <br>
        <h2 class="text-2xl font-semibold mb-4">Alta de Paciente</h2>
          <!-- Display messages -->
          <!-- Display messages -->
          <?php if (isset($success_alta_paciente)): ?>
            <p id="success-message" class="text-green-700 text-lg mb-4"><?= htmlspecialchars($success_alta_paciente) ?></p>
        <?php endif; ?>
        <?php if (isset($error_alta_paciente)): ?>
            <p id="error-message" class="text-red-700 text-lg mb-4"><?= htmlspecialchars($error_alta_paciente) ?></p>
        <?php endif; ?>
        <form method="POST" class="space-y-4">
            <input type="hidden" name="alta-paciente" value="alta-paciente">
            <div>
                <label for="cedula" class="block text-sm font-medium">Cédula del Paciente:</label>
                <input type="text" id="cedula-alta" name="cedula" class="border p-2 w-full" required>
            </div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Dar de Alta</button>
        </form>
      </div>
        
      <div id="recetar-medicamento-tratamiento" class="bg-[#F8FFFE] p-4 rounded-lg  shadow-md shadow-green-400/50">
      <h2 class="text-2xl font-semibold mb-4">Recetar Tratamiento</h2>
          <!-- Display messages -->
          <!-- Display messages -->
        <?php if (isset($success_recetar_tratamiento)): ?>
            <p id="success-message" class="text-green-700 text-lg mb-4"><?= htmlspecialchars($success_recetar_tratamiento) ?></p>
        <?php endif; ?>
        <?php if (isset($error_recetar_tratamiento)): ?>
            <p id="error-message" class="text-red-700 text-lg mb-4"><?= htmlspecialchars($error_recetar_tratamiento) ?></p>
        <?php endif; ?>

          <!-- Ingreso form -->
          <form method="POST" class="bg-white p-6 rounded space-y-4">
            <input type="hidden" name="recetar-tratamiento" value="recetar-tratamiento">
            <div>
              <label class="block text-gray-700">Cédula del Paciente:</label>
              <input type="text" name="cedula" required class="cedula-receta w-full p-2 border rounded-md">
            </div>
            <textarea id="receta-tratamiento"name="receta-tratamiento" placeholder=""class="w-full p-2 border rounded-md" required></textarea>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Recetar Tratameinto</button>
          </form>
          <h2 class="text-2xl font-semibold mb-4">Recetar Medicamento</h2>
          <!-- Display messages -->
          <!-- Display messages -->
        <?php if (isset($success_recetar_medicamento)): ?>
            <p id="success-message" class="text-green-700 text-lg mb-4"><?= htmlspecialchars($success_recetar_medicamento) ?></p>
        <?php endif; ?>
        <?php if (isset($error_recetar_medicamento)): ?>
            <p id="error-message" class="text-red-700 text-lg mb-4"><?= htmlspecialchars($error_recetar_medicamento) ?></p>
        <?php endif; ?>

          <!-- Ingreso form -->
          <form method="POST" class="bg-white p-6 rounded space-y-4">
            <input type="hidden" name="recetar-medicamento" value="recetar-medicamento">
            <div>
              <label class="block text-gray-700">Cédula del Paciente:</label>
              <input type="text" name="cedula" required class="cedula-receta w-full p-2 border rounded-md">
            </div>
            <textarea id="receta-medicamento"name="receta-medicamento" placeholder=""class="w-full p-2 border rounded-md" required></textarea>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Recetar Medicamentos</button>
          </form>
      </div>
        <div id="confirmation-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <h3 class="text-xl font-semibold mb-4">Confirmar Acción</h3>
          <p class="mb-6">¿Estás seguro de que deseas realizar esta acción?</p>
          <div class="flex justify-end space-x-4">
          <button id="cancel-btn" class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
          <button id="confirm-btn" class="px-4 py-2 bg-blue-500 text-white rounded">Confirmar</button>
          </div>
        </div>
        </div>
    
        <script>
        let formToSubmit;
    
        document.querySelectorAll('button[type="submit"]').forEach(button => {
          button.addEventListener('click', function(event) {
          const form = this.closest('form');
          if (form.checkValidity()) {
            event.preventDefault();
            formToSubmit = form;
            document.getElementById('confirmation-modal').classList.remove('hidden');
          }
          });
        });
    
        document.getElementById('cancel-btn').addEventListener('click', function() {
          document.getElementById('confirmation-modal').classList.add('hidden');
        });
    
        document.getElementById('confirm-btn').addEventListener('click', function() {
          if (formToSubmit) {
          formToSubmit.submit();
          }
        });
        </script>
      <div id="mis-pacientes" class="bg-[#F8FFFE] p-4 rounded-lg  shadow-md shadow-green-400/50">
        <h2 class="text-2xl font-semibold mb-4">Mis Pacientes</h2>
        <div class="flex items-center mb-4">
          <input 
            type="text" 
            id="busqueda-mis-pacientes" 
            class="border rounded-lg px-4 py-2 w-full" 
            placeholder="Buscar..." 
            oninput="buscarMisPacientes()" 
          />
        </div>
        <div id="tabla-container-mis-pacientes" class="overflow-x-auto">
          <table class="table-auto min-w-full border border-gray-200 text-sm">
            <thead class="bg-gray-200">
              <tr>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Apellido</th>
                <th class="px-4 py-2">Cédula</th>
                <th class="px-4 py-2">Causa De Ingreso</th>
                <th class="px-4 py-2">Fecha De Ingreso</th>
                <th class="px-4 py-2">Tratamiento</th>
                <th class="px-4 py-2">Medicamentos</th>
              </tr>
            </thead>
            <tbody id="tabla-body-mis-pacientes">
              <!-- Contenido cargado dinámicamente -->
            </tbody>
          </table>
        </div>
        <div id="paginacion-container-mis-pacientes" class="flex items-center justify-between mt-4">
          <!-- Contenido de paginación -->
        </div>
      </div>
      <div id="traspaso-paciente" class="bg-[#F8FFFE] p-4 rounded-lg  shadow-md shadow-green-400/50">
      <h2 class="text-2xl font-semibold mb-4">Traspasar Paciente a otro Departamento</h2>
        <!-- Display messages -->
        <?php if (isset($success_traspasar_atencion)): ?>
            <p id="success-message" class="text-green-700 text-lg mb-4"><?= htmlspecialchars($success_traspasar_atencion) ?></p>
        <?php endif; ?>
        <?php if (isset($error_traspasar_atencion)): ?>
            <p id="error-message" class="text-red-700 text-lg mb-4"><?= htmlspecialchars($error_traspasar_atencion) ?></p>
        <?php endif; ?>  
      <form method="POST" class="space-y-4">
            <input type="hidden" name="traspaso-paciente" value="traspaso-paciente">
            <div>
                <label for="cedula" class="block text-sm font-medium">Cédula del Paciente:</label>
                <input type="text" id="cedula-traspaso" name="cedula" class="border p-2 w-full" required>
            </div>
            <label for="departamento" class="block font-medium">Departamento:</label>
                <select id="departamento" name="departamento" class="border rounded-md p-2 w-full mb-2" required>
                    <option value="">Seleccione un departamento</option>
                    <?php
                        include_once '../../api/src/controllers/recursosHumanosControlador.php';
                        $controller = new HumanResourcesController();
                        $departamentos = $controller->getDepartamentos();
                        foreach ($departamentos as $departamento) {
                            if (!in_array($departamento['id_departamento'], [1, 2, 3, 5, 7])) {
                              echo '<option value="' . $departamento['id_departamento'] . '">' . $departamento['nombre'] . '</option>';
                            }
                        }
                    ?>
                </select>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Hacer Traspaso</button>
        </form>
      </div>


      <div id="asignar-examen" class="bg-[#F8FFFE] p-4 rounded-lg  shadow-md shadow-green-400/50">
      <h2 class="text-2xl font-semibold mb-4">Asignar Examen</h2>
        <!-- Display messages -->
        <?php if (isset($success_asignar_examen)): ?>
            <p id="success-message" class="text-green-700 text-lg mb-4"><?= htmlspecialchars($success_asignar_examen) ?></p>
        <?php endif; ?>
        <?php if (isset($error_asignar_examen)): ?>
            <p id="error-message" class="text-red-700 text-lg mb-4"><?= htmlspecialchars($error_asignar_examen) ?></p>
        <?php endif; ?>  
      <form method="POST" class="space-y-4">
            <input type="hidden" name="asignar-examen" value="asignar-examen">
            <div>
                <label for="cedula" class="block text-sm font-medium">Cédula del Paciente:</label>
                <input type="text" id="cedula-examen" name="cedula" class="border p-2 w-full" required>
            </div>
            <label for="lista-examenes" class="block font-medium">Examenes:</label>
                <select id="lista-examenes" name="examen" class="border rounded-md p-2 w-full mb-2" required>
                    <option value="">seleccione un examen</option>
                    <?php
                        
                        $examen_query = "SELECT me.id_examen as id_examen, ex.nombre as nombre FROM medicos_examenes as me JOIN examenes as ex on me.id_examen = ex.id_examen WHERE me.id_medico = :medico;";
                        $stmt = $conn->prepare($examen_query);
                        $stmt->bindParam(':medico', $user_rol, PDO::PARAM_STR);
                        $stmt->execute();
                        while ($examen = $stmt->fetch(PDO::FETCH_ASSOC)) {
                              echo '<script>console.log("'.$examen['nombre'].' <br>")</script>';
                              echo '<option value="' . $examen['id_examen'] . '">' . $examen['nombre'] . '</option>';
                        }
                    ?>
                </select>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Asignar Examen</button>
        </form>
      </div>
      <?php
        }
        ?>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', cargarDatosPacientesRegistrados);

    let paginaActualPacientesRegistrados = 1;
    function cargarDatosPacientesRegistrados() {
      const tablaBody = document.getElementById('tabla-body-pacientes-registrados');
      const paginacionContainer = document.getElementById('paginacion-container-pacientes-registrados');
      const busqueda = document.getElementById('busqueda-pacientes-registrados').value;

      fetch(`pacientesRegistrados.php?pagina=${paginaActualPacientesRegistrados}&busqueda=${encodeURIComponent(busqueda)}`)
        .then(response => {
          console.log('response', response);
          return response.json()
        })
        .then(data => {
          const tablaBody = document.getElementById('tabla-body-pacientes-registrados');
          tablaBody.innerHTML = '';

          // Renderiza las filas
          data.data.forEach(fila => {
            const row = `
              <tr class="cursor-pointer">
                <td class="border-2 px-4 py-2">${fila.nombre}</td>
                <td class="border-2 px-4 py-2">${fila.apellido}</td>
                <td class="border-2 px-4 py-2">${fila.cedula}</td>
                <td class="border-2 px-4 py-2">${fila.correo}</td>
                <td class="border-2 px-4 py-2">${fila.telefono}</td>
                <td class="border-2 px-4 py-2">${fila.seguro}</td>
                <td class="border-2 px-4 py-2">${fila.numero_seguro}</td>
              </tr>`;
            tablaBody.innerHTML += row;
          });
          // Add click event listeners to the table rows
          tablaBody.querySelectorAll('tr').forEach(row => {
            row.addEventListener('click', function() {
              const cedula = this.cells[2].textContent.trim(); // Assuming 'cedula' is in the third cell
              document.getElementById('cedula-ingreso').value = cedula;
            });
          });
          // Actualiza la paginación
          const paginacion = document.getElementById('paginacion-container-pacientes-registrados');
          paginacion.innerHTML = '';
          for (let i = 1; i <= data.total_paginas; i++) {
            paginacion.innerHTML += `
              <button onclick="irPaginaPacientesRegistrados(${i})" class="px-2 py-1 border ${i === data.pagina_actual ? 'bg-gray-300' : ''}">
                ${i}
              </button>`;
          }
        })
        .catch(error => {
          console.error('Error al cargar datos:', error);
        });
    }

    function buscarPacientesRegistrados() {
      console.log('buscar');
      paginaActualPacientesRegistrados = 1; // Reinicia a la primera página
      cargarDatosPacientesRegistrados();
    }

    function irPaginaPacientesRegistrados(pagina) {
      paginaActualPacientesRegistrados = pagina;
      cargarDatosPacientesRegistrados();
    }
    console.log('cargarDatos');
    // Cargar primera página al inicio
    cargarDatosPacientesRegistrados();

    //-----------------------------------------------------------------------------------------


    document.addEventListener('DOMContentLoaded', cargarDatosMisPacientes);

    let paginaActualMisPacientes = 1;
    function cargarDatosMisPacientes() {
      const tablaBody = document.getElementById('tabla-body');
      const paginacionContainer = document.getElementById('paginacion-container-mis-pacientes');
      const busqueda = document.getElementById('busqueda-mis-pacientes').value;

      fetch(`misPacientes.php?pagina=${paginaActualMisPacientes}&busqueda=${encodeURIComponent(busqueda)}&doctor=${<?php echo $_SESSION['id_empleado']; ?>}`)
        .then(response => {
          console.log('response', response);
          return response.json()
        })
        .then(data => {
          const tablaBody = document.getElementById('tabla-body-mis-pacientes');
          tablaBody.innerHTML = '';

          // Renderiza las filas
          data.data.forEach(fila => {
            const row = `
              <tr class="cursor-pointer">
                <td class="border px-4 py-2">${fila.nombre}</td>
                <td class="border px-4 py-2">${fila.apellido}</td>
                <td class="border px-4 py-2">${fila.cedula}</td>
                <td class="border px-4 py-2">${fila.causaIngreso}</td>
                <td class="border px-4 py-2">${fila.fecha_ingreso}</td>
                <td class="border px-4 py-2">${fila.tratamiento ? fila.tratamiento : ' '}</td>
                <td class="border px-4 py-2">${fila.medicamentos ? fila.medicamentos : ' '}</td>

              </tr>`;
            tablaBody.innerHTML += row;
          });

          // Add click event listeners to the table rows
          tablaBody.querySelectorAll('tr').forEach(row => {
            row.addEventListener('click', function() {
              const cedula = this.cells[2].textContent.trim();
              const tratamiento = this.cells[5].textContent.trim();
              const medicamento = this.cells[6].textContent.trim(); // Assuming 'cedula' is in the third cell
              document.querySelectorAll('.cedula-receta').forEach(input => input.value = cedula);
              document.querySelector('#receta-tratamiento').value = tratamiento;
              document.querySelector('#receta-medicamento').value = medicamento;
              document.querySelector('#cedula-examen').value = cedula;

            });
          });
          // Actualiza la paginación
          const paginacion = document.getElementById('paginacion-container-mis-pacientes');
          paginacion.innerHTML = '';
          for (let i = 1; i <= data.total_paginas; i++) {
            paginacion.innerHTML += `
              <button onclick="irPaginaMisPacientes(${i})" class="px-2 py-1 border ${i === data.pagina_actual ? 'bg-gray-300' : ''}">
                ${i}
              </button>`;
          }
        })
        .catch(error => {
          console.error('Error al cargar datos:', error);
        });
    }

    function buscarMisPacientes() {
      console.log('buscar');
      paginaActualMisPacientes = 1; // Reinicia a la primera página
      cargarDatosMisPacientes();
    }

    function irPaginaMisPacientes(pagina) {
      paginaActualMisPacientes = pagina;
      cargarDatosMisPacientes();
    }
    console.log('cargarDatos');
    // Cargar primera página al inicio
    cargarDatosMisPacientes();


    // Ocultar mensajes después de 7 segundos
    setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            var errorMessage = document.getElementById('error-message');
            if (successMessage) {
                successMessage.classList.add('fade-out');
            }
            if (errorMessage) {
                errorMessage.classList.add('fade-out');
            }
        }, 7000);
  </script>
</body>
</html>
