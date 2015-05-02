<?php

include_once '../DAO/DAOSubasta.php';
include_once '../Models/ViewClass.php';

class SubastaController {

    public function selectAll() {
        $dao = new DAOSubasta();
        return $dao->selectAll();
    }

    public function admin() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
        }

        $view = new ViewClass("index", "?view=adminSubasta");
        $view->render();
    }

    public function createView() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
        }

        $view = new ViewClass("index", "?view=createSubasta");
        $view->render();
    }

    public function create() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
        }

        $id_producte = $_POST['id_prod'];
        $data_limit = $_POST['data_limit'];
        $hora_limit = $_POST['time'];

        $dao = new DAOSubasta();
        $dao->create($id_producte, $data_limit, $hora_limit);

        $view = new ViewClass("index", "?view=adminSubasta");
        $view->render();
    }

    public function selectById($id) {
        $dao = new DAOSubasta();
        return $dao->selectById($id);
    }

    public function delete() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
        }

        $id = $_GET['sub'];

        $dao = new DAOSubasta();
        $dao->delete($id);

        $view = new ViewClass("index", "?view=adminSubasta");
        $view->render();
    }

    public function details() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
        }

        $id = $_GET['sub'];
        $view = new ViewClass("index", "?view=subDetails&sub=" . $id);
        $view->render();
    }

    public function update() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
        }
        $id_sub = $_POST['id_sub'];
        $id_prod = $_POST['id_prod'];
        $id_max_postor = $_POST['id_max_postor'];
        $data_limit = $_POST['data_limit'];
        $hora_limit = $_POST['hora_limit'];
        $estat = $_POST['estat'];


        $dao = new DAOSubasta();
        $dao->update($id_sub, $id_prod, $id_max_postor, $data_limit, $hora_limit, $estat);

        $view = new ViewClass("index", "?view=subDetails&sub=" . $id_sub);
        $view->render();
    }

}
