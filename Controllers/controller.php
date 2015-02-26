<?php

if (isset($_GET['controller'])) {
	require_once($_GET['controller'].".php");
	$controller = new $_GET['controller']();
	if (isset($_GET['action'])){
		$controller->$_GET['action']($_GET['idioma']);
	}
}
?>

