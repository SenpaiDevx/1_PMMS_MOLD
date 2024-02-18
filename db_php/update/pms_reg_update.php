<?php
date_default_timezone_set("Asia/Manila");
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_ = $_POST['pms'];
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();
if ($pms_[0] == 'pms_regUp') {
    try {
    $pms_pdo->beginTransaction();
    $dat_update = date('Y-m-d', time());
    $pms_regSQL = "SELECT PMS_MOLD_ID, PMS_DEFECT_ID, PMS_JOB_NO, PMS_ISSUED FROM pms_reg WHERE PMS_CONTROL_NO = ?";
    $pms_reg_con = $pms_pdo->prepare($pms_regSQL);
    $pms_reg_con->bindParam(1, $pms_[1]['pms_tb_ctrl'], PDO::PARAM_STR);
    $pms_reg_con->execute();
    $pms_reg_row = $pms_reg_con->fetch(PDO::FETCH_ASSOC);
    $PMS_DEFECT_ID = $pms_reg_row['PMS_DEFECT_ID'];

    $pms_defctSql = "SELECT TYPE, DEFECT, DEFECT_DETAIL, DEFECT_CAV, QUANTITY FROM pms_defect WHERE PMSID = ?;";
    $pms_defctSql_pdo = $pms_pdo->prepare($pms_defctSql);
    $pms_defctSql_pdo->bindParam(1, $PMS_DEFECT_ID, PDO::PARAM_STR);
    $pms_defctSql_pdo->execute();
    $defect_row = $pms_defctSql_pdo->fetch(PDO::FETCH_ASSOC);
    $pms_defctSql_pdo->closeCursor();

    $pms_regList = "UPDATE pms_reg SET PMS_MOLD_ID = ?, PMS_JOB_NO = ?, PMS_ISSUED = ?
    WHERE PMS_CONTROL_NO = ?;";
    $pms_regPDO = $pms_pdo->prepare($pms_regList);
    $pms_regPDO->bindParam(1, $pms_[1]['pms_tb_mcode'], PDO::PARAM_STR);
    $pms_regPDO->bindParam(2, $pms_[1]['pms_tb_order'], PDO::PARAM_STR);
    $pms_regPDO->bindParam(3, $dat_update, PDO::PARAM_STR);
    $pms_regPDO->bindParam(4, $pms_[1]['pms_tb_ctrl'], PDO::PARAM_STR);
    $pms_regPDO->execute();
    $pms_regPDO->closeCursor();

    $pms_defectList = "UPDATE pms_defect SET TYPE = ?, DEFECT = ?,  DEFECT_DETAIL = ?,  DEFECT_CAV = ?,  QUANTITY = ? WHERE PMSID = ?;";
    $pms_defectPDO = $pms_pdo->prepare($pms_defectList);
    $pms_defectPDO->bindParam(1, $pms_[1]['pms_tb_type'], PDO::PARAM_STR);
    $pms_defectPDO->bindParam(2, $pms_[1]['pms_tb_defect'], PDO::PARAM_STR);
    $pms_defectPDO->bindParam(3, $pms_[1]['pms_tb_detail'], PDO::PARAM_STR);
    $pms_defectPDO->bindParam(4, $pms_[1]['pms_tb_cav'], PDO::PARAM_STR);
    $pms_defectPDO->bindParam(5, $pms_[1]['pms_tb_qty'], PDO::PARAM_STR);
    $pms_defectPDO->bindParam(6, $PMS_DEFECT_ID, PDO::PARAM_STR);
    $pms_defectPDO->execute();
    

    $pms_defectPDO->closeCursor();
    $pms_pdo->commit();

    $tag = '{
        "msg" : "done"
    }';
    echo $tag;

} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage() . "<br>";
}
}
