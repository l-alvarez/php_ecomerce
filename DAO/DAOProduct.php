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
        mysqli_query($con, "set character_set_results='utf8'");
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

        mysqli_query($con, "set character_set_results='utf8'");
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

        mysqli_query($con, "set character_set_results='utf8'");
        $prepStmt->bind_param("i", $search_id);
        $prepStmt->execute();
        $res = $prepStmt->get_result();

        $prepStmt->close();
        $con->close();

        return $res;
    }
    
    public function create($id_categoria, $preu_inicial,$nom,$desc_llarga,$url_foto) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("INSERT INTO producte (`id_categoria`,`preu_inicial`,`nom`,`dec_llarga`,`url_foto`) VALUES (?,?,?,?,?)");
        //echo $con->error;
        $prepStmt->bind_param("ddsss",$id_categoria, $preu_inicial, $nom,$desc_llarga,$url_foto );
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

    public function delete($id) {
        $con = parent::getMySQLIConn();

        $con->autocommit(FALSE);
        $delete = $con->prepare("DELETE FROM `producte` WHERE `id_producte`=?");
        $delete->bind_param("d", $id);

        if (!$delete->execute()) {
            $con->rollback();
        } else {
            $con->commit();
        }

        $updateProducts->close();
        $updateCategories->close();
        $delete->close();

        $con->close();
    }
    public function update($id_producte, $id_categoria, $preu_inicial,$nom,$desc_llarga,$url_foto) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("UPDATE `producte` SET `id_producte`=?, `id_categoria`=?, `preu_inicial`=?,`nom`=?,`desc_llarga`=?,`url_foto`=? WHERE `id_producte`=?");        //echo $con->error;
        $prepStmt->bind_param("dddsss", $id_producte,$id_categoria,$preu_inicial, $nom, $desc_llarga, $url_foto, $id_producte);
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

}
