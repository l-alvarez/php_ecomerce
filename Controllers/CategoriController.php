<?php
include '../DAO/DAOCategori.php';
include_once '../Models/ViewClass.php';

class ProducteController {

    public function selectAll() {
        $dao = new DAOCategori();
        return $dao->selectAll();
    }
    
    public function selectById($id) {
        $dao = new DAOCategori();
        return $dao->selectById($id);
    }
    
    public function show() {
        $id = (int)$_GET["id"];
        $view = new ViewClass("index","?view=showProduct&id=$id");
        $view->render();
    }
}