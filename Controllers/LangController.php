<?php

include_once '../Models/ViewClass.php';
include_once '../Controllers/UserController.php';

class LangController {

    public function setLang() {
        
        $idioma = $_GET["idioma"];
        
        session_start();

        if (isset($_SESSION)) {
            $_SESSION['lang'] = $idioma;
            $ctrl = new UserController();
            $ctrl->setLang($_SESSION['user'], $idioma);
        }

        setcookie("lang", $idioma, time() + 3600, "/sce/");
        $view = new ViewClass("index", "");
        $view->render();
    }

}
