<?php
if (isset($_GET['err'])) {
    $err = $_GET['err'];
    switch ($err) {
        case 1:
            $label = LABEL_ERROR_SIGNUP_0;
            break;
        case 2:
            $label = LABEL_ERROR_SIGNUP_1;
            break;
        case 3:
            $label = LABEL_ERROR_ANSWER_INCORRECT;
            break;
    }
    echo $label;
}
?>
<div id="formulari">
    <form method="post" action="../Controllers/Command.php?controller=AccesController&action=pwdRecVerify" name="login">
        <fieldset>
            <input type="hidden" name="user" value="<?php echo $_SESSION['username'] ?>" />
            <?php
            echo '<legend>' . LABEL_PASWD_RECOVERY . '</legend>';

            echo $_SESSION['pregunta'] . "<br>";
            ?>
            <input type="text" placeholder="<?php echo LABEL_ANSWER ?>" name="respuesta" id="resp"/>
            <br/>
            <input type="password" placeholder="<?php echo LABEL_PASS ?>" name="password" id="password"/>
            <br/>
            <input type="password" placeholder="<?php echo LABEL_PASS ?>" name="password2" id="password2"/>
            <br/>
            <?php echo '<input type="submit" value="' . LABEL_ACCEPT . '"/>' ?>
        </fieldset>
    </form>
</div>