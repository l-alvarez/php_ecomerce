<?php

include_once '../Controllers/CategoryController.php';

//echo LABEL_PRODUCTES;

$prod = new CategoryController();
$resultado = $prod->selectAll();

function mostrar_categories($result) {
    $line = '';

    while ($temp = mysql_fetch_assoc($result)) {
        $line .= '<tr><td><a href="../Controllers/Command.php?controller=ProductController&action=search&cat='. $temp['id_categoria'] .'">' . $temp['nom'] . '</a></td></tr>';
    }
    return '<table id="tabla productos">' . $line . '</table>';
}

if (!$resultado) {
    die("Error: no se pudo realizar la consulta");
}
echo mostrar_categories($resultado);
