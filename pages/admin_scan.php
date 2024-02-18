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
    <script src="../node_modules/htmx.org/dist/htmx.min.js"></script>
    <script src="../node_modules/htmx.org/dist/ext/class-tools.js"></script>
</head>

<body>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: #3525c2; border-radius: 0;">
            <li class="breadcrumb-item active" aria-current="page">
                <span style="color: white;">PMMS SCANNING MONITORING</span>
            </li>
        </ol>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <div class="alert alert-primary">
                    <div class="row">
                        <h5 style="font-weight: 500;">CURRENT ACTIVE PR-CONTROL #</h5>
                    </div>
                    <div class="row">
                        <ul class="list-group col-12">
                            <li class="list-group-item">CONTRLOL # 1</li>
                            <li class="list-group-item">CONTRLOL # 2</li>
                            <li class="list-group-item">CONTRLOL # 3</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="alert alert-warning">
                    <div class="row">
                        <div class="col-3 table-responsive">
                            <br />
                            <br />
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="text-nowrap">CONTROL #</th>
                                        <td class="text-nowrap">PR2024-102122</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">MODEL #</th>
                                        <td class="text-nowrap">PTTM17-036</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-9 table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" colspan="7">
                                            <span style="text-align: center;">
                                                PRODUCTION RUN DETAILS
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-nowrap">PROCESS</th>
                                        <td class="text-nowrap">Row 1, Cell 2</td>
                                        <th class="text-nowrap">START TIME</th>
                                        <td class="text-nowrap">Row 1, Cell 3</td>
                                        <th class="text-nowrap">DIVISION</th>
                                        <td class="text-nowrap">Row 1, Cell 3</td>
                                        <td rowspan="2">sddssss</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">CODE</th>
                                        <td class="text-nowrap">Row 2, Cell 2</td>
                                        <th class="text-nowrap">PLAN(min)</th>
                                        <td class="text-nowrap">Row 2, Cell 3</td>
                                        <th class="text-nowrap">STATUS</th>
                                        <td style="background-color: green;">Row 2, Cell 3</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="row">
            <!-- using form for sending data  -->
            <div class="col-xs-6">
                <form method="post" hx-post="/1_PMMS_MOLD/db_php/scanner/test.php?action=pooling" hx-trigger="input" hx-target="#target_this">
                    <div class="form-group">
                        <label for="username" class="control-label">Username</label>
                        <input type="text" name="usr_n" id="usr_n" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="username" class="control-label">Password</label>
                        <input type="text" name="pass_in" id="pass_in" class="form-control">
                    </div>
                    <div class="form-group">
                        <div id="target_this"></div>
                    </div>
                </form>
            </div>
            <!-- for div button input select -->
            <div class="col-xs-6"></div>
            <div class="form-group">
                <label for="">main input</label>
                <input type="text" name="txt_in" id="txt_in" class="form-control">
            </div>
        </div>
    </div>

</body>
<script src="../public/js/jquery-2.1.4.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 23)) . PHP_EOL ?>"></script>
<script src="../public/js/j_ui/jquery-ui.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 24)) . PHP_EOL ?>"></script>
<script src="../public/js/bootstrap.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 25)) . PHP_EOL ?>"></script>
<script src="../node_modules/jquery/dist/jquery.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 25)) . PHP_EOL ?>"></script>
<script src="../node_modules/tabulator-tables/dist/js/tabulator.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 25)) . PHP_EOL ?>"></script>
<script src="../node_modules/select2/dist/js/select2.full.min.js?v=<?php echo $GLOBALS['RAND'](rand(5, 10)) . PHP_EOL ?>"></script>
<script src="../view/PMMS_SCAN_VIEW.js" type="module"></script>

</html>