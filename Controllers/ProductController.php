<?php

include_once '../DAO/DAOProduct.php';
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
            $view = new ViewClass("index", "?view=error&error=1");
        }

        $view->render();
    }

    public function show() {
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            $view = new ViewClass("index", "?view=showProduct&id=$id");
        } else {
            $view = new ViewClass("index", "?view=error&error=1");
        }
        $view->render();
    }

        public function admin() {
            if (!isset($_SESSION)) {
                session_start();
            }

            if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
                header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
            }

            $view = new ViewClass("index", "?view=adminProducts");
            $view->render();
        }

    public function create() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
        }

        $id_categoria = $_POST['id_cat'];
        $preu_inicial = $_POST['preu_ini'];
        $nom = $_POST['nom'];
        $desc_llarga = $_POST['desc_llarga'];
        $url_foto = $_POST['url_foto'];

        $dao = new DAOProduct();
        $dao->create($id_categoria, $preu_inicial, $nom, $desc_llarga, $url_foto);

        $view = new ViewClass("index", "?view=adminProducts");
        $view->render();
    }

    public function createView() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
        }

        $view = new ViewClass("index", "?view=createProduct");
        $view->render();
    }

    public function delete() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
        }

        $id = $_GET['prod'];

        $dao = new DAOProduct();
        $dao->delete($id);

        $view = new ViewClass("index", "?view=adminProducts");
        $view->render();
    }

    public function details() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
        }

        $id = $_GET['prod'];
        $view = new ViewClass("index", "?view=prodDetails&prod=" . $id);
        $view->render();
    }
       public function update() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
            header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
        }
        $id_producte = $_POST['id_prod'];
        $id_categoria = $_POST['cat'];
        $preu_inicial = $_POST['preu_ini'];
        $nom = $_POST['nom'];
        $desc_llarga = $_POST['desc_llarga'];
        $url_foto = $_POST['url_foto'];
         

        $dao = new DAOProduct();
        $dao->update($id_producte,$id_categoria, $preu_inicial, $nom, $desc_llarga, $url_foto);

        $view = new ViewClass("index", "?view=prodDetails&prod=" . $id_producte);
        $view->render();
    }

}
