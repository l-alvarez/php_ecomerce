<?php

$controllers = ["ProductController", "LangController", "CategoryController", "AccesController", "SubastaController", "UserController", "CodeController"];

if (isset($_GET['controller']) && in_array($_GET['controller'], $controllers)) {
    include_once($_GET['controller'] . ".php");
    $controller = new $_GET['controller']();
    if (isset($_GET['action']) && method_exists($controller, $_GET['action'])) {
        $controller->$_GET['action']();
    } else {
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=1");
    }
} else {
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=1");
}
