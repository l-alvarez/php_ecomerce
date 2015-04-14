<?php

?>
<form method = "post" action = "../Controllers/Command.php?controller=AccesController&action=recovery" name = "login">
    <fieldset>
        <?php echo '<legend>' . LABEL_PASWD_RECOVERY . '</legend>' ?>
        <input type="text" placeholder="<?php echo LABEL_USERNAME ?>" name="user" id="user"/>
        <br/>
        <?php echo '<input type="submit" value="' . LABEL_ACCEPT . '"/>' ?>
    </fieldset>
</form>
