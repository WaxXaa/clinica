<?php
class Usuario {
    private $conn;
    private $table = 'users';
    public $user;
    public $contra;
    public $id;

    public function __construct($db, $user, $contra) {
        $this->conn = $db;
        $this->user = $user;
        $this->contra = $contra;
    }

    // Crear un nuevo usuario
    public function crearUsuario() {
        try {
            $this->user = htmlspecialchars(strip_tags($this->user));
        $this->contra = htmlspecialchars(strip_tags($this->contra));
        $query = 'INSERT INTO ' . $this->table . 'CALL p_registrar_usuario(:username, :contra)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user', $this->user);
        $stmt->bindParam(':contra', password_hash($this->contra, PASSWORD_DEFAULT));
        return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
    public static function obtener_usuario_login() {
        try {
            $this->user = htmlspecialchars(strip_tags($this->user));
            $this->contra = htmlspecialchars(strip_tags($this->contra));
            $query = 'INSERT INTO ' . $this->table . ' SELECT id, username, contra FROM usuarios WHERE username = :username';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $this->user);
            $result = $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user){
                if($user[$user] === 'superad'){
                    if ($this->contra === $user['contra']) {
                        $this->id = $user['id'];
                        return true;
                    }
                }
                if (password_verify($this->password, $user['contra'])) {
                    $this->id = $user['id'];
                    return true;
                }
                return false;
            }
            
            
        } catch (PDOEcxeption $e) {
            return false;
        }
    }
}
?>
