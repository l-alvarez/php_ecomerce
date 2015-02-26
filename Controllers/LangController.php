<?php
include '../Models/ViewClass.php';

class LangController {
    public function setLang() {
        $_COOKIE['lang'] = $_GET['idioma'];
        $view = new ViewClass("index");
        $view->render();
    }
}
?>