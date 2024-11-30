<?php
include_once __DIR__ . '/../Core/Database.php';
include_once __DIR__ . '/../Models/Rol.php';
include_once __DIR__ . '/../Models/Empleado.php';
include_once __DIR__ . '/../Models/Departamento.php';

class HumanResourcesController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // un metodo para traer todos los departamentos
    public function getDepartamentos() {
        $departamentos = new Departamento($this->db);
        return $departamentos->getDepartamentos();
    }
    // un metodo para traer todos los roles de un departamento
    public function getRolesDepartamento($departmento) {
        $rol = new Rol($this->db);
        return $rol->getRolesDepartamento($departmento);
    }

    // un metodo para obtener los turnos
    public function getTurnos() {
        $empleado = new Empleado($this->db);
        return $empleado->getTurnos();
    }

    // Método para crear un nuevo empleado
    public function createEmpleado($data) {
        $empleado = new Empleado($this->db);
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $departamento = $data['departamento'];
        $rol = $data['rol'];
        $turno = $data['turno'];
        $email = $data['email'];
        $salario = $data['salario'];
        $username = $data['user'];
        $password = $data['contra'];
        $nuevoEmpleado = $empleado->crearEmpleado($nombre, $apellido, $departamento, $username, $password, $rol, $turno, $email, $salario);
        if($nuevoEmpleado) {
            $message = "empleado registrado exitosamente.";
            $message_type = "success";
        } else {
            $message = "Error al registrar empleado. Verifica que los datos esten correctos y vuelve a intentarlo. si sigue saliendo error el sistema esta caido, intenta mas tarde.";
            $message_type = "error";
        }
        session_start();
      
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $message_type;
      
        header("Location: ../../../views/mensaje/mensaje.php");
        $this->db = null;
        exit();
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
