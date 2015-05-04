<?php

include_once '../Config/codeKey.php';
include_once '../DAO/DAOCode.php';
include_once '../Models/ViewClass.php';

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
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
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
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
        }

        $view = new ViewClass("index", "?view=adminCodes");
        $view->render();
    }

    public function create() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
        }

        $discount = $_POST['discount'];

        if ($discount < 5 || $discount > 80) {
            $view = new ViewClass("index", "?view=createCode&err");
            $view->render();
        }

        $categoriesId = '';
        if (isset($_POST['categories'])) {
            $categories = $_POST['categories'];

            for ($i = 0; $i < count($categories); $i++) {
                $categoriesId .= $categories[$i] . ',';
            }
            $categoriesId = substr($categoriesId, 0, -1);
        }

        $usersId = '';
        if (isset($_POST['users'])) {
            $users = $_POST['users'];

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

        $info = $discount . '|' . $date . '|' . $unique . '|' . $usersId . '|' . $categoriesId;

        $code = $this->encrypt_decrypt('encrypt', $info);

        $dec = $this->encrypt_decrypt('decrypt', $code);

        $dao = new DAOCode();
        $dao->create($code, $active);

        $view = new ViewClass("index", "?view=codeDetails&code=" . $code);
        $view->render();
    }

    public function createView() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
        }

        $view = new ViewClass("index", "?view=createCode");
        $view->render();
    }
    
    public function delete() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
        }

        $code = $_GET['code'];
        
        $dao = new DAOCode();     
        $dao->delete($code);
        
        $view = new ViewClass("index", "?view=adminCodes");
        $view->render();
    }

    function encrypt_decrypt($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = KEY;
        $secret_iv = IV;

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

}
