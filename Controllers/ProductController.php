<?php

include '../DAO/DAOProduct.php';
include_once '../Models/ViewClass.php';

class ProductController {

    public function selectAll() {
        $dao = new DAOProduct();
        return $dao->selectAll();
    }

    public function selectById($id) {
        $dao = new DAOProduct();
        return $dao->selectById($id);
    }

    public function selectByKeyWord($word) {
        $dao = new DAOProduct();
        return $dao->selectByKeyWord($word);
    }

    public function selectByCategory($cat) {
        $dao = new DAOProduct();
        return $dao->selectByCategory($cat);
    }

    public function search() {
        if (isset($_GET['name'])) {
            $word = $_GET['name'];
            $view = new ViewClass("index", "?view=search&find=$word");
        } else if (isset($_GET['cat'])) {
            $cat = (int) $_GET['cat'];
            $view = new ViewClass("index", "?view=search&filtr=$cat");
        } else {
            //TODO: error
        }

        $view->render();
    }

    public function show() {
        $id = (int) $_GET['id'];
        $view = new ViewClass("index", "?view=showProduct&id=$id");
        $view->render();
    }

}
