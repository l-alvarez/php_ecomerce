<?php

require_once "Mail.php";
require_once '../Models/ViewClass.php';
require_once '../Config/mailConfig.php';
require_once '../DAO/DAOUser.php';

class AccesController {

    public function signup() {
        $username = $_POST["user_name"];
        $passwd = $_POST["password"];
        $passwd2 = $_POST["password2"];
        $pregunta = $_POST["pregunta"];
        $respuesta = $_POST["respuesta"];
        $mail = $_POST["email"];
        $lang = $_COOKIE["lang"];

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

        $tmp = mcrypt_create_iv(20);

        $salt = $tmp;

        $cryptPwd = hash('sha512', $salt . $passwd);

        $cryptAns = hash('sha512', $salt . $respuesta);

        $dao->insert($username, $cryptPwd, $mail, $pregunta, $cryptAns, $salt, $lang);

        $this->sendMail($username, $mail, $lang, 1);

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

        echo $salt . '<br>';

        $cryptPwd = hash('sha512', $salt . $pass);

        if ($hash != $cryptPwd) {
            $view = new ViewClass("index", "?view=login&err=err");
            $view->render();
        }

        session_start();
        $_SESSION['loged'] = 1;
        $_SESSION['user'] = $info['login'];
        $_SESSION['type'] = $info['tipus_usuari'];

        $view = new ViewClass("index", "");
        $view->render();
    }

    public function logout() {
        session_start();
        $_SESSION['loged'] = 0;
        $_SESSION['user'] = "";
        $_SESSION['type'] = "";

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
            sendMail($user, $mail, $lang, 0);
        }

        $view = new ViewClass("index", "?view=paswdRecovery&st=end");
        $view->render();
    }

    public function pwdRec() {
        $name = $_GET['user'];
        $dao = new DAOUser();
        $res = $dao->selectByName($user);
        $found = $res->fetch_assoc();

        if (!$found) {
            $view = new ViewClass("index", "");
            $view->render();
        }
    }

    private function sendMail($name, $dest, $lang, $type) {
        include_once '../lang/' . $lang . '_lang.php';
        $from = "SCE <luis.marc.sce2015@gmail.com>";
        $to = $name . " <" . $dest . ">";
        $subject = LABEL_MAIL_VERIFY;
        if ($type == 1) {
            $body = LABEL_MAIL_GREET . $name . ";<br>" . LABEL_MAIL_BODY . "<a href=\"https://localhost/sce/Controllers/Command.php?controller=AccesController&action=activate&user=" . $name . "\"> Link </a>.<br>" . LABEL_MAIL_END;
        } else {
            $body = LABEL_MAIL_GREET . $name . ";<br>" . LABEL_MAIL_BODY_RECOVERY . "<a href=\"https://localhost/sce/Controllers/Command.php?controller=AccesController&action=pwdRec&user=" . $name . "\"> Link </a>.<br>" . LABEL_MAIL_END;
        }

        $host = "smtp.gmail.com";
        $port = "587";
        $username = "luis.marc.sce2015@gmail.com";
        $password = "sce20142015";

        $headers = array('From' => $from,
            'To' => $to,
            'Subject' => $subject,
            'MIME-Version' => '1.0',
            'Content-type' => 'text/html; charset=iso-8859-1');

        $smtp = Mail::factory('smtp', array('host' => $host,
                    'port' => $port,
                    'auth' => true,
                    'username' => $username,
                    'password' => $password));

        $mail = $smtp->send($to, $headers, $body);

        if (PEAR::isError($mail)) {
            echo("<p>" . $mail->getMessage() . "</p>");
        } else {
            $mis = "email enviat OK";
        }
    }

}
