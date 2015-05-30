<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['loged']) || $_SESSION['loged'] != 1 || !isset($_GET['id'])) {
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
}

include_once '../Controllers/SubastaController.php';
include_once '../Controllers/ProductController.php';

$idSub = $_GET['id'];

$subCtrl = new SubastaController();
$fetch = $subCtrl->selectById($idSub);
$subasta = $fetch->fetch_assoc();

if (!isset($_SESSION['id_user']) || $_SESSION['id_user'] != $subasta['id_max_postor']) {
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
}

$prodCtrl = new ProductController();
$fetch = $prodCtrl->selectById($subasta['id_producte']);
$producte = $fetch->fetch_assoc();

$price = $subasta['preu_actual'];
$name = $producte['nom'];
?>
<div style="margin-left: 10em">
    <?php echo $name ?>
    <br>
    <img src='<?php echo $producte['url_foto'] ?>' WIDTH=100 HEIGHT=100>
    <br>
    <?php echo $price . "€" ?>
</div>

<div id="formulari">
    <form method="post" action="./index.php?view=payView&id=<?php echo $idSub ?>" name="code">
        <fieldset>
            <input type="text" name="code" placeholder="<?php echo LABEL_CODE ?>">
            <br>
            <input type="submit" value="<?php echo LABEL_ACCEPT ?>"/>
            <br>
        </fieldset>
    </form>
</div>