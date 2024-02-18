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
        <span class="navbar-brand mb-0 h1" style="color:white;">PMMS Mold Accounts Mgmt</span>
        <ul class="nav justify-content-end" style="display: none;" id="userOut">
            <li class="nav-item">
                <a class="nav-link active" style="font-weight:bolder; color:white;" id="onLogout">LOGOUT</a>
            </li>
        </ul>
    </nav>
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <div class="container h-100 d-flex align-items-center justify-content-center">
        <div class="col-md-6">
            <div class="card" id="swap_login">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="pms_usr">Username</label>
                            <input type="text" class="form-control" id="pms_usr" name="pms_usr" placeholder="Enter username">
                        </div>
                        <div class="form-group">
                            <label for="pms_pass">Password</label>
                            <input type="password" class="form-control" id="pms_pass" name="pms_pass" placeholder="Enter password">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember_me">
                            <label class="form-check-label" for="remember_me">Remember me</label>
                        </div>
                        <div class="form-group">
                            <div id="msg"></div>
                        </div>
                        <button type="click" class="btn btn-primary" id="toLogin">Login</button>
                        <a href="#" id="toSign" class="btn btn-primary active" role="button" aria-pressed="true">Sign
                            Up</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="display:none" id="swap_sign">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card ">
                    <div class="card-body">
                        <div class="row d-flex align-items-center">
                            <h4 class="card-title">PMMS SIGN-UP</h4>
                            <button type="click" class="ml-auto" id="back">GO BACK</button>
                        </div>
                        <form action="" method="POST">
                            <div class="form-grou">
                                <div id="sign_msg"></div>
                            </div>
                            <div class="form-group">
                                <label for="sign_id" class="form-label">Employee ID</label>
                                <input type="text" class="form-control" id="sign_id">
                            </div>
                            <div class="form-group">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="sign_username">
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="sign_email">
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="sign_pass">
                            </div>
                            <div class="form-group">
                                <label for="pms_type" class="form-label">Password</label>
                                <select name="pms_type" id="pms_type" class="form-control">
                                    <option value="1">Administrator</option>
                                    <option value="2">Manager</option>
                                    <option value="2">P.I.C Staff</option>
                                </select>
                            </div>
                            <button type="click" class="btn btn-primary btn-block" id="onSign">Submit</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="container-fuild">
        <div class="row" style="display: none;" id="loginTable">
            <div class="col-6 m-1">
                <div id="pmms_acctg"></div>
            </div>
            <div class="col-5 m-3" style="display: none;" id="logOperator">
                <div id="pms_operators"></div>
            </div>
        </div>
    </div>

    <div class="container" style="display: none;">
        <div class="row">
            <div class="col-xs-12" id="operator_">
                <div class="alert alert-secondary">
                    <div class="form-group">
                        <label for="">USER OPTION</label>
                        <input type="checkbox" id="prop_operator" class="form-control" checked data-toggle="toggle" data-on="ADD USER INFO" data-off="RESET PASSWORD" data-onstyle="success" data-offstyle="danger" data-width="220">
                    </div>
                    <div class="row" id="userOptionDiv">
                        <div class="form-group col-12">
                            <label for="USERNAME">EMPLOYEE ID</label>
                            <input type="text" name="acctg_id" id="acctg_id" class="form-control">
                        </div>
                        <div class="form-group col-12">
                            <label for="USERNAME">USER NAME</label>
                            <input type="text" name="acctg_user" id="acctg_user" class="form-control">
                        </div>
                    </div>
                    <div class="row" id="passDiv" style="display: none;">
                        <div class="form-group">
                            <label for="">TYPE CURRENT PASSWORD</label>
                            <input type="text" class="form-control" name="acctg_change" id="acctg_change">
                        </div>
                        <div class="form-group">
                            <button type="button" id="acctg_change" class="btn btn-warning btn-block">CHANGE</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xs-12" id="account_">
                <div class="alert alert-secondary">
                    <div class="form-group">
                        <label for=""></label>
                        <input type="text" name="" id="" class="form-control">
                    </div>
                </div>
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
<script src="../public/js/qr_code/qrcode.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 10)) . PHP_EOL ?>"></script>
<!-- <script src="../node_modules/bootstrap4-toggle/js/bootstrap4-toggle.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 25)) . PHP_EOL ?>"></script> -->
<script src="../view/PMMS_ACCT_VIEW.js" type="module"></script>

</html>