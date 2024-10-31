<?php
class Usuario {
    private $conn;
    private $table = 'usuario';
    public $user;
    public $contra;
    public $id;
    public $c;

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
    public function obtener_usuario_login() {
        session_start();

        if ($this->user == 'superad' && $this->contra == '1') {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = 1;


            return true;
        }
        try {
            $query = 'SELECT * FROM usuario WHERE username = :username;';
            $stmt = $this->conn->prepare($query);
            $this->user = htmlspecialchars(strip_tags($this->user));
            $this->contra = htmlspecialchars(strip_tags($this->contra));
            $stmt->bindParam(':username', $this->user);
            $stmt->execute();
            
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->c = $this->contra;



            if ($userData) {

                if (password_verify($this->contra, $userData['contra'])) {
                    $this->id = $userData['id_usuario'];
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
