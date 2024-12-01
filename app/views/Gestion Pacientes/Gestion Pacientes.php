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

$usuarios_query = "SELECT e.nombre as nombre, d.nombre AS seguro, r.nombre AS rol, r.id_rol AS id_rol FROM empleado AS e JOIN departamento AS d on e.departamento = d.id_departamento JOIN rol AS r on e.rol = r.id_rol WHERE usuario = :user_id;";
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
<body class="flex justify-start items-start h-screen bg-[#EAFCF3] text-white" x-data="{ sidebarOpen: true, isDark: false, openProfile: false, openStatus: false }" x-init="initializeSidebarToggleButton()">
  <!-- Header -->
  <?php include_once '../../views/header.php'; ?>
  <!-- Sidebar -->
  <aside :class="sidebarOpen ? 'w-1/6' : 'w-28'" class="relative  h-screen p-5 pt-20 transition-all duration-700 flex flex-col space-y-4">
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
    $stmt->bindParam(':role', $user_role);
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
  <div class="flex-1 p-5 space-y-5 mt-10 text-black">
    <!-- Contenedor Principal -->
    <div id="main-container-modulos" class=" rounded-lg p-5 shadow-md grid grid-cols-2 gap-4">
      <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            $success = "Paciente registrado correctamente.";
          } else {
            $error = "Error al registrar paciente. Por favor, inténtelo de nuevo.";
          }
        }
      }
      ?>
      <div id="registro-paciente" class="bg-[#F8FFFE] p-5 rounded-lg shadow-md shadow-green-400/50">
        <h1 class="text-lg">Registrar Paciente</h1>

        <div class="mt-6">
          <!-- Display messages -->
          <?php if (isset($success)): ?>
            <p class="text-green-700 text-lg mb-4"><?= $success ?></p>
          <?php endif; ?>
          <?php if (isset($error)): ?>
            <p class="text-red-700 text-lg mb-4"><?= $error ?></p>
          <?php endif; ?>

          <!-- Registration form -->
          <form method="POST" class=" p-6 space-y-4">
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
      <div id="lista-pacientes" class="bg-[#F8FFFE] p-4 rounded-lg  shadow-md shadow-green-400/50">
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
                <th class="px-4 py-2">Telefono</th>
                <th class="px-4 py-2">Seguro</th>
                <th class="px-4 py-2">Numero Seguro</th>
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
      <div id="registro-ingreso" class="bg-[#F8FFFE] p-4 rounded-lg  shadow-md shadow-green-400/50">
      <h2 class="text-2xl font-semibold mb-4">Ingreso de Paciente Al Hospital</h2>
          <!-- Display messages -->
          <?php if (isset($success)): ?>
            <p class="text-green-700 text-lg mb-4"><?= $success ?></p>
          <?php endif; ?>
          <?php if (isset($error)): ?>
            <p class="text-red-700 text-lg mb-4"><?= $error ?></p>
          <?php endif; ?>

          <!-- Ingreso form -->
          <form method="POST" class="bg-white p-6 rounded space-y-4">
            <input type="hidden" name="registrarIngreso" value="registrarIngreso">
            <div>
              <label class="block text-gray-700">Cédula del Paciente:</label>
              <input type="text" name="cedula" required class="w-full p-2 border rounded-md">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Registrar Ingreso</button>
          </form>
      </div>
      <div id="alta-paciente" class="bg-[#F8FFFE] p-4 rounded-lg  shadow-md shadow-green-400/50">
        <h2 class="text-2xl font-semibold mb-4">Alta de Paciente</h2>
        <form action="alta_paciente.php" method="POST" class="space-y-4">
            <div>
                <label for="cedula" class="block text-sm font-medium">Cédula del Paciente:</label>
                <input type="text" id="cedula" name="cedula" class="border p-2 w-full" required>
            </div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Dar de Alta</button>
        </form>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', cargarDatos);

    let paginaActual = 1;
    function cargarDatos() {
      const tablaBody = document.getElementById('tabla-body');
      const paginacionContainer = document.getElementById('paginacion-container');
      const busqueda = document.getElementById('busqueda').value;

      fetch(`tabla.php?pagina=${paginaActual}&busqueda=${encodeURIComponent(busqueda)}`)
        .then(response => {
          console.log('response', response);
          return response.json()
        })
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
                <td class="border px-4 py-2">${fila.correo}</td>
                <td class="border px-4 py-2">${fila.telefono}</td>
                <td class="border px-4 py-2">${fila.seguro}</td>
                <td class="border px-4 py-2">${fila.numero_seguro}</td>
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
