<?php include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/plugin_version_ctrl.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PMMS SCANNING</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css?v=<?php echo $GLOBALS['RAND'](rand(3, 10)) . PHP_EOL ?>">
    <link rel="stylesheet" href="../node_modules/tabulator-tables/dist/css/tabulator_bootstrap4.min.css?v=<?php echo $GLOBALS['RAND'](rand(3, 4)) . PHP_EOL ?>">
    <link rel="stylesheet" href="../public/js/j_ui/jquery-ui.min.css?v=<?php echo $GLOBALS['RAND'](rand(3, 9)) . PHP_EOL ?>">
    <link rel="stylesheet" href="../node_modules/select2/dist/css/select2.min.css?v=<?php echo $GLOBALS['RAND'](rand(3, 9)) . PHP_EOL ?>">
    <link rel="stylesheet" href="../public/js/j_ui/jquery-ui.min.css?v=<?php echo $GLOBALS['RAND'](rand(3, 9)) . PHP_EOL ?>">
    <link rel="stylesheet" href="../node_modules/bootstrap4-toggle/css/bootstrap4-toggle.min.css?v=<?php echo $GLOBALS['RAND'](rand(3, 9)) . PHP_EOL ?>">
    <script src="../node_modules/htmx.org/dist/htmx.min.js"></script>
    <script src="../node_modules/htmx.org/dist/ext/class-tools.js"></script>

</head>

<body>
    <nav class="navbar" style="background-color: #3525c2;">
        <span class="navbar-brand mb-0 h1" style="color:white;">PMMS SCAN LOGIN</span>
    </nav>

    <div class="container h-100 d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12">
                <br>
                <br>
                <br>
                <form method="post" hx-post="/1_PMMS_MOLD/db_php/scanner/scan_to_login.php" hx-target="closet, .col-12" hx-swap="outerHTML">
                    <center>
                        <div class="card">
                            <div class="card-body">
                                <img class="card-img-top" src="/1_PMMS_MOLD/dump_/user_login.png" alt="Card image cap" style="width: 50%; height: 50%;">
                            </div>
                        </div>
                    </center>
                    <div class="form-group mt-3">
                        <label for="pms_user">Username</label>
                        <input type="text" name="pms_user" id="pms_user" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="pms_pass">Password</label>
                        <input type="password" name="pms_pass" id="pms_pass" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container h-100 d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12">
                <table class="table" id="pms_list_plan" style="display: none;">
                    <thead>
                        <tr>
                            <th scope="col">
                                <h3 class="text-center">PROCESS LIST PLAN</h3>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <button type="button" class="btn btn-primary btn-block" id="unPlanBtn">ADD NEW PLAN</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="scan_start_tb"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table" id="pms_data_plan" style="display: none;">
                    <thead>
                        <tr>
                            <th scope="col">
                                <h3 class="text-center">PMMS MOLD STATUS</h3>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div id="pms_InOut" class="col-12"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-xl-12" id="onScan" style="display: none;">
                <div class="form-group" id="formScan" style="height: 100px;"> </div>
            </div>
            <div class="col-xs-12 col-xl-12" id="unPlanScaned" style="display: none;">
                <div class="form-group">
                    <label for="">PROCESS NAME</label>
                    <div class="row m-2">
                        <select name="unplan_proc" id="unplan_proc" class="form-control col-8 m-1"
                        hx-post="/1_PMMS_MOLD/db_php/select/pms_operators.php"
                        hx-trigger="change"
                        hx-target="#unplan_name"
                        hx-swap="innerHTML"></select>
                        <button type="button" class="btn btn-primary col-3">ADD</button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Operator Name</label>
                    <select name="unplan_name" id="unplan_name" class="form-control"></select>
                </div>
                <div class="form-group">
                    <label for="">Employee ID</label>
                    <input type="text" name="unplan_emp_id" id="unplan_emp_id" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">PLAN(mins)</label>
                    <input type="time" name="unplan_time" id="unplan_time" class="form-control">
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary" id="unplan_btn">SUBMIT</button>&nbsp
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12" id="scan_status_diag" style="display: none;">
                <!-- Scan Status -->
                <form id="form_plan" action="" method="post">
                        <div class="form-group ">
                            <center>
                                <label for="">CHANGE STATUS</label>
                                <input type="checkbox" class="msgbox" name="current_status" id="current_status" data-toggle="toggle" data-onstyle="success" data-on="IN" data-off="OUT" data-offstyle="danger" data-width="200">
                            </center>
                        </div>
                    <div class="form-group">
                        <label for="">QR-CODE SCAN:</label>
                        <input type="text" name="pms_setqr" id="pms_setqr" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">SET TIME:</label>
                        <input type="time" name="pms_setTime" id="pms_setTime" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">SET STATUS AS:</label>
                        <select type="text" name="pms_set_stat" id="pms_set_stat" class="form-control">
                            <option value="0">ONGOING</option> <!-- NOT GOOD  -->
                            <option value="1">PENDING</option> <!-- NOT GOOD  -->
                            <option value="2">FOR TRIAL</option> <!-- GOOD OR NOT GOOD  -->
                            <option value="3">DONE</option> <!-- NO SELECTION -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">MOLD CONDITION:</label>
                        <select type="text" name="pms_mold_con" id="pms_mold_con" class="form-control">
                            <option value="GOOD">GOOD</option>
                            <option value="NG">NOT GOOD</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">REMARKS</label>
                        <input type="text" name="pms_remarks" id="pms_remarks" class="form-control">
                    </div>
                </form>
            </div>
        </div>
    </div>



</body>
<script src="../public/js/jquery-2.1.4.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 23)) . PHP_EOL ?>"></script>
<script src="../public/js/j_ui/jquery-ui.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 24)) . PHP_EOL ?>"></script>
<script src="../public/js/bootstrap.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 25)) . PHP_EOL ?>"></script>
<script src="../node_modules/bootstrap4-toggle/js/bootstrap4-toggle.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 25)) . PHP_EOL ?>"></script>
<script src="../node_modules/jquery/dist/jquery.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 25)) . PHP_EOL ?>"></script>
<script src="../node_modules/tabulator-tables/dist/js/tabulator.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 25)) . PHP_EOL ?>"></script>
<script src="../node_modules/select2/dist/js/select2.full.min.js?v=<?php echo $GLOBALS['RAND'](rand(5, 10)) . PHP_EOL ?>"></script>
<script src="../view/PMMS_SCAN_VIEW.js" type="module"></script>

</html>