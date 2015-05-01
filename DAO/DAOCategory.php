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
    
    public function update($name, $desc, $father,$id) {
        $con = parent::getMySQLIConn();
        // UPDATE Applicant SET phone_number=?, street_name=?, city=?, county=?, zip_code=?, day_date=?, month_date=?, year_date=? WHERE account_id=?
        $prepStmt = $con->prepare("UPDATE `categoria` SET `id_categoria_pare`=?, `nom`=?, `desc`=? WHERE `id_categoria`=?");
        echo $con->error;
        $prepStmt->bind_param("dssd",$father,$name,$desc,$id);
        $prepStmt->execute();
        
        $prepStmt->close();
        $con->close();
    }
}
