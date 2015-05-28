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
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . " /sce/Views/index.php?view=error&error=3");
        }

        $id = $_GET['cat'];
        $view = new ViewClass("index", "?view=catDetails&cat=" . $id);
        $view->render();
    }

    public function update() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://". $_SERVER['HTTP_HOST'] ."/sce/Views/index.php?view=error&error=3");
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
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://". $_SERVER['HTTP_HOST'] ."/sce/Views/index.php?view=error&error=3");
        }

        $view = new ViewClass("index", "?view=adminCategories");
        $view->render();
    }

    public function create() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://". $_SERVER['HTTP_HOST'] ."/sce/Views/index.php?view=error&error=3");
        }

        $name = $_POST['name'];
        $desc = $_POST['desc'];
        $father = $_POST['padre'];

        $dao = new DAOCategory();
        $dao->create($name, $desc, $father);

        $view = new ViewClass("index", "?view=adminCategories");
        $view->render();
    }

    public function createView() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://". $_SERVER['HTTP_HOST'] ."/sce/Views/index.php?view=error&error=3");
        }

        $view = new ViewClass("index", "?view=createCategory");
        $view->render();
    }

    public function delete() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://". $_SERVER['HTTP_HOST'] ."/sce/Views/index.php?view=error&error=3");
        }

        $id = $_GET['cat'];

        $fetch = $this->selectById($id);
        $info = $fetch->fetch_assoc();
        $father = $info['id_categoria_pare'];

        $dao = new DAOCategory();
        $dao->delete($id, $father);

        $view = new ViewClass("index", "?view=adminCategories");
        $view->render();
    }

}
