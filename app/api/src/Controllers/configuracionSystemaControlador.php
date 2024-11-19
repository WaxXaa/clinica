<?php
include_once 'Database.php';
include_once 'Configuracion.php';

class SystemConfigController {
    private $configModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->configModel = new SystemConfigModel($db);
    }

    // Obtener todas las configuraciones
    public function getAllConfigs() {
        return $this->configModel->getAllConfigs();
    }

    // Obtener configuración por clave
    public function getConfigByKey($key) {
        return $this->configModel->getConfigByKey($key);
    }

    // Actualizar configuración
    public function updateConfig($key, $value) {
        return $this->configModel->updateConfig($key, $value);
    }

    // Crear nueva configuración
    public function createConfig($key, $value) {
        return $this->configModel->createConfig($key, $value);
    }
}
?>
