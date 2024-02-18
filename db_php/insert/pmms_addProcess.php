<?php
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_ = $_POST['pms'];
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();

if ($pms_[0] == 'mold_plan') {
    // 查詢 Mold Plan 表格
    try {
        $pms_pdo->beginTransaction();
        $mold_time = date('Y-m-d H:i:s', time());
        $pms_mold_query = "INSERT INTO pms_process(PMS_CONTROL_NO,PROCESS_NAME,PLAN_TIME,PIC_NAME, PLAN_DATETIME,PMS_PIC_ID) VALUES(?,?,?,?,?,?)";
        $pms_model_stmt = $pms_pdo->prepare($pms_mold_query);
        $pms_model_stmt->bindParam(1, $pms_[1]['PMS_CONTROL_NO'], PDO::PARAM_STR);
        $pms_model_stmt->bindParam(2, $pms_[1]['PROCESS_NAME'], PDO::PARAM_STR);
        $pms_model_stmt->bindParam(3, $pms_[1]['PLAN_TIME'], PDO::PARAM_STR);
        $pms_model_stmt->bindParam(4, $pms_[1]['PIC_NAME'], PDO::PARAM_STR);
        $pms_model_stmt->bindParam(5, $mold_time, PDO::PARAM_STR);
        $pms_model_stmt->bindParam(6, $pms_[1]['PMS_PIC_ID'], PDO::PARAM_STR);
        $pms_model_stmt->execute();
        $pms_model_stmt->closeCursor();

        $pms_moldDataSelect = "SELECT PMSID, PROCESS_NAME, PLAN_TIME, PIC_NAME FROM pms_process WHERE PMS_CONTROL_NO = ?;";
        $process_stmt = $pms_pdo->prepare($pms_moldDataSelect);
        $process_stmt->bindParam(1, $pms_[1]['PMS_CONTROL_NO'], PDO::PARAM_STR);
        $process_stmt->execute();
        $procTag = '[';
        while ($mold_row = $process_stmt->fetch(PDO::FETCH_ASSOC)) {
            $procTag .= '{
                "PMSID" :   "' . $mold_row["PMSID"] . '",
                "PROCESS_NAME" :  "' . $mold_row["PROCESS_NAME"] . '",
                "PLAN_TIME" :  "' . $mold_row["PLAN_TIME"] . '",
                "PIC_NAME" :  "' . $mold_row["PIC_NAME"] . '"
            },';
        }
        $procTag =  rtrim($procTag, ',');
        $procTag .= ']';

        echo $procTag;
        $pms_pdo->commit();
    } catch (PDOException $e) {
        $procTag = '[{
            "PROCESS_NAME" :  "' . $e->getMessage() . '",
            "PLAN_TIME" :  "' . $e->getCode() . '",
            "PIC_NAME" :  "this PR # IS INVALID"
        }]';

        echo $procTag;
    }
}

if ($pms_[0] == 'listMold') {
    try {
        $pms_pdo->beginTransaction();
        $pms_rowMoldQuery = "SELECT PMSID, PROCESS_NAME, PLAN_TIME, PIC_NAME FROM pms_process WHERE PMS_CONTROL_NO = ?;";
        $mold_stmt = $pms_pdo->prepare($pms_rowMoldQuery);
        $mold_stmt->bindParam(1, $pms_[1], PDO::PARAM_STR);
        $mold_stmt->execute();
        $procTag = '[';
        while ($mold_row = $mold_stmt->fetch(PDO::FETCH_ASSOC)) {
            $procTag .= '{
                "PMSID" :   "' . $mold_row["PMSID"] . '",
                "PROCESS_NAME" :  "' . $mold_row["PROCESS_NAME"] . '",
                "PLAN_TIME" :  "' . $mold_row["PLAN_TIME"] . '",
                "PIC_NAME" :  "' . $mold_row["PIC_NAME"] . '"
            },';
        }
        $procTag =  rtrim($procTag, ',');
        $procTag .= ']';
        echo $procTag;
        $mold_stmt->closeCursor();
        $pms_pdo->commit();
    } catch (PDOException $e) {
        $procTag = '[{
            "PROCESS_NAME" :  "' . $e->getMessage() . '",
            "PLAN_TIME" :  "' . $e->getCode() . '",
            "PIC_NAME" :  "this PR # IS INVALID"
        }]';
        echo $procTag;
    }
}
