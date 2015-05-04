<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
    header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
}

$err = "";
if (isset($_GET['err'])) {
    $err = LABEL_DISCOUNT_ERROR;
}

include_once '../Controllers/CategoryController.php';
include_once '../Controllers/UserController.php';

$categories = "";
$catCtrl = new CategoryController();
$allCats = $catCtrl->selectAll();

while ($next = mysql_fetch_assoc($allCats)) {
    $categories .='<option value="' . $next['id_categoria'] . '">' . $next['nom'] . '</option>';
}

$users = "";
$usrCtrl = new UserController();
$allUsrs = $usrCtrl->selectAll();

while ($next = mysql_fetch_assoc($allUsrs)) {
    $users .='<option value="' . $next['id_usuari'] . '">' . $next['login'] . '</option>';
}

echo $err;
?>

<div id="formulari">
    <form method="post" action="../Controllers/Command.php?controller=CodeController&action=create" name="update">
        <fieldset>
            <?php echo LABEL_DISCOUNT . ': ' ?><input type="text" min="5" max="75" name="discount"/> %
            <br><br>
            <div>
                <?php echo LABEL_CATEGORIES; ?>
                <br>

                <select name="categories[]" multiple="">
                    <?php echo $categories ?>
                </select>
            </div>
            <br>
            <div>
                <?php echo LABEL_USER . "s"; ?>
                <br>
                <select name="users[]" multiple="">
                    <?php echo $users; ?>
                </select>
            </div>
            <br>
            <div>
                <input type="checkbox" name="unique" /><?php echo LABEL_UNIQUE_USE ?>
                <br>
                <input type="checkbox" name="active" /><?php echo LABEL_ACTIVE ?>
            </div>
            <br>
            <?php echo LABEL_DATA_LIMIT ?>: <input type="date" name="data_limit" id="data_limit"/>
            <br><br>
            <input type="submit" value="<?php echo LABEL_ACCEPT ?>"/>
        </fieldset>
    </form>
</div>