
<?php

//Creamos unfunción que detecte el idioma del navegador del cliente. 
function getUserLanguage() {
    $idioma = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
    return $idioma;
}

//Almacenamos dicho idioma en una variable 
$user_language = getUserLanguage();
echo $user_language;
//De acuerdo al idioma hacemos una o varias redirecciones. 
if ($user_language == 'es') {
    echo 'español';
} elseif ($user_language == 'ca') {
    echo 'catala';
} else {
    echo 'en';
}
?>