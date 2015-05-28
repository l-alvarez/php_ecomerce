<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
    header("Location: http://". $_SERVER['HTTP_HOST'] ."/sce/Views/index.php?view=error&error=3");
}

include_once '../Controllers/SubastaController.php';


$sub= new SubastaController();
$resultado = $sub->selectAll();

function list_subasta($result) {
    $line = '';

    while ($temp = mysql_fetch_assoc($result)) {
        include_once '../Controllers/ProductController.php';
        $id = (double) $temp['id_producte'];
        $prod = new ProductController();
        $res = $prod ->selectById($id);
        $info = $res->fetch_assoc();

        
        
        
        //$hola= $res['nom'];
        //echo $hola;
        $line .= '<tr><td><a href="../Controllers/Command.php?controller=SubastaController&action=details&sub=' . $temp['id_subhasta'] . '">' . $info['nom'] . '</a></td>'
                . '<td><a href="../Controllers/Command.php?controller=SubastaController&action=delete&sub=' . $temp['id_subhasta'] . '">' . LABEL_DELETE . '</a></td></tr>';
    }
    return '<table id="tabla subasta">' . $line . '</table>';
}

if (!$resultado) {
    die("Error: no se pudo realizar la consulta");
}

echo '<a href="../Controllers/Command.php?controller=SubastaController&action=createView" >' . LABEL_CREATE_SUBASTA . '</a>';

echo list_subasta($resultado);
