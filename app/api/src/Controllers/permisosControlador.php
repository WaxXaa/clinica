<?php
include_once 'Database.php';
include_once 'Permiso.php';

class PermissionController {
    private $db;
    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->permissionModel = new PermissionModel($db);
    }

    
    
}
?>
