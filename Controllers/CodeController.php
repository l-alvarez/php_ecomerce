<?php

include_once '../Config/codeKey.php';
include_once '../DAO/DAOCode.php';
include_once '../DAO/DAOUser.php';
include_once '../DAO/DAOCategory.php';
include_once '../Models/ViewClass.php';
include_once '../Models/Email.php';

class CodeController {

    public function selectAll() {
        $dao = new DAOCode();
        return $dao->selectAll();
    }

    public function selectOne($code) {
        $dao = new DAOCode();
        return $dao->selectOne($code);
    }

    public function details() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
        }

        $code = $_GET['code'];
        $view = new ViewClass("index", "?view=codeDetails&code=" . $code);
        $view->render();
    }

    public function admin() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
        }

        $view = new ViewClass("index", "?view=adminCodes");
        $view->render();
    }

    public function disable($code) {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['loged']) || $_SESSION['loged'] != 1) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
        }

        $used = 0;

        $dao = new DAOCode();
        $dao->disable($code, $used);
    }

    public function update() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
        }

        $code = $_POST['code'];

        if (isset($_POST['active'])) {
            $active = 1;
        } else {
            $active = 0;
        }

        $dao = new DAOCode();
        $dao->update($code, $active);

        $view = new ViewClass("index", "?view=codeDetails&code=" . $code);
        $view->render();
    }

    public function create() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
        }

        if (!isset($_POST['discount'])) {
            $discount = -1;
        } else {
            $discount = $_POST['discount'];
        }
        if ($discount < 5 || $discount > 80) {
            $view = new ViewClass("index", "?view=createCode&err");
            $view->render();
        }

        $categoriesId = "-1";
        if (isset($_POST['categories'])) {
            $categories = $_POST['categories'];
            $categoriesId = '';

            for ($i = 0; $i < count($categories); $i++) {
                $categoriesId .= $categories[$i] . ',';
            }
            $categoriesId = substr($categoriesId, 0, -1);
        }

        $usersId = "-1";
        if (isset($_POST['users'])) {
            $users = $_POST['users'];
            $usersId = '';

            for ($i = 0; $i < count($users); $i++) {
                $usersId .= $users[$i] . ',';
            }
            $usersId = substr($usersId, 0, -1);
        }

        if (isset($_POST['unique'])) {
            $unique = 1;
        } else {
            $unique = 0;
        }

        if (isset($_POST['active'])) {
            $active = 1;
        } else {
            $active = 0;
        }

        $date = $_POST['data_limit'];
        if ($date == '') {
            $date = "-1";
        }

        $info = $discount . '|' . $date . '|' . $unique . '|' . $usersId . '|' . $categoriesId;

        $code = $this->encrypt_decrypt('encrypt', $info);

        $short = substr($code, 0, 16);

        try {
            $dao = new DAOCode();
            $dao->create($code, $active, $short);

            if ($usersId != -1) {
                $this->sendMails($users, $short, $categories);
            } else {
                $this->sendAllMails($code, $categories);
            }

            $view = new ViewClass("index", "?view=codeDetails&code=" . $short);
        } catch (Exception $e) {
            $view = new ViewClass("index", "?view=adminCodes");
        }

        $view->render();
    }

    private function sendMails($users, $code, $categories) {
        $mail = new Email();
        $lang = $_COOKIE['lang'];
        $dao = new DAOUser();
        $cat = new DAOCategory();
        $categ = '';

        if ($categories == "-1") {
            $categories = LABEL_ANY;
        } else {
            for ($i = 0; $i < count($categories); $i++) {
                $fetch = $cat->selectById($categories[$i]);
                $info = $fetch->fetch_assoc();

                $categ .= $info['nom'] . ',';
            }
            $categ = substr($categ, 0, -1);
        }

        for ($i = 0; $i < count($users); $i++) {
            $fetch = $dao->selectById($users[$i]);
            $user = $fetch->fetch_assoc();

            $mail->codeMail($user['login'], $user['email'], $lang, $code, $categ);
        }
    }

    private function sendAllMails($code, $categories) {
        $mail = new Email();
        $lang = $_COOKIE['lang'];
        $dao = new DAOUser();
        $users = $dao->selectAll();
        $cat = new DAOCategory();

        if ($categories == "-1") {
            $categories = LABEL_ANY;
        } else {
            for ($i = 0; $i < count($categories); $i++) {
                $fetch = $cat->selectById($categories[i]);
                $info = $fetch->fetch_assoc();

                $categ .= $info['nom'] . ',';
            }
            $categ = substr($categ, 0, -1);
        }

        while ($user = $users->fetch_assoc()) {
            $mail->codeMail($user['login'], $user['email'], $lang, $code, $categ);
        }
    }

    public function createView() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
        }

        $view = new ViewClass("index", "?view=createCode");
        $view->render();
    }

    public function delete() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
        }

        $code = $_GET['code'];

        $dao = new DAOCode();
        $dao->delete($code);

        $view = new ViewClass("index", "?view=adminCodes");
        $view->render();
    }

    public function encrypt_decrypt($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = KEY;
        $secret_iv = IV;

        $key = hash('sha256', $secret_key);

        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output1 = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output1);
        } else if ($action == 'decrypt') {
            $decode = base64_decode($string);
            $output = openssl_decrypt($decode, $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

}
