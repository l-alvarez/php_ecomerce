<?php

include_once 'DBConnection.php';

class DAOCode extends DBConnection{

    public function selectAll() {
        $con = parent::getMySQLConn();
        $sentencia = "SELECT * FROM codigo";
        $resultado = mysql_query($sentencia, $con);
        mysql_close($con);
        return $resultado;
    }

    public function selectOne($code) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("SELECT * FROM codigo WHERE codigo=?");
        mysqli_query($con, "set character_set_results='utf8'");
        
        $prepStmt->bind_param("s", $code);
        $prepStmt->execute();
        
        $res = $prepStmt->get_result();
        
        $prepStmt->close();
        $con->close();
        return $res;
    }

    public function update($code, $active) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("UPDATE codigo SET activo=? WHERE codigo=?");
        //echo $con->error;
        $prepStmt->bind_param("is", $active, $code);
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

    public function create($code,$activo) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("INSERT INTO codigo (codigo,activo) VALUES (?,?)");
        //echo $con->error;
        $prepStmt->bind_param("si", $code, $activo);
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

    public function delete($code) {
        $con = parent::getMySQLIConn();
        $delete = $con->prepare("DELETE FROM codigo WHERE codigo=?");
        
        $delete->bind_param("s", $code);
        $delete->execute();

        $delete->close();

        $con->close();
    }
}
