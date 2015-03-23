<html> 
    <head> 
        <meta  http-equiv="Content-Type" content="text/html;  charset=iso-8859-1"> 
    </head> 
    <p><body> 
        <?php
        echo LABEL_SEARCH . ':';

        echo '<form method="get" action="../Controllers/Command.php" id="searchform">';
        echo '<input style="max-width: 75%" type="text" name="name"> ';
        echo '<input type="hidden" name="controller" value="ProductController">';
        echo '<input type="hidden" name="action" value="search">';
        echo '<input  type="submit" name="submit" value="' . LABEL_SEARCH . '"> ';
        echo '</form> ';
        ?>
    </body> 
</html> 