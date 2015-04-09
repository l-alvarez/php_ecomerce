<?php

class ViewClass {

    private $layout;

    public function __construct($action, $params) {
        $this->layout = "Views/" . $action . ".php" . $params;
    }

    public function render() {
        header("Location: ../" . $this->layout);
        die();
    }

}
