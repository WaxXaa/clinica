<?php
include_once '../core/Database.php'
include_once '../models/Usuario.php'
session_start();
class SeguridadControlador {
  public $correo;
  public $contra;
  public $db;

  public function __construct($correo, $contra){
    $this->correo = $correo;
    $this->contra = $contra;
    $database = new Database();
    $this->db = $database->connect();
  }
  public function __construct(){}
  public function login(){
    $usuarioModelo = new Usuario($this-db, $correo, $contra);
    $loginSuccess = $usuarioModelo->obtener_usuario_login();
    if ($loginSuccess) {
      $_SESSION['logged_in'] = true;
      $_SESSION['user_id'] = $usuarioModelo->id;
      header('Location: ../views/in')
    } else {
      echo 'credenciales incorrectas';
    }
  }
}
?>