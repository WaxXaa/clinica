<?php
include_once '../controllers/usuarioControlador.php';
include_once '../Controllers/seguridadControlador.php';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['login'])) {
    session_start();
    $correo = isset($_POST['correo']);
    $contra = isset($_POST['contra']);
    if (!empty($correo) && !empty($contra)){
      trim($correo);
      trim($contra);
      $seguridadControlador = new SeguridadControlador($correo, $contra);
      $seguridadControlador->login();
    } else {
      echo "Por favor, complete todos los campos.";
    }
  }
}
?>