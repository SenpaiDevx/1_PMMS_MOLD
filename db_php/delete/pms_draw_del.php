<?php
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_ = $_POST['pms'];
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();

if ($pms_[0] == 'delDraw') {
    try {
        $pms_pdo->beginTransaction();
        $delDraw =  "DELETE FROM pms_draw_file WHERE PMSID = ?";
        $pms_delDraw = $pms_pdo->prepare($delDraw);
        $pms_delDraw->bindParam(1, $pms_[1], PDO::PARAM_STR);
        $pms_delDraw->execute();
        $pms_delDraw->closeCursor();

        $delDrawTag = '{
            "msg" : '.TRUE.',
            "code" : 502
        }';
        echo $delDrawTag;
        $pms_pdo->commit();
    } catch (PDOException $e) {
        $delDrawTag = '{
            "msg" : '. $e->getMessage().',
            "code" : 503, 
        }';
        echo $delDrawTag;
    }

}
