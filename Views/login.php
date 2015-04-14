<?php
if (isset($_GET['err'])) {
    if ($_GET['err'] == 1) {
        echo LABEL_ERROR_LOGIN_VERIFIED;
    } else {
        echo LABEL_ERROR_LOGIN;
    }
}
// tu clave secreta
include_once "../Config/ReCaptcha.php";
/*$secret = "6LfbVwUTAAAAABXxjnGltsMj5nIN6etJyLutItJa";
 
// respuesta vacía
$response = null;
 
// comprueba la clave secreta
$reCaptcha = new ReCaptchaReCaptcha($secret, $requestMethod);

 * ?>
 */
?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<div id="formulari">
    <form method="post" action="../Controllers/Command.php?controller=AccesController&action=login" name="login">
        <fieldset>
            <?php echo '<legend>' . LABEL_LOGIN . '</legend>' ?>
            <input type="text" placeholder="<?php echo LABEL_USERNAME ?>" name="user" id="user"/>
            <br/>
            <input type="password" placeholder="<?php echo LABEL_PASS ?>" name="password" id="password"/>
            <br/>
            <div class="g-recaptcha" data-sitekey="6LfbVwUTAAAAALvm41fBHov9zLAEOTvO-nJ4AGKp"></div>
            <?php echo '<input type="submit" value="' . LABEL_LOGIN . '"/ payload>' ?>
            <input type="button" onClick="location.href = './index.php?view=signup'" value="<?php echo LABEL_SIGNUP ?>">
            <br>
            <a href="./index.php?view=paswdRecovery"><?php echo LABEL_PASWD_RECOVERY ?></a>

        </fieldset>
    </form>
</div>

