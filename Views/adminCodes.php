<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
    header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
}

include_once '../Controllers/CodeController.php';

$ctrl = new CodeController();
$resultado = $ctrl->selectAll();

function list_codes($result) {
    $line = '';

    while ($temp = mysql_fetch_assoc($result)) {
        $line .= '<tr><td><a href="../Controllers/Command.php?controller=CodeController&action=details&code=' . $temp['codigo'] . '">' . $temp['codigo'] . '</a></td>'
                . '<td><a href="../Controllers/Command.php?controller=CodeController&action=delete&code=' . $temp['codigo'] . '">' . LABEL_DELETE . '</a></td></tr>';
    }
    return '<table id="tabla productos">' . $line . '</table>';
}

if (!$resultado) {
    die("Error: no se pudo realizar la consulta");
}

echo '<a href="../Controllers/Command.php?controller=CodeController&action=createView" >' . LABEL_CREATE_CODE . '</a>';

echo list_codes($resultado);
