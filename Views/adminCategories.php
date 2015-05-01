<?php
session_start();
if(!isset($_SESSION['type']) || $_SESSION['type'] != 1){
    header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
}

include_once '../Controllers/CategoryController.php';

$prod = new CategoryController();
$resultado = $prod->selectAll();

function list_categories($result) {
    $line = '';

    while ($temp = mysql_fetch_assoc($result)) {
        $line .= '<tr><td><a href="../Controllers/Command.php?controller=CategoryController&action=details&cat=' . $temp['id_categoria'] . '">' . $temp['nom'] . '</a></td></tr>';
    }
    return '<table id="tabla productos">' . $line . '</table>';
}

if (!$resultado) {
    die("Error: no se pudo realizar la consulta");
}

echo list_categories($resultado);