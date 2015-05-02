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
    
    public function updatePwd($user, $password){
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("UPDATE usuaris SET pwd = ? WHERE login = ?");
        $prepStmt->bind_param("ss",$password,$user);
        $prepStmt->execute();
        
        $prepStmt->close();
        $con->close();
    }

    public function insert($name, $pwd, $mail, $pregunta, $respuesta, $salt, $lang) {
        $con = parent::getMySQLIConn();
        $prepStmt = $con->prepare("INSERT INTO usuaris (login,pwd,tipus_usuari,baixa_logica,email,pregunta,respuesta,salt,idioma) VALUES (?,?,'0','0',?,?,?,?,?)");        
        $prepStmt->bind_param("sssssss", $name,$pwd,$mail,$pregunta,$respuesta,$salt,$lang);
        $prepStmt->execute();

        $prepStmt->close();
        $con->close();
    }

}
