<?php
date_default_timezone_set("Asia/Manila");
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();

try {
    $pms_pdo->beginTransaction();
    $query = "SELECT PROCESS_NAME, PMS_PIC_ID, PLAN_TIME, PIC_NAME, PLAN_DATETIME FROM pms_process WHERE PMS_CONTROL_NO = :ctrl ORDER BY PROCESS_NAME ASC;";
    $stmt = $pms_pdo->prepare($query);
    $stmt->execute([
        ':ctrl' => $_POST['pms']
    ]);
    $tag = '[';
    while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tag .= '{
            "PROCESS_NAME": "' . $rows["PROCESS_NAME"] . '",
            "PMS_PIC_ID": "' . $rows["PMS_PIC_ID"] . '",
            "PLAN_TIME": "' . $rows["PLAN_TIME"] . '",
            "PIC_NAME": "' . $rows["PIC_NAME"] . '",
            "PLAN_DATETIME": "' . $rows["PLAN_DATETIME"] . '"
        },';
    }
    $tag = rtrim($tag, ',');
    $tag .= ']';
    echo $tag;
    $stmt->closeCursor();
    $pms_pdo->commit();
} catch (PDOException $e) {
    $tag = '{
        "success": false,
        "msg"  : "' . addslashes($e->getMessage()) . '"
    }';
    echo $tag;
}
?>