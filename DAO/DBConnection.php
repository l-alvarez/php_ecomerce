<?php

include_once '../Config/config.php';

class DBConnection {

    private $conn;

    public function getMySQLIConn() {
        if (!($this->conn = mysqli_connect(SERVER, USER, PSW))) {
            die("Error: No se pudo conectar");
        }

        if (!mysqli_select_db($this->conn, "sce_db")) {
            die("Error: No existe la base de datos");
        }

        return $this->conn;
    }

    public function getMySQLConn() {
        if (!($this->conn = mysql_connect(SERVER, USER, PSW))) {
            die("Error: No se pudo conectar");
        }

        if (!mysql_select_db("sce_db", $this->conn)) {
            die("Error: No existe la base de datos");
        }

        return $this->conn;
    }

}

?>