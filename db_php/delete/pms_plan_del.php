<?php
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_ = $_POST['pms'];
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();

if ($pms_[0] == 'mold_delete') {
    try {
        $pms_pdo->beginTransaction();
        $pms_moldDelQry = "DELETE FROM pms_process WHERE PMSID =?;";
        $mold_stmt = $pms_pdo->prepare($pms_moldDelQry);
        $mold_stmt->bindParam(1, $pms_[1], PDO::PARAM_STR);
        $mold_stmt->execute();
        $planTag = '{
            "msg" : "false",
            "ResultCode":"0000"
        }';
        $pms_pdo->commit();
        echo $planTag;
    } catch (PDOException $e) {
        $planTag = '{
            "msg" : "' . $e->getMessage() . '",
            "ResultCode":"' . $e->getCode() . '",
        }';
        echo $planTag;
    }
}
