

<div id="div_session_timeout" class="ui-state-highlight" style="float: left; width: 30%;  font-size: .8em; text-align: center;">
    <script language="javascript" type="text/javascript">
        /* Visit http://www.yaldex.com/ for full source code and get more free JavaScript, CSS and DHTML scripts! */
        var dateStamp = new Date("<?php echo date('D M j Y H:i:s'); ?>"); // Obtener la fecha y hora actual del servidor en este formato: Sun May 23 2010 20:14:11
        var intStamp = Number(dateStamp); // Convertir a timestamp la fecha y hora actual del servidor
        //Begin
        function getTime() {
            now = new Date(intStamp); // Trabajar con el formato timestamp
            // Obtener la fecha y hora en la que deberá terminar la sessión
            // en mi caso, la sesión la tengo establecida a 3600 segundos
            y2k = new Date("<?php echo date('M j Y H:i:s', time() + 3600); ?>");
            days = (y2k - now) / 1000 / 60 / 60 / 24;
            daysRound = Math.floor(days);
            hours = (y2k - now) / 1000 / 60 / 60 - (24 * daysRound);
            hoursRound = Math.floor(hours);
            minutes = (y2k - now) / 1000 / 60 - (24 * 60 * daysRound) - (60 * hoursRound);
            minutesRound = Math.floor(minutes);
            seconds = (y2k - now) / 1000 - (24 * 60 * 60 * daysRound) - (60 * 60 * hoursRound) - (60 * minutesRound);
            secondsRound = Math.round(seconds);
            sec = (secondsRound == 1) ? " segundo" : " segundos";
            min = (minutesRound == 1) ? " minuto, " : " minutos, ";
            hr = (hoursRound == 1) ? " hora, " : " horas, ";
            dy = (daysRound == 1) ? " d\355a, " : " d\355as, "
            //document.timeForm.input1.value = "Time remaining: " + daysRound  + dy + hoursRound + hr + minutesRound + min + secondsRound + sec;
            if (daysRound + hoursRound + minutesRound + secondsRound == '0000') {
                document.getElementById("session_timeout").innerHTML = '<span style="color: red;">La sesi\363n ha expirado.</span><br />' + hoursRound + hr + minutesRound + min + secondsRound + sec;
            } else {
                document.getElementById("session_timeout").innerHTML = "Tiempo restante de esta sesi\363n: <br />" + hoursRound + hr + minutesRound + min + secondsRound + sec;
                newtime = window.setTimeout("getTime();", 1000);
                intStamp = intStamp + 1000; // Para avanzar un segundo en cada iteracion a partir de la fecha y hora actual obtenida desde el servidor
            } // endif
        } // end function
        window.onload = getTime;
        //  End -->
    </script>
    <span id="session_timeout"></span>
</div>