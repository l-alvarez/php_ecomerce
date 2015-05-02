<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
    header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
}

include_once '../Controllers/SubastaController.php';

$prod = new SubastaController();
$resultado = $prod->selectAll();

function list_subasta($result) {
    $line = '';

    while ($temp = mysql_fetch_assoc($result)) {
        $line .= '<tr><td><a href="../Controllers/Command.php?controller=SubastaController&action=details&sub=' . $temp['id_subhasta'] . '">' . $temp['id_subhasta'] . '</a></td>'
                . '<td><a href="../Controllers/Command.php?controller=SubastaController&action=delete&sub=' . $temp['id_subhasta'] . '">' . LABEL_DELETE . '</a></td></tr>';
    }
    return '<table id="tabla subasta">' . $line . '</table>';
}

if (!$resultado) {
    die("Error: no se pudo realizar la consulta");
}

echo '<a href="../Controllers/Command.php?controller=SubastaController&action=createView" >' . LABEL_CREATE_SUBASTA . '</a>';

echo list_subasta($resultado);
