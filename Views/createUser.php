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
        case 4:
            $label = LABEL_ERROR_SIGNUP_4;
            break;
    }
    echo $label;
}
?>

<div class="container">
    <section>
        <form method="post" action="../Controllers/Command.php?controller=UserController&action=create">
            <fieldset>
                <?php echo '<legend>' . LABEL_CREATE_USER . '</legend>' ?>
                <input type="hidden" name="form_action" value="signin" />

                <div id="userIdMessage">
                    <input type="text" placeholder="<?php echo LABEL_USERNAME; ?>" name="user_name" value="" required="required" id="username"/>
                </div>
                <div>
                    <input type="text" placeholder="<?php echo LABEL_NAME; ?>" name="name" required="" id="name"/>
                </div>
                <div>
                    <input type="text" placeholder="<?php echo LABEL_SURNAME; ?>" name="surname" required="" id="surname"/>
                </div>
                <div>
                    <input type="text" placeholder="<?php echo LABEL_NIF; ?>" name="nif" required="" id="nif"/>
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
                    <input type="text" placeholder="<?php echo LABEL_DIRECCION; ?>" name="direccion" required="" id="direccion"/>
                </div>
                <?php echo LABEL_USER_TYPE . ':' ?>
                <div>
                    <select name="type">
                        <option value="0"><?php echo LABEL_USER ?></option>
                        <option value="1"><?php echo LABEL_ADMIN ?></option>
                    </select>
                </div>
                <?php echo LABEL_VERIFIED . ':' ?>
                <div>
                    <select name="baixa">
                        <option value="1"><?php echo LABEL_YES ?></option>
                        <option value="0"><?php echo LABEL_NO ?></option>
                    </select>
                </div>
                <?php echo LABEL_LANG . ':' ?>
                <div>
                    <select name="lang">
                        <option value="es">Español</option>
                        <option value="en">English</option>
                        <option value="cat">Català</option>
                    </select>
                </div>
                <div>
                    <input type="submit" name="enter" value="<?php echo LABEL_ACCEPT ?>"/>
                </div>
            </fieldset>
        </form>
    </section>
</div>