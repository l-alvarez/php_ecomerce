<?php

include_once '../Controllers/SubastaController.php';
include_once '../Controllers/UserController.php';
include_once '../Controllers/ProductController.php';
include_once '../Models/Email.php';

$idSub = $_GET['sub'];

$subCtrl = new SubastaController();
$usrCtrl = new UserController();
$prodCtrl = new ProductController();

$fetch = $subCtrl->selectById($idSub);
$subasta = $fetch->fetch_assoc();

$fetch = $usrCtrl->selectById($subasta['id_max_postor']);
$user = $fetch->fetch_assoc();

$subCtrl->endAuction($idSub, $subasta['id_max_postor'], $user['direccio']);

$fetch = $prodCtrl->selectById($subasta['id_producte']);
$producte = $fetch->fetch_assoc();

$email = new Email();
$email->paymentComplete($user['nom'], $user['email'], $user['idioma'], $producte['nom']);
