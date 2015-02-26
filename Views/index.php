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
        include '../Config/conBd.php';

        if (!isset($_COOKIE['lang'])) {
            $idioma = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
            setcookie("lang",$idioma,time()+3600);
        } else {
            $idioma=$_COOKIE['lang'];
        }
        
        include_once "../lang/{$idioma}_lang.php";
        ?>
    </head>
    <body>

        <div id="pagewrap">

            <div id="header">
                <h1>Header</h1>
                <div id= idiomas>
                    <a href="../Controllers/controller.php?controller=LangController&action=setLang&idioma=en"> <img class="langimg" src="../img/in.png"> </a>
                    <a href="../Controllers/controller.php?controller=LangController&action=setLang&idioma=es"> <img class="langimg" src="../img/sp.png"> </a>
                    <a href="../Controllers/controller.php?controller=LangController&action=setLang&idioma=ca"> <img class="langimg" src="../img/cat.png"> </a>
                    <?php
                    echo LABEL_BENVINGUDA;
                    ?>
                </div>
            </div>

            <div id="content">
                <?php
                echo LABEL_PRODUCTES;


                $db = new DBConnection();
                $iden = $db->getConn();

                function sql_dump_result($result) {
                    $line = '';
                    $head = '';

                    while ($temp = mysql_fetch_assoc($result)) {
                        if (empty($head)) {
                            $keys = array_keys($temp);
                            $head = '<tr><th>' . implode('</th><th>', $keys) . '</th></tr>';
                        }

                        $line .= '<tr><td>' . implode('</td><td>', $temp) . '</td></tr>';
                    }

                    return '<table>' . $head . $line . '</table>';
                }

                $sentencia = "SELECT estoc, desc_curta, url_foto FROM producte";
                $resultado = mysql_query($sentencia, $iden);
                if (!$resultado)
                    die("Error: no se pudo realizar la consulta");

                // Muestra el contenido de la tabla como una tabla HTML	
                echo sql_dump_result($resultado);

                // Libera la memoria del resultado
                mysql_free_result($resultado);

                // Cierra la conexión con la base de datos 
                mysql_close($iden);
                ?> 
            </div>

            <div id="sidebar">
                <?php
                echo LABEL_MENU;
                ?>

            </div>

            <div id="footer">
                <?php
                echo LABEL_INFO;
                ?>
            </div>

        </div>

    </body>
</html>