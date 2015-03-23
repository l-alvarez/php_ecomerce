<?php

include_once "DBConnection.php";

class DAOCategory extends DBConnection {

    public function selectAll() {
        $con = parent::getMySQLConn();
        $sentencia = "SELECT * FROM categoria";
        $resultado = mysql_query($sentencia, $con);
        mysql_close($con);
        return $resultado;
    }

    public function selectById($id) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("SELECT * FROM categoria WHERE id_categoria = ?");
        $id_find = $id;
        mysqli_query($con, "set character_set_results='utf8'");
        $prepStmt->bind_param("s", $id_find);
        $prepStmt->execute();
        $res = $prepStmt->get_result();
        $prepStmt->close();
        $con->close();
        return $res;
    }

}
