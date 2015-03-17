<?php
include '../Controllers/ProducteController.php';
$prod = new ProducteController();
$resultado = $prod->selectById($_GET['id']);

function sql_dump_result($result) {
    $line = '';
    $line1 = '';
    $line0 = '';

    while ($temp = mysql_fetch_assoc($result)) {
        $line0.='<p>/'.$temp['id_categoria'].'>'.$temp['nom'].'</p>';
        $line .= '<tr><td>' . $temp['nom'] . '</a></td><td><img src=' . $temp['url_foto'] . ' WIDTH=100 HEIGHT=100></td></tr>';
        $line1.='<tr><td>' . $temp['desc_llarga'] . '</td></tr>';
    }
    return $line0.'<table id="tabla productos">' . $line . $line1 . '</table>';
}
if (!$resultado) {
    die("Error: no se pudo realizar la consulta");
}

echo sql_dump_result($resultado);

//echo '<table id = "temporizador"><tr><td> '. include'../javascript/contador.php' . '</td><td></td></tr></table >';
?>



