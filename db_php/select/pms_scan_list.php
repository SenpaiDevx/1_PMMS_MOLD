<?php
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_ = $_POST['pms'];
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();

if ($pms_[0] == 'pms_list') {
    try {
        $pms_pdo->beginTransaction();
        $list_query = "SELECT PMS_PIC_ID, PLAN_TIME, PIC_NAME, PROCESS_NAME FROM pms_process WHERE PMS_CONTROL_NO = :ctrl ORDER BY PMS_CONTROL_NO DESC;";
        $list_pdo = $pms_pdo->prepare($list_query);
        $list_pdo->execute([
            ':ctrl' => $pms_[1]
        ]);
        $tag = '[';

        if (!$list_pdo->rowCount()) {
            $tag = '[{
                "scan_id" : "NO DATA FOUND",
                "scan_mins" : "NO DATA FOUND",
                "scan_opr" : "NO DATA FOUND",
                "scan_proc" : "NO DATA FOUND"
            }]';
            echo $tag;
        } else {
            while ($row = $list_pdo->fetch(PDO::FETCH_ASSOC)) {
                $tag .= '{
                    "scan_id" : "' . $row["PMS_PIC_ID"] . '",
                    "scan_mins" : "' . $row["PLAN_TIME"] . '",
                    "scan_opr" : "' . $row["PIC_NAME"] . '",
                    "scan_proc" : "' . $row["PROCESS_NAME"] . '"
                },';
            }
            $tag = rtrim($tag, ',');
            $tag .= ']';
            echo $tag;
        }
        $list_pdo->closeCursor();
        $pms_pdo->commit();
    } catch (PDOException $e) {
        $pms_pdo->rollBack();
        $tag = '{
            "result" : false,
            "message" : "Error : ' . $e->getMessage() . '"
        }';
        echo $tag;
    }
}

