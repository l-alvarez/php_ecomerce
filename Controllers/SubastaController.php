<?php

include_once '../DAO/DAOSubasta.php';
include_once '../Controllers/ProductController.php';
include_once '../Controllers/UserController.php';
include_once '../Models/ViewClass.php';
include_once '../Models/Email.php';

class SubastaController {

    public function selectAll() {
        $dao = new DAOSubasta();
        return $dao->selectAll();
    }

    public function selectByProduct($prodId) {
        $dao = new DAOSubasta();
        return $dao->selectByProduct($prodId);
    }

    public function selectNotFinished() {
        $dao = new DAOSubasta();
        return $dao->selectNotFinished();
    }

    public function selectFinished() {
        $dao = new DAOSubasta();
        return $dao->selectFinished();
    }

    public function selectAuctionParticipants($id) {
        $dao = new DAOSubasta();
        return $dao->selectAuctionParticipants($id);
    }

    public function setAlert($id) {
        $dao = new DAOSubasta();
        return $dao->setAlert($id);
    }

    public function setState($id) {
        $dao = new DAOSubasta();
        return $dao->setState($id);
    }

    public function admin() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
        }

        $view = new ViewClass("index", "?view=adminSubasta");
        $view->render();
    }

    public function show() {
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            $view = new ViewClass("index", "?view=showSubasta&id=$id");
        } else {
            $view = new ViewClass("index", "?view=error&error=1");
        }
        $view->render();
    }

    public function createView() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
        }

        $view = new ViewClass("index", "?view=createSubasta");
        $view->render();
    }

    public function create() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
        }

        $id_producte = $_POST['id_prod'];
        $data_limit = $_POST['data_limit'];
        $hora_limit = $_POST['time'];

        if ($_POST['price'] > 0) {
            $preu = $_POST['price'];
        } else {
            $ctrl = new ProductController();
            $fetch = $ctrl->selectById($id_producte);
            $prod = $fetch->fetch_assoc();
            $preu = $prod['preu_inicial'];
        }

        $inc = $preu * 0.05;

        $dao = new DAOSubasta();
        $dao->create($id_producte, $data_limit, $hora_limit, $preu, $inc);

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
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
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
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
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
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
        }

        $id_sub = $_POST['id_sub'];

        $dao = new DAOSubasta();
        $fetch = $dao->selectById($id_sub);
        $subasta = $fetch->fetch_assoc();

        $data_limit = $_POST['data_limit'];
        $hora_limit = $_POST['hora_limit'];
        $estat = $_POST['estat'];
        $price = $_POST['price'];

        if ($subasta['preu_actual'] != $price) {
            $inc = $price * 0.05;
        } else {
            $inc = $subasta['increment'];
        }


        $dao->update($id_sub, $data_limit, $hora_limit, $estat, $price, $inc);

        $view = new ViewClass("index", "?view=subDetails&sub=" . $id_sub);
        $view->render();
    }

    public function toBid() {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['loged']) || $_SESSION['loged'] != 1) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
        }

        $id_sub = $_GET['id'];

        $dao = new DAOSubasta();
        $fetch = $dao->selectById($id_sub);
        $subasta = $fetch->fetch_assoc();

        $milliseconds = round(microtime(true) * 1000);
        $mili = strtotime($subasta['hora_limit'] . $subasta['data_limit']) - strtotime($milliseconds);

        $end = strtotime($subasta['hora_limit'] . $subasta['data_limit']);
        $actual = time();

        if ($end <= $actual) {
            $view = new ViewClass("index", "?view=showSubasta&id=" . $id_sub . "&err");
            $view->render();
        }

        $id_usr = $_SESSION['id_user'];

        $id_old = $subasta['id_max_postor'];
        $price = $subasta['preu_actual'];
        $inc = $subasta['increment'];
        $newPrice = $price + $inc;

        if ($id_old != $id_usr) {
            $dao = new DAOSubasta();
            $dao->bid($id_sub, $id_usr, $newPrice);

            $usrCtrl = new UserController();
            $fetch = $usrCtrl->selectById($id_old);
            $user = $fetch->fetch_assoc();

            $link = "https://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=showSubasta&id=" . $id_sub;
            $lang = $_COOKIE['lang'];

            $email = new Email();
            $email->bidOver($user['login'], $user['email'], $lang, $link);
        }

        $view = new ViewClass("index", "?view=showSubasta&id=" . $id_sub);
        $view->render();
    }

    public function endAuction($idSub, $idUsr, $direccio) {
        $dao = new DAOSubasta();
        return $dao->endAuction($idSub, $idUsr, $direccio);
    }

}
