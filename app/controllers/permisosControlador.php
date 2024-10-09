<?php
include_once 'Database.php';
include_once 'Permiso.php';

class PermissionController {
    private $permissionModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->permissionModel = new PermissionModel($db);
    }

    // Obtener todos los permisos
    public function getAllPermissions() {
        return $this->permissionModel->getAllPermissions();
    }

    // Obtener permisos por rol
    public function getPermissionsByRole($roleId) {
        return $this->permissionModel->getPermissionsByRole($roleId);
    }

    // Asignar un permiso a un rol
    public function assignPermissionToRole($permissionId, $roleId) {
        return $this->permissionModel->assignPermissionToRole($permissionId, $roleId);
    }
}
?>
