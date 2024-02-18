<?php
include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/db.php';
$pms_connect = new Connection();
$pms_pdo = $pms_connect->connect();

switch ($_POST['pms']) {
    case 'un_process_plan':
        $query = "SELECT PROCESS_NAME, PMSID, PROCESS_JOB FROM pms_scanners_pic ORDER BY PROCESS_NAME DESC;";
        $stmt = $pms_pdo->query($query);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <option value="<?php echo $row["PMSID"]; ?>" selected><?php echo $row["PROCESS_NAME"].' — '.$row['PROCESS_JOB']; ?></option>
        <?php
        } 
        $stmt->closeCursor();
        break;
    default:
        break;
}

?>