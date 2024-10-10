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
    $usuarioModelo = new Usuario($this-db, $_POST['correo'], $_POST['contra']);
    $loginSuccess = $usuarioModelo->login();
    if ($loginSuccess) {
      $_SESSION['id'] = $usuarioModelo->id;
      header('Location: ../views/admin.php')
    } else {
      echo 'credenciales incorrectas';
    }
  }
}
?>