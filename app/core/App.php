<?php
include_once '../controllers/usuarioControlador.php';
include_once '../Controllers/seguridadControlador.php';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['login'])) {
    session_start();
    $user = isset($_POST['user']);
    $contra = isset($_POST['contra']);
    if (!empty($user) && !empty($contra)){
      trim($user);
      trim($contra);
      $seguridadController = new SeguridadControlador($user, $contra);
      $seguridadController->login();
    } else {
      echo "Por favor, complete todos los campos.";
    }
  }
  if(isset($_POST['registrar_usuario'])) {
    session_start();
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
}
?>