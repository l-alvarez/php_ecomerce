<?php

include_once '../Models/ViewClass.php';
include_once '../Config/mailConfig.php';
include_once '../DAO/DAOUser.php';
include_once '../Models/Email.php';

class AccesController {

    public function signup() {

        $username = $_POST["user_name"];
        $passwd = $_POST["password"];
        $passwd2 = $_POST["password2"];
        $pregunta = $_POST["pregunta"];
        $respuesta = $_POST["respuesta"];
        $mail = $_POST["email"];
        $lang = $_COOKIE["lang"];
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $nif = $_POST["nif"];
        $direccion = $_POST["direccion"];

        $captcha = $_POST["g-recaptcha-response"];

        if (strlen($passwd) > 20 || strlen($passwd) < 8) {
            $view = new ViewClass("index", "?view=signup&err=0");
            $view->render();
        }
        if ($passwd != $passwd2) {
            $view = new ViewClass("index", "?view=signup&err=1");
            $view->render();
        }

        $dao = new DAOUser();
        $res1 = $dao->selectByName($username);
        if ($res1->fetch_assoc()) {
            $view = new ViewClass("index", "?view=signup&err=2");
            $view->render();
        }
        $res2 = $dao->selectByEmail($mail);
        if ($res2->fetch_assoc()) {
            $view = new ViewClass("index", "?view=signup&err=3");
            $view->render();
        }
        if (!$captcha) {
            $view = new ViewClass("index", "?view=signup&err=4");
            $view->render();
        }
        if (strlen($nif) > 9) {
            $view = new ViewClass("index", "?view=signup&err=5");
            $view->render();
        }

        $salt = mcrypt_create_iv(20);

        $cryptPwd = hash('sha512', $salt . $passwd);

        $cryptAns = hash('sha512', $salt . $respuesta);

        $dao->create($username, $cryptPwd, $mail, $pregunta, $cryptAns, $salt, $lang, 0, 0, $name, $surname, $nif, $direccion);

        $email = new Email();
        $email->verifyMail($username, $mail, $lang);

        $view = new ViewClass("index", "");
        $view->render();
    }

    public function login() {
        $userName = $_POST["user"];
        $pass = $_POST["password"];

        $dao = new DAOUser();
        $user = $dao->selectByName($userName);

        $info = $user->fetch_assoc();

        if (!$info) {
            $view = new ViewClass("index", "?view=login&err=err");
            $view->render();
        }
        if ($info['baixa_logica'] == '0') {
            $view = new ViewClass("index", "?view=login&err=1");
            $view->render();
        }

        $salt = $info['salt'];
        $hash = $info['pwd'];

        $cryptPwd = hash('sha512', $salt . $pass);

        if ($hash != $cryptPwd) {
            $view = new ViewClass("index", "?view=login&err=err");
            $view->render();
        }

        session_start();
        $_SESSION['loged'] = 1;
        $_SESSION['user'] = $info['login'];
        $_SESSION['type'] = $info['tipus_usuari'];
        $_SESSION['lang'] = $info['idioma'];
        $_SESSION['id_user'] = $info['id_usuari'];

        $view = new ViewClass("index", "");
        $view->render();
    }

    public function logout() {
        session_start();
        $_SESSION['loged'] = 0;
        $_SESSION['user'] = "";
        $_SESSION['type'] = "";
        $_SESSION['lang'] = "";
        $_SESSION['id_user'] = "";
        
        session_destroy();

        $view = new ViewClass("index", "");
        $view->render();
    }

    public function activate() {
        if (isset($_GET['user'])) {
            $user = $_GET['user'];
            $dao = new DAOUser();
            $dao->activate($user);
        }

        $view = new ViewClass("index", "");
        $view->render();
    }

    public function recovery() {
        if (!isset($_POST['user'])) {
            $view = new ViewClass("index", "?view=paswdRecovery&st=err");
            $view->render();
        }

        $lang = $_COOKIE["lang"];
        $user = $_POST['user'];
        $dao = new DAOUser();
        $res = $dao->selectByName($user);
        $found = $res->fetch_assoc();

        if ($found) {
            $mail = $found['email'];
            $email = new Email();
            $email->recoveryMail($user, $mail, $lang);
        }

        $view = new ViewClass("index", "?view=paswdRecovery&st=end");
        $view->render();
    }

    public function pwdRec() {
        $name = $_GET['user'];
        $dao = new DAOUser();
        $res = $dao->selectByName($name);
        $found = $res->fetch_assoc();

        if (!$found) {
            $view = new ViewClass("index", "");
            $view->render();
        }
        session_start();
        $_SESSION['username'] = $name;
        $_SESSION['pregunta'] = $found['pregunta'];

        $view = new ViewClass("index", "?view=pwdRec");
        $view->render();
    }

    public function pwdRecVerify() {
        $user = $_POST['user'];
        $pwd1 = $_POST['password'];
        $pwd2 = $_POST['password2'];
        $resp = $_POST['respuesta'];

        $dao = new DAOUser();
        $res = $dao->selectByName($user);
        $found = $res->fetch_assoc();

        if (!$found) {
            $view = new ViewClass("index", "");
            $view->render();
        }

        if (strlen($pwd1) > 20 || strlen($pwd1) < 8) {
            $view = new ViewClass("index", "?view=pwdRec&err=1");
            $view->render();
        }
        if ($pwd1 != $pwd2) {
            $view = new ViewClass("index", "?view=pwdRec&err=2");
            $view->render();
        }

        $salt = $found['salt'];

        $cryptAns = hash('sha512', $salt . $resp);

        $hashResp = $found['respuesta'];

        if ($hashResp != $cryptAns) {
            $view = new ViewClass("index", "?view=pwdRec&err=3");
            $view->render();
        }

        $cryptPwd = hash('sha512', $salt . $pwd1);

        $dao->updatePwd($user, $cryptPwd);

        $view = new ViewClass("index", "");
        $view->render();
    }
}
