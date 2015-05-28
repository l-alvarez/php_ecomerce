<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
    header("Location: http://". $_SERVER['HTTP_HOST'] ."/sce/Views/index.php?view=error&error=3");
}

include_once '../Controllers/CategoryController.php';

$ctrl = new CategoryController();
$resultado = $ctrl->selectAll();

function list_categories($result) {
    $line = '';

    while ($temp = mysql_fetch_assoc($result)) {
        $line .= '<tr><td><a href="../Controllers/Command.php?controller=CategoryController&action=details&cat=' . $temp['id_categoria'] . '">' . $temp['nom'] . '</a></td>'
                . '<td><a href="../Controllers/Command.php?controller=CategoryController&action=delete&cat=' . $temp['id_categoria'] . '">' . LABEL_DELETE . '</a></td></tr>';
    }
    return '<table id="tabla productos">' . $line . '</table>';
}

if (!$resultado) {
    die("Error: no se pudo realizar la consulta");
}

echo '<a href="../Controllers/Command.php?controller=CategoryController&action=createView" >' . LABEL_CREATE_CATEGORY . '</a>';

echo list_categories($resultado);
