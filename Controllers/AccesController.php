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

        $tmp = mcrypt_create_iv(10);

        $salt = $tmp;

        $cryptPwd = hash('sha512', $passwd . $salt);

        $subCryptPwd = substr($cryptPwd, 0, 10);


        $dao->insert($username, $subCryptPwd, $mail, $pregunta, $respuesta, $salt, $lang);

        //$this->sendMail($mail, $lang);

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
            echo "usuario no existe";
            die();
            ///TODO: error
        }

        $salt = $info['salt'];
        $hash = $info['pwd'];

        echo $salt . '<br>';

        $cryptPwd = hash('sha512', $pass . $salt);

        echo $cryptPwd . '<br>';

        $subCryptPwd = substr($cryptPwd, 0, 10);

        echo $hash . '<br>';
        echo $subCryptPwd . '<br>';

        if ($hash != $subCryptPwd) {
            echo "contraseña incorrecta";
            die();
            //TODO: error
        }

        //session stuff

        echo "login correcto, falta implementar sesion";
        /*
          $view = new ViewClass("index", "");
          $view->render();
        */
    }

    private function sendMail($dest, $lang) {

        include_once '../lang/' . $lang . '_lang.php';

        echo MAIL;

        $from = '<' . MAIL . '>';
        $to = $dest;
        $subject = LABEL_MAIL_VERIFY;
        $body = LABEL_MAIL_BODY;

        $headers = array(
            'From' => $from,
            'To' => $to,
            'Subject' => $subject
        );

        $smtp = Mail::factory('smtp', array('host' => 'smtp.gmail.com',
                    'port' => '465',
                    'auth' => true,
                    'username' => MAIL,
                    'password' => PASSWD
        ));

        echo "hola";

        $mail = $smtp->send($to, $headers, $body);
        //mail($to,$from,$body,$headers);

        echo "enviado";

        if (PEAR::isError($mail)) {
            echo('<p>' . $mail->getMessage() . '</p>');
        } else {
            echo('<p>Message successfully sent!</p>');
        }
    }

}
