<?php
include"DBConnection.php";
class DAOProducte extends DBConnection{
    public function selectAll() {
        $con = parent::getConn();
        $sentencia = "SELECT * FROM producte";
        $resultado = mysql_query($sentencia, $con);
        mysql_close($con);
        return $resultado;
    }
    
    public function selectById($id) {
        $con = parent::getConn();
        //$prepStatment = $con->prepare("SELECT * FROM producte WHERE id_producte = ?");
        //$prepStatment->execute($id);
        
        $stmt = "SELECT * FROM producte WHERE id_producte = ".$id;
        $res = mysql_query($stmt, $con);
        mysql_close($con);
        return $res;
    }
}