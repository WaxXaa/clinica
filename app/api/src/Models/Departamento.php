<?php
class Departamento {
    private $conn;
    private $table = 'departamento';
    public $nombre;
    public $id;

    public function __construct($db) {
        $this->conn = $db;
    }
    //metodo para obtenerl los departamentos
    public function getDepartamentos(){
        $query = 'SELECT * FROM ' . $this->table . ';';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $departamentos = [];
        while ($depa =  $stmt->fetch(PDO::FETCH_ASSOC)) {
          array_push($departamentos,$depa);
        }
        $this->db = null;
        return $departamentos;
    }
  }