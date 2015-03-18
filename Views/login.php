<div id="pagina">
    <div id="login">
        <div id="candau"><img src="../img/candado.png" alt="candado"/></div>
        <div id="formulari">
            <form method="post" action="login/login.php" name="login">
                <fieldset>
                    <legend>LOGIN</legend>
                    <input type="text" name="user" id="user"/>
                    <br/>
                    <input type="password" name="password" id="password"/>
                    <br/>
                    <input type="submit" value="LOGIN"/>
                </fieldset>
            </form>
        </div>
        <?php
        session_start();
        // Mostrem un missatge segons el error al loguejar-se
        /* if ($_SESSION['login']==1)
          {echo "<div id='error'>*Usuari buit</div>";}
          elseif ($_SESSION['login']==2)
          {echo "<div id='error'>*Contrasenya buida</div>";}
          elseif ($_SESSION['login']==3)
          {echo "<div id='error'>*Usuari i contrasenya incorrectes</div>";}
          elseif ($_SESSION['login']==4)
          {echo "<div id='error'>*Usuari bloquejat</div>";}
         * 
         */
        ?>

    </div>
</div>
