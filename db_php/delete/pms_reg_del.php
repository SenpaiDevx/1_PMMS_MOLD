<?php
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_ = $_POST['pms'];
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();

if ($pms_[0] == 'pms_regListDel') {
    $pms_pdo->beginTransaction();
    $pms_regSQL = "SELECT PMS_DEFECT_ID FROM pms_reg WHERE PMS_CONTROL_NO = ?";
    $pms_reg_con = $pms_pdo->prepare($pms_regSQL);
    $pms_reg_con->bindParam(1, $pms_[1]['ctrl_no'], PDO::PARAM_STR);
    $pms_reg_con->execute();
    $pms_reg_row = $pms_reg_con->fetch(PDO::FETCH_ASSOC);
    $PMS_DEFECT_ID = $pms_reg_row['PMS_DEFECT_ID'];


    $pms_del_query = "DELETE PR, PD
    FROM pms_reg PR
    LEFT JOIN pms_mold_list PM ON PR.PMS_MOLD_ID = PM.MOLD_CTRL_NO
    LEFT JOIN pms_defect PD ON PR.PMS_DEFECT_ID = PD.PMSID
    WHERE PR.PMS_CONTROL_NO = ? AND PR.PMS_DEFECT_ID = ? ;";

    $pms_defect_del = $pms_pdo->prepare($pms_del_query);
    $pms_defect_del->bindParam(1, $pms_[1]['ctrl_no'], PDO::PARAM_STR);
    $pms_defect_del->bindParam(2, $PMS_DEFECT_ID, PDO::PARAM_STR);
    
    if ($pms_defect_del->execute()) {
        $delTag = '{
            "msg" : "true"
        }';
        echo $delTag;
    } else {
        $delTag = '{
            "msg" : "false"
        }';
        echo $delTag;
    }

    $pms_defect_del->closeCursor();
    $pms_pdo->commit();
}



