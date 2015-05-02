<!--<body onLoad="timer()">
    <div id="cuerpo_dow">
        <div id="contador"></div>
        <script language="javascript">
            function timer() {
                var t = setTimeout("timer()", 1000);
                document.getElementById('contador').innerHTML = 'Por favor espere ' + i-- + " segundos";
                if (i == -1) {
                    document.getElementById('contador').innerHTML = 'Hola que ase?';
                    clearTimeout(t);
                }
            }
            i = 5;
        </script>
    </div>-->
<table>
<tr><td><a href="../Controllers/Command.php?controller=CategoryController&action=admin"><?php echo LABEL_ADMIN_CATEGORIES ?></a></td></tr>
<tr><td><a href="../Controllers/Command.php?controller=ProductController&action=admin"><?php echo LABEL_ADMIN_PRODUCT ?></a></td></tr>
<tr><td><a href="../Controllers/Command.php?controller=SubastaController&action=admin"><?php echo LABEL_ADMIN_SUBASTA ?></a></td></tr>
</table>