<?php
include '../DAO/DAOProducte.php';

class ProducteController {

    public function selectAll() {
        $dao = new DAOProducte();
        return $dao->selectAll();
    }
}

?>