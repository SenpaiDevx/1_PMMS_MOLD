<?php
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_ = $_POST['pms'];
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();


if ($pms_[0] == '') {
    # code...
}
