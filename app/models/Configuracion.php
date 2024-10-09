<?php
class SystemConfigModel {
    private $conn;
    private $table = 'system_config';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todas las configuraciones del sistema
    public function getAllConfigs() {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener configuración por clave
    public function getConfigByKey($key) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE config_key = :key';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':key', $key);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar configuración
    public function updateConfig($key, $value) {
        $query = 'UPDATE ' . $this->table . ' SET config_value = :value WHERE config_key = :key';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':key', $key);
        $stmt->bindParam(':value', $value);
        return $stmt->execute();
    }

    // Crear nueva configuración
    public function createConfig($key, $value) {
        $query = 'INSERT INTO ' . $this->table . ' (config_key, config_value) VALUES (:key, :value)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':key', $key);
        $stmt->bindParam(':value', $value);
        return $stmt->execute();
    }
}
?>
