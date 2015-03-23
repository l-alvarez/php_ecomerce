<div class="container">
    <section id="content">
        <form method="post" action="signin.do">
            <input type="hidden" name="form_action" value="signin" />
            <h1>Sign in</h1>
            <div id="userIdMessage">
                <input type="text" placeholder="Username" name="user_name" value="" required="required" id="username" onkeyup="validateUserId()"/>
            </div>
            <div>
                <input type="text"  placeholder="First name" name="first_name" value="" required="required" id="firstname"/>
            </div>
            <div>
                <input type="text" placeholder="Last name" name="last_name" value="" required="required" id="lastname"/>
            </div>
            <div>
                <input type="password" placeholder="Password" name="password" value="" required="required" id="passwordsign"/>
            </div>
            <div>
                <input type="password" placeholder="Confirm password" name="password2" value="" required="required" id="passwordsign2"/>
            </div>
            <div>
                <input type="text" placeholder="Phone number" name="phone" value=""  id="phone" />
            </div>
            <div>
                <input type="email" placeholder="E-mail" name="email" value="" required="required" id="email" />
            </div>
            <div>
                <input type="submit" name="enter" value="Enter"/>
            </div>
        </form>
    </section><!-- content -->
</div><!-- container -->