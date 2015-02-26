<?php

class ViewClass {
    private $layout;

    public function __construct($action) {
        $this->layout = "../Views/" . $action . ".php";
    }

    public function render() {
        include($this->layout);
    }
}

?>