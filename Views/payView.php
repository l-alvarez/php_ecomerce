<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['loged']) || $_SESSION['loged'] != 1 || !isset($_GET['id'])) {
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
}

include_once '../Controllers/SubastaController.php';
include_once '../Controllers/ProductController.php';
include_once '../Controllers/CodeController.php';
include_once '../Controllers/UserController.php';
include_once '../Controllers/CategoryController.php';

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

$err = "";

if ($_POST['code'] != "") {
    $codeCtrl = new CodeController();
    $short = $_POST['code'];

    $fetch = $codeCtrl->selectOne($short);
    $info = $fetch->fetch_assoc();
    $code = $info['codigo'];

    $active = $info['activo'];

    $dec = $codeCtrl->encrypt_decrypt('decrypt', $code);

    $discount = strtok($dec, '|');
    $date = strtok('|');
    $unique = strtok('|');
    $users = strtok('|');
    $cat = strtok('|');

    $validUser = false;
    $validCat = false;

    if ($users != -1) {
        $usrCtrl = new UserController();
        $userId = strtok($users, ",");

        while ($userId !== false || $validUser !== true) {
            $fetch = $usrCtrl->selectById($userId);
            $usrInfo = $fetch->fetch_assoc();

            if ($userId == $subasta['id_max_postor']) {
                $validUser = true;
            }

            $userId = strtok(",");
        }
    } else {
        $validUser = true;
    }

    if ($cat != -1) {
        $catCtrl = new CategoryController();
        $catId = strtok($cat, ",");

        while ($catId !== false || $validCat !== true) {
            $fetch = $catCtrl->selectById($catId);
            $catInfo = $fetch->fetch_assoc();

            if ($catId == $producte['id_categoria']) {
                $validCat = true;
            }

            $catId = strtok(",");
        }
    } else {
        $validCat = true;
    }

    if ($active != 1 || ($unique == 1 && $info['used'] == 1) || !$validCat || !$validUser || (strtotime("00:00:00" . $date) <= time())) {
        $err = LABEL_CODE_INVALID;
        $price = $subasta['preu_actual'];
    } else {
        $price = $subasta['preu_actual'] - ($subasta['preu_actual'] * ( $discount / 100 ));
        $codeCtrl->disable($short);
    }
} else {
    $price = $subasta['preu_actual'];
}

$name = $producte['nom'];

echo $err;
?>

<div style="margin-left: 10em">
    <?php echo $name ?>
    <br>
    <img src='<?php echo $producte['url_foto'] ?>' WIDTH=100 HEIGHT=100>
    <br>
    <?php echo $price . "€" ?>
</div>

<div style="margin-left:10em; float:left; margin-top:5em">
    <?php echo "<b>" . LABEL_PAY_PAYPAL . "</b>" ?>
    <script async="async" src="https://www.paypalobjects.com/js/external/paypal-button.min.js?merchant=luis.marc.sce2015-facilitator@gmail.com" 
            data-button="buynow" 
            data-name="<?php echo $name ?>" 
            data-quantity="1" 
            data-amount="<?php echo $price ?>" 
            data-currency="EUR" 
            data-shipping="0" 
            data-tax="0" 
            data-callback="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/sce/Tasks/PayPalCallback.php?sub=" . $idSub ?>" 
            data-env="sandbox"
    ></script>
</div>

<div style="margin-right:10em; float:right; margin-top:5em">
    <?php echo "<b>" . LABEL_PAY_STRIPE . "</b>" ?>
    <form action="" method="POST">
        <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="pk_test_6pRNASCoBOKtIshFeQd4XMUh"
            data-amount="<?php echo $price . "00" ?>"
            data-name="<?php echo $name ?>"
            data-description="<?php echo $producte['desc_llarga'] ?>"
            data-image="<?php echo $producte['url_foto'] ?>">
        </script>
    </form>
</div>