<?php
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();

try {
    $pms_pdo->beginTransaction();
    $query = "SELECT 
    PR.PMS_CONTROL_NO, PR.PMS_MOLD_ID, PR.PMS_JOB_NO,
    PL.MODEL, PL.PART_NO, PL.CAVI_NO,
    PL.CUSTOMER, PL.MOLD_NAME, PL.MARK_NO, PL.MP_LOC
    FROM pms_reg PR 
    LEFT JOIN pms_mold_list PL ON PR.PMS_MOLD_ID = PL.MOLD_CTRL_NO WHERE PR.PMS_CONTROL_NO = :id ;";
    $stmt = $pms_pdo->prepare($query);
    $stmt->execute([
        ":id" => $_POST['pmsToScan'],
    ]);

    $counts = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <tr>
        <th>PR CONTROL</th>
        <td>
            <?php
            $ifs = (!$counts) ? 'invalid pr' : $row['PMS_CONTROL_NO'];
            echo $ifs;
            ?>
        </td>
        <th>JOB ORDER #</th>
        <td>
            <?php
            $ifs = (!$counts) ? 'invalid pr' : $row['PMS_JOB_NO'];
            echo $ifs;
            ?>
        </td>
    </tr>
    <tr>
        <th scope="col">MOLD CODE</th>
        <td>
            <?php
            $ifs = (!$counts) ? 'invalid pr' : $row['PMS_MOLD_ID'];
            echo $ifs;
            ?>
        </td>
        <th scope="col">CUSTOMER</th>
        <td>
            <?php
            $ifs = (!$counts) ? 'invalid pr' : $row['CUSTOMER'];
            echo $ifs;
            ?>
        </td>
    </tr>
    <tr>
        <th scope="col" class="text-wrap">MODEL</th>
        <td>
            <?php
            $ifs = (!$counts) ? 'invalid pr' : $row['MODEL'];
            echo $ifs;
            ?>
        </td>
        <th scope="col">MOLD NAME</th>
        <td>
            <?php
            $ifs = (!$counts) ? 'invalid pr' : $row['MOLD_NAME'];
            echo $ifs;
            ?>
        </td>
    </tr>
    <tr>
        <th>PART NO</th>
        <td>
            <?php
            $ifs = (!$counts) ? 'invalid pr' : $row['PART_NO'];
            echo $ifs;
            ?>
        </td>
        <th>MARK #</th>
        <td>
            <?php
            $ifs = (!$counts) ? 'invalid pr' : $row['MARK_NO'];
            echo $ifs;
            ?>
        </td>
    </tr>
    <tr>
        <th scope="col">CAV #</th>
        <td>
            <?php
            $ifs = (!$counts) ? 'invalid pr' : $row['CAVI_NO'];
            echo $ifs;
            ?>
        </td>
        <th scope="col">MP LOCATION</th>
        <td>
            <?php
            $ifs = (!$counts) ? 'invalid pr' : $row['MP_LOC'];
            echo $ifs;
            ?>
        </td>
    </tr>
    <?php

    $stmt->closeCursor();
    $pms_pdo->commit();
} catch (PDOException $e) {
    $pms_pdo->rollBack();
    echo 'Error: ' . $e->getMessage();
}
