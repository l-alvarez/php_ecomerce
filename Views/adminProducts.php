
<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
    header("Location: http://". $_SERVER['HTTP_HOST'] ."/sce/Views/index.php?view=error&error=3");
}

include_once '../Controllers/ProductController.php';

$prod = new ProductController();
$resultado = $prod->selectAll();

function list_prod($result) {
    $line = '';

    while ($temp = mysql_fetch_assoc($result)) {
        $line .= '<tr><td><a href="../Controllers/Command.php?controller=ProductController&action=details&prod=' . $temp['id_producte'] . '">' . $temp['nom'] . '</a></td>'
                . '<td><a href="../Controllers/Command.php?controller=ProductController&action=delete&prod=' . $temp['id_producte'] . '">' . LABEL_DELETE . '</a></td></tr>';
    }
    return '<table id="tabla productos">' . $line . '</table>';
}

if (!$resultado) {
    die("Error: no se pudo realizar la consulta");
}

echo '<a href="../Controllers/Command.php?controller=ProductController&action=createView" >' . LABEL_CREATE_PRODUCT . '</a>';

echo list_prod($resultado);

