<?php

include_once "DBConnection.php";

class DAOSubasta extends DBConnection {

    public function selectAll() {
        $con = parent::getMySQLConn();
        $sentencia = "SELECT * FROM subhasta WHERE estat=0";
        $resultado = mysql_query($sentencia, $con);
        mysql_close($con);
        return $resultado;
    }

    public function selectNotFinished() {
        $con = parent::getMySQLConn();
        $sentencia = "SELECT * FROM subhasta WHERE estat=0 AND notificada=0";
        $resultado = mysql_query($sentencia, $con);
        mysql_close($con);
        return $resultado;
    }

    public function selectFinished() {
        $con = parent::getMySQLConn();
        $sentencia = "SELECT * FROM subhasta WHERE estat=0 AND notificada=1";
        $resultado = mysql_query($sentencia, $con);
        mysql_close($con);
        return $resultado;
    }

    public function selectAuctionParticipants($id) {
        $con = parent::getMySQLConn();
        $sentencia = "SELECT * FROM participantsubasta WHERE id_subasta=" . $id;
        $resultado = mysql_query($sentencia, $con);
        mysql_close($con);
        return $resultado;
    }

    public function setAlert($id) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("UPDATE subhasta SET notificada=1 WHERE id_subhasta=?");

        $prepStmt->bind_param("d", $id);
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

    public function setState($id) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("UPDATE subhasta SET estat=1 WHERE id_subhasta=?");

        $prepStmt->bind_param("d", $id);
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

    public function create($id_producte, $data_limit, $hora_limit, $preu, $inc) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("INSERT INTO subhasta (id_producte,data_limit,hora_limit,preu_actual,increment) VALUES (?,?,?,?,?)");
        // echo $con->error;
        $prepStmt->bind_param("dssdd", $id_producte, $data_limit, $hora_limit, $preu, $inc);
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

    public function delete($id) {
        $con = parent::getMySQLIConn();

        $prepStmt = $con->prepare("DELETE FROM subhasta WHERE id_subhasta=?");
        $prepStmt->bind_param("d", $id);
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

    public function selectById($id) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("SELECT * FROM subhasta WHERE id_subhasta=?");

        mysqli_query($con, "set character_set_results='utf8'");
        $prepStmt->bind_param("s", $id);
        $prepStmt->execute();
        $res = $prepStmt->get_result();

        $prepStmt->close();
        $con->close();
        return $res;
    }

    public function selectByProduct($prodId) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("SELECT * FROM subhasta WHERE id_producte=? AND estat=0");

        mysqli_query($con, "set character_set_results='utf8'");
        $prepStmt->bind_param("s", $prodId);
        $prepStmt->execute();
        $res = $prepStmt->get_result();

        $prepStmt->close();
        $con->close();
        return $res;
    }

    public function update($id_sub, $data_limit, $hora_limit, $estat, $preu, $inc) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("UPDATE subhasta SET data_limit=?, hora_limit=?, estat=?, preu_actual=?, increment=? WHERE id_subhasta=?");

        $prepStmt->bind_param("ssdddd", $data_limit, $hora_limit, $estat, $preu, $inc, $id_sub);
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

    public function bid($id_sub, $id_new, $price) {
        $con = parent::getMySQLIConn();

        $updateSub = $con->prepare("UPDATE subhasta SET id_max_postor=?, preu_actual=? WHERE id_subhasta=?");
        $updateSub->bind_param("ddd", $id_new, $price, $id_sub);
        $updateSub->execute();

        $participant = $con->prepare("REPLACE INTO participantsubasta (id_subasta,id_usuari) VALUES (?,?)");
        $participant->bind_param("dd", $id_sub, $id_new);
        $participant->execute();

        $updateSub->close();
        $participant->close();

        $con->close();
    }

    public function endAuction($idSub, $idUsr, $direccio) {
        $con = parent::getMySQLIConn();

        $con->autocommit(FALSE);

        $updateSub = $con->prepare("UPDATE subhasta SET pagada=1 WHERE id_subhasta=?");
        $updateSub->bind_param("d", $idSub);

        $addCommand = $con->prepare("INSERT INTO comanda (id_subhasta,id_usuari,direccio) VALUES (?,?,?)");
        $addCommand->bind_param("dds", $idSub, $idUsr, $direccio);

        if (!$updateSub->execute() || !$addCommand->execute()) {
            $con->rollback();
        } else {
            $con->commit();
        }

        $updateSub->close();
        $addCommand->close();
        $con->close();
    }

}
