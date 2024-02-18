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
    <!-- REGISTRATION MODULE -->
    <div class="container-fluid">
        <h2>PMMS REGISTRATION</h2>
        <div class="row" id="pms_inputs">
            <div class="col-xs-3 m-3">
                <div class="form-group">
                    <label for="exampleInput">CONTROL NO</label>
                    <input type="text" class="form-control" id="pms_ctrlno" name="pms_ctrlno" placeholder="">
                </div>
                <div class="form-group">
                    <label for="exampleInput">JOB ORDER BY WEEK NO</label>
                    <input type="text" class="form-control" id="pms_jobno" name="pms_jobno">
                </div>
                <div class="form-group">
                    <label for="exampleInput">Target Date:</label>
                    <input type="date" class="form-control" id="pms_targetDate" name="pms_targetDate">
                </div>
            </div>
            <div class="col-6 m-3">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="exampleInput">MOLD CODE</label>
                            <select name="mold_ctrl" id="mold_ctrl" class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInput">CUSTOMER</label>
                            <input type="text" class="form-control" id="pms_customer" name="pms_customer" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInput">MODEL</label>
                            <input type="text" class="form-control" id="pms_model" name="pms_model" placeholder="">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="exampleInput">MOLD NAME</label>
                            <input type="text" class="form-control" id="pms_mold_name" name="pms_mold_name" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInput">PART NO</label>
                            <input type="text" class="form-control" id="pms_part" name="pms_part" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInput">MARK #</label>
                            <input type="text" class="form-control" id="pms_mark" name="pms_mark" placeholder="">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="exampleInput">CAV #</label>
                            <input type="text" class="form-control" id="pms_cav2" name="pms_cav2" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInput">MP LOCATION</label>
                            <input type="text" class="form-control" id="pms_loc" name="pms_loc" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInput">DRAWING #</label>
                            <input type="text" class="form-control" id="pms_draw" name="pms_draw" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInput">PART NAME</label>
                            <input type="text" class="form-control" id="pms_partName" name="pms_partName" placeholder="">
                        </div>
                          
                        
                    </div>
                </div>
            </div>
            <div class="col-xs-6 m-3">
                <label for="exampleInput">TYPE</label>
                <div class="row" id="chkgroup">
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="checkbox" id="pms_fab" value="FAB" aria-label="Checkbox for following text input">
                                </div>
                            </div>
                            <input type="text" class="form-control" value="FAB" disabled>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="checkbox" value="ECN" id="pms_ecn"> 
                                </div>
                            </div>
                            <input type="text" class="form-control" value="ECN" disabled>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="checkbox" value="REPAIR" id="pms_repair">
                                </div>
                            </div>
                            <input type="text" class="form-control" value="REPAIR" disabled>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="checkbox" value="BACK JOB" id="pms_backjob">
                                </div>
                            </div>
                            <input type="text" class="form-control" value="BACK JOB" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInput">DEFECT</label>
                            <input type="text" class="form-control" id="pms_defect" name="pms_defect" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInput">DEFECT DETAIL</label>
                            <input type="text" class="form-control" id="pms_detail" name="pms_detail" placeholder="">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInput">DEFECT CAV</label>
                            <input type="text" class="form-control" id="pms_cav" name="pms_cav" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInput">QUANTITY</label>
                            <input type="text" class="form-control" id="pms_qty" name="pms_qty" placeholder="">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="exampleInput">Cavity</label>
                                <input type="text" class="form-control" id="pms_scan-cavs" name="pms_scan-cavs" placeholder="">
                            </div>
                            <div class="form-group col-4">
                                <label for="exampleInput">Job Q'ty</label>
                                <input type="text" class="form-control" id="pms_jobQty" name="pms_jobQty" placeholder="">
                            </div>
                            <div class="form-group col-4">
                                <label for="exampleInput">Charge</label>
                                <select name="pms_charge" id="pms_charge" class="form-control">
                                    <option value="O">O</option>
                                    <option value="X">X</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="col-xs-10 m-3" style="width: 50%;">
                <div id="pms_insert_table"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 m-3">
                <button type="button" class="btn btn-primary btn-lg btn-block" id="pms_insert">INSERT PMS</button>
            </div>
        </div>
        <div class="row">
            <div id="modal_valid" style="display:none">
                <div class="alert alert-warning"> ID IS READY EXISTED</div>
            </div>
        </div>
    </div>
    <!-- DRAWING MODULE -->
    <div class="container-fluid">
        <div class="row">
            <h2 class="m-3">PMMS DRAWING UPLOADER </h2>
        </div>
        <div class="row">
            <div class="col-xs-12 well wel-lg m-3">
                <div class="form-group">
                    <label for="exampleInput">PR CONTROL NO:</label>
                    <select name="pr_control_no" id="pr_control_no" class="form-control"></select>
                </div>
            </div>
            <div class="col-xs-12 m-3">
                <div class="form-group">
                    <label for="exampleInput">DRAWING CONTROL #:</label>
                    <input type="text" class="form-control" id="pms_drawNo" name="pms_drawNo" placeholder="" disabled>
                </div>

            </div>
            <div class="col-xs-10">
                <button type="click" class="btn btn-primary btn-block" id="pms_saveDraw">SAVE</button>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 alert alert-primary m-3 w-50">
                <ul class="list-unstyled">
                    <div class="row" id="draw_upload">

                    </div>
                </ul>
            </div>
            <div class="col-xs-8 m-3">
                <div id="pms_drawTable"></div>

            </div>
            <div class="col-xs-6" id="addDrawDialog" style="display:none;">
                <div class="row" id="draw_hide">
                    <div class="col-xs-6 m-2">
                        <div class="form-group">
                            <label for="">DRAWING NAME</label>
                            <input type="text" class="form-control" name="title_draw" id="title_draw">
                        </div>
                    </div>
                    <div class="col-xs-6 m-2">
                        <div class="form-group">
                            <label for="">NAME OF UPLOADER</label>
                            <input type="text" class="form-control" name="pic_name" id="pic_name">
                        </div>
                    </div>
                    <div class="col-xs-6 m-2">
                        <form action="" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="" class="control-label">ADD DRAWING</label>
                                <input type="file" class="input-group-text form-control" id="drawFile">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row" id="draw_warning" style="display: none;">
                    <div class="alert alert-warning" role="alert">Are You Sure to Delete This Drawing?</div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <h2>DRAWING AND PLANNING</h2>
        <div id="qr_text"></div>

        <div class="row">
            <div class="col-xs-4 m-2">
                <div id="plan2draw" class="col-xs-3"></div>
            </div>
            <div class="col-xs-4 m-2">
                <h3>PMMS DRAWING AND PLANNING</h3>
                <div id="mold_plan"></div>
            </div>
            <div class="col-xs-4 m-2">
                <div id="mold_table"></div>
            </div>

            <div class="col-xs-3 m-2 alert alert-primary" style="display: none;">
                <div id="pms_action_plan">
                    <div class="form-group">
                        <label for="" class="control label">PROCESS NAME</label>
                        <select name="proc_name" id="proc_name" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <label for="" class="control label">P.I.C EMPLOYEE NAME</label>
                        <input type="text" name="pms_name" id="pms_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="" class="control label">P.I.C EMPLOYEE ID</label>
                        <input type="text" name="pms_picid" id="pms_picid" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="" class="control label">PROCESS PLAN (min)</label>
                        <input type="time" name="proc_mins" id="proc_mins" class="form-control">
                    </div>
                    
                </div>
                <div id="mold_confirm" style="display: none;">
                    <div class="alert alert-warning">Confirm to delete this plan?</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12" id="qr_dialog" style="display: none;">
                <div id="qr_embed"></div>
            </div>
        </div>
    </div>



    <script src="../public/js/jquery-2.1.4.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 23)) . PHP_EOL ?>"></script>
    <script src="../public/js/j_ui/jquery-ui.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 24)) . PHP_EOL ?>"></script>
    <script src="../public/js/bootstrap.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 25)) . PHP_EOL ?>"></script>
    <script src="../node_modules/jquery/dist/jquery.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 25)) . PHP_EOL ?>"></script>
    <script src="../node_modules/tabulator-tables/dist/js/tabulator.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 25)) . PHP_EOL ?>"></script>
    <script src="../node_modules/select2/dist/js/select2.full.min.js?v=<?php echo $GLOBALS['RAND'](rand(5, 10)) . PHP_EOL ?>"></script>
    <script src="../node_modules/pdfmake/build/pdfmake.min.js?v=<?php echo $GLOBALS['RAND'](rand(5, 10)) . PHP_EOL ?>"></script>
    <script src="../node_modules/pdfmake/build/vfs_fonts.js?v=<?php echo $GLOBALS['RAND'](rand(7, 10)) . PHP_EOL ?>"></script>
    <script src="../node_modules/pdfobject/pdfobject.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 10)) . PHP_EOL ?>"></script>
    <script src="../public/js/qr_code/qrcode.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 10)) . PHP_EOL ?>"></script>
    <script src="../view/PMMS_INSERT_VIEW.js" type="module"></script>

</body>

</html>