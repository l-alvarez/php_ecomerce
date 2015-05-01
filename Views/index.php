<?php
session_start();

if (!isset($_COOKIE["lang"])) {
    $idioma = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
    setcookie("lang", $idioma, time() + 3600, "/sce/");
} else {
    $idioma = $_COOKIE["lang"];
}
include_once "../lang/{$idioma}_lang.php";

if ($_SERVER['SERVER_PORT'] != '443') {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}

foreach (glob("../Models/*.php") as $filename) {
    include_once $filename;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <link rel="stylesheet" type="text/css" href="../stylesheet/cssresponsivedesign.css">

        <script src='https://www.google.com/recaptcha/api.js'></script>

        <!-- css3-mediaqueries.js for IE8 or older -->
        <!--[if lt IE 9]>
                <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
        <![endif]-->
        <title>Index</title>
    </head>
    <body>
        <div id="pagewrap">
            <div id="header">
                <a href="/sce/Views/index.php"><img src="../img/icono.jpg" style="height: 100px; width: 100px" ></a><br>
                <?php
                echo LABEL_BENVINGUDA;
                ?>
                <div style="height: 20px">
                    <div style="width: 100px; float:left" id="idiomas">
                        <a href="../Controllers/Command.php?controller=LangController&action=setLang&idioma=en"> <img class="langimg" src="../img/in.png"> </a>
                        <a href="../Controllers/Command.php?controller=LangController&action=setLang&idioma=es"> <img class="langimg" src="../img/sp.png"> </a>
                        <a href="../Controllers/Command.php?controller=LangController&action=setLang&idioma=ca"> <img class="langimg" src="../img/cat.png"> </a>
                    </div>
                    <?php
                    if (isset($_SESSION['user']) && $_SESSION['loged'] == 1) {
                        echo "<div id = 'login' style = \"width: auto; float: right; height: 20px\">";
                        echo LABEL_GREET . $_SESSION['user'] . " (<a href = \"../Controllers/Command.php?controller=AccesController&action=logout\">" . LABEL_LOGOUT . "</a>)";
                        echo "</div>";
                    } else {
                        echo "<div id = 'login' style = \"width: 150px; float: right; height: 20px\">";
                        echo "<a href = \"./index.php?view=login\">" . LABEL_LOGIN . "</a> / <a href = \"./index.php?view=signup\">" . LABEL_SIGNUP . "</a>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>


            <div id="content">
                <?php
                if (isset($_GET['view'])) {
                    if (file_exists('./' . $_GET['view'] . '.php')) {
                        include_once './' . $_GET['view'] . '.php';
                    } else {
                        header("Location: http://localhost/sce/Views/index.php?view=error&error=2");
                    }
                } else {
                    include_once './list.php';
                }
                ?>
            </div>

            <div id = "sidebar">
                <?php
                echo '<h3>' . LABEL_MENU . '</h3>';
                include_once './sidebar/search.php';

                if (isset($_SESSION['type']) && $_SESSION['type'] == 1) {
                    echo '<h3>Admin</h3>';
                    include_once './sidebar/sidebarAdmin.php';
                }

                echo '<h3>' . LABEL_CATEGORIES . '</h3>';
                include_once './sidebar/categories.php';
                ?>
            </div>

            <div id="footer">
                <a href="./index.php?view=legal"><?php echo LABEL_INFO; ?>
            </div>
        </div>
    </body>
</html>