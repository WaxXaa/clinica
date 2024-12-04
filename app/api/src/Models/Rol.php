<?php

class Rol {
    private $conn;
    private $table = 'rol';
    public $nombre;
    public $tipo;
    public $departamento;

    public function __construct($db) {
        $this->conn = $db;
    }
    //metodo para obtenerl los roles de un departamento
    public function getRolesDepartamento($departamento) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE departamento = :id_departamento';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_departamento', $departamento);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  }