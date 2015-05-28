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

        mysqli_query($con, "set character_set_results='utf8'");
        $prepStmt->bind_param("s", $id);
        $prepStmt->execute();
        $res = $prepStmt->get_result();
        
        $prepStmt->close();
        $con->close();
        return $res;
    }

    public function update($name, $desc, $father, $id) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("UPDATE `categoria` SET `id_categoria_pare`=?, `nom`=?, `descripcio`=? WHERE `id_categoria`=?");

        $prepStmt->bind_param("dssd", $father, $name, $desc, $id);
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

    public function create($name, $desc, $father) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("INSERT INTO categoria (`id_categoria_pare`,`nom`,`descripcio`) VALUES (?,?,?)");

        $prepStmt->bind_param("dss", $father, $name, $desc);
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

    public function delete($id, $id_pare) {
        $con = parent::getMySQLIConn();

        $con->autocommit(FALSE);

        $updateProducts = $con->prepare("UPDATE `producte` SET `id_categoria`=? WHERE `id_categoria`=?");
        $updateProducts->bind_param("dd", $id_pare, $id);

        $updateCategories = $con->prepare("UPDATE `categoria` SET `id_categoria_pare`=? WHERE `id_categoria_pare`=?");
        $updateCategories->bind_param("dd", $id_pare, $id);

        $delete = $con->prepare("DELETE FROM `categoria` WHERE `id_categoria`=?");
        $delete->bind_param("d", $id);

        if (!$updateProducts->execute() || !$updateCategories->execute() || !$delete->execute()) {
            $con->rollback();
        } else {
            $con->commit();
        }

        $updateProducts->close();
        $updateCategories->close();
        $delete->close();

        $con->close();
    }

}
