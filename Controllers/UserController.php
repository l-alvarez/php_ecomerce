<?php

include_once '../DAO/DAOUser.php';
include_once '../Models/ViewClass.php';

class UserController {

    public function selectAll() {
        $dao = new DAOUser();
        return $dao->selectAll();
    }

    public function selectById($id) {
        $dao = new DAOUser();
        return $dao->selectById($id);
    }

    public function selectByName($name) {
        $dao = new DAOUser();
        return $dao->selectByName($name);
    }

    public function createView() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
        }

        $view = new ViewClass("index", "?view=createUser");
        $view->render();
    }

    public function details() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
        }

        $id = $_GET['usr'];
        $view = new ViewClass("index", "?view=userDetails&usr=" . $id);
        $view->render();
    }

    public function admin() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
        }

        $view = new ViewClass("index", "?view=adminUsers");
        $view->render();
    }

    public function create() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
        }

        $username = $_POST['user_name'];
        $passwd = $_POST['password'];
        $passwd2 = $_POST['password2'];
        $pregunta = $_POST['pregunta'];
        $respuesta = $_POST['respuesta'];
        $email = $_POST['email'];
        $type = $_POST['type'];
        $baixa = $_POST['baixa'];
        $lang = $_POST['lang'];
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $nif = $_POST["nif"];
        $direccion = $_POST["direccion"];

        if (strlen($passwd) > 20 || strlen($passwd) < 8) {
            $view = new ViewClass("index", "?view=createUser&err=0");
            $view->render();
        }
        if ($passwd != $passwd2) {
            $view = new ViewClass("index", "?view=createUser&err=1");
            $view->render();
        }

        $dao = new DAOUser();
        $res1 = $dao->selectByName($username);
        if ($res1->fetch_assoc()) {
            $view = new ViewClass("index", "?view=createUser&err=2");
            $view->render();
        }
        $res2 = $dao->selectByEmail($email);
        if ($res2->fetch_assoc()) {
            $view = new ViewClass("index", "?view=createUser&err=3");
            $view->render();
        }

        $tmp = mcrypt_create_iv(20);

        $salt = $tmp;

        $cryptPwd = hash('sha512', $salt . $passwd);

        $cryptAns = hash('sha512', $salt . $respuesta);

        $dao->create($username, $cryptPwd, $email, $pregunta, $cryptAns, $salt, $lang, $type, $baixa, $name, $surname, $nif, $direccion);


        $dao = new DAOUser();
        $dao->create();

        $view = new ViewClass("index", "?view=adminUsers");
        $view->render();
    }

    public function delete() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
        }

        $id = $_GET['usr'];

        $dao = new DAOUser();
        $dao->delete($id);

        $view = new ViewClass("index", "?view=adminUsers");
        $view->render();
    }

    public function modify() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
        }

        $id = $_POST['id'];
        $login = $_POST['login'];
        $mail = $_POST['email'];
        $type = $_POST['type'];
        $baixa = $_POST['baixa'];
        $lang = $_POST['lang'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $direccio = $_POST['direccio'];
        $nif = $_POST['nif'];

        $dao = new DAOUser();
        $dao->update($id, $login, $mail, $type, $baixa, $lang, $name, $surname, $nif, $direccio);

        $view = new ViewClass("index", "?view=userDetails&usr=" . $id);
        $view->render();
    }

    public function update() {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        $id = $_POST['id'];
        
        if (!isset($_SESSION['id_user']) || $_SESSION['id_user'] != $id) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
        }

        $login = $_POST['login'];
        $mail = $_POST['email'];
        $type = $_POST['type'];
        $baixa = $_POST['baixa'];
        $lang = $_POST['lang'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $direccio = $_POST['direccio'];
        $nif = $_POST['nif'];

        $dao = new DAOUser();
        $dao->update($id, $login, $mail, $type, $baixa, $lang, $name, $surname, $nif, $direccio);

        $view = new ViewClass("index", "?view=modifyUserData");
        $view->render();
    }

    public function setLang($name, $lang) {
        $dao = new DAOUser();
        $dao->setLang($name, $lang);
    }

}
