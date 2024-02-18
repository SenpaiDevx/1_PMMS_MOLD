<?php
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_ = $_POST['pms'];
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();

if ($pms_[0] == 'plan_update') { // 상품 추가
    try {
        $pms_pdo->beginTransaction();
        $mold_time = date('Y-m-d H:i:s', time());
        $plan_updateQry = "UPDATE pms_process SET PROCESS_NAME = ?, PLAN_TIME = ?, PIC_NAME = ?, PLAN_DATETIME = ? WHERE PMSID = ?;";
        $plan_update_stmt = $pms_pdo->prepare($plan_updateQry);
        $plan_update_stmt->bindParam(1, $pms_[1]['PROCESS_NAME'], PDO::PARAM_STR);
        $plan_update_stmt->bindParam(2, $pms_[1]['PLAN_TIME'], PDO::PARAM_STR);
        $plan_update_stmt->bindParam(3, $pms_[1]['PIC_NAME'], PDO::PARAM_STR);
        $plan_update_stmt->bindParam(4, $mold_time, PDO::PARAM_STR);
        $plan_update_stmt->bindParam(5, $pms_[1]['PMSID'], PDO::PARAM_STR);
        if ($plan_update_stmt->execute()) {
            $planTag = '{
                "msg" : true,
                "ResultCode":"0000",
            }';
            echo $planTag;
        }
        $pms_pdo->commit();
    } catch (PDOException $e) {
        $planTag = '{
                "msg" : "false",
                "ResultCode":"' . $e->getCode() . '",
            }';
        echo $planTag;
    }
}
