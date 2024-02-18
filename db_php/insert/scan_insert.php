<?php
// note here scan_insert.php and scan_out.php are the same file, just for different operation

date_default_timezone_set("Asia/Manila");
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();
$isTime = date('Y-m-d H:i:s', time());
function convertMilitaryTo12HourTime($militaryTime, $timezone) {
    list($hours, $minutes) = explode(':', $militaryTime);
    $amPm = ($hours >= 12) ? 'pm' : 'am';
    $hours = ($hours > 12) ? $hours - 12 : $hours;
    $time = date('Y-m-d H:i:s', strtotime("$hours:$minutes $amPm"));
    $timezoneObj = new DateTimeZone($timezone);
    $dateObj = new DateTime($time);
    $dateObj->setTimezone($timezoneObj);
    return $dateObj->format('h:i a');
}
try {
    $pms_pdo->beginTransaction();
    $insert_query = "INSERT INTO pms_scaninout (
        PMS_CONTROL_NO, PROCESS_NAME, PROCESS_CODE, 
        TIME_IN, STATUS, MOLD_CONDITION, REMARKS, 
        PMS_RUNTIME
    ) VALUES (
        :PMS_CONTROL_NO, :PROCESS_NAME, :PROCESS_CODE, 
        :TIME_IN, :STATUS, :MOLD_CONDITION, :REMARKS, :PMS_RUNTIME
    )";
    $loca_time = convertMilitaryTo12HourTime($_POST['pms']['TIME_IN'], "Asia/Manila");
    $stmt = $pms_pdo->prepare($insert_query);
    $stmt->execute([
        ":PMS_CONTROL_NO" => $_POST['pms']['PMS_CONTROL_NO'], 
        ":PROCESS_NAME" => $_POST['pms']['PROCESS_NAME'], 
        ":PROCESS_CODE" => $_POST['pms']['PROCESS_CODE'], 
        ":TIME_IN" => $loca_time, 
        ":STATUS" => $_POST['pms']['STATUS'], 
        ":MOLD_CONDITION" => $_POST['pms']['MOLD_CONDITION'], 
        ":REMARKS" => $_POST['pms']['REMARKS'],
        ":PMS_RUNTIME" => $isTime
    ]);

    $lastId = $pms_pdo->lastInsertId();
    $tag = '[
        {
            "action": "'.$lastId.'",
            "scan_ctrl_no" : "'.$_POST['pms']['PMS_CONTROL_NO'].'",
            "scan_code" : "'.$_POST['pms']['PROCESS_NAME'].'-'.$_POST['pms']['PROCESS_CODE'].'",
            "scan_in" : "'.$loca_time.'",
            "scan_mold" : "'.$_POST['pms']['STATUS'].'",
            "scan_remarks": "'.$_POST['pms']['REMARKS'].'"
        }
    ]';

    echo $tag;
    $pms_pdo->commit();
} catch (PDOException $e) {
    $tag = '{
        "success": false,
        "msg" : "'.$e->getMessage().'"
    }';
    echo $tag;
    $pms_pdo->rollBack();
}
?>