<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/../../../../public/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../../../../public/phpmailer/src/Exception.php';
require_once __DIR__ . '/../../../../public/phpmailer/src/PHPMailer.php';

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
        $cedula = $data['cedula'];
        $departamento = $data['departamento'];
        $rol = $data['rol'];
        $turno = $data['turno'];
        $email = $data['email'];
        $salario = $data['salario'];
        $username = $data['user'];
        $password = $data['contra'];
        $nuevoEmpleado = $empleado->crearEmpleado($nombre, $apellido, $cedula, $departamento, $username, $password, $rol, $turno, $email, $salario);
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
        exit();
    }
    public function editarSalario($cedula, $salario) {
        $empleado = new Empleado($this->db);
        $salarioEditado = $empleado->editarSalario($cedula, $salario);
        if($salarioEditado) {
            $message = "Salario actualizado exitosamente.";
            $message_type = "success";
        } else {
            $message = "Error al actualizar el salario. Verifica que los datos esten correctos y vuelve a intentarlo. si sigue saliendo error el sistema esta caido, intenta mas tarde.";
            $message_type = "error";
        }
        session_start();
      
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $message_type;
      
        header("Location: ../../../views/mensaje/mensaje.php");
        exit();
    }
    public function editarTurno($cedula, $turno) {
        $empleado = new Empleado($this->db);
        $turnoEditado = $empleado->editarTurno($cedula, $turno);
        if($turnoEditado) {
            $message = "Turno actualizado exitosamente.";
            $message_type = "success";
        } else {
            $message = "Error al actualizar el turno. Verifica que los datos esten correctos y vuelve a intentarlo. si sigue saliendo error el sistema esta caido, intenta mas tarde.";
            $message_type = "error";
        }
        session_start();
      
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $message_type;
      
        header("Location: ../../../views/mensaje/mensaje.php");
        exit();
    }
    public function getRolesByPermission($permiso_id) {
        $query = "SELECT rol FROM rol_permisos WHERE permiso = :permiso";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':permiso', $permiso_id);
        $stmt->execute();
        $roles = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $roles;
    }

    // Método para asignar un rol a un empleado
    public function assignRoleToEmployee($employeeId, $roleId) {
        return $this->employeeModel->assignRoleToEmployee($employeeId, $roleId);
    }
    
    
    public function enviarCorreo($email, $asunto, $mensaje) {
        define("CORREO_REMITENTE", "manuelalfonsop@gmail.com");
        define("CORREO_PASS", "xqxk zvqs jcfh rmtn");
        $empleados = new Empleado($this->db);
        $nombreEmpleado = $empleados->getNombreEmpleado($email);
            //Enviar email
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = constant('CORREO_REMITENTE');                     //SMTP username
            $mail->Password   = constant('CORREO_PASS');                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;

            //Recipients
            $mail->setFrom(constant('CORREO_REMITENTE'), 'Clinica Hispital');
            $mail->addAddress($email);     //Add a recipient
            //plantilla HTML

            $mensajeHTML='
                <p align="center">Estimado Colaborador: '. $nombreEmpleado.' </p>
                <p align="center">'.$mensaje.'</p>
                <p>Atentamente Recursos Humanos </p>';


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body    = $mensajeHTML;
            $mail->AltBody = 'Este es Un Mensaje de Recursos Humanos';

            $mail->send();
    }
}
?>
