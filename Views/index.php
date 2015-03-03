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

            <div id="header">
                <a href="/sce/Views/index.php"><h1>Header</h1></a>
                <?php
                echo LABEL_BENVINGUDA;
                ?>
                <div id="idiomas">
                    <a href="../Controllers/Command.php?controller=LangController&action=setLang&idioma=en"> <img class="langimg" src="../img/in.png"> </a>
                    <a href="../Controllers/Command.php?controller=LangController&action=setLang&idioma=es"> <img class="langimg" src="../img/sp.png"> </a>
                    <a href="../Controllers/Command.php?controller=LangController&action=setLang&idioma=ca"> <img class="langimg" src="../img/cat.png"> </a>
                </div>
            </div>


            <div id="content">
                <?php
                include './list.php';
                ?>
            </div>

            <div id = "sidebar">
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