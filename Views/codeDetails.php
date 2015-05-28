<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
    header("Location: http://". $_SERVER['HTTP_HOST'] ."/sce/Views/index.php?view=error&error=3");
}

include_once '../Controllers/CodeController.php';
include_once '../Controllers/CategoryController.php';
include_once '../Controllers/UserController.php';

$codeCtrl = new CodeController();

$short = $_GET['code'];

$all = $codeCtrl->selectOne($short);
$infos = $all->fetch_assoc();
$code = $infos['codigo'];

$active = $infos['activo'];
if($active == 1) {
    $chkActive = 'checked=""';
} else {
    $chkActive = "";
}

$dec = $codeCtrl->encrypt_decrypt('decrypt', $code);

$discount = strtok($dec, '|');
$date = strtok('|');
$unique = strtok('|');
$users = strtok('|');
$cat = strtok('|');

if ($date == -1) {
    $showDate = "";
} else {
    $showDate = $date;
}

if ($unique == 1) {
    $check = 'checked=""';
} else {
    $check = "";
}

if ($users == -1) {
    $showUsers = LABEL_ALL;
} else {
    $usrCtrl = new UserController();
    $showUsers = '';
    $userId = strtok($users, ",");

    while ($userId !== false) {
        $usr = $usrCtrl->selectById($userId);
        $usrInfo = $usr->fetch_assoc();

        $showUsers .= '<b>' . $usrInfo['login'] . '</b><br>';
        $userId = strtok(",");
    }
}

if ($cat == -1) {
    $showCat = LABEL_ALL;
} else {
    $catCtrl = new CategoryController();
    $showCat = '';
    $catId = strtok($cat, ",");

    while ($catId !== false) {
        $ct = $catCtrl->selectById($catId);
        $catInfo = $ct->fetch_assoc();

        $showCat .= '<b>' . $catInfo['nom'] . '</b><br>';
        $catId = strtok(",");
    }
}
?>

<div id="formulari">
    <form method="post" action="../Controllers/Command.php?controller=CodeController&action=update" name="update">
        <fieldset>
            <?php echo LABEL_CODE_SHORT ?>: <input type="text" disabled="" value="<?php echo $short ?>" name="code"/>
            <br>
            <?php echo LABEL_CODE_LONG . ': ' . $code ?>
            <br><br>
            <?php echo LABEL_DISCOUNT . ': ' . $discount . ' %' ?>
            <br><br>
            <div>
                <?php echo LABEL_CATEGORIES . ':' ?>
                <br>
                <?php echo $showCat ?>
            </div>
            <br>
            <div>
                <?php echo LABEL_USER . "s:" ?>
                <br>
                <?php echo $showUsers ?>
            </div>
            <br>
            <div>
                <input type="checkbox" disabled="" <?php echo $check; ?> name="unique" /><?php echo LABEL_UNIQUE_USE ?>
                <br>
                <input type="checkbox" name="active" <?php echo $chkActive; ?> /><?php echo LABEL_ACTIVE ?>
            </div>
            <br>
            <?php echo LABEL_DATA_LIMIT ?>: <input type="date" name="data_limit" disabled="" value="<?php echo $showDate ?>" id="data_limit"/>
            <br><br>
            <input type="submit" value="<?php echo LABEL_ACCEPT ?>"/>
        </fieldset>
    </form>
</div>