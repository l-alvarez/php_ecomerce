<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
    header("Location: http://". $_SERVER['HTTP_HOST'] ."/sce/Views/index.php?view=error&error=3");
}

include_once '../Controllers/ProductController.php';
include_once '../Controllers/SubastaController.php';
$options = "";
$ctrl = new ProductController();
$all = $ctrl->selectAll();

while ($next = mysql_fetch_assoc($all)) {
    $options .='<option value="' . $next['id_producte'] . '">' . $next['nom'] . '</option>';
}
?>

<div id="formulari">
    <form method="post" action="../Controllers/Command.php?controller=SubastaController&action=create" name="create">
        <fieldset>
            <br>
            <?php echo LABEL_PRODUCTES?>
            <select name="id_prod">
                <option value="-1"><?php echo LABEL_NONE ?></option>
                <?php echo $options ?>
            </select>
            <br>
            <br>
            <?php echo LABEL_DATA_LIMIT ?>: <input type="date" placeholder="<?php echo LABEL_DATA_LIMIT ?>" name="data_limit" id="data_limit"/>
            <br>
            <?php echo LABEL_TIME ?>: <input type="time" placeholder="<?php echo LABEL_TIME ?>" name="time" id="time"/>
            <br>
            <?php echo LABEL_PRICE ?>: <input type="text" placeholder="<?php echo LABEL_PRICE ?>" value="0" name="price" id="price"/> €
            <br>
            <input type="submit" value="<?php echo LABEL_ACCEPT ?>"/>
            <br>
        </fieldset>
    </form>
</div>