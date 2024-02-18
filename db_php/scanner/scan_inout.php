<?php
date_default_timezone_set("Asia/Manila");
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();
$pms_ = explode('|', $_POST['pms']);;
$isTime = date('Y-m-d H:i:s');  //현재시간
$time_in = date('H:i:s');     
// set timezone manila for $isTime variable

try {
    $pms_pdo->beginTransaction();
    // check if there an entry
    $query_2 = "SELECT PMSID, PMS_CONTROL_NO, STATUS, REMARKS, PROCESS_NAME, PROCESS_CODE, TIME_IN, TIME_OUT FROM pms_scaninout WHERE PMS_CONTROL_NO = :ctrl  AND PROCESS_CODE = :code;";
    $stmt_2 = $pms_pdo->prepare($query_2);
    $stmt_2->execute([
        ':ctrl' => $pms_[0],
        ':code' => $pms_[2]
    ]);
    $last_id = $pms_pdo->lastInsertId();

    if (!$stmt_2->rowCount()) {
        $query = "INSERT INTO pms_scaninout (PMS_CONTROL_NO, PROCESS_NAME, PROCESS_CODE, PMS_RUNTIME, TIME_IN, STATUS, MOLD_CONDITION) VALUES (:ctrl, :names, :code, :rtimes, :ins, :stat, :mold);";
        $stmt = $pms_pdo->prepare($query);
        $stmt->execute([
            ":ctrl" => $pms_[0],
            ":code" => $pms_[2],
            ":rtimes" => $isTime,
            ":names" => $pms_[1],
            ":ins" => $time_in,
            ":stat" => 'ONGOING',
            ":mold" => 'NG'
        ]);

        $stmt->closeCursor();

        $query_3 = "SELECT PMSID, PMS_CONTROL_NO, STATUS, REMARKS, PROCESS_NAME, PROCESS_CODE, TIME_IN, TIME_OUT FROM pms_scaninout WHERE PMS_CONTROL_NO = :ctrl  AND PROCESS_CODE = :code;";
        $stmt_3 = $pms_pdo->prepare($query_3);
        $stmt_3->execute([
            ':ctrl' => $pms_[0],
            ':code' => $pms_[2]
        ]);

        $tag = '[';
        while ($rows = $stmt_3->fetch(PDO::FETCH_ASSOC)) {
            $tag .= '{
            "action" : "' . $rows["PMSID"] . '",
             "scan_code":"' . $rows["PROCESS_NAME"] . '-' . $rows['PROCESS_CODE'] . '",
             "scan_in":"' . $rows["TIME_IN"] . '",
             "scan_out":"' . $rows["TIME_OUT"] . '",
             "scan_mold":"' . $rows["STATUS"] . '",
             "scan_remarks":"' . $rows["REMARKS"] . '",
             "scan_ctrl_no":"' . $rows["PMS_CONTROL_NO"] . '"
           },';
        }

        $tag = rtrim($tag, ',');
        $tag .= ']';
        echo $tag;
        $stmt_3->closeCursor();
    } else {
        $tag = '[';
        while ($rows = $stmt_2->fetch(PDO::FETCH_ASSOC)) {
            $tag .= '{
            "action" : "' . $rows["PMSID"] . '",
             "scan_code":"' . $rows["PROCESS_NAME"] . '-' . $rows['PROCESS_CODE'] . '",
             "scan_in":"' . $rows["TIME_IN"] . '",
             "scan_out":"' . $rows["TIME_OUT"] . '",
             "scan_mold":"' . $rows["STATUS"] . '",
             "scan_remarks":"' . $rows["REMARKS"] . '",
             "scan_ctrl_no":"' . $rows["PMS_CONTROL_NO"] . '"
           },';
        }

        $tag = rtrim($tag, ',');
        $tag .= ']';
        echo $tag;
        $stmt_2->closeCursor();
    }
    $pms_pdo->commit();
} catch (PDOException $e) {
    $pms_pdo->rollBack();
}
