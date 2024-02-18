<?php
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_ = $_POST['pms'];
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();

if ($pms_[0] == 'drawUpdate') {
    try {
        $pms_pdo->beginTransaction();
        $updateTime = date('Y-m-d H:i:s');
        $updateDraw = "UPDATE pms_draw_file SET PMS_DRAW_NAME = ?, PMS_PIC_NAME= ?, PMS_DRAW_DATE = ? WHERE PMSID = ?;";
        $updateDraw_pdo = $pms_pdo->prepare($updateDraw);
        $updateDraw_pdo->bindParam(1, $pms_[1]['PMS_DRAW_NAME'], PDO::PARAM_STR);
        $updateDraw_pdo->bindParam(2, $pms_[1]['PMS_PIC_NAME'], PDO::PARAM_STR);
        $updateDraw_pdo->bindParam(3, $updateTime, PDO::PARAM_STR);
        $updateDraw_pdo->bindParam(4, $pms_[1]['PMSID'], PDO::PARAM_STR);
        if ($updateDraw_pdo->execute()) {
            $update = '{
                "msg" : true,
                "code" : "001",
             }';
             echo $update;
        };
        $updateDraw_pdo->closeCursor();
        $pms_pdo->commit();
    } catch (PDOException $e) {
        $update = '{
            "msg" : false,
            "code" : '.$e->getMessage().',
         }';
         echo $update;
    }
}

