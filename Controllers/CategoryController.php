<?php

include_once '../DAO/DAOCategory.php';
include_once '../Models/ViewClass.php';

class CategoryController {

    public function selectAll() {
        $dao = new DAOCategory();
        return $dao->selectAll();
    }

    public function selectById($id) {
        $dao = new DAOCategory();
        return $dao->selectById($id);
    }

    public function details() {
        session_start();
        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
        }

        $id = $_GET['cat'];
        $view = new ViewClass("index", "?view=catDetails&cat=" . $id);
        $view->render();
    }

    public function update() {
        session_start();
        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
        }

        $name = $_POST['name'];
        $desc = $_POST['desc'];
        $father = $_POST['padre'];
        $id = $_POST['id'];

        $dao = new DAOCategory();
        $dao->update($name, $desc, $father, $id);

        $view = new ViewClass("index", "?view=catDetails&cat=" . $id);
        $view->render();
    }

    public function admin() {
        session_start();
        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
        }

        $view = new ViewClass("index", "?view=adminCat");
        $view->render();
    }

}
