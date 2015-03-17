<?php
include '../DAO/DAOProducte.php';
include_once '../Models/ViewClass.php';

class ProducteController {

    public function selectAll() {
        $dao = new DAOProducte();
        return $dao->selectAll();
    }
    
    public function selectById($id) {
        $dao = new DAOProducte();
        return $dao->selectById($id);
    }
    
    public function show() {
        $id = (int)$_GET["id"];
        $view = new ViewClass("index","?view=showProduct&id=$id");
        $view->render();
    }
}