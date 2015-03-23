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

}
