<?php
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_ = $_POST['pms'];
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();
$mild = 'aaAaa';

if ($pms_[0] == 'onScan') {
    try {
        $pms_pdo->beginTransaction();
        $query = "SELECT
        PPC.PMS_CODE,
        PPC.PMS_CODENAME,
        PPC.PMS_OP_NAME,
        PSP.PROCESS_NAME
        FROM pms_scan_process_code PPC
        LEFT JOIN pms_scanners_pic PSP ON PPC.PROCESS_ID = PSP.PMSID
        WHERE PSP.PROCESS_NAME = :names;";
        $stmt = $pms_pdo->prepare($query);
        $stmt->execute([
            ":names" => $pms_[1]
        ]);
        $tag = '[';
        if (!$stmt->rowCount()) {
            $tagS = '[{
                "PMS_CODE" : "NO DATA FOUND",
                "PMS_OP_NAME" : "NO DATA FOUND",
                "PROCESS_NAME" : "NO DATA FOUND",
                "PMS_CODENAME" : "NO DATA FOUND"
            }]';
            echo $tagS;
        } else {
            while ($row  = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $tag .= '{
                    "PMS_CODE" : "'.$row['PMS_CODE'].'",
                    "PMS_OP_NAME" : "'.$row['PMS_OP_NAME'].'",
                    "PROCESS_NAME" : "'.$row['PROCESS_NAME'].'",
                    "PMS_CODENAME" : "'.$row['PMS_CODENAME'].'"
                },';
            }
            $tag = rtrim($tag, ',');
            $tag .= ']';
            echo $tag;
        }
        $stmt->closeCursor();
        $pms_pdo->commit();
    } catch (PDOException $e) {
        $tag = '{
            "msg": "'.$e->getMessage().'",
            "code":"'.$e->getCode().'"
        }';
        echo $tag;
    }
}
?>