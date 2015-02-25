<?php

class DBConnection {

    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $conn;

    public function getConn() {
        if (!($this->conn = mysql_connect($this->servername, $this->username, $this->password)))
            die("Error: No se pudo conectar");

        // Selecciona la base de datos 
        if (!mysql_select_db("sce_db", $this->conn))
            die("Error: No existe la base de datos");
        
        return $this->conn;
    }

    /*public function getConnection() {
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password);
        mysql_select_db("sce_db", $this->conn);
// Check connection
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
            echo $this->conn;
        }

        return $this->conn;
    }*/

//echo "Connected successfully";
}

?>