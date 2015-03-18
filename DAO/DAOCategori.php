
<?php
include"DBConnection.php";
class DAOProducte extends DBConnection{
    public function selectAll() {
        $con = parent::getConn();
        $sentencia = "SELECT * FROM categoria";
        $resultado = mysql_query($sentencia, $con);
        mysql_close($con);
        return $resultado;
    }
    
    public function selectById($id) {
        $con = parent::getConn();
        //$prepStatment = $con->prepare("SELECT * FROM producte WHERE id_producte = ?");
        //$prepStatment->execute($id);
        mysql_query ("set character_set_results='utf8'");
        $stmt = "SELECT * FROM categoria WHERE id_categoria = ".$id;
        $res = mysql_query($stmt, $con);
        mysql_close($con);
        return $res;
    }
}
