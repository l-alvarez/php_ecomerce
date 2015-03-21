<?php

$controllers = ["ProductController","LangController","CategoryController"];

if (isset($_GET['controller']) && in_array($_GET['controller'], $controllers)) {
	require_once($_GET['controller'].".php");
	$controller = new $_GET['controller']();
	if (isset($_GET['action']) && method_exists($controller, $_GET['action'])){
		$controller->$_GET['action']();
	} else {
            //TODO: redirect to error page
        }
} else {
    //TODO: redirect to error page
}
?>

