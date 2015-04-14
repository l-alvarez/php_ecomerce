<?php
if (isset($_GET['err'])) {
    echo LABEL_ERROR_LOGIN;
}
?>

<div id="pagina">
    <div id="login">
        <div id="formulari">
            <form method="post" action="../Controllers/Command.php?controller=AccesController&action=login" name="login">
                <fieldset>
                    <?php echo '<legend>' . LABEL_LOGIN . '</legend>' ?>
                    <input type="text" placeholder="<?php echo LABEL_USERNAME ?>" name="user" id="user"/>
                    <br/>
                    <input type="password" placeholder="<?php echo LABEL_PASS ?>" name="password" id="password"/>
                    <br/>
                    <?php echo '<input type="submit" value="' . LABEL_LOGIN . '"/>' ?>
                    <input type="button" onClick="location.href = './index.php?view=signup'" value="<?php echo LABEL_SIGNUP ?>">
                </fieldset>
            </form>
        </div>
    </div>
</div>
