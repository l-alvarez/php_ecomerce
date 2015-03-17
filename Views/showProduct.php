<?php
include '../Controllers/ProducteController.php';

echo LABEL_PRODUCTES;

$prod = new ProducteController();
$resultado = $prod->selectById($_GET['id']);

function sql_dump_result($result) {
    $line = '';
    $head = '';

    while ($temp = mysql_fetch_assoc($result)) {
        if (empty($head)) {
            $keys = array_keys($temp);
            $head = '<tr id="ctabla"><th>'.LABEL_ESTOC.'</th><th>'.LABEL_NOM.'</th><th>'.LABEL_FOTO.'</th></tr>';
        }
        $line .= '<tr><td></td><td><a href="../Controllers/Command.php?controller=ProducteController&action=show&id='.$temp['id_producte'].'">'.$temp['nom'].'</a></td><td><img src=' . $temp['url_foto'] . ' WIDTH=100 HEIGHT=100></td></tr>';
    }
    return '<table id="tabla productos">' . $head . $line . '</table>';
}

if (!$resultado)
    die("Error: no se pudo realizar la consulta");

echo sql_dump_result($resultado);

?>

