<?php

include_once '../Controllers/ProductController.php';
include_once '../Controllers/SubastaController.php';

//echo LABEL_PRODUCTES;
$prod = new ProductController();


if (isset($_GET['find'])) {
    $word = $_GET['find'];
    $resultado = $prod->selectByKeyWord($word);
} else if (isset($_GET['filtr'])) {
    $cat = (int) $_GET['filtr'];
    $resultado = $prod->selectByCategory($cat);
} else {
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=1");
}

function sql_dump_result($result) {
    $sub = new SubastaController();
    $line = '';
    $head = '<tr id="ctabla"><th>' . LABEL_LEFT_TIME . '</th><th>' . LABEL_NOM . '</th><th>' . LABEL_FOTO . '</th></tr>';

    while ($producte = $result->fetch_assoc()) {
        $allAuc = $sub->selectByProduct($producte['id_producte']);

        if ($allAuc->num_rows != 0) {
            while ($temp = $allAuc->fetch_assoc()) {
                $milliseconds = round(microtime(true) * 1000);
                $mili = strtotime($temp['hora_limit'] . $temp['data_limit']) - strtotime($milliseconds);

                $line .= '<tr><td> <img src="http://gifcountdown.com/europe-madrid/' . $mili . '/fdfdfd/000000/000000/333333/000000/true/counter.gif" WIDTH=170 HEIGHT=100> ' .
                        ' </td><td><a href="../Controllers/Command.php?controller=SubastaController&action=show&id=' . $temp['id_subhasta'] . '">' . $producte['nom'] . '</a></td>' .
                        '<td><img src=' . $producte['url_foto'] . ' WIDTH=100 HEIGHT=100></td></tr>';
            }
        }
    }
    return '<table id="tabla productos">' . $head . $line . '</table>';
}

if (!$resultado) {
    die("Error: no se pudo realizar la consulta");
}

if ($resultado->num_rows == 0) {
    echo LABEL_NO_RESULTS;
} else {
    echo sql_dump_result($resultado);
}


