<?php
include_once '../Config/config.php';

class DBConnection {

    private $conn;

    public function getConn() {
        if (!($this->conn = mysql_connect(SERVER, USER, PSW)))
            die("Error: No se pudo conectar");

        // Selecciona la base de datos 
        if (!mysql_select_db("sce_db", $this->conn))
            die("Error: No existe la base de datos");
        
        return $this->conn;
    }
}

?>