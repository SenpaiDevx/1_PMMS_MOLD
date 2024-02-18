<?php
date_default_timezone_set("Asia/Manila");
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_ = $_POST['pms'];
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();

if ($pms_[0] == 'mold_list') {
    $pms_moldlist = "SELECT * FROM pms_mold_list";
    $mold_data = $pms_pdo->query($pms_moldlist);
    $mold_data->execute();
    $mold_tag = '[';
    while ($mold_row = $mold_data->fetch(PDO::FETCH_ASSOC)) {
        $mold_tag .= '{
            "MOLD_CTRL_NO" : "' . $mold_row['MOLD_CTRL_NO'] . '",
            "CUSTOMER" : "' . $mold_row['CUSTOMER'] . '",
            "MODEL" : "' . $mold_row['MODEL'] . '",
            "MOLD_NAME" : "' . $mold_row['MOLD_NAME'] . '",
            "PART_NO" : "' . $mold_row['PART_NO'] . '",
            "MARK_NO" : "' . $mold_row['MARK_NO'] . '",
            "CAVI_NO" : "' . $mold_row['CAVI_NO'] . '",
            "MP_LOC" : "' . $mold_row['MP_LOC'] . '"
        },';
    }
    $mold_tag = rtrim($mold_tag, ',');
    $mold_tag .= ']';
    echo $mold_tag;
}
 
if ($pms_[0] == 'week_gen') {
    $pms_pdo->beginTransaction();
    $curr_date = date('Y-m-d');
    $prev_date = date('Y-m-d', strtotime('-1 day', strtotime($curr_date)));
    $NUM_WEEK = function ($date_now) {
        return date('W', strtotime($date_now));
    };
    $prefix = 'W' . $NUM_WEEK($curr_date) . '-' . 'P';
    function id_up($no)
    { // base on the inserted 
        if ((int) substr($no, -1) < 9) {
            $a = (int) substr($no, -1);
            $a++;
            $number = substr($no, 0, 8) . $a;
        } else if ((int) substr($no, -2) < 99) {
            $b = (int) substr($no, -2);
            $b++;
            $number = substr($no, 0, 7) . $b;
        } else if ((int) substr($no, -3) < 999) {
            $c = (int) substr($no, -3);
            $c++;
            $number = substr($no, 0, 6) . $c;
        } else if ((int) substr($no, -4) < 9999) {
            $d = (int) substr($no, -4);
            $d++;
            $number = substr($no, 0, 5) . $d;
        } else {
            return $no;
        }
        return $number;
    };

    $weekNoSql = "SELECT PMS_JOB_NO FROM pms_reg WHERE PMS_JOB_NO = (SELECT MAX(PMS_JOB_NO) FROM pms_reg)";
    $week_stmt = $pms_pdo->prepare($weekNoSql);
    $week_stmt->execute();
    $week_row = $week_stmt->fetch(PDO::FETCH_ASSOC);
    $w = $week_row['PMS_JOB_NO'];
    if ($week_stmt->rowCount() > 0  && !empty(str_replace(' ', '', $week_row['PMS_JOB_NO']))) {
        $increment = id_up($week_row['PMS_JOB_NO']);
        echo $increment;
    } else {
        $increment = $prefix . id_up('0001');
        echo $increment;
    }

    //substr($no, 0,4) -> 1234
    $pms_pdo->commit();
}

if ($pms_[0] == 'pms_registration') {
    $pms_pdo->beginTransaction();
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
}

if ($pms_[0] == 'prControlNo') {
    $prControl = "SELECT PMS_CONTROL_NO FROM pms_reg;";
    $prControl_query = $pms_pdo->query($prControl);
    $prControl_query->execute();
    $prTag = '[';
    $i = 0;
    while ($row_control_no = $prControl_query->fetch(PDO::FETCH_ASSOC)) {
        $prTag .= '{
            "id" : ' . $i . ',
            "text" : "' . $row_control_no["PMS_CONTROL_NO"] . '"
        },';
        $i++;
    }
    $prTag = rtrim($prTag, ',');
    $prTag .= ']';
    echo $prTag;
    $prControl_query->closeCursor();
}


//PMMS DRAW
if ($pms_[0] == 'regDraw') {
    try {
        $pms_pdo->beginTransaction();
        $draw_date = date('Y-m-d H:i:s', time());
        $regDraw_query = "INSERT INTO pms_draw ( PMS_CONTROL_NO, PMS_DRAW_NO, PMS_DRAW_DATE) VALUES(?,?,?)";
        $pdo_draw = $pms_pdo->prepare($regDraw_query);
        $pdo_draw->bindParam(1, $pms_[1]['PMS_CONTROL_NO'], PDO::PARAM_STR);
        $pdo_draw->bindParam(2, $pms_[1]['PMS_DRAW_NO'], PDO::PARAM_STR);
        $pdo_draw->bindParam(3, $draw_date, PDO::PARAM_STR);
        $pdo_draw->execute();
        $pdo_draw->closeCursor();

        // here the next incrementation of control drawing number
        $drawTag = '{
        "msg" : "TRUE"
        }';
        echo $drawTag;
        $pms_pdo->commit();
    } catch (PDOException $e) {
        $pms_pdo->rollBack();
        $drawTag = '{
            "msg" : "FALSE"
            }';
        echo $drawTag;
        //throw $th;
    }
}

if ($pms_[0] == 'validDraw') {
    $pms_pdo->beginTransaction();
    $validDraw_query = "SELECT COUNT(*) as COUNTS FROM pms_draw;";
    $validDraw_pdo = $pms_pdo->query($validDraw_query);
    // $validDraw_pdo->bindParam(1, $pms_[1], PDO::PARAM_STR);
    $validDraw_pdo->execute();
    $row_valid = $validDraw_pdo->fetch(PDO::FETCH_ASSOC);


    if ((int) $row_valid['COUNTS'] > 0) {
        $CountsQL = "SELECT PMS_DRAW_NO FROM pms_draw ORDER BY PMS_DRAW_NO DESC LIMIT 1;";
        $Count_pdo = $pms_pdo->prepare($CountsQL);
        $Count_pdo->execute();
        $drawIDcount = $Count_pdo->fetch(PDO::FETCH_ASSOC);
        if ((int) substr($drawIDcount['PMS_DRAW_NO'], -1) < 9) {
            $c1 = (int) substr($drawIDcount['PMS_DRAW_NO'], -1);
            $c1++;
            $numC = substr($drawIDcount['PMS_DRAW_NO'], 0, -1) . $c1;
        } else if ((int) substr($drawIDcount['PMS_DRAW_NO'], -2) < 99) {
            $b1 = (int) substr($drawIDcount['PMS_DRAW_NO'], -2);
            $b1++;
            $numC = substr($drawIDcount['PMS_DRAW_NO'], 0, -2) . $b1;
        } else if ((int) substr($drawIDcount['PMS_DRAW_NO'], -3) < 999) {
            $d1 = (int) substr($drawIDcount['PMS_DRAW_NO'], -3);
            $d1++;
            $numC = substr($drawIDcount['PMS_DRAW_NO'], 0, -3) . $d1;
        } else if ((int) substr($drawIDcount['PMS_DRAW_NO'], -4) < 9999) {
            $e1 = (int) substr($drawIDcount['PMS_DRAW_NO'], -4);
            $e1++;
            $numC = substr($drawIDcount['PMS_DRAW_NO'], 0, -4) . $e1;
        } else if ((int) substr($drawIDcount['PMS_DRAW_NO'], -5) < 99999) {
            $f1 = (int) substr($drawIDcount['PMS_DRAW_NO'], -5);
            $f1++;
            $numC = substr($drawIDcount['PMS_DRAW_NO'], 0, -5) . $f1;
        } else if ((int) substr($drawIDcount['PMS_DRAW_NO'], -6) < 999999) {
            $g1 = (int) substr($drawIDcount['PMS_DRAW_NO'], -6);
            $g1++;
            $numC = substr($drawIDcount['PMS_DRAW_NO'], 0, -6) . $g1;
        } else {
            $numC = $drawIDcount['PMS_DRAW_NO'];
            return $numC;
        }
        $msg = '{
            "id" : "' . $numC . '"
           }';
        echo $msg;
    } else {

        // initialize counting before insert draw contrl no
        $msg = '{
            "id" : "DRAW-000000",
            "last" : "' . substr("DRAW-654321", 0, -1) . '"
           }';
        echo $msg;
    }
    $pms_pdo->commit();
    $validDraw_pdo->closeCursor();
}


if ($pms_[0] == 'valid_ctrlno') {
    $pms_ctrl = "SELECT EXISTS(SELECT 1 FROM pms_reg WHERE PMS_CONTROL_NO = ?) AS IDS";
    try {
        $pms_pdo->beginTransaction();
        $ctrl_pdo = $pms_pdo->prepare($pms_ctrl);
        $ctrl_pdo->bindParam(1, $pms_[1], PDO::PARAM_STR);
        $ctrl_pdo->execute();
        $PMS_CONTROL_NO = $ctrl_pdo->fetch(PDO::FETCH_ASSOC);
        if ($PMS_CONTROL_NO['IDS']) {
            $msg = '{
                "msg" : ' . 1 . '
            }';
            echo $msg;
        } else {
            $msg = '{
                "msg" : ' . 0 . '
            }';
            echo $msg;
        }
        $pms_pdo->commit();
    } catch (PDOException $e) {
        $msg = '{
            "msg" : "' . $e->getMessage() . '"
        }';
        echo $msg;
    }
}


if ($pms_[0] == 'pms_draw_all') {
    $pms_draw_query = "SELECT * FROM pms_draw ORDER BY PMS_DRAW_NO ASC";
    $pms_darw_query_pdo = $pms_pdo->query($pms_draw_query);
    $drawTag = '[';
    while ($draw_row = $pms_darw_query_pdo->fetch(PDO::FETCH_ASSOC)) {
        $drawTag .= '{
            "PMS_CONTROL_NO" : "' . $draw_row['PMS_CONTROL_NO'] . '",
            "PMS_DRAW_NO" : "' . $draw_row['PMS_DRAW_NO'] . '"
        },';
    }
    $drawTag = rtrim($drawTag, ',');
    $drawTag .= ']';
    echo $drawTag;
}

if ($pms_[0] == 'pms_draw_count') {
    $draw_count = "SELECT
	pms_reg.PMS_MOLD_ID AS 'MOLD_CODE',
    pms_reg.PMS_JOB_NO AS 'JOB_ORDER',
    pms_draw.PMS_DRAW_NO,
    pms_draw.PMS_CONTROL_NO,
    COUNT(pms_draw_file.PMSID) AS DRAW_COUNT,
    (SELECT COUNT(pms_process.PMS_CONTROL_NO) FROM pms_process WHERE pms_process.PMS_CONTROL_NO = pms_draw.PMS_CONTROL_NO) as PLAN_COUNT
FROM  pms_draw 
LEFT JOIN pms_draw_file ON pms_draw.PMS_DRAW_NO = pms_draw_file.PMS_DRAW_NO
LEFT JOIN pms_reg ON pms_draw.PMS_CONTROL_NO = pms_reg.PMS_CONTROL_NO
GROUP BY pms_draw.PMS_DRAW_NO
ORDER BY pms_draw.PMS_DRAW_NO ASC;";
    $drawCountPdo = $pms_pdo->query($draw_count);
    $drawCountPdo->execute();
    $drawTag = '[';
    while ($draw_cnt = $drawCountPdo->fetch(PDO::FETCH_ASSOC)) {
        $drawTag .= '{
            "PMS_DRAW_NO" : "' . $draw_cnt['PMS_DRAW_NO'] . '",
            "PMS_CONTROL_NO" : "' . $draw_cnt['PMS_CONTROL_NO'] . '",
            "DRAW_COUNT" : "' . $draw_cnt['DRAW_COUNT'] . '",
            "PLAN_COUNT" : "' . $draw_cnt['PLAN_COUNT'] . '",
            "MOLD_CODE" : "' . $draw_cnt['MOLD_CODE'] . '",
            "JOB_ORDER" : "' . $draw_cnt['JOB_ORDER'] . '"
        },';
    }


    $drawTag = rtrim($drawTag, ',');
    $drawTag .= ']';
    echo  $drawTag;
}


if ($pms_[0] == 'mold_process') {
    $mold_query = "SELECT IN_PROCESS FROM pms_mold_operations WHERE IN_PROCESS IS NOT NULL";
    $mold_stmt = $pms_pdo->query($mold_query);
    $mold_stmt->execute();
    $moldTag = '[';
    while ($mold_row = $mold_stmt->fetch(PDO::FETCH_ASSOC)) {
        $moldTag .= '{
            "IN_PROCESS" : "' . $mold_row['IN_PROCESS'] . '"
        },';
    }
    $moldTag = rtrim($moldTag, ',');
    $moldTag .= ']';
    echo $moldTag;
}

if ($pms_[0] == 'mold_plan') {
    $all_plan = "SELECT
    PR.PMS_CONTROL_NO,
    PR.PMS_MOLD_ID,
    PR.PMS_JOB_NO,
    (
    SELECT COUNT(pms_process.PMS_CONTROL_NO)
    FROM  pms_process
    WHERE pms_process.PMS_CONTROL_NO = pr.PMS_CONTROL_NO 
    ) AS 'PLAN_CP'
    FROM pms_reg PR
    GROUP BY pr.PMS_CONTROL_NO
    ORDER BY pr.PMS_CONTROL_NO DESC;";

    $plan_stmt = $pms_pdo->prepare($all_plan);
    $plan_stmt->execute();
    $planTag = "[";
    while ($row = $plan_stmt->fetch(PDO::FETCH_ASSOC)) {
        $planTag .= '{
            "mold_plan_ctrl" : "'.$row['PMS_CONTROL_NO'].'", 
            "mold_plan_job" : "'.$row['PMS_JOB_NO'].'", 
            "mold_plan_count" : "'.$row['PLAN_CP'].'", 
            "mold_plan_code" : "'.$row['PMS_MOLD_ID'].'" 
        },';
    }

    $planTag = rtrim($planTag, ",");
    $planTag .= ']';
    echo  $planTag;
}
