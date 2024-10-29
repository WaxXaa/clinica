<?php
class PermissionModel {
    private $conn;
    private $permissionsTable = 'permissions';
    private $rolePermissionsTable = 'role_permissions';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todos los permisos
    public function getAllPermissions() {
        $query = 'SELECT * FROM ' . $this->permissionsTable;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener permisos por rol
    public function getPermissionsByRole($roleId) {
        $query = 'SELECT p.* FROM ' . $this->permissionsTable . ' p JOIN ' . $this->rolePermissionsTable . ' rp ON p.id = rp.permission_id WHERE rp.role_id = :role_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':role_id', $roleId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Asignar permiso a un rol
    public function assignPermissionToRole($permissionId, $roleId) {
        $query = 'INSERT INTO ' . $this->rolePermissionsTable . ' (permission_id, role_id) VALUES (:permission_id, :role_id)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':permission_id', $permissionId);
        $stmt->bindParam(':role_id', $roleId);
        return $stmt->execute();
    }
}
?>
