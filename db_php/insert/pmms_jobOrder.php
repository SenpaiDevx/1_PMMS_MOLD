<?php
date_default_timezone_set("Asia/Manila");
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_ = $_POST['pms'];
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();

if ($pms_[0] == 'JO_REG') {
    $pms_reg = "INSERT INTO pms_reg (
     PMS_CONTROL_NO
    ,PMS_MOLD_ID
    ,PMS_DEFECT_ID
    ,PMS_JOB_NO
    ,PMS_ISSUED
    ,CAVITY
    ,JOB_QTY
    ,CHARGE
    ,DRAWING_NO
    ,PART_NAME
    ,TARGET_DATE) VALUES (?,?,?,?,?,?,?,?,?,?,?);";
    $pms_defect = "INSERT INTO pms_defect (TYPE, DEFECT, DEFECT_DETAIL, DEFECT_CAV, QUANTITY) VALUES (?,?,?,?,?);";

    try {
        $pms_pdo->beginTransaction();
        $pms_defect_pdo = $pms_pdo->prepare($pms_defect);
        $pms_defect_pdo->bindParam(1, $pms_[1]['TYPE'], PDO::PARAM_STR);
        $pms_defect_pdo->bindParam(2, $pms_[1]['DEFECT'], PDO::PARAM_STR);
        $pms_defect_pdo->bindParam(3, $pms_[1]['DEFECT_DETAIL'], PDO::PARAM_STR);
        $pms_defect_pdo->bindParam(4, $pms_[1]['DEFECT_CAV'], PDO::PARAM_STR);
        $pms_defect_pdo->bindParam(5, $pms_[1]['QUANTITY'], PDO::PARAM_STR);
        $pms_defect_pdo->execute();
        $pms_defect_pdo->closeCursor();

        $last_id_qry = "SELECT LAST_INSERT_ID() AS ID";
        $last_id_stmt = $pms_pdo->query($last_id_qry);
        $last_id_stmt->execute();
        $row_id = $last_id_stmt->fetch();
        $last_id_stmt->closeCursor();
        $id = $row_id['ID'];


        $issued = date('Y-m-d H:i:s', time());

        $pms_reg_pdo = $pms_pdo->prepare($pms_reg);
        $pms_reg_pdo->bindParam(1, $pms_[1]['CONTROL_NO'], PDO::PARAM_STR);
        $pms_reg_pdo->bindParam(2, $pms_[1]['MOLD_CODE'], PDO::PARAM_STR);
        $pms_reg_pdo->bindParam(3, $id, PDO::PARAM_STR);
        $pms_reg_pdo->bindParam(4, $pms_[1]['JOB_ORDER'], PDO::PARAM_STR);
        $pms_reg_pdo->bindParam(5, $issued, PDO::PARAM_STR);

        $pms_reg_pdo->bindParam(6, $pms_[1]['CAVITY'], PDO::PARAM_STR);
        $pms_reg_pdo->bindParam(7, $pms_[1]['JOB_QTY'], PDO::PARAM_STR);
        $pms_reg_pdo->bindParam(8, $pms_[1]['CHARGE'], PDO::PARAM_STR);
        $pms_reg_pdo->bindParam(9, $pms_[1]['DRAWING_NO'], PDO::PARAM_STR);
        $pms_reg_pdo->bindParam(10, $pms_[1]['PART_NAME'], PDO::PARAM_STR);
        $pms_reg_pdo->bindParam(11, $pms_[1]['TARGET_DATE'], PDO::PARAM_STR);

        $pms_reg_pdo->execute();
        $pms_reg_pdo->closeCursor();

        $pms_reg_list = "SELECT 
        PR.PMS_CONTROL_NO,
        PR.PMS_JOB_NO,
        PR.PMS_ISSUED,
        PR.CAVITY,
        PR.JOB_QTY,
        PR.CHARGE,
        PR.DRAWING_NO,
        PR.PART_NAME,
        PR.TARGET_DATE,
        PM.MOLD_CTRL_NO,
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
    LEFT JOIN pms_defect PD ON PR.PMS_DEFECT_ID = PD.PMSID;";
        $pms_reglist_pdo = $pms_pdo->prepare($pms_reg_list);
        $pms_reglist_pdo->execute();
        $pms_regTag = '[';

        while ($pms_list_row = $pms_reglist_pdo->fetch(PDO::FETCH_ASSOC)) {
            $pms_regTag .= '{
            "PMS_CONTROL_NO" : "' . $pms_list_row['PMS_CONTROL_NO'] . '",
            "PMS_JOB_NO" : "' . $pms_list_row['PMS_JOB_NO'] . '",
            "MOLD_CTRL_NO" : "' . $pms_list_row['MOLD_CTRL_NO'] . '",
            "CUSTOMER" : "' . $pms_list_row['CUSTOMER'] . '",
            "MODEL" : "' . $pms_list_row['MODEL'] . '",
            "MOLD_NAME" : "' . $pms_list_row['MOLD_NAME'] . '",
            "PART_NO" : "' . $pms_list_row['PART_NO'] . '",
            "MARK_NO" : "' . $pms_list_row['MARK_NO'] . '",
            "CAVI_NO" : "' . $pms_list_row['CAVI_NO'] . '",
            "MP_LOC" : "' . $pms_list_row['MP_LOC'] . '",
            "TYPE" : "' . $pms_list_row['TYPE'] . '",
            "DEFECT" : "' . $pms_list_row['DEFECT'] . '",
            "DEFECT_DETAIL" : "' . $pms_list_row['DEFECT_DETAIL'] . '",
            "DEFECT_CAV" : "' . $pms_list_row['DEFECT_CAV'] . '",
            "QUANTITY" : "' . $pms_list_row['QUANTITY'] . '",
            "PMS_ISSUED" : "' . $pms_list_row['PMS_ISSUED'] . '",
            "CAVITY" : "' . $pms_list_row['CAVITY'] . '",
            "JOB_QTY" : "' . $pms_list_row['JOB_QTY'] . '",
            "CHARGE" : "' . $pms_list_row['CHARGE'] . '",
            "DRAWING_NO" : "' . $pms_list_row['DRAWING_NO'] . '",
            "PART_NAME" : "' . $pms_list_row['PART_NAME'] . '",
            "TARGET_DATE" : "' . $pms_list_row['TARGET_DATE'] . '"
        },';
        }

        $pms_regTag = rtrim($pms_regTag, ',');
        $pms_regTag .= ']';
        $pms_result = (empty($pms_regTag)) ? '{"msg":"empty"}' : $pms_regTag;

        $pms_pdo->commit();
        echo $pms_result;
        $pms_reglist_pdo->closeCursor();
    } catch (PDOException $e) {
        $data = '{
            "msg" : "' . $e->getMessage() . '"
        }';
        echo $data;
    }
}


