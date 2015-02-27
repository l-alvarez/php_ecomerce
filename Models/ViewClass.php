<?php
class ViewClass {
    private $layout;

    public function __construct($action) {
        $this->layout = "../" . $action . ".php";
    }

    public function render() {
        include($this->layout);
    }
}
?>