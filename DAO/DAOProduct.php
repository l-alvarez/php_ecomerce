<?php

include_once "DBConnection.php";

class DAOProduct extends DBConnection {

    public function selectAll() {
        $con = parent::getMySQLConn();
        $sentencia = "SELECT * FROM producte";
        $resultado = mysql_query($sentencia, $con);
        mysql_close($con);
        return $resultado;
    }

    public function selectById($id) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("SELECT * FROM producte WHERE id_producte = ?");
        $id_find = $id;
        mysqli_query ($con, "set character_set_results='utf8'");
        $prepStmt->bind_param("s", $id_find);
        $prepStmt->execute();
        $res = $prepStmt->get_result();
        $prepStmt->close();
        $con->close();
        return $res;
    }
    
    public function selectByKeyWord($word) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("SELECT * FROM producte WHERE MATCH(nom,desc_llarga) AGAINST( +?  IN BOOLEAN MODE )");
        $search_word = $word;
        // echo $con->error;
        mysqli_query ($con, "set character_set_results='utf8'");
        $prepStmt->bind_param("s", $search_word);
        $prepStmt->execute();
        $res = $prepStmt->get_result();
        $prepStmt->close();
        $con->close();
        return $res;
    }
    
    public function selectByCategory($cat_id) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("SELECT * FROM producte WHERE id_categoria = ? ");
        $search_id = $cat_id;
        // echo $con->error;
        mysqli_query ($con, "set character_set_results='utf8'");
        $prepStmt->bind_param("i", $search_id);
        $prepStmt->execute();
        $res = $prepStmt->get_result();
        
        $prepStmt->close();
        $con->close();
        
        return $res;
    }
}