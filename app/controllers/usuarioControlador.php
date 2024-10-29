<?php
include_once '../core/Database.php';
include_once '../models/Usuario.php';

class UserController {
    private $userModel;

    public function __construct($user, $contra) {
        $database = new Database();
        $db = $database->connect();
        $this->userModel = new UserModel($db, $user, $contra);
    }

    // Crear un nuevo usuario
    public function createUser(){
        if($this->userModel->crearUsuario()) {
            $message = "usuario registrado exitosamente.";
            $message_type = "success";
        } else {
            $message = "Error al registrar el usuario. Verifica que los datos esten correctos y vuelve a intentarlo. si sigue saliendo error el sistema esta caido, intenta mas tarde.";
            $message_type = "error";
        }
        session_start();
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $message_type;
        
        
        header("Location: ../views/mensaje/mensaje.php");
        $this->db = null;
        exit();
    }

    // Obtener todos los usuarios
    public function getAllUsers() {
        return $this->userModel->getAllUsers();
    }
}
?>
