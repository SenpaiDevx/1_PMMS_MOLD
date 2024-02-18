<?php
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();

try {
    $pms_pdo->beginTransaction();
    $query = "SELECT
	ppc.PMS_OP_NAME,
    psa.PROCESS_NAME
FROM pms_scan_process_code ppc
LEFT JOIN pms_scanners_pic psa ON ppc.PROCESS_ID = psa.PMSID
WHERE ppc.PROCESS_ID = ?
ORDER BY psa.PROCESS_NAME;";
    $stmt = $pms_pdo->prepare($query);
    $stmt->bindParam(1, $_POST['unplan_proc'], PDO::FETCH_ASSOC);
    $stmt->execute();
    
    while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
        <option value="<?php echo $rows['PMS_OP_NAME']; ?>" selected><?php echo $rows['PMS_OP_NAME']; ?></option>
    <?php
    }
    $pms_pdo->commit();
} catch (PDOException $e) {
    ?>
        <option value="0" selected>Data base error</option>
    <?php
    // echo ('Error!: ' . $e->getMessage());
}
?>