<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
    header("Location: http://". $_SERVER['HTTP_HOST'] ."/sce/Views/index.php?view=error&error=3");
}

include_once '../Controllers/ProductController.php';
include_once '../Controllers/CategoryController.php';
$options = "";
$ctrl = new CategoryController();
$all = $ctrl->selectAll();

while ($next = mysql_fetch_assoc($all)) {
    $options .='<option value="' . $next['id_categoria'] . '">' . $next['nom'] . '</option>';
}
?>

<div id="formulari">
    <form method="post" action="../Controllers/Command.php?controller=ProductController&action=create" name="update">
        <fieldset>
            <?php echo LABEL_CATEGORIES?>
            <select name="id_cat">
                <option value="-1"><?php echo LABEL_NONE ?></option>
                <?php echo $options ?>
            </select>
            <br>
            <br>
            <?php echo LABEL_NAME ?>: <input type="text" placeholder="<?php echo LABEL_NAME ?>" name="nom" id="nom"/>
            <br>
            <br>
            <?php echo LABEL_PREU_INI ?>: <input type="text" placeholder="<?php echo LABEL_PREU_INI ?>" name="preu_ini" id="preu_ini"/>
            <br>
            <?php echo LABEL_DESCRIPTION ?>:<br> <textarea name="desc_llarga"><?php echo LABEL_DESCRIPTION ?></textarea>
            <br>
            <?php echo LABEL_URL_FOTO ?>: <input type="text" placeholder="<?php echo LABEL_URL_FOTO ?>" name="url_foto" id="url_foto"/>
            <br>
            <input type="submit" value="<?php echo LABEL_ACCEPT ?>"/>
            <br>
        </fieldset>
    </form>
</div>