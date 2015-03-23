<?php

include_once '../Controllers/ProductController.php';
include_once '../Controllers/CategoryController.php';

if (isset($_GET['id'])) {
    $prod = new ProductController();
    $resultado = $prod->selectById($_GET['id']);
    $cat = new CategoryController();

    if (!$resultado) {
        die("Error: no se pudo realizar la consulta");
    }

    echo mostrar_producte($resultado, $cat);
} else {
    header("Location: http://localhost/sce/Views/index.php?view=error&error=1");
}

function mostrar_producte($result, $cat) {
    $line = '';
    $line1 = '';
    $line0 = '';

    while ($temp = $result->fetch_assoc()) {
        $category = $cat->selectById($temp['id_categoria']);
        $name = $category->fetch_assoc()['nom'];
        $line0.='<p>' . $name . '>>' . $temp['nom'] . '</p>';
        $line .= '<tr><td>' . $temp['nom'] . '</a></td><td><img src=' . $temp['url_foto'] . ' WIDTH=100 HEIGHT=100></td></tr>';
        $line1.='<tr><td>' . $temp['desc_llarga'] . '</td></tr>';
    }
    return $line0 . '<table id="tabla productos">' . $line . $line1 . '</table>';
}
