<?php

include_once '../Controllers/ProductController.php';
include_once '../Controllers/SubastaController.php';
include_once '../Controllers/CategoryController.php';

if (isset($_GET['err'])) {
    echo LABEL_AUCTION_FINISHED;
}

if (isset($_GET['id'])) {
    $sub = new SubastaController();
    $result = $sub->selectById($_GET['id']);
    $subasta = $result->fetch_assoc();

    $prod = new ProductController();
    $resultado = $prod->selectById($subasta['id_producte']);
    $producto = $resultado->fetch_assoc();

    $cat = new CategoryController();

    if ($producto['id_categoria'] != -1) {
        $category = $cat->selectById($producto['id_categoria']);
        $name = $category->fetch_assoc()['nom'];
    } else {
        $name = LABEL_NONE;
    }

    $newPrice = $subasta['preu_actual'] + $subasta['increment'];
    $line0 = '<p>' . $name . '>>' . $producto['nom'] . '</p>';
    $line = '<tr><td>' . $producto['nom'] . '</a></td><td><img src=' . $producto['url_foto'] . ' WIDTH=100 HEIGHT=100></td></tr>';

    if ($subasta['estat'] == 0) {
        if (isset($_SESSION['loged']) && $_SESSION['loged'] == 1) {
            $line1 = '<tr><td>' . $producto['desc_llarga'] . '</td><td>' . $newPrice . '€' .
                    ' <button onclick="location.href=\'../Controllers/Command.php?controller=SubastaController&action=toBid&id=' . $subasta['id_subhasta'] . '\'">' . LABEL_PUJAR . '</button></td></tr>';
        } else {
            $line1 = '<tr><td>' . $producto['desc_llarga'] . '</td><td>' . $newPrice . '€ <button onclick="location.href=\'./index.php?view=signup\'">' . LABEL_LOGIN . '</button></td></tr>';
        }
    } else {
        $line1 = '<tr><td>' . $producto['desc_llarga'] . '</td><td>' . $subasta['preu_actual'] . '€ ' . LABEL_AUCTION_FINISHED . '</td></tr>';
    }


    $all = $line0 . '<table id="tabla productos">' . $line . $line1 . '</table>';

    echo $all;
} else {
    header("Location: " . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=1");
}
