<?php
include '../Models/ViewClass.php';

class LangController {
    public function setLang($idioma) {
        $_COOKIE['lang'] = $idioma;
        $view = new ViewClass("index");
        $view->render();
    }
}
?>