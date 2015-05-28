<?php

include_once '../Controllers/ProductController.php';

//echo LABEL_PRODUCTES;
$prod = new ProductController();
if (isset($_GET['find'])) {
    $word = $_GET['find'];
    $resultado = $prod->selectByKeyWord($word);
} else if (isset($_GET['filtr'])) {
    $cat = (int) $_GET['filtr'];
    $resultado = $prod->selectByCategory($cat);
} else {
    header("Location: http://". $_SERVER['HTTP_HOST'] ."/sce/Views/index.php?view=error&error=1");
}

function sql_dump_result($result) {
    $line = '';
    $head = '';

    while ($temp = $result->fetch_assoc()) {
        if (empty($head)) {
            $head = '<tr id="ctabla"><th>' . LABEL_ESTOC . '</th><th>' . LABEL_NOM . '</th><th>' . LABEL_FOTO . '</th></tr>';
        }
        $stock = (1 / 50) * 100;
        if ($stock > 100) {
            $stock = 100;
        }
        if ($stock < 0) {
            $stock = 0;
        }

        $line .= '<tr><td><div class="progress-bar blue stripes"><span style="margin-right:50%"></span></div></td><td><a href="../Controllers/Command.php?controller=ProductController&action=show&id=' . $temp['id_producte'] . '">' . $temp['nom'] . '</a></td><td><img src=' . $temp['url_foto'] . ' WIDTH=100 HEIGHT=100></td></tr>';
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


