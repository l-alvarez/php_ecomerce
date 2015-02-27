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
