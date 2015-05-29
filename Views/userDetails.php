<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
}

include_once '../Controllers/UserController.php';

if (isset($_GET['usr'])) {
    $id = $_GET['usr'];

    $ctrl = new UserController();
    $info = $ctrl->selectById($id);
    $user = $info->fetch_assoc();

    $name = $user['login'];
    $type = $user['tipus_usuari'];

    if ($type == 1) {
        $typeT = LABEL_ADMIN;
    } else {
        $typeT = LABEL_USER;
    }

    $date = $user['data_registrat'];
    $mail = $user['email'];
    $baixa = $user['baixa_logica'];

    if ($baixa == 1) {
        $verified = LABEL_YES;
    } else {
        $verified = LABEL_NO;
    }

    $direccio = $user['direccio'];
    $name = $user['nom'];
    $surname = $user['cognom'];
    $nif = $user['nif'];

    $lang = $user['idioma'];
    $pregunta = $user['pregunta'];
} else {
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=1");
}
?>

<div id="formulari">
    <form method="post" action="../Controllers/Command.php?controller=UserController&action=modify" name="update">
        <fieldset>
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <input type="hidden" value="<?php echo $nif ?>" name="nif" id="nif"/>
            <?php echo "Id: " . $id ?>
            <br>
            <?php echo LABEL_NIF . ": " . $nif ?> 
            <br>
            <?php echo LABEL_USERNAME ?>: <input type="text" value="<?php echo $name ?>" name="login" id="login"/>
            <br>
            <?php echo LABEL_NAME ?>: <input type="text" value="<?php echo $name ?>" name="name" id="name"/>
            <br>
            <?php echo LABEL_SURNAME ?>: <input type="text" value="<?php echo $surname ?>" name="surname" id="surname"/>
            <br>
            <?php echo LABEL_DIRECCION . ": " ?><input type="text" name="direccio" value="<?php echo $direccio ?>">
            <br>
            <?php echo LABEL_MAIL ?>: <input type="text" name="email" value="<?php echo $mail; ?>" />
            <br>
            <?php echo LABEL_DATE . ": " . $date ?>
            <br>
            <?php echo LABEL_USER_TYPE . ': ' . $typeT ?>
            <br>
            <select name="type">
                <option value="<?php echo $type ?>"><?php echo LABEL_CHOOSE_NEW ?></option>
                <option value="0"><?php echo LABEL_USER ?></option>
                <option value="1"><?php echo LABEL_ADMIN ?></option>
            </select>
            <br>
            <?php echo LABEL_VERIFIED . ': ' . $verified ?>
            <br>
            <select name="baixa">
                <option value="<?php echo $baixa ?>"><?php echo LABEL_CHOOSE_NEW ?></option>
                <option value="1"><?php echo LABEL_YES ?></option>
                <option value="0"><?php echo LABEL_NO ?></option>
            </select>
            <br>
            <?php echo LABEL_LANG . ': ' . $lang ?>
            <br>
            <select name="lang">
                <option value="<?php echo $lang ?>"><?php echo LABEL_CHOOSE_NEW ?></option>
                <option value="es">Español</option>
                <option value="en">English</option>
                <option value="cat">Català</option>
            </select>
            <br>
            <?php echo LABEL_QUESTION . ': ' . $pregunta ?>
            <br>
            <input type="submit" value="<?php echo LABEL_UPDATE ?>"/>
            <br>
        </fieldset>
    </form>
</div>