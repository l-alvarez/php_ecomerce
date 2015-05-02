<?php

include_once "DBConnection.php";

class DAOSubasta extends DBConnection {

    public function selectAll() {
        $con = parent::getMySQLConn();
        $sentencia = "SELECT * FROM subhasta";
        $resultado = mysql_query($sentencia, $con);
        mysql_close($con);
        return $resultado;
    }

    public function create($id_producte, $data_limit, $hora_limit) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("INSERT INTO subhasta (`id_producte`,`data_limit`,`hora_limit`) VALUES (?,?,?)");
        //echo $con->error;
        $prepStmt->bind_param("dss", $id_producte, $data_limit, $hora_limit);
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

    public function delete($id) {
        $con = parent::getMySQLIConn();
        echo $id;
        $con->autocommit(FALSE);
        echo $con->error;
        $delete = $con->prepare("DELETE FROM `subhasta` WHERE `id_subhasta`=?");
        $delete->bind_param("d", $id);

        if (!$delete->execute()) {
            $con->rollback();
        } else {
            $con->commit();
        }

        $delete->close();

        $con->close();
    }

    public function selectById($id) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("SELECT * FROM subhasta WHERE id_subhasta = ?");
        $id_find = $id;
        mysqli_query($con, "set character_set_results='utf8'");
        $prepStmt->bind_param("s", $id_find);
        $prepStmt->execute();
        $res = $prepStmt->get_result();
        $prepStmt->close();
        $con->close();
        return $res;
    }

    public function update($id_sub, $id_prod, $id_max_postor, $data_limit, $hora_limit, $estat) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("UPDATE `subhasta` SET `id_subhasta`=?, `id_producte`=?, `id_max_postor`=?, `data_limit`=?, `hora_limit`=?,`estat`=? WHERE `id_subhasta`=?");
        echo $con->error;
        $prepStmt->bind_param("ddddddd",$id_sub, $id_prod, $id_max_postor, $data_limit, $hora_limit, $estat, $id_sub);
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

}
