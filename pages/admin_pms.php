<?php
    $generateRandomString = function ($length = 10) {
        static $counter = 0;
    
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = str_shuffle($characters);
        $result = substr($randomString, 0, $length);
    
        // Increment the counter
        $counter++;
    
        // Decrease counter by 3 when it reaches a threshold (e.g., 10)
        if ($counter % 10 == 0) {
            $counter -= 3;
        }
    
        return $result;
    };
    $RAND = $generateRandomString
?>



<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<meta http-equiv='cache-control' content='no-cache'>
	<meta http-equiv='expires' content='0'>
	<meta http-equiv='pragma' content='no-cache'>
	<title></title>

	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<style>
		.cap {
			border-radius: 5px;
			background-color: blue;
		}
	</style>
	<link rel="stylesheet" href="../public/css/bootstrap.min.css?v=<?php echo $GLOBALS['RAND'](rand(3, 12)) . PHP_EOL ?>" />
	<link rel="stylesheet" href="../public/css/font-awesome.min.css?v=<?php echo $GLOBALS['RAND'](rand(3, 16)) . PHP_EOL ?>" />
	<link rel="stylesheet" href="../public/css/fonts.googleapis.com.css?v=<?php echo $GLOBALS['RAND'](rand(3, 18.3)) . PHP_EOL ?>" />
	<link rel="stylesheet" href="../public/css/ace.min.css?v=<?php echo $GLOBALS['RAND'](rand(3, 5)) . PHP_EOL ?>" class="ace-main-stylesheet">
	<link rel="stylesheet" href="../public/css/ace-skins.min.css?v=<?php echo $GLOBALS['RAND'](rand(3, 11)) . PHP_EOL ?>" />
	<link rel="stylesheet" href="../public/css/ace-rtl.min.css?v=<?php echo $GLOBALS['RAND'](rand(3, 4)) . PHP_EOL ?>" />
    <link rel="stylesheet" href="../node_modules/tabulator-tables/dist/css/tabulator_bootstrap4.min.css?v=<?php echo $GLOBALS['RAND'](rand(3, 4)) . PHP_EOL ?>">
    <link rel="stylesheet" href="../public/js/j_ui/jquery-ui.min.css?v=<?php echo $GLOBALS['RAND'](rand(3, 9)) . PHP_EOL ?>">
	<link rel="stylesheet" href="../public/css/main.css?v=<?php echo $GLOBALS['RAND'](rand(3, 17)) . PHP_EOL ?>">
	<script src="../public/js/ace-extra.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 23)) . PHP_EOL ?>"></script>
</head>

<body class="no-skin">
	<div id="navbar" class="navbar navbar-default ace-save-state">
		<div class="navbar-container ace-save-state" id="navbar-container">
			<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
				<span class="sr-only">Toggle sidebar</span>

				<span class="icon-bar"></span>

				<span class="icon-bar"></span>

				<span class="icon-bar"></span>
			</button>

			<div class="navbar-header pull-left">
				<a href="#" class="navbar-brand">
					<small>
						P.M.M.S</small>
				</a>
			</div>

			<div class="navbar-buttons navbar-header pull-right" role="navigation">
				<ul class="nav ace-nav">

					<li class="light-blue dropdown-modal">
						<a data-toggle="dropdown" href="#" class="dropdown-toggle">
							<span class="user-info">
								<small>Welcome,</small>
								Administrator
							</span>

							<i class="ace-icon fa fa-caret-down"></i>
						</a>

						<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
							<li>
								<a href="#" style="display : none;">
									<i class="ace-icon fa fa-cog"></i>
									Settings
								</a>
							</li>

							<li style="display : none;">
								<a href="profile.php">
									<i class="ace-icon fa fa-user"></i>
									Profile
								</a>
							</li>

							<li class="divider"></li>

							<li>
								<a id="hr_logout">
									<i class="ace-icon fa fa-power-off"></i>
									Logout
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div><!-- /.navbar-container -->
	</div>
	<div class="main-container ace-save-state" id="main-container">
		<script type="text/javascript">
			try {
				ace.settings.loadState('main-container')
			} catch (e) {}
		</script>

		<div id="sidebar" class="sidebar responsive ace-save-state">
			<script type="text/javascript">
				try {
					ace.settings.loadState('sidebar')
				} catch (e) {}
			</script>

			<div class="sidebar-shortcuts" id="sidebar-shortcuts" style="display :none;">
				<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
					<button class="btn btn-success">
						<i class="ace-icon fa fa-signal"></i>
					</button>

					<button class="btn btn-info">
						<i class="ace-icon fa fa-pencil"></i>
					</button>

					<button class="btn btn-warning">
						<i class="ace-icon fa fa-users"></i>
					</button>

					<button class="btn btn-danger">
						<i class="ace-icon fa fa-cogs"></i>
					</button>
				</div>

				<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
					<span class="btn btn-success"></span>

					<span class="btn btn-info"></span>

					<span class="btn btn-warning"></span>

					<span class="btn btn-danger"></span>
				</div>
			</div><!-- /.sidebar-shortcuts -->

			<ul class="nav nav-list">
				<li class="">
					<a href="#" style="padding-left: 0px; padding-right: 0px;">
						<i class="menu-icon fa fa-tachometer"></i>
						<span class="menu-text" id="xparse" style="padding-left: 0px; padding-right: 0px;">PO REGISTRATION</span>
					</a>
					<b class="arrow"></b>
				</li>
			</ul><!-- /.nav-list -->

			<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
				<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
			</div>
		</div>

		<div class="main-content">
			<div class="main-content-inner">
				<div class="page-content">
					<button type="click" id="pms_click">Click Test</button>
				</div>
			</div>
		</div><!-- /.main-content -->

		<div class="footer">
			<div class="footer-inner">
				<div class="footer-content">
					<span class="bigger-120">
						<span class="blue bolder">PMMS SYSTEM</span>
						Web Application &copy; 2024
					</span>
					&nbsp; &nbsp;
					</span>
				</div>
			</div>
		</div>

		<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
			<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>

		</a>
	</div><!-- /.main-container -->

	<!-- basic scripts -->

	<!--[if !IE]> -->
	<script src="../public/js/jquery-2.1.4.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 23)) . PHP_EOL ?>"></script>
	<script src="../public/js/j_ui/jquery-ui.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 24)) . PHP_EOL ?>"></script>
	<script src="../public/js/bootstrap.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 25)) . PHP_EOL ?>"></script>
	<script src="../node_modules/jquery/dist/jquery.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 25)) . PHP_EOL ?>"></script>
    <script src="../node_modules/tabulator-tables/dist/js/tabulator.min.js?v=<?php echo $GLOBALS['RAND'](rand(3, 25)) . PHP_EOL ?>"></script>

	<script type="text/javascript">
		if ('ontouchstart' in document.documentElement) document.write("<script src='./public/js/jquery.mobile.custom.min.js'><" + "/script>");
	</script>
	<script>
		$(document).find('input').each((index, elem) => {
			$(elem).attr('autocomplete', 'off')
		})
	</script>

	<!-- page specific plugin scripts -->

	<!-- ace scripts -->
	<script src="../public/js/ace-elements.min.js?v=<?php echo $GLOBALS['RAND'](rand(1, 21)) . PHP_EOL ?>"></script>
	<script src="../public/js/ace.min.js?v=<?php echo $GLOBALS['RAND'](rand(7, 23)) . PHP_EOL ?>"></script>


	<!-- inline scripts related to this page -->

    <script src=""></script>



</body>

</html>