<?php

include_once '../Controllers/SubastaController.php';
include_once '../Controllers/UserController.php';
include_once '../Models/Email.php';

$subCtrl = new SubastaController();
$usrCtrl = new UserController();
$email = new Email();

$fetch = $subCtrl->selectFinished();
$hours = 86400;
$actual = time();

while ($subasta = mysql_fetch_assoc($fetch)) {
    $end = strtotime($subasta['hora_limit'] . $subasta['data_limit']);

    if ($end < $actual) {
        $allInfo = $subCtrl->selectAuctionParticipants($subasta['id_subhasta']);

        while ($participant = mysql_fetch_assoc($allInfo)) {
            $usrInfo = $usrCtrl->selectById($participant['id_usuari']);
            $user = $usrInfo->fetch_assoc();
            $lang = $user['idioma'];

            if ($user['id_usuari'] == $subasta['id_max_postor']) {
                $link = "https://" . $_SERVER['HTTP_HOST'] . "/sce/Views/index.php?view=showSubasta&id=" . $subasta['id_subhasta']; //TODO
                $email->auctionWin($user['login'], $user['email'], $lang, $link);
            } else {
                $email->auctionLose($user['login'], $user['email'], $lang);
            }
        }

        $subCtrl->setState($subasta['id_subhasta']);
    }
}
