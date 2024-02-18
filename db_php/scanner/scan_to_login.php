<?php
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();
try {
    $pms_pdo->beginTransaction();
    $query = "SELECT EXISTS(SELECT 1 FROM pms_login WHERE PMS_USR = :usr AND PMS_PASS = :pass) as isLogin";
    $stmt = $pms_pdo->prepare($query);
    $stmt->execute([
        ":usr" => $_POST["pms_user"],
        ":pass" => $_POST["pms_pass"]
    ]);
    $stmt_row = $stmt->fetch(PDO::FETCH_ASSOC);     // fetch row (and only one)

    if ((int) $stmt_row['isLogin']) {
        ?>
        <div class="container h-100 d-flex align-items-center justify-content-center">
            <div class="row" id="mainContent">
                <div class="input-group mt-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text m-1" id="basic-addon3">START SCAN:</span>
                        <input type="search" class="form-control col-10 m-1" name="pmsToScan" id="pmsToScan"
                            hx-post="/1_PMMS_MOLD/db_php/scanner/scan_ctrl.php" hx-target="#pms_result" hx-trigger="input changed delay:500ms"
                            hx-swap="innerHTML">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" colspan="4">
                                    <h4 class="text-center">MOLD REPAIR INFORMATION</h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="pms_result">
                            <tr>
                                <th>PR CONTROL</th>
                                <td> <?php echo 'this' ?> </td>
                                <th>JOB ORDER #</th>
                                <td> <?php echo 'this' ?> </td>
                            </tr>
                            <tr>
                                <th scope="col">MOLD CODE</th>
                                <td> <?php echo 'this' ?> </td>
                                <th scope="col">CUSTOMER</th>
                                <td> <?php echo 'this' ?> </td>
                            </tr>
                            <tr>
                                <th scope="col" class="text-wrap">MODEL</th>
                                <td><?php echo 'this' ?></td>
                                <th scope="col">MOLD NAME</th>
                                <td> <?php echo 'this' ?></td>
                            </tr>
                            <tr>
                                <th>PART NO</th>
                                <td><?php echo 'this' ?> </td>
                                <th>MARK #</th>
                                <td><?php echo 'this' ?> </td>
                            </tr>
                            <tr>
                                <th scope="col">CAV #</th>
                                <td> <?php '' ?></td>
                                <th scope="col">MP LOCATION</th>
                                <td> <?php '' ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12" id="tb_container">
                <!-- the tabulator is hide already render only show after login -->

                </div>
            </div>
        </div>
        <script>
            $('#pms_list_plan').removeAttr('style')
        </script>
        <?php
    } else {
        ?>
        <div class="alert alert-warning">
            <h5>
                <?php echo 'User does not exist in DB' . (int) $stmt_row['isLogin'] ?>
            </h5>
        </div>
        <?php
    }
    $pms_pdo->commit();
    $stmt->closeCursor();
} catch (PDOException $e) {
    $pms_pdo->rollBack();
    ?>
    <div class="alert alert-danger">
        <?php echo 'Error: ' . $e->getMessage() ?>
    </div>
    <?php
}