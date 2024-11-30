<?php
include_once '../controllers/usuarioControlador.php';
include_once '../Controllers/seguridadControlador.php';
include_once '../Controllers/recursosHumanosControlador.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['login'])) {
    $user = $_POST['user'];
    $contra = $_POST['contra'];
    if (!empty($user) && !empty($contra)){
      $seguridadController = new SeguridadControlador($user, $contra);
      $seguridadController->login();
    } else {
      echo "Por favor, complete todos los campos.";
    }
  }
  if(isset($_POST['registrar_usuario'])) {
    $user = isset($_POST['user']);
    $contra = isset($_POST['contra']);
    if (!empty($user) && !empty($contra)){
      trim($user);
      trim($contra);
      $usuarioController = new usuarioControlador($user, $contra);
      $usuarioController->createUser();
    } else {
      echo "Por favor, complete todos los campos.";
    }
  }
  if(isset($_POST['registrarEmpleado'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $departamento = $_POST['departamento'];
    $rol = $_POST['rol'];
    $user = $_POST['user'];
    $contra = $_POST['contra'];
    $turno = $_POST['turno'];
    $email = $_POST['email'];
    $salario = $_POST['salario'];
    if (!empty($nombre) && !empty($apellido) && !empty($departamento) && !empty($rol) && !empty($user) && !empty($contra) && !empty($turno) && !empty($salario)){
      trim($nombre);
      trim($apellido);
      trim($email);

      trim($user);
      trim($contra);

      $data = [
        'nombre' => $nombre,
        'apellido' => $apellido,
        'departamento' => $departamento,
        'rol' => $rol,
        'user' => $user,
        'contra' => $contra,
        'turno' => $turno,
        'email' => $email,
        'salario' => $salario
      ];
      $controlador = new HumanResourcesController();
      $controlador->createEmpleado($data);
    } else {
      echo "Por favor, complete todos los campos.";
    }
  }
  $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['url'])) {
        switch ($data['url']) {
            case 'getRolesDepartamento':
                if (isset($data['id_departamento'])) {
                    $id_departamento = $data['id_departamento'];
                    $controlador = new HumanResourcesController();
                    $roles = $controlador->getRolesDepartamento($id_departamento);
                    echo json_encode($roles);
                    exit();
                } else {
                    echo json_encode(['error' => 'id_marca no proporcionado']);
                    exit();
                }
                break;
            default:
                echo json_encode(['error' => '404 - not found']);
                break;
        }
    }
}
?>