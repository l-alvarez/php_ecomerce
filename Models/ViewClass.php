<?php

class ViewClass {

    private $layout;

    public function __construct($action) {
        $this->layout = "Views/" . $action . ".php";
    }

    public function render() {
        //include($this->layout);
        header("Location: http://localhost/sce/" . $this->layout);
        die();
    }

}

?>