<?php
include_once '../core/Database.php';
include_once '../models/Usuario.php';
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
    session_start();

    $usuarioModelo = new Usuario($this->db, $this->user, $this->contra);
    $loginSuccess = $usuarioModelo->obtener_usuario_login();
    if ($loginSuccess) {
      
      header('Location: ../../index.php');
      exit();
    }else {
      $message = $usuarioModelo->c ."Credenciales Incorrectas. si sigue saliendo error el sistema esta caido, intenta mas tarde." . $loginSuccess;
      $message_type = "error";
      $_SESSION['message'] = $message;
      $_SESSION['message_type'] = $message_type;
  
  
  header("Location: ../views/mensaje/mensaje.php");
  $this->db = null;
  exit();
  }
  }
  
}
?>