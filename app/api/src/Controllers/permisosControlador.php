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

    
}
?>
