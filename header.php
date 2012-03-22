<?php

	ob_start();
	date_default_timezone_set('America/New_York');
	header("Content-type: text/html; charset=utf-8");  
	error_reporting(E_ALL ^ E_NOTICE);
	require "includes/config.php"; 
	require "includes/sess.php";
	session_start();

		$rel = $_GET['rel'];

		$q = mysql_query("SELECT project_name FROM table_project, table_relation WHERE relation_id = '{$rel}'  AND  r_project = project_id");

		$name = mysql_fetch_array($q);
		$project_name = $name[0];

?>

<!DOCTYPE html>
<html>
	<head>
		<title>UsableX - Export</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="css/jquery.ui.theme.css" />

		<style>

			*{margin:0px; padding:0px;}

			table{
				border-collapse:collapse;
				position:absolute;
				bottom:0px;
			}

			table td{
				height:15px;
			}

			#quick-details{
				
			}

			#quick-details img{
				height: 30px;
				float: left;
			}

			#quick-details-time{
				float: right;
				margin-right: -300px;
			}

			#quick-details{		
				background-size: 30px;		
				text-align:center;
			}

			#project-name{
				display:inline-block;
				font-family: Arial;
				font-size:18px;
				font-weight: bold;
			}

			body,html{
				height:50px;
				padding-left:4px;
			}

		</style>
	</head>
<body>

	<div id ='quick-details'>
		
		<img src='img/um_logo.gif' /> 
		<span id='project-name'><?php echo $project_name; ?></span>	
		<span id='quick-details-time' class="ui-widget-content  ui-widget " style='border:0px !important;'>Generated on <?php echo date("l, F d, Y h:i:s A", time()); ?></span>
		
	</div>

	<table id='xport' name='xport' class='ui-widget-content  ui-widget '>

		<tr class='ui-widget-header ui-widget-content ui-widget'>
		  
			<td class='tblTR ui-widget-header ui-widget-content ui-widget ui-state-default' style='min-width:128px; max-width:128px; text-align:center;'>FUNCTION</td>
			<td class='tblTR ui-widget-header ui-widget-content ui-widget ui-state-default' style='min-width:70px; max-width:70px; text-align:center;'>TCID</td> 
			<td class='tblTR ui-widget-header ui-widget-content ui-widget ui-state-default' style='min-width:74px; max-width:74px; text-align:center;'>PRIORITY</td> 
			<td class='tblTR ui-widget-header ui-widget-content ui-widget ui-state-default' style='min-width:79px; max-width:79px; text-align:center;'>CLASS</td> 
			<td class='tblTR ui-widget-header ui-widget-content ui-widget ui-state-default' style='min-width:132px; max-width:132px; text-align:center;'>NAME</td> 
			<td class='tblTR ui-widget-header ui-widget-content ui-widget ui-state-default' style='min-width:160px; max-width:160px; text-align:center;'>PREREQUISITE</td>
			<td class='tblTR ui-widget-header ui-widget-content ui-widget ui-state-default' style='min-width:347px; max-width:347px; text-align:center;'>SCENARIO</td>
			<td class='tblTR ui-widget-header ui-widget-content ui-widget ui-state-default' style='min-width:348px; max-width:348px; text-align:center;'>VERIFICATION</td>
	   
		</tr>

	</table>
	

</body>
</html>