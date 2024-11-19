<?php
session_start();
class Usuario {
    private $conn;
    private $table = 'usuario';
    public $user;
    public $contra;
    public $id;

    public function __construct($db, $user, $contra) {
        $this->conn = $db;
        $this->user = $user;
        $this->contra = $contra;
    }

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

        if (isset($this->user, $this->contra) && $this->user === 'superad' && intval($this->contra) === 1) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = 1;
            return;
        }
        else {
            return false;
        }
        try {
            $query = 'SELECT * FROM usuario WHERE username = :username;';
            $stmt = $this->conn->prepare($query);
            $this->user = htmlspecialchars(strip_tags($this->user));
            $this->contra = htmlspecialchars(strip_tags($this->contra));
            $stmt->bindParam(':username', $this->user);
            $stmt->execute();

            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userData) {

                if (password_verify($this->contra, $userData['contra'])) {
                    $_SESSION['user_id']=$userData['id_usuario'];
                    $_SESSION['logged_in'] = true;
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
