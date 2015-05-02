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

    public function admin() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
        }
        
        $view = new ViewClass("index", "?view=adminUsers");
        $view->render();
    }

}
