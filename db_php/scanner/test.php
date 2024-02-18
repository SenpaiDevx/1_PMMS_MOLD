<?php
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();

echo 'POST : '.$_POST['usr_n'] .'get : '. $_GET['action']. 'another post : '.$_POST['pass_in'];
