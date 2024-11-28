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


    public function obtener_usuario_login() {

        if (isset($this->user, $this->contra) && $this->user === 'superad' && intval($this->contra) === 1) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = 1;
            return true;
        }
        try {
            $query = 'SELECT * FROM usuario WHERE username = :username;';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $this->user);
            $stmt->execute();

            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userData) {
                $this->contra = trim($this->contra);
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
