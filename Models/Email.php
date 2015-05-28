<?php

class Email {

    private function sendMail($name, $dest, $body, $subject) {
        $from = "SCE <luis.marc.sce2015@gmail.com>";
        $to = $name . " <" . $dest . ">";

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

    public function verifyMail($name, $dest, $lang) {
        include_once '../lang/' . $lang . '_lang.php';

        $body = LABEL_MAIL_GREET . $name . ";<br>" . LABEL_MAIL_BODY . "<a href=\"" . $_SERVER['HTTP_HOST'] .
                "/sce/Controllers/Command.php?controller=AccesController&action=activate&user=" . $name . "\"> Link </a>.<br>" . LABEL_MAIL_END;

        $subject = LABEL_MAIL_VERIFY;

        $this->sendMail($name, $dest, $body, $subject);
    }

    public function recoveryMail($name, $dest, $lang) {
        include_once '../lang/' . $lang . '_lang.php';

        $body = LABEL_MAIL_GREET . $name . ";<br>" . LABEL_MAIL_BODY_RECOVERY . "<a href=\"" . $_SERVER['HTTP_HOST'] .
                "/sce/Controllers/Command.php?controller=AccesController&action=pwdRec&user=" . $name . "\"> Link </a>.<br>" . LABEL_MAIL_END;

        $subject = LABEL_MAIL_RECOVERY;

        $this->sendMail($name, $dest, $body, $subject);
    }

    public function codeMail($name, $dest, $lang, $code) {
        include_once '../lang/' . $lang . '_lang.php';

        $body = LABEL_MAIL_GREET . $name . ";<br>" . LABEL_MAIL_BODY_CODE . ": " . $code . ".<br>" . LABEL_MAIL_END;

        $subject = LABEL_CODE;

        $this->sendMail($name, $dest, $body, $subject);
    }

}
