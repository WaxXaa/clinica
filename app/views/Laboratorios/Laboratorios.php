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
$user_rol = $usuarios_result['id_rol'];
$user_department = $usuarios_result['departamento'];
include_once '../../api/src/controllers/recursosHumanosControlador.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratorios</title>
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

            <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if(isset($_POST['realizar-examen'])){
                $id_examen = $_POST['numero_examen_realizado'];
                try{
                    $stmt = $conn->prepare("CALL indicarExamenRealizado(:id_examen_paciente, @codigo_estado, @mensaje)");

                // Enlazar parámetros de entrada
                $stmt->bindParam(':id_examen_paciente', $id_examen, PDO::PARAM_INT);

                // Ejecutar el procedimiento
                $stmt->execute();

                // Obtener los valores de salida
                $result = $conn->query("SELECT @codigo_estado AS codigo_estado, @mensaje AS mensaje")->fetch(PDO::FETCH_ASSOC);

                $codigo_estado = (int)$result['codigo_estado'];
                $mensaje = $result['mensaje'];

                // Manejar el resultado basado en el código de estado
                switch ($codigo_estado) {
                    case 1:
                        // Éxito: Estado actualizado
                        $success_realizar_examnes = $mensaje;
                        break;
                    case 2:
                    case -1:
                        // Error en la transacción
                        $error_realizar_examenes = $mensaje;
                        break;
                    default:
                        // Error no esperado
                        $error_realizar_examenes = 'Ha ocurrido un error inesperado.';
                        break;
                }
            } catch (PDOException $e) {
                // Manejo de errores de conexión u otros errores
                $error_realizar_examenes = 'Error: ' . $e->getMessage();
            }
                    }
                    if(isset($_POST['resultados-listos'])){
                        $id_examen = $_POST['numero_examen_listo'];
                        try{
                            $stmt = $conn->prepare("CALL indicarResultadosListos(:id_examen_paciente, @codigo_estado, @mensaje)");
        
                        // Enlazar parámetros de entrada
                        $stmt->bindParam(':id_examen_paciente', $id_examen, PDO::PARAM_INT);
        
                        // Ejecutar el procedimiento
                        $stmt->execute();
        
                        // Obtener los valores de salida
                        $result = $conn->query("SELECT @codigo_estado AS codigo_estado, @mensaje AS mensaje")->fetch(PDO::FETCH_ASSOC);
        
                        $codigo_estado = (int)$result['codigo_estado'];
                        $mensaje = $result['mensaje'];
        
                        // Manejar el resultado basado en el código de estado
                        switch ($codigo_estado) {
                            case 1:
                                // Éxito: Estado actualizado
                                $success_resultado_examen = $mensaje;
                                break;
                            case 2:
                            case -1:
                                // Error en la transacción
                                $error_resultado_examen = $mensaje;
                                break;
                            default:
                                // Error no esperado
                                $error_resultado_examen = 'Ha ocurrido un error inesperado.';
                                break;
                        }
                    } catch (PDOException $e) {
                        // Manejo de errores de conexión u otros errores
                        $error_resultado_examen = 'Error: ' . $e->getMessage();
                    }
                            }
            }
            ?>
            
        <!-- Contenedor Principal -->
        <div id="main-container-modulos" class=" rounded-lg p-5 shadow-md grid grid-cols-2 gap-4">
        
        <?php
        
        $controller = new HumanResourcesController();
        $roles_con_PHR1 = $controller->getRolesByPermission('PLB2');

        // Verificar si el rol del usuario actual está en la lista de roles con PHR1
        if (in_array($user_rol, $roles_con_PHR1)) {
        // Mostrar la sección de registro de empleado
        ?>
        <div id="estados-examenes" class="bg-[#F8FFFE] p-4 rounded-lg  shadow-md shadow-green-400/50">

        <h2 class="text-2xl font-semibold mb-4">Realización de Examen</h2>
          <!-- Display messages -->
          <!-- Display messages -->
        <?php if (isset($success_realizar_examnes)): ?>
            <p id="success-message" class="text-green-700 text-lg mb-4"><?= htmlspecialchars($success_realizar_examnes) ?></p>
        <?php endif; ?>
        <?php if (isset($error_realizar_examenes)): ?>
            <p id="error-message" class="text-red-700 text-lg mb-4"><?= htmlspecialchars($error_realizar_examenes) ?></p>
        <?php endif; ?>

          <!-- Ingreso form -->
          <form method="POST" class="bg-white p-6 rounded space-y-4">
            <input type="hidden" name="realizar-examen" value="realizar-examen">
            <div>
              <label class="block text-gray-700">N° Examen:</label>
              <input type="text" name="numero_examen_realizado" required class="numero_examen w-full p-2 border rounded-md">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Registrar la Realizacion del Examen</button>
          </form>
          </div>

          <?php } ?>
          <?php
        
        $controller = new HumanResourcesController();
        $roles_con_PHR1 = $controller->getRolesByPermission('PLB3');

        // Verificar si el rol del usuario actual está en la lista de roles con PHR1
        if (in_array($user_rol, $roles_con_PHR1)) {
        // Mostrar la sección de registro de empleado
        ?>
        <div id="estados-examenes-res" class="bg-[#F8FFFE] p-4 rounded-lg  shadow-md shadow-green-400/50">

          <h2 class="text-2xl font-semibold mb-4">Indicar Resultados Listos</h2>
          <!-- Display messages -->
          <!-- Display messages -->
        <?php if (isset($success_resultado_examen)): ?>
            <p id="success-message" class="text-green-700 text-lg mb-4"><?= htmlspecialchars($success_resultado_examen) ?></p>
        <?php endif; ?>
        <?php if (isset($error_resultado_examen)): ?>
            <p id="error-message" class="text-red-700 text-lg mb-4"><?= htmlspecialchars($error_recetar_medicamento) ?></p>
        <?php endif; ?>

          <!-- Ingreso form -->
          <form method="POST" class="bg-white p-6 rounded space-y-4">
            <input type="hidden" name="resultados-listos" value="resultados-listos">
            <div>
              <label class="block text-gray-700">N° Examen:</label>
              <input type="text" name="numero_examen_listo" required class="numero_examen w-full p-2 border rounded-md">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Indicar Resultados Listos</button>
          </form>
      </div>

          <?php } ?>
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
        <?php
        
        $controller = new HumanResourcesController();
        $roles_con_PHR1 = $controller->getRolesByPermission('PLB1');

        // Verificar si el rol del usuario actual está en la lista de roles con PHR1
        if (in_array($user_rol, $roles_con_PHR1)) {
        // Mostrar la sección de registro de empleado
        ?>
      <div id="lista-examenes" class="bg-[#F8FFFE] p-4 rounded-lg  shadow-md shadow-green-400/50">
        <h2 class="text-2xl font-semibold mb-4">Examenes</h2>
        <div class="flex items-center mb-4">
          <input 
            type="text" 
            id="busqueda-examenes" 
            class="border rounded-lg px-4 py-2 w-full" 
            placeholder="Buscar..." 
            oninput="buscarExamenes()" 
          />
        </div>
        <div id="tabla-container-mis-pacientes" class="overflow-x-auto">
          <table class="table-auto min-w-full border border-gray-200 text-sm">
            <thead class="bg-gray-200">
              <tr>
                <th class="px-4 py-2">N° Examen</th>
                <th class="px-4 py-2">Nombre Paciente</th>
                <th class="px-4 py-2">Apellido Paciente</th>
                <th class="px-4 py-2">Cédula Paciente</th>
                <th class="px-4 py-2">Nombre del Examen</th>
                <th class="px-4 py-2">Estado</th>
              </tr>
            </thead>
            <tbody id="tabla-body-examenes">
              <!-- Contenido cargado dinámicamente -->
            </tbody>
          </table>
        </div>
        <div id="paginacion-container-examenes" class="flex items-center justify-between mt-4">
          <!-- Contenido de paginación -->
        </div>
      </div>
        <?php } ?>
        <div>
    </div>
        <script>
            
    document.addEventListener('DOMContentLoaded', cargarDatosExamenes);

let paginaActualExamenes = 1;
function cargarDatosExamenes() {
  const paginacionContainer = document.getElementById('paginacion-container-examenes');
  const busqueda = document.getElementById('busqueda-examenes').value;
  console.log('busqueda', busqueda);
  
  fetch(`./listaExamenes.php?pagina=${paginaActualExamenes}&busqueda=${encodeURIComponent(busqueda)}`)
    .then(response => {
      console.log('response', response);
      return response.json()
    })
    .then(data => {
      const tablaBody = document.getElementById('tabla-body-examenes');
      tablaBody.innerHTML = '';

      // Renderiza las filas
      data.data.forEach(fila => {
        const row = `
          <tr class="cursor-pointer">
            <td class="border px-4 py-2">${fila.numExamen}</td>
            <td class="border px-4 py-2">${fila.nombre}</td>
            <td class="border px-4 py-2">${fila.apellido}</td>
            <td class="border px-4 py-2">${fila.cedula}</td>
            <td class="border px-4 py-2">${fila.examen}</td>
            <td class="border px-4 py-2">${fila.estado}</td>
          </tr>`;
        tablaBody.innerHTML += row;
      });

      tablaBody.querySelectorAll('tr').forEach(row => {
        row.addEventListener('click', function() {
          const numExamen = this.cells[0].textContent.trim();
          document.querySelectorAll('.numero_examen').forEach(input => input.value = numExamen);

        });
      });
      // Actualiza la paginación
      const paginacion = document.getElementById('paginacion-container-examenes');
      paginacion.innerHTML = '';
      for (let i = 1; i <= data.total_paginas; i++) {
        paginacion.innerHTML += `
          <button onclick="irPaginaExamenes(${i})" class="px-2 py-1 border ${i === data.pagina_actual ? 'bg-gray-300' : ''}">
            ${i}
          </button>`;
      }
    })
    .catch(error => {
      console.error('Error al cargar datos:', error);
    });
}

function buscarExamenes() {
  console.log('buscar');
  paginaActualExamenes = 1; // Reinicia a la primera página
  cargarDatosExamenes();
}

function irPaginaExamenes(pagina) {
  paginaActualExamenes = pagina;
  cargarDatosExamenes();
}
console.log('cargarDatos');
// Cargar primera página al inicio
cargarDatosExamenes();


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
