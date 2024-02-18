<?php include $_SERVER['DOCUMENT_ROOT'] . '/1_PMMS_MOLD/db_php/plugin_version_ctrl.php' ?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

    <div class="container" id="swap_to_scan">
        <div class="row">
            <div class="col-12">
                <center>
                    <br />
                    <br />
                    <br />
                    <div class="card">
                        <div class="card-body">
                            <img class="card-img-top" src="/1_PMMS_MOLD/dump_/user_login.png" alt="Card image cap"
                                style="width: 50%; height: 50%;">
                        </div>
                    </div>
                </center>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <center>
                    <form method="post" hx-post="/1_PMMS_MOLD/db_php/scanner/scan_login.php?action=pr_scan"
                        hx-target="this" hx-swap="outerHTML">
                        <div class="form-group">
                            <label for="username">Username : </label>
                            <input type="text" class="form-control" name="pms_usr" id="pms_usr"
                                placeholder="Scan your employee ID...">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="pms_pass" id="pms_pass"
                                placeholder="Your password...">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">LOGIN</button>
                        </div>
                    </form>
                </center>
            </div>
        </div>

        <div class="row"></div>
    </div>
    <div class="container" id="scan_to_table" style="display: none;">
        <div class="input-group mb-3">
            <form hx-post="/1_PMMS_MOLD/db_php/scanner/test.php" hx-swap="innerHTML"
                hx-trigger="input changed delay:500ms, search">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">START SCAN:</span>
                    <input type="search" class="form-control col-7 col-sm-11 col-md-11 col-lg-11 col-xl-11"
                        name="pmsToScan" id="pmsToScan">
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-12 m-3">
                <label for="basic-url">QR CODE</label>

            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" colspan="4">
                                <h4 class="text-center">MOLD REPAIR INFORMATION</h4>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="targetScan">

                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                <table class="table">
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
                                <div id="scan_start_tb"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="card" id="select_scan" style="display: none;">
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="">SELECT PROCESS CODE</label>
                            <select name="" id="pms_select_code" class="form-control">
                                <option value="1">GRS</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-secondary" id="pmsScanINPUT">PROCEED</button>
                            <button type="button" class="btn btn-secondary" id="scanClose">CLOSE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <form hx-post="/1_PMMS_MOLD/db_php/scanner/test.php" hx-trigger="input changed delay:500ms, search" method="post">
        <div class="form-group">
            <label for="">THIS IS TEST</label>
            <input type="text" name="test_12" id="test_1" class="form-control">
        </div>
    </form>


    <!-- ends -->
    <div class="container" style="display: none;">
        <div class="row">
            <div class="col-12">
                <span class="text-center">
                    <h4>GRINDING SECTION</h4>
                </span>
            </div>
        </div>
        <div class="row">
            <div id="scan_table" class="col-12"></div>
        </div>
        <div class="row">
            <div class="col-12" id="scan_status_diag" style="display: none;">
                <form method="post">
                    <center>
                        <div class="form-group">
                            <label for="">CHANGE STATUS</label>
                            <input type="checkbox" id="current_status" data-toggle="toggle" data-onstyle="success"
                                data-on="IN" data-off="OUT" data-offstyle="danger" data-width="200">
                        </div>
                    </center>
                    <div class="form-group">
                        <label for="">SET STATUS AS:</label> 
                        <!--  -->
                        <select type="text" name="pms_set_stat" id="pms_set_stat" class="form-control">
                            <option value="0">ONGOING</option> <!-- NOT GOOD  -->
                            <option value="0">FOR TRIAL</option> <!-- GOOD OR NOT GOOD  -->
                            <option value="0">DONE</option> <!-- NO SELECTION -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">MOLD CONDITION:</label>
                        <select type="text" name="pms_mold_con" id="pms_mold_con" class="form-control">
                            <option value="0">GOOD</option>
                            <option value="0">NOT GOOD</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="button" class="btn btn-primary" id="done_submit">SUBMIT</button>
                            <button type="button" class="btn btn-primary" id="done_close">CLOSE</button>
                        </div>
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