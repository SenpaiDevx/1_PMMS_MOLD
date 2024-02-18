<?php
date_default_timezone_set("Asia/Manila");
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();
function convertMilitaryTo12HourTime($militaryTime, $timezone)
{
    list($hours, $minutes) = explode(':', $militaryTime);
    $amPm = ($hours >= 12) ? 'pm' : 'am';
    $hours = ($hours > 12) ? $hours - 12 : $hours;
    $time = date('Y-m-d H:i:s', strtotime("$hours:$minutes $amPm"));
    $timezoneObj = new DateTimeZone($timezone);
    $dateObj = new DateTime($time);
    $dateObj->setTimezone($timezoneObj);
    return $dateObj->format('h:i a e');
}

try {
    $pms_pdo->beginTransaction();
    switch ($_POST['pms']['CURR_STAT']) {
        case 'true':
            $on_time = convertMilitaryTo12HourTime(htmlspecialchars($_POST["pms"]['TIME_IN']), "Asia/Manila");
            $query = "UPDATE pms_scaninout SET 
            TIME_IN = :ins, 
            STATUS = :stat, 
            MOLD_CONDITION = :mold, 
            REMARKS = :mark 
            WHERE PMSID = :id";
            $stmt = $pms_pdo->prepare($query);
            $stmt->execute([
                ":ins" => $on_time,
                ":stat" => $_POST['pms']['STATUS'],
                ":mold" => $_POST['pms']['MOLD_CONDITION'],
                ":mark" => $_POST['pms']['REMARKS'],
                ":id" => $_POST['pms']['ID']
            ]);
            $stmt->closeCursor();

            $select_query = "SELECT PMSID, PROCESS_NAME, PROCESS_CODE, TIME_IN, TIME_OUT, REMARKS, PMS_CONTROL_NO, STATUS FROM pms_scaninout WHERE PMS_CONTROL_NO = :ctrl AND PROCESS_CODE = :code AND PMSID = :id";
            $select_stmt = $pms_pdo->prepare($select_query);
            $select_stmt->execute([
                ":ctrl" => $_POST['pms']['PR_CONTROL_NO'],
                ":id" => $_POST['pms']['ID'],
                ":code" => $_POST['pms']['PROCESS_NAME']
            ]);
            $tag = '[';
            while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                $tag .= '{
                    "scan_code" : "' . $row['PROCESS_NAME'] . '-' . $row['PROCESS_CODE'] . '",
                    "scan_mold" : "' . $row['STATUS'] . '",
                    "scan_remarks" : "' . $row['REMARKS'] . '",
                    "scan_ctrl_no" : "' . $row['PMS_CONTROL_NO'] . '",
                    "action" : "' . $row['PMSID'] . '",
                    "scan_in" : "' . $row['TIME_IN'] . '",
                    "scan_out" : "' . $row['TIME_OUT'] . '"
                },';
            }
            $tag = rtrim($tag, ',');
            $tag .= ']';

            echo $tag;
            $select_stmt->closeCursor();
            break;

        case 'false':
            $on_time = convertMilitaryTo12HourTime(htmlspecialchars($_POST["pms"]['TIME_OUT']), "Asia/Manila");
            $query = "UPDATE pms_scaninout SET 
            TIME_OUT = :outs, 
            STATUS = :stat, 
            MOLD_CONDITION = :mold, 
            REMARKS = :mark 
            WHERE PMSID = :id";
            $stmt = $pms_pdo->prepare($query);
            $stmt->execute([
                ":outs" => $on_time,
                ":stat" => $_POST['pms']['STATUS'],
                ":mold" => $_POST['pms']['MOLD_CONDITION'],
                ":mark" => $_POST['pms']['REMARKS'],
                ":id" => $_POST['pms']['ID']
            ]);
            $stmt->closeCursor();

            $select_query = "SELECT PMSID, PROCESS_NAME, PROCESS_CODE, TIME_IN, TIME_OUT, REMARKS, PMS_CONTROL_NO, STATUS FROM pms_scaninout WHERE PMS_CONTROL_NO = :ctrl AND PROCESS_CODE = :code AND PMSID = :id";
            $select_stmt = $pms_pdo->prepare($select_query);
            $select_stmt->execute([
                ":ctrl" => $_POST['pms']['PR_CONTROL_NO'],
                ":id" => $_POST['pms']['ID'],
                ":code" => $_POST['pms']['PROCESS_NAME']
            ]);
            $tag = '[';
            while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                $tag .= '{
                    "scan_code" : "' . $row['PROCESS_NAME'] . '-' . $row['PROCESS_CODE'] . '",
                    "scan_mold" : "' . $row['STATUS'] . '",
                    "scan_remarks" : "' . $row['REMARKS'] . '",
                    "scan_ctrl_no" : "' . $row['PMS_CONTROL_NO'] . '",
                    "action" : "' . $row['PMSID'] . '",
                    "scan_in" : "' . $row['TIME_IN'] . '",
                    "scan_out" : "' . $row['TIME_OUT'] . '"
                },';
            }
            $tag = rtrim($tag, ',');
            $tag .= ']';
            echo $tag;
            $select_stmt->closeCursor();
            break;
        default:
            # code...
            break;
    }
    $pms_pdo->commit();
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
