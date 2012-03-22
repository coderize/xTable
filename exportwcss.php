<?php 

header("Content-type: text/html; charset=utf-8");  
error_reporting(E_ALL ^ E_NOTICE);
require "includes/config.php"; 
require "includes/sess.php";
session_start();


?>

<!DOCTYPE html>
<html>
<head>

	<title>UsableX - Export</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="css/jquery.ui.theme.css" />

		<style>

			#xport{
				border-collapse:collapse;
			}

			.scenario, .verification{
				width: 310px;
			}

			.status, .tcid, .priority, .class{
				width: 70px;
			}

			.prereq pre, .name, .func{
				width: 150px;
			}
			 
			 pre{
				font-size: 1em;
				white-space: pre-wrap;       /* css-3 */
				white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
				white-space: -pre-wrap;      /* Opera 4-6 */
				white-space: -o-pre-wrap;    /* Opera 7 */
				word-wrap: break-word;       /* Internet Explorer 5.5+ */
				margin: -1px 0px -1px 0px;
			 }
			 
			 .center{
				text-align:center;
			 }
			 
			.all{
				padding: 5px;
			}

			thead{
				font-size: 1.2em !important;
			}

			@font-face {
				font-family:Calibri;
				font-style:normal;
      				font-weight:normal;
    				src:url('https://xtable.4usable.net/xtable/css/font/calibri.ttf');
				format('truetype');
			}

			body {
				font-family:Calibri;
			}
		 
			.func{
				min-width: 126px;
				max-width: 126px;
			}
			
			.tcid{
				text-align: center;
				min-width: 64px;	
				max-width: 64px;	
			}

			.priority{
				text-align: center;		
				min-width:68px;	
				max-width: 68px;					
			}	

			.class{
				text-align: center;		
				min-width: 75px;	
				max-width: 75px;	
			}

			.name{	
				min-width:130px;	
				max-width: 130px;	
			}

			.prereq{	
				min-width:159px;	
				max-width: 159px;	
			}

			.scenario{	
				min-width:358px;	
				max-width: 358px;	
			}
		 
			.verification{	
				min-width:358px;	
				max-width: 358px;	
			}		 
		 
		</style>
	</head>
<body>

<?php

$rel = mysql_real_escape_string($_GET['rel']);

$q = @mysql_query("SELECT manual_function_name AS 'FUNCTION'			
										, status_name as 'STATUS'
										, manual_tcid AS 'TCID'
										, priority_name AS 'PRIORITY'
										, class_name AS 'CLASS'
										, manual_name AS 'NAME'
										, manual_prereq AS 'PREREQUISITE'
										, manual_steps AS 'SCENARIO'
										, manual_expected AS 'VERIFICATION'
									 
									FROM table_manual, table_class, table_relation, table_priority, table_status
									 
									WHERE manual_relation_id = {$rel}
										AND manual_relation_id = relation_id
										AND manual_class_id = class_id
										AND manual_priority_id = priority_id
										AND manual_status = status_id
										AND manual_status < 3
									
									ORDER BY status_name, manual_tcid"); //or die ("UNABLE TO GET TESTCASES");

$table = "<table id='xport' name='xport' class='ui-widget-content  ui-widget '>

	   ";

      while($query_row = @mysql_fetch_object($q))  {  
	  
		$table .= "		
			<tr class='ui-widget-content ui-widget'>

			   <td  valign='top' class= 'func all ui-widget-content ui-widget'>$query_row->FUNCTION</td>
			   
			   <td valign='top' class= 'tcid center all ui-widget-content ui-widget'>$query_row->TCID</td>
			   
			   <td  valign='top' class= 'priority center all ui-widget-content ui-widget'>$query_row->PRIORITY</td>
			   
			   <td  valign='top' class= 'class center all ui-widget-content ui-widget'>$query_row->CLASS</td>
			   
			   <td valign='top' class= 'name all ui-widget-content ui-widget'>$query_row->NAME</td>
			  
			  <td  valign='top' class= 'prereq all ui-widget-content ui-widget '><pre valign='top' class='ui-widget'>" . strip_tags($query_row->PREREQUISITE) . "</pre></td>			   
			  
			   <td  valign='top' class= 'scenario all ui-widget-content ui-widget'><pre valign='top'  class='ui-widget'>" . strip_tags($query_row->SCENARIO) ."</pre></td>			   
			   
			   <td  valign='top' class= 'verification all ui-widget-content ui-widget'><pre valign='top'  class='ui-widget'>" . strip_tags($query_row->VERIFICATION) . "</pre></td>		
			   
			</tr>";       

	   } 
		
	$table .= "</table>";
	
	echo $table;	
	
?>