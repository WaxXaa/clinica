<?php
class Usuario {
    private $conn;
    private $table = 'users';
    public $correo;
    public $contra;
    public $id;

    public function __construct($db, $correo, $contra) {
        $this->conn = $db;
        $this->correo = $correo;
        $this->contra = $contra;
    }

    // Crear un nuevo usuario
    public function crearUsuario($rol) {
        try {
            $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->contra = htmlspecialchars(strip_tags($this->contra));
        $rol = htmlspecialchars(strip_tags($rol));
        $query = 'INSERT INTO ' . $this->table . ' CALL p_registrar_usuario(:nombre, :email, :password, :rol)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->correo);
        $stmt->bindParam(':password', password_hash($this->contra, PASSWORD_DEFAULT));
        $stmt->bindParam(':rol', $rol);
        return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
    public static function obtener_usuario_login() {
        try {
            $this->correo = htmlspecialchars(strip_tags($this->correo));
            $this->contra = htmlspecialchars(strip_tags($this->contra));
            $query = 'INSERT INTO ' . $this->table . ' SELECT id, correo, contra FROM usuarios WHERE correo = :correo';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':correo', $this->correo);
            $result = $stmt->execute();
            // Obtener los resultados
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar si la contraseña proporcionada coincide con la almacenada
            if ($user && password_verify($this->password, $user['password'])) {
                $id = $user['id'];
                $this->id = $id;
                return true;
            }
            return false;
            
        } catch (PDOEcxeption $e) {
            return false;
        }
    }
}
?>
