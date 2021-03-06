<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
    header("Location: http://". $_SERVER['HTTP_HOST'] ."/sce/Views/index.php?view=error&error=3");
}

include_once '../Controllers/UserController.php';

$ctrl = new UserController();
$resultado = $ctrl->selectAll();

function list_users($result) {
    $line = '';

    while ($temp = mysql_fetch_assoc($result)) {
        $line .= '<tr><td><a href="../Controllers/Command.php?controller=UserController&action=details&usr=' . $temp['id_usuari'] . '">' . $temp['login'] . '</a></td>'
                . '<td><a href="../Controllers/Command.php?controller=UserController&action=delete&usr=' . $temp['id_usuari'] . '">' . LABEL_DELETE . '</a></td></tr>';
    }
    return '<table id="tabla productos">' . $line . '</table>';
}

if (!$resultado) {
    die("Error: no se pudo realizar la consulta");
}

echo '<a href="../Controllers/Command.php?controller=UserController&action=createView" >' . LABEL_CREATE_USER . '</a>';

echo list_users($resultado);