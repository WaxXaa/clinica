<?php
include_once 'Database.php';
include_once 'UserModel.php';

class UserController {
    private $userModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->userModel = new UserModel($db);
    }

    // Crear un nuevo usuario
    public function createUser($nombre, $email, $password, $roleId) {
        return $this->userModel->createUser($nombre, $email, $password, $roleId);
    }

    // Obtener todos los usuarios
    public function getAllUsers() {
        return $this->userModel->getAllUsers();
    }

    // Obtener un usuario por ID
    public function getUserById($id) {
        return $this->userModel->getUserById($id);
    }

    // Actualizar usuario
    public function updateUser($id, $nombre, $email, $roleId) {
        return $this->userModel->updateUser($id, $nombre, $email, $roleId);
    }

    // Desactivar usuario
    public function deactivateUser($id) {
        return $this->userModel->deactivateUser($id);
    }

    // Activar usuario
    public function activateUser($id) {
        return $this->userModel->activateUser($id);
    }
}
?>
