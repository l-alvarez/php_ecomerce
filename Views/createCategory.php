<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
    header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
}

include_once '../Controllers/CategoryController.php';

$options = "";
$ctrl = new CategoryController();
$all = $ctrl->selectAll();

while ($next = mysql_fetch_assoc($all)) {
    $options .='<option value="' . $next['id_categoria'] . '">' . $next['nom'] . '</option>';
}
?>

<div id="formulari">
    <form method="post" action="../Controllers/Command.php?controller=CategoryController&action=create" name="update">
        <fieldset>
            <br>
            <?php echo LABEL_NAME ?>: <input type="text" placeholder="<?php echo LABEL_NAME ?>" name="name" id="name"/>
            <br>
            <?php echo LABEL_DESCRIPTION ?>:<br> <textarea name="desc"><?php echo LABEL_DESCRIPTION ?></textarea>
            <br>
            <select name="padre">
                <option value="-1"><?php echo LABEL_NONE ?></option>
                <?php echo $options ?>
            </select>
            <br>
            <input type="submit" value="<?php echo LABEL_ACCEPT ?>"/>
            <br>
        </fieldset>
    </form>
</div>