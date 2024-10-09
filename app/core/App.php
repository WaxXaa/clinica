<?php
include_once '../controllers/usuarioControlador.php'
include_once '../Controllers/seguridadControlador.php'
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['login'])) {
    session_start();
    $seguridadControlador = new SeguridadControlador();
    $seguridadControlador->login();
  }
}
?>