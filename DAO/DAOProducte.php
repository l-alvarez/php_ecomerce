<?php
include"DBConnection.php";
class DAOProducte extends DBConnection{
    public function selectAll() {
        $con = parent::getConn();
        $sentencia = "SELECT estoc, desc_curta, url_foto FROM producte";
        $resultado = mysql_query($sentencia, $con);
        mysql_close($con);
        return $resultado;
    }
}