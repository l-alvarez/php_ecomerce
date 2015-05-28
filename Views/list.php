<?php

include_once '../Controllers/ProductController.php';
include_once '../Controllers/SubastaController.php';

echo LABEL_PRODUCTES;

$sub = new SubastaController();
$resultado = $sub->selectAll();

function sql_dump_result($result) {
    $prod = new ProductController();
    $line = '';

    $head = '<tr id="ctabla"><th>' . LABEL_LEFT_TIME . '</th><th>' . LABEL_NOM . '</th><th>' . LABEL_FOTO . '</th></tr>';

    while ($temp = mysql_fetch_assoc($result)) {

        $fetch = $prod->selectById($temp['id_producte']);
        $producte = $fetch->fetch_assoc();

        $milliseconds = round(microtime(true) * 1000);
        $mili = strtotime($temp['hora_limit'] . $temp['data_limit']) - strtotime($milliseconds);

        $line .= '<tr><td> <img src="http://gifcountdown.com/europe-madrid/' . $mili . '/fdfdfd/000000/000000/333333/000000/true/counter.gif" WIDTH=170 HEIGHT=100> ' .
                ' </td><td><a href="../Controllers/Command.php?controller=SubastaController&action=show&id=' . $temp['id_subhasta'] . '">' . $producte['nom'] . '</a></td>' .
                '<td><img src=' . $producte['url_foto'] . ' WIDTH=100 HEIGHT=100></td></tr>';
    }
    return '<table id="tabla productos">' . $head . $line . '</table>';
}

if (!$resultado) {
    die("Error: no se pudo realizar la consulta");
}
echo sql_dump_result($resultado);
