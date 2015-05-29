<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id_user']) || $_SESSION['loged'] != 1) {
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=error&error=3");
}

include_once '../Controllers/UserController.php';

$id = $_SESSION['id_user'];

$ctrl = new UserController();
$info = $ctrl->selectById($id);
$user = $info->fetch_assoc();

$login = $user['login'];
$type = $user['tipus_usuari'];

$date = $user['data_registrat'];
$mail = $user['email'];
$baixa = $user['baixa_logica'];

$direccio = $user['direccio'];
$name = $user['nom'];
$surname = $user['cognom'];
$nif = $user['nif'];

$lang = $user['idioma'];
$pregunta = $user['pregunta'];
?>

<div id="formulari">
    <form method="post" action="../Controllers/Command.php?controller=UserController&action=update" name="update">
        <fieldset>
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <input type="hidden" name="type" value="<?php echo $type ?>">
            <input type="hidden" name="baixa" value="<?php echo $baixa ?>">
            <?php echo LABEL_NIF ?>: <input type="text" value="<?php echo $nif ?>" name="nif" id="nif"/>
            <br>
            <?php echo LABEL_USERNAME ?>: <input type="text" value="<?php echo $login ?>" name="login" id="login"/>
            <br>
            <?php echo LABEL_NAME ?>: <input type="text" value="<?php echo $name ?>" name="name" id="name"/>
            <br>
            <?php echo LABEL_SURNAME ?>: <input type="text" value="<?php echo $surname ?>" name="surname" id="surname"/>
            <br>
            <?php echo LABEL_MAIL ?>: <input type="text" name="email" value="<?php echo $mail; ?>" />
            <br>
            <?php echo LABEL_DATE . ": " . $date ?>
            <br>
            <?php echo LABEL_DIRECCION . ": " ?><input type="text" name="direccio" value="<?php echo $direccio ?>">
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