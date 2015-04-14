<?php
if (isset($_GET['err'])) {
    $err = $_GET['err'];
    switch ($err) {
        case 0:
            $label = LABEL_ERROR_SIGNUP_0;
            break;
        case 1:
            $label = LABEL_ERROR_SIGNUP_1;
            break;
        case 2:
            $label = LABEL_ERROR_SIGNUP_2;
            break;
        case 3:
            $label = LABEL_ERROR_SIGNUP_3;
            break;
    }
    echo $label;
}
?>

<div class="container">
    <section>
        <form method="post" action="../Controllers/Command.php?controller=AccesController&action=signup">
            <fieldset>
                <?php echo '<legend>' . LABEL_SIGNUP . '</legend>' ?>
                <input type="hidden" name="form_action" value="signin" />

                <div id="userIdMessage">
                    <input type="text" placeholder="<?php echo LABEL_USERNAME; ?>" name="user_name" value="" required="required" id="username"/>
                </div>
                <div>
                    <input type="password" placeholder="<?php echo LABEL_PASS; ?>" name="password" value="" required="required" id="passwordsign"/>
                </div>
                <div>
                    <input type="password" placeholder="<?php echo LABEL_PASS; ?>" name="password2" value="" required="required" id="passwordsign2"/>
                </div>
                <div>
                    <input type="text" placeholder="<?php echo LABEL_QUESTION; ?>" name="pregunta" value=""  id="pregunta" />
                </div>
                <div>
                    <input type="text" placeholder="<?php echo LABEL_ANSWER; ?>" name="respuesta" value=""  id="respuesta" />
                </div>
                <div>
                    <input type="email" placeholder="<?php echo LABEL_MAIL; ?>" name="email" value="" required="required" id="email" />
                </div>
                <div>
                    <input type="submit" name="enter" value="Enter"/>
                    <input type="button" onClick="location.href = './index.php?view=login'" value="<?php echo LABEL_LOGIN ?>">
                </div>
            </fieldset>
        </form>
    </section>
</div>