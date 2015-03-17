<?php
include '../Models/ViewClass.php';

class LangController {
    public function setLang(){
        setcookie("lang", $_GET["idioma"], time() + 3600, "/sce/");
        $view = new ViewClass("index","");
        $view->render();
    }
}
?>