<?php
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();
$pms_ = $_POST['pms'];

if ($pms_[0] == 'addDraw') {
    $pms_draw = date('Y-m-d', time());
    try {
        $pms_pdo->beginTransaction();
        $pms_draw_query = "INSERT INTO pms_draw_file (PMS_CONTROL_NO, PMS_DRAW_NO, PMS_DRAW_NAME, PMS_PIC_NAME, PMS_DRAW_DATE) 
        VALUES (?,?,?,?,?)";
        $pms_stmt = $pms_pdo->prepare($pms_draw_query);
        $pms_stmt->bindParam(1, $pms_[1]['PMS_CONTROL_NO'], PDO::PARAM_STR);
        $pms_stmt->bindParam(2, $pms_[1]['PMS_DRAW_NO'], PDO::PARAM_STR);
        $pms_stmt->bindParam(3, $pms_[1]['PMS_DRAW_NAME'], PDO::PARAM_STR);
        $pms_stmt->bindParam(4, $pms_[1]['PMS_PIC_NAME'], PDO::PARAM_STR);
        $pms_stmt->bindParam(5, $pms_draw, PDO::PARAM_STR);
        $pms_stmt->execute();
        $pms_stmt->closeCursor();

        $drawListQuery = "SELECT PMSID, PMS_DRAW_NO, PMS_DRAW_NAME, PMS_PIC_NAME, PMS_DRAW_DATE FROM pms_draw_file WHERE PMS_CONTROL_NO = ?; ";
        $drawlistStmt = $pms_pdo->prepare($drawListQuery);
        $drawlistStmt->bindParam(1, $pms_[1]['PMS_CONTROL_NO'], PDO::PARAM_STR);
        $drawlistStmt->execute();
        $listTag = '[';
        while ($DrawListRow = $drawlistStmt->fetch(PDO::FETCH_ASSOC)) {
            $listTag .= '{
                "PMSID" : "' . $DrawListRow['PMSID'] .'",
                "PMS_DRAW_NO" : "' . $DrawListRow['PMS_DRAW_NO'] . '",
                "PMS_DRAW_NAME" : "' . $DrawListRow['PMS_DRAW_NAME'] . '",
                "PMS_PIC_NAME" : "' . $DrawListRow['PMS_PIC_NAME'] . '",
                "PMS_DRAW_DATE" : "' . $DrawListRow['PMS_DRAW_DATE'] . '"
            },';
        }
        $listTag = rtrim($listTag, ',');
        $listTag .= ']';
        $drawlistStmt->closeCursor();
        echo $listTag;
        $pms_pdo->commit();
    } catch (PDOException $e) {
        $draw = '' . $e->getMessage() . '';
        echo $draw;
    }
}

if ($pms_[0] == 'allDraw') {
    try {
        $pms_pdo->beginTransaction();
        $fetchAllDraw = "SELECT PMSID, PMS_DRAW_NO, PMS_DRAW_NAME, PMS_PIC_NAME, PMS_DRAW_DATE FROM pms_draw_file WHERE PMS_CONTROL_NO = ?;";
        $fetcthSelectedDraw = $pms_pdo->prepare($fetchAllDraw);
        $fetcthSelectedDraw->bindParam(1, $pms_[1], PDO::PARAM_STR);
        $fetcthSelectedDraw->execute();
        $drawRow = '[';
        while ($drawLine = $fetcthSelectedDraw->fetch(PDO::FETCH_ASSOC)) {
            $drawRow .= '{
                "PMSID" : "' . $drawLine['PMSID'] .'",
                "PMS_DRAW_NO" : "' . $drawLine['PMS_DRAW_NO'] . '",
                "PMS_DRAW_NAME" : "' . $drawLine['PMS_DRAW_NAME'] . '",
                "PMS_PIC_NAME" : "' . $drawLine['PMS_PIC_NAME'] . '",
                "PMS_DRAW_DATE" : "' . $drawLine['PMS_DRAW_DATE'] . '"
            },';
        }
        $drawRow = rtrim($drawRow, ',');
        $drawRow .= ']';
        $fetcthSelectedDraw->closeCursor();
        echo $drawRow;
        $pms_pdo->commit();
    } catch (PDOException $e) {
    }
}
