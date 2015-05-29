<?php

include_once "DBConnection.php";

class DAOUser extends DBConnection {

    public function selectAll() {
        $con = parent::getMySQLConn();
        $sentencia = "SELECT * FROM usuaris";
        $resultado = mysql_query($sentencia, $con);
        mysql_close($con);
        return $resultado;
    }

    public function selectById($id) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("SELECT * FROM usuaris WHERE id_usuari = ? ");
        $search_id = $id;

        mysqli_query($con, "set character_set_results='utf8'");
        $prepStmt->bind_param("i", $search_id);
        $prepStmt->execute();
        $res = $prepStmt->get_result();

        $prepStmt->close();
        $con->close();

        return $res;
    }

    public function selectByName($name) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("SELECT * FROM usuaris WHERE login = ? ");
        $search_name = $name;

        mysqli_query($con, "set character_set_results='utf8'");
        $prepStmt->bind_param("s", $search_name);
        $prepStmt->execute();
        $res = $prepStmt->get_result();

        $prepStmt->close();
        $con->close();

        return $res;
    }

    public function activate($user) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("UPDATE usuaris SET baixa_logica = '1' WHERE login = ?;");

        $prepStmt->bind_param("s", $user);
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

    public function selectByEmail($email) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("SELECT * FROM usuaris WHERE email = ? ");
        $search_mail = $email;

        mysqli_query($con, "set character_set_results='utf8'");
        $prepStmt->bind_param("s", $search_mail);
        $prepStmt->execute();
        $res = $prepStmt->get_result();

        $prepStmt->close();
        $con->close();

        return $res;
    }

    public function updatePwd($user, $password) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("UPDATE usuaris SET pwd = ? WHERE login = ?");
        $prepStmt->bind_param("ss", $password, $user);
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

    public function create($username, $pwd, $mail, $pregunta, $respuesta, $salt, $lang, $type, $baixa, $name, $surname, $nif, $direccio) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("INSERT INTO usuaris (login,pwd,tipus_usuari,baixa_logica,email,pregunta,respuesta,salt,idioma,nom,cognom,nif,direccio) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
        // echo $con->error;
        $prepStmt->bind_param("ssiisssssssss", $username, $pwd, $type, $baixa, $mail, $pregunta, $respuesta, $salt, $lang, $name, $surname, $nif, $direccio);
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

    public function update($id, $login, $mail, $type, $baixa, $lang, $name, $surname, $nif, $direccio) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("UPDATE usuaris SET login=?, email=?, tipus_usuari=?, baixa_logica=?, idioma=?, nom=?, cognom=?, nif=?, direccio=? WHERE id_usuari=?");
        echo $con->error;
        $prepStmt->bind_param("ssiisssssd", $login, $mail, $type, $baixa, $lang, $name, $surname, $nif, $direccio, $id);
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

    public function delete($id) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("DELETE FROM usuaris WHERE id_usuari=?");
        $prepStmt->bind_param("d", $id);
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

    public function setLang($name, $lang) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("UPDATE usuaris SET idioma=? WHERE login=?");
        $prepStmt->bind_param("ss", $lang, $name);
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

}
