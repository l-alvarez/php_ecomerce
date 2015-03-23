<?php

class ViewClass {

    private $layout;

//    public function __construct($action) {
//        $this->layout = "Views/" . $action . ".php";
//    }

    public function __construct($action, $params) {
        $this->layout = "Views/" . $action . ".php" . $params;
    }

    public function render() {
        //include($this->layout);
        header("Location: http://localhost/sce/" . $this->layout);
        die();
    }

}

?>