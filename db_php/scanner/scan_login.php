<?php
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();
$main = 'wwwwww';
$mains = 'librid';
$tops = 'on the law';

switch ($_GET['action']) {
    case 'pr_scan':
        $pr_scan_query = "SELECT EXISTS(SELECT 1 FROM pms_login WHERE PMS_USR = :usr AND PMS_PASS = :pass) as pr_exist";
        try {
            $pms_pdo->beginTransaction();
            $login_stmt = $pms_pdo->prepare($pr_scan_query);
            $login_stmt->execute([
                ":usr" => $_POST['pms_usr'],
                ":pass" => $_POST['pms_pass']
            ]);
            $login = $login_stmt->fetch(PDO::FETCH_ASSOC);
            if ($login['pr_exist']) {
            ?>
            <div class="alert alert-secondary">
                
            </div>
                <script>
                    $('#swap_to_scan').css({
                        "display": "none"
                    })
                    // $('#scan_to_table').removeAttr('style')
                </script>
            <?php
            } else {
            ?>
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h2>
                            <?php
                            echo $_POST['pms_usr'];
                            ?>
                        </h2>
                    </div>
                </div>
            <?php
            }

            $pms_pdo->commit();
        } catch (PDOException $e) {
            ?>
            <div class="alert alert-warning" role="alert">
                <span class="badge badge-secondary">
                    <?php echo "Error: " . $e->getMessage() ?>
                </span>
            </div>
        <?php
        }
        break;

    case 'onScan':
        $pr_onScan = "SELECT 
        PR.PMS_CONTROL_NO,
        PR.PMS_MOLD_ID,
        PR.PMS_JOB_NO,
        PL.MODEL,
        PL.PART_NO,
        PL.CAVI_NO,
        PL.CUSTOMER,
        PL.MOLD_NAME,
        PL.MARK_NO,
        PL.MP_LOC
        FROM pms_reg PR 
        LEFT JOIN pms_mold_list PL ON PR.PMS_MOLD_ID = PL.MOLD_CTRL_NO WHERE PR.PMS_CONTROL_NO = ?;";
        try {
            $pms_pdo->beginTransaction();
            $onScan = $pms_pdo->prepare($pr_onScan);
            $onScan->bindParam(1, $_POST['pmsToScan'], PDO::PARAM_STR);
            $onScan->execute();
            $scanRow = $onScan->fetch(PDO::FETCH_ASSOC);

            // if ($_GET['output'] == 'html') {
        ?>
            <tr>
                <th>PR CONTROL</th>
                <td><?php echo $scanRow['PMS_CONTROL_NO']; ?></td>
                <th>JOB ORDER #</th>
                <td><?php echo $scanRow['PMS_JOB_NO']; ?></td>
            </tr>
            <tr>
                <th scope="col">MOLD CODE</th>
                <td><?php echo $scanRow['PMS_MOLD_ID']; ?></td>
                <th scope="col">CUSTOMER</th>
                <td><?php echo $scanRow['CUSTOMER']; ?></td>
            </tr>
            <tr>
                <th scope="col" class="text-wrap">MODEL</th>
                <td><?php echo $scanRow['MODEL']; ?></td>
                <th scope="col">MOLD NAME</th>
                <td><?php echo $scanRow['MOLD_NAME']; ?></td>
            </tr>
            <tr>
                <th>PART NO</th>
                <td><?php echo $scanRow['PART_NO']; ?></td>
                <th>MARK #</th>
                <td><?php echo $scanRow['MARK_NO']; ?></td>
            </tr>
            <tr>
                <th scope="col">CAV #</th>
                <td><?php echo $scanRow['CAVI_NO']; ?></td>
                <th scope="col">MP LOCATION</th>
                <td><?php echo $scanRow['MP_LOC']; ?></td>
            </tr>
         <?php
            // } else {
            // }
            $pms_pdo->commit();
        } catch (PDOException $E) {
            $error = '{
                "msg" : "' . $E->getMessage() . '"
            }';
            echo $error;
        }

        break;
}


