<?php
header("Content-type: text/html; charset=utf-8");  
error_reporting(E_ALL ^ E_NOTICE);
require "includes/config.php"; 
require "includes/sess.php";
session_start();

 if( !$_SESSION['fname'] ){
	header('Refresh: 0; URL=http://10.10.40.16/xtable/login.php');
	exit;
} 
?>

<html>
	<head>
		<title>UsableX</title>
		<link href="css/home-style.css" rel="stylesheet" type="text/css" media="all" /><br/>
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="js/jqueryUI/js/jqueryui.js"></script>
	</head>

	<body>
	<a href="http://localhost/usablex/xtable/login_mod.php?kill=kill" style="text-decoration:none">
		<button name="modal" id="modal" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
		<span class="ui-button-text">Logout</span></button>
	</a>
	
	<div id="main">

		<div id="icon">
			<a href="http://10.10.40.16/xtable/index.php?vertical=na" name="navXTable" id="navXTable" title="xTable">
				<img alt="XTable" id="XTable" src="img/xtable.png" height="130px" width="130px" />
				
				
				
			</a>
		</div>

		<div id="icon">
			<a href="dashboard.html" name="navDashboard" id="navDashboard" >
				<img alt="Dashboard" id="Dashboard" src="img/dashboard.png" height="130px" width="130px"  title="Dashboard"/>
			</a>
		</div>

		<div id="icon">
			<a href="http://10.10.40.16/xtable/reportgen.php?vertical=na&client=" name="navReporting" id="navReporting" title="Reporting">		
				<img alt="Reporting" id="Reporting" src="img/reports_icon.jpg" height="130px" width="130px" />
				
				
				
			</a>
		</div>		
		
		<div id="icon">
			<a href="administration.html" name="navAdministration" id="navAdministration">
				<img alt="Administration" id="Administration" src="img/admin.png" height="130px" width="130px" title="Administration"/>				
			</a>			
		</div>
		
	</body>
	
</html>


