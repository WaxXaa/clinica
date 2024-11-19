<?php
include_once '../Core/Database.php';
include_once '../Models/Usuario.php';
class SeguridadControlador {
  public $user;
  public $contra;
  public $db;

  public function __construct($user, $contra){
    $this->user = $user;
    $this->contra = $contra;
    $database = new Database();
    $this->db = $database->getConnection();
  }
  public function login(){

    $usuarioModelo = new Usuario($this->db, $this->user, $this->contra);
    if($usuarioModelo->obtener_usuario_login()) {
      $message = "usuario registrado exitosamente.";
      $message_type = "success";
  } else {
      $message = "Error al iniciar sesion. Verifica que los datos esten correctos y vuelve a intentarlo. si sigue saliendo error el sistema esta caido, intenta mas tarde.";
      $message_type = "error";
  }
  session_start();

  $_SESSION['message'] = $message;
  $_SESSION['message_type'] = $message_type;

  header("Location: ../../../../index.php");
  $this->db = null;
  exit();

  }
}
?>