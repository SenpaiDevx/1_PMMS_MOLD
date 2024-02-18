<?php
date_default_timezone_set("Asia/Manila");
include($_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/vendor/phpqrcode/qrlib.php');
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';



$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();
if (isset($_GET['mold_id'])) {
    try {
        $pms_pdo->beginTransaction();
        $sql_qr = "SELECT PMS_QRCODE FROM pms_reg WHERE PMS_CONTROL_NO = ?;";
        $qr_stmt = $pms_pdo->prepare($sql_qr);
        $qr_stmt->bindParam(1, $_GET['mold_id'], PDO::PARAM_STR);
        $qr_stmt->execute();
        $select_qr = $qr_stmt->fetch(PDO::FETCH_ASSOC);
        if (is_null($select_qr['PMS_QRCODE'])) {
            $dump = '/1_PMMS_MOLD/dump_/' . $_GET['mold_id'] . '.png';
            $qr_update = "UPDATE pms_reg SET PMS_QRCODE = ? WHERE PMS_CONTROL_NO = ?;";
            $update_stmt = $pms_pdo->prepare($qr_update);
            $update_stmt->bindParam(1, $dump, PDO::PARAM_STR);
            $update_stmt->bindParam(2, $_GET['mold_id'], PDO::PARAM_STR);
            $update_stmt->execute();
            QRcode::png($_GET['mold_id'], $_SERVER['DOCUMENT_ROOT'] . $dump, '7', 10, 2, true);

        }
        $get_qr = "SELECT 
            PR.PMS_CONTROL_NO,
            PR.PMS_MOLD_ID,
            PR.PMS_JOB_NO,
            PR.PMS_ISSUED,
            PR.CAVITY,
            PR.JOB_QTY,
            PR.CHARGE,
            PR.DRAWING_NO,
            PR.PART_NAME,
            PR.TARGET_DATE,
            PM.CUSTOMER,
            PM.MODEL,
            PM.MOLD_NAME,
            PM.PART_NO,
            PM.MARK_NO,
            PM.CAVI_NO,
            PM.MP_LOC,
            PD.TYPE,
            PD.DEFECT,
            PD.DEFECT_DETAIL,
            PD.DEFECT_CAV,
            PD.QUANTITY
            FROM pms_reg PR
            LEFT JOIN pms_mold_list PM ON PR.PMS_MOLD_ID = PM.MOLD_CTRL_NO
            LEFT JOIN pms_defect PD ON PR.PMS_DEFECT_ID = PD.PMSID
            WHERE PR.PMS_CONTROL_NO = ?;";
            $get_stmt = $pms_pdo->prepare($get_qr);
            $get_stmt->bindParam(1, $_GET['mold_id'], PDO::PARAM_STR);
            $get_stmt->execute();
            $roz = $get_stmt->fetch(PDO::FETCH_ASSOC);

            $tag = '{
                "PMS_CONTROL_NO" : "' . $roz['PMS_CONTROL_NO'] . '",
                "PMS_MOLD_ID" : "' . $roz['PMS_MOLD_ID'] . '",
                "PMS_JOB_NO" : "' . $roz['PMS_JOB_NO'] . '",
                "PMS_ISSUED" : "' . $roz['PMS_ISSUED'] . '",
                "CUSTOMER" : "' . $roz['CUSTOMER'] . '",
                "MODEL" : "' . $roz['MODEL'] . '",
                "MOLD_NAME" : "' . $roz['MOLD_NAME'] . '",
                "PART_NO" : "' . $roz['PART_NO'] . '",
                "MARK_NO" : "' . $roz['MARK_NO'] . '",
                "CAVI_NO" : "' . $roz['CAVI_NO'] . '",
                "MP_LOC" : "' . $roz['MP_LOC'] . '",
                "TYPE" : "' . $roz['TYPE'] . '",
                "DEFECT" : "' . $roz['DEFECT'] . '",
                "DEFECT_DETAIL" : "' . $roz['DEFECT_DETAIL'] . '",
                "DEFECT_CAV" : "' . $roz['DEFECT_CAV'] . '",
                "QUANTITY" : "' . $roz['QUANTITY'] . '",
                "CAVITY" : "' . $roz['CAVITY'] . '",
                "JOB_QTY" : "' . $roz['JOB_QTY'] . '",
                "CHARGE" : "' . $roz['CHARGE'] . '",
                "DRAWING_NO" : "' . $roz['DRAWING_NO'] . '",
                "PART_NAME" : "' . $roz['PART_NAME'] . '",
                "TARGET_DATE" : "' . $roz['TARGET_DATE'] . '"

            }';

            echo $tag;
            $get_stmt->closeCursor();
        $pms_pdo->commit();
        $qr_stmt->closeCursor();
    } catch (PDOException $e) {
        echo  '{"error":{"text":' . json_encode($e->getMessage()) . '}}';
    }
}
