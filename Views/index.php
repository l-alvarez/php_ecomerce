<?php
if (!isset($_COOKIE["lang"])) {
    $idioma = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
    setcookie("lang", $idioma, time() + 3600, "/sce/");
} else {
    $idioma = $_COOKIE["lang"];
}
include "../lang/{$idioma}_lang.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../stylesheet/cssresponsivedesign.css">

        <!-- css3-mediaqueries.js for IE8 or older -->
        <!--[if lt IE 9]>
                <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
        <![endif]-->
        <title>Index</title>
        <?php
        foreach (glob("../Models/*.php") as $filename) {
            include_once $filename;
        }
        ?>
    </head>
    <body>
        <div id="pagewrap">

            <?php
            include_once './templates/header.php';
            ?>

            <div id="content">
                <?php
                echo LABEL_PRODUCTES;

                $prod = new Producte();
                $resultado = $prod->selectAll();

                function sql_dump_result($result) {
                    $line = '';
                    $head = '';

                    while ($temp = mysql_fetch_assoc($result)) {
                        if (empty($head)) {
                            $keys = array_keys($temp);
                            $head = '<tr id="ctabla"><th>Estoc</th><th>Nom</th><th>Foto</th></tr>';
                        }
                        $line .= '<tr><td>' . $temp['estoc'] . '</td><td>' . $temp['desc_curta'] . '</td><td><img src=' . $temp['url_foto'] . ' WIDTH=100 HEIGHT=100></td></tr>';
                    }
                    return '<table id="tabla productos">' . $head . $line . '</table>';
                }

                if (!$resultado)
                    die("Error: no se pudo realizar la consulta");

                echo sql_dump_result($resultado);
                ?> 
            </div>
            
            <?php
            include_once './templates/sidebar.php';
            ?>
            
            <?php
            include_once './templates/footer.php';
            ?>

        </div>

    </body>
</html>