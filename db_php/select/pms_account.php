<?php
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_ = $_POST['pms'];
$pms_get = $_GET['action'];
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();

if ($_GET['action'] == 'toLogin') {
    try {
        $pms_pdo->beginTransaction();
        $log_query = "SELECT EXISTS(SELECT 1 FROM pms_login WHERE PMS_USR = ? AND PMS_PASS = ?) AS isLogin;";
        $log_stmt = $pms_pdo->prepare($log_query);
        $log_stmt->bindParam(1, $pms_[0], PDO::PARAM_STR);
        $log_stmt->bindParam(2, $pms_[1], PDO::PARAM_STR);
        $log_stmt->execute();
        $log_row =  $log_stmt->fetch(PDO::FETCH_ASSOC);
        $pms_pdo->commit();
        if ((int) $log_row['isLogin']) {
?>
            <div class="alert alert-success">
                로그인에 성공하였습니다.<br>
            </div>
            <script>
                console.log('on the way')
                $('#userOut').removeAttr('style')
            </script>
        <?php
        } else {
        ?>
            <div class="alert alert-danger" id="errMsg">
                note done.<br>
            </div>
            <script>
                $('#userOut').css({
                    "display": "none"
                })
            </script>
        <?php
        }
        $log_stmt->closeCursor();
    } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br/>";
    }
}

if ($_GET['action'] == 'SignUp') {
    try {
        $pms_pdo->beginTransaction();
        $sign_query = "INSERT INTO pms_login (PMS_EMPLOYEE_ID, PMS_USR, PMS_PASS, PMS_USR_TYPE, PMS_EMAIL) VALUES(?,?,?,?,?)";
        $sign_stmt = $pms_pdo->prepare($sign_query);
        $sign_stmt->bindParam(1, $_POST['pms']['0'], PDO::PARAM_STR);
        $sign_stmt->bindParam(2, $_POST['pms']['1'], PDO::PARAM_STR);
        $sign_stmt->bindParam(3, $_POST['pms']['2'], PDO::PARAM_STR);
        $sign_stmt->bindParam(4, $_POST['pms']['3'], PDO::PARAM_STR);
        $sign_stmt->bindParam(5, $_POST['pms']['4'], PDO::PARAM_STR);
        $sign_stmt->execute();
        // after execute get the row effect if the insert query successfully inserted
        $rows_affected = $sign_stmt->rowCount();
        if (!$rows_affected) {
        ?>
            <div class="alert alert-danger">
                user already exist. please login or reset password.
            </div>
        <?php
        } else {
        ?>
            <div class="alert alert-success">
                User created Successfully<br>
                Please login to continue...
            </div>
        <?php
        }

        $pms_pdo->commit();
    } catch (PDOException $e) {
        ?>
        <div class="alert alert-success">
            user already exist. please login or reset password.
            <?php echo $e->getMessage(); ?>
        </div>
<?php
        $pms_pdo->rollBack();
    }
}

if ($_GET['action'] == 'pms_acctg') {
    $user_query = "SELECT * FROM pms_login;";
    $user_stmt = $pms_pdo->query($user_query);
    $user_stmt->execute();
    $user_tag = '[';
    while ($rows = $user_stmt->fetch(PDO::FETCH_ASSOC)) {
        $user_tag .= '{
            "acct_id" : "' . $rows['PMS_EMPLOYEE_ID'] . '",
            "acct_usr" : "' . $rows['PMS_USR'] . '",
            "acct_email" : "' . $rows['PMS_EMAIL'] . '",
            "acct_type" : "' . $rows['PMS_USR_TYPE'] . '"
        },';
    }
    $user_tag = rtrim($user_tag, ',');
    $user_tag .= ']';
    echo $user_tag;
}

if ($_GET['action'] == 'pms_operator') {
    $operator_query = "SELECT 
    PCP.PMS_CODE, 
    PCP.PMS_CODENAME, 
    PCP.PMS_OP_NAME, 
    PSA.PROCESS_NAME, 
    PSA.PROCESS_JOB 
    FROM pms_scan_process_code PCP 
    LEFT JOIN pms_scanners_pic PSA ON PCP.PROCESS_ID = PSA.PMSID";
    $oper_stmt = $pms_pdo->query($operator_query);
    $oper_stmt->execute();
    $oper_tag = '[';
    while ($rows = $oper_stmt->fetch(PDO::FETCH_ASSOC)) {
        $oper_tag .= '{
            "opr_name" : "' . $rows['PMS_OP_NAME'] . '",
            "opr_code" : "' . $rows['PMS_CODE'] . '",
            "opr_codm" : "' . $rows['PMS_CODENAME'] . '",
            "opr_process" : "' . $rows['PROCESS_NAME'] . '",
            "opr_job" : "' . $rows['PROCESS_JOB'] . '"
        },';
    }
    $oper_tag = rtrim($oper_tag, ',');
    $oper_tag .= ']';
    echo $oper_tag;
}
