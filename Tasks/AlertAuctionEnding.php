<?php

include_once '../Controllers/SubastaController.php';
include_once '../Controllers/UserController.php';
include_once '../Models/Email.php';

$subCtrl = new SubastaController();
$usrCtrl = new UserController();
$email = new Email();

$fetch = $subCtrl->selectNotFinished();
$hours = 86400;
$actual = time();

while ($subasta = mysql_fetch_assoc($fetch)) {
    $end = strtotime($subasta['hora_limit'] . $subasta['data_limit']);
    if (($end - $actual) < $hours) {
        $allInfo = $subCtrl->selectAuctionParticipants($subasta['id_subhasta']);

        while ($participant = mysql_fetch_assoc($allInfo)) {
            $usrInfo = $usrCtrl->selectById($participant['id_usuari']);
            $user = $usrInfo->fetch_assoc();

            $link = "https://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=showSubasta&id=" . $subasta['id_subhasta'];
            $lang = $user['idioma'];

            $email->auctionAlert($user['login'], $user['email'], $lang, $link);
        }

        $subCtrl->setAlert($subasta['id_subhasta']);
    }
}
