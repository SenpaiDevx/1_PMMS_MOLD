<?php
date_default_timezone_set("Asia/Manila");
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();
$pms_ = $_POST['pms'];
$isTime = date('Y-m-d H:i:s', time());
try {
    $pms_pdo->beginTransaction();
    $query = "INSERT INTO pms_process (PMS_CONTROL_NO, PROCESS_NAME, PMS_PIC_ID, PLAN_TIME, PIC_NAME, PLAN_DATETIME) 
    VALUES(?,?,?,?,?,?);";
    $stmt = $pms_pdo->prepare($query);
    $stmt->bindParam(1, $pms_[0], PDO::PARAM_STR);
    $stmt->bindParam(2, $pms_[1], PDO::PARAM_STR);
    $stmt->bindParam(3, $pms_[2], PDO::PARAM_STR);
    $stmt->bindParam(4, $pms_[3], PDO::PARAM_STR);
    $stmt->bindParam(5, $pms_[4], PDO::PARAM_STR);
    $stmt->bindParam(6, $isTime, PDO::PARAM_STR);
    $stmt->execute();
    $tags = '[
        {
            "scan_opr" : "'. $pms_[4] .'",
            "scan_id" : "'. $pms_[2] .'",
            "scan_mins" : "'. $pms_[3] .'",
            "scan_proc" : "'. $pms_[1] .'"
        }
    ]';
    echo $tags;
    $pms_pdo->commit();
    $stmt->closeCursor();
} catch (PDOException $e) {
    $pms_pdo->rollBack();
    ?>
        <div class="alert alert-warning" id="msg">
            <?php  echo "Error!: " . $e->getMessage() . "<br/>"; ?>
        </div>
        <script>
            let parent = $('#unplan_btn').parent()
            $(parent).append(`
            <div class="alert alert-warning" id="msg">
            <?php  echo "Error!: " . $e->getMessage() . "<br/>"; ?>
            </div>`);
        </script>
    <?php
}

?>