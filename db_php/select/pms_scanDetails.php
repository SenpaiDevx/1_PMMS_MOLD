<?php
// this will output a dynamic html templates 
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_ = $_POST['scan_qr'];
// $pms_json = json_decode(file_get_contents('php://input'));
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();
if ($_POST['pms_scanDB'] == 'pms_scanDB') {
    $pms_pdo->beginTransaction();
    $pms_getReg = "SELECT
    PR.PMS_CONTROL_NO,
    PR.PMS_MOLD_ID,
    PR.PMS_DEFECT_ID,
    PR.PMS_JOB_NO,
    PR.PMS_ISSUED,
    PD.PMS_DRAW_NO,
    PD.PMS_DRAW_DATE,
    PF.TYPE,
    PF.DEFECT,
    PF.DEFECT_DETAIL,
    PF.DEFECT_CAV,
    PF.QUANTITY,
    PM.MOLD_CTRL_NO,
    PM.CUSTOMER,
    PM.MODEL,
    PM.MOLD_NAME,
    PM.PART_NO,
    PM.MARK_NO,
    PM.CAVI_NO,
    PM.MP_LOC
FROM pms_reg PR
LEFT JOIN pms_mold_list PM ON PR.PMS_MOLD_ID = PM.MOLD_CTRL_NO
LEFT JOIN pms_draw PD ON PR.PMS_CONTROL_NO = PD.PMS_CONTROL_NO
LEFT JOIN pms_defect PF ON PR.PMS_DEFECT_ID = PF.PMSID
WHERE PR.PMS_CONTROL_NO = ?;";
    $pms_details_pdo = $pms_pdo->prepare($pms_getReg);
    $pms_details_pdo->bindParam(1, $pms_, PDO::PARAM_STR);
    $pms_details_pdo->execute();
    $tag = '[';
    $html = '';
    while ($rows = $pms_details_pdo->fetch(PDO::FETCH_ASSOC)) {
        $html .= <<<STD
        <tr>
        <th scope="col">Customer Ctrl #</th>
        <td scope="col">{$rows['PMS_CONTROL_NO']}</th>
        </tr>
        <tr>
        <th scope="col">Job Order #</th>
        <td scope="col">{$rows['PMS_JOB_NO']}</th>
        </tr>
        <tr>
        <th scope="col">Date Issued</th>
        <td scope="col">2024-01-02</th>
        </tr>
        <tr>
        <th scope="col">Delivery Date </th>
        <td scope="col">2024-01-31</th>
        </tr>
        STD;
        
    }
    $tag = rtrim($tag, ',');
    $tag .= ']';
    $pms_pdo->commit();
    echo $html;
}




