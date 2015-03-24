<div class="container">
    <section>
        <form method="post" action="">
            <input type="hidden" name="form_action" value="signin" />
            <h1><?php echo LABEL_SIGNUP ?></h1>
            <div id="userIdMessage">
                <input type="text" placeholder="<?php echo LABEL_USERNAME; ?>" name="user_name" value="" required="required" id="username" onkeyup="validateUserId()"/>
            </div>
            <div>
                <input type="text"  placeholder="<?php echo LABEL_NAME; ?>" name="first_name" value="" required="required" id="firstname"/>
            </div>
            <div>
                <input type="text" placeholder="<?php echo LABEL_LASTNAME; ?>" name="last_name" value="" required="required" id="lastname"/>
            </div>
            <div>
                <input type="password" placeholder="<?php echo LABEL_PASS; ?>" name="password" value="" required="required" id="passwordsign"/>
            </div>
            <div>
                <input type="password" placeholder="<?php echo LABEL_PASS; ?>" name="password2" value="" required="required" id="passwordsign2"/>
            </div>
            <div>
                <input type="text" placeholder="<?php echo LABEL_PHONE; ?>" name="phone" value=""  id="phone" />
            </div>
            <div>
                <input type="email" placeholder="<?php echo LABEL_MAIL; ?>" name="email" value="" required="required" id="email" />
            </div>
            <div>
                <input type="submit" name="enter" value="Enter"/>
                <input type="button" onClick="location.href = './index.php?view=login'" value="<?php echo LABEL_LOGIN ?>">
            </div>
        </form>
    </section>
</div>