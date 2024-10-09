<?php
include_once 'Database.php';
include_once 'Empleado.php';

class HumanResourcesController {
    private $employeeModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->employeeModel = new EmployeeModel($db);
    }

    // Método para crear un nuevo empleado
    public function createEmployee($nombre, $email, $roleId) {
        return $this->employeeModel->createEmployee($nombre, $email, $roleId);
    }

    // Obtener un empleado por ID
    public function getEmployeeById($employeeId) {
        return $this->employeeModel->getEmployeeById($employeeId);
    }

    // Obtener todos los empleados
    public function getAllEmployees() {
        return $this->employeeModel->getAllEmployees();
    }

    // Método para asignar un rol a un empleado
    public function assignRoleToEmployee($employeeId, $roleId) {
        return $this->employeeModel->assignRoleToEmployee($employeeId, $roleId);
    }
}
?>
