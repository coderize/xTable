<?php
ob_start();
error_reporting(E_ALL & ~E_NOTICE); 
require "includes/config.php"; 
require "includes/sess.php";
session_start();
?>

<html>

	<head>
	
		<style>
		
		#loaderbox{
			background: #fff url("img/loader.gif") no-repeat center center;
			position:absolute;
			top:20%;
			left:40%;
			z-index:1000;
			height:300px;
			width:300px;	
		}		
		
		*{
			margin:0px;
			padding:0px;	
		}
		
		#logo{
			margin:5px;	
		}

		a{
			text-decoration:none;
		
		}
		
		.testBox{
			border: 1px solid black;
			position:relative;
			display:none;
		}		

		.totalEx{
			position:absolute;
			right:640px;
			top:0px;
		}
		
		.totalPass{
			position:absolute;
			top:0px;
			right:500px;
		}
		
		.totalPassPerc{
			position:absolute;
			top:0px;
			right:345px;
		}
		
		.totalFail{
			position:absolute;
			top:0px;
			right:213px;
		}
		
		.totalFailPerc{
			position:absolute;
			top:0px;
			right:67px;
		}
		
		#funcCount{
			right:640px;
			position:absolute;
		}	
		
		#funcPass{
			right:500px;
			position:absolute;
		}	
		
		#funcFail{
			right:215px;
			position:absolute;
		}	
		
		#funcPassPerc{
			right:345px;
			position:absolute;
		}
		
		#funcFailPerc{
			right:70px;
			position:absolute;	
		}
		
		.client{
			position:relative;
			background-color:#999999;
			color:#fff;	
		}
		
		.client a{  color:#fff; }
		
		.funcBox{
			border:1px dotted #bbb;
			/* display:none; */
			background-color:#fff;
			color:#000;		
		}
		
		.project{	
			position:relative;
			/* display:none; */
			background-color:#D9E1E3;
			color:#0000ee;	
		}
		
		.project a{ color: #0000ee; } 
		.funcBox a {	color:#000; }	
		
		.mainContent{
			border: 1px solid #000;
			position:relative;
			width:97%;
			background-color:#777777; 
			color:#ffffff;
			margin: 0 auto;
			padding-bottom:10px;
			font:14px Arial,Helvetica,sans-serif;
			-moz-border-radius-bottomright: 10px;
			border-bottom-right-radius: 10px;
			-moz-border-radius-bottomleft: 10px;
			border-bottom-left-radius: 10px;		
			-moz-border-radius-topright: 10px;
			border-top-right-radius: 10px;
			-moz-border-radius-topleft: 10px;
			border-top-left-radius: 10px;
			font-weight:bold;
		}
		
		.headExec{
			position:absolute;
			right:605px;
			top:0px;	
		}
		
		.headPass{
			position:absolute;
			right:470px;
			top:0px;	
		}	
		.clientCountPass{
			position:absolute;
			right:500px;
			top:0px;	
		}
		
		.headPassPerc{
			position:absolute;
			right:320px;
			top:0px;	
		}
		
		.headFail{
			position:absolute;
			right:190px;
			top:0px;	
		}
		
		.headFailPerc{
			position:absolute;
			right:50px;
			top:0px;
			display:block;	
		}	
		
		.clear{
			clear:both;
			visibility:hidden;	
		}
		
		#projCount{
			right:640px;
			position:absolute;	
		}
		
		.clientCount{
			right:640px;
			position:absolute;	
		}
		
		#projCountPerc{
			right:500px;
			position:absolute;	
		}
		
		#projCountFail{
			right:215px;
			position:absolute;	
		}
		
		.clientFail{
			right:215px;
			position:absolute;	
		}
		
		#projCountPassPerc{
			right:345px;
			position:absolute;	
		}
		
		.clientPassPerc{
			right:345px;
			position:absolute;	
		}
		
		#projCountFailPerc{
			right:70px;
			position:absolute;	
		}
		
		.clientFailPerc{
			right:70px;
			position:absolute;	
		}
		
		.execution{
			padding-left:100px;
		}
		
		.testName{
			padding-left:75px;
		}
			
		.execResultP{
			position:absolute;
			right:500px;	
		}
		
		.execResultF{
			position:absolute;
			right:210px;	
		}
		
		.execResult{
			border-bottom:1px dotted #000;
			position:relative;
			display:none;	
		}
		
		.dateText{
			position:absolute;
			bottom:0px;
			padding-left:100px;	
		}
		
		.testNameLink{
			margin-left:75px;
		}
		
		#noman,#noauto{
			margin-left: 50px;
			color:#f00;
			font-weight:bold;
		}

		#noman{
			margin-bottom:300px;
		}	
		
		</style>
	
	</head>

<body>


<?php

$month = mysql_real_escape_string($_GET['month']);
$vertical = mysql_real_escape_string($_GET['vertical']);
$client =  mysql_real_escape_string($_GET['client']);

if(!$vertical or !$client){
	echo "Missing Vertical or Client";
	exit;
}

$automation  = $_GET['auto'];
if(!$automation){

		
								$cliquery = mysql_query("SELECT client_name AS 'CLIENT'
																, COUNT(IF(exec_result='0',1,Null)) + COUNT(IF(exec_result='1',1,Null)) AS 'TOTAL'
																, COUNT(IF(exec_result='0',1,Null)) AS 'PASSES'
																, COUNT(IF(exec_result='0',1,Null))/(COUNT(IF(exec_result='0',1,Null)) + COUNT(IF(exec_result='1',1,Null)))*100 AS 'PASS_PERC'
																, COUNT(IF(exec_result='1',1,Null)) AS 'FAILS'
																, COUNT(IF(exec_result='1',1,Null))/(COUNT(IF(exec_result='0',1,Null)) + COUNT(IF(exec_result='1',1,Null)))*100 AS 'FAIL_PERC'

																FROM table_manual_exec, table_manual, table_vertical, table_client, table_project, table_relation

																WHERE vertical_id = r_vertical
																AND client_id = r_client
																AND project_id = r_project
																AND vertical_id = '{$vertical}'
																AND client_id = '{$client}'
																AND manual_id = exec_manual_id
																AND relation_id = manual_relation_id
																AND MONTHNAME(FROM_UNIXTIME(exec_end)) = '{$month}' ");
													
										
								$clis = mysql_fetch_object($cliquery);
			
	
			echo "<div class='mainContent'>";
			echo "<div class='clear'>Testing...</div>";
			echo "<div class='headExec'>Total Executed</div>";
			echo "<div class='headPass'>Total Passed</div>";
			echo "<div class='headPassPerc'>Percent Passed</div>";
			echo "<div class='headFail'>Total Failed</div>";
			echo "<div class='headFailPerc'>Percent Failed</div>";
			
			echo  "<div class='client'>";
			
			$clipassperc = number_format($clis->PASS_PERC,2);
			$clifailperc = number_format($clis->FAIL_PERC,2);
			
			

						 echo "<a href='javascript:void(0);' class='clientName'>" . $clis->CLIENT. "</a><span class='clientCount'>{$clis->TOTAL}</span><span class='clientCountPass'>{$clis->PASSES}</span><span class='clientPassPerc'>{$clipassperc}%</span><span class='clientFail'>{$clis->FAILS}</span><span class='clientFailPerc'>{$clifailperc}%</span><br />";
						
	$qres2 = mysql_query("SELECT project_name AS 'PROJECT', project_id AS 'PROJECT_ID'
																						, COUNT(IF(exec_result='0',1,Null)) + COUNT(IF(exec_result='1',1,Null)) AS 'TOTAL'
																						, COUNT(IF(exec_result='0',1,Null)) AS 'PASSES'
																						, COUNT(IF(exec_result='0',1,Null))/(COUNT(IF(exec_result='0',1,Null)) + COUNT(IF(exec_result='1',1,Null)))*100 AS 'PASS_PERC'
																						, COUNT(IF(exec_result='1',1,Null)) AS 'FAILS'
																						, COUNT(IF(exec_result='1',1,Null))/(COUNT(IF(exec_result='0',1,Null)) + COUNT(IF(exec_result='1',1,Null)))*100 AS 'FAIL_PERC'

																						FROM table_manual_exec, table_manual, table_vertical, table_client, table_project, table_relation

																						WHERE vertical_id = r_vertical
																						AND client_id = r_client
																						AND project_id = r_project
																						AND vertical_id = '{$vertical}'
																						AND client_id = '{$client}'
																						AND manual_id = exec_manual_id
																						AND relation_id = manual_relation_id
																						AND MONTHNAME(FROM_UNIXTIME(exec_end)) = '{$month}'

																						GROUP BY project_name
																						");

						
								while($innerproj = mysql_fetch_object($qres2)){	
								
										echo "<div class='project'>";
										$projpassperc = number_format($innerproj->PASS_PERC ,2);
										$projfailperc = number_format($innerproj->FAIL_PERC ,2);
									
										echo "&nbsp &nbsp &nbsp &nbsp<a href='javascript:void(0);' class='projName'> " . $innerproj->PROJECT ." </a> <span id='projCount'>{$innerproj->TOTAL}</span><span id='projCountPerc'>{$innerproj->PASSES}</span><span id='projCountPassPerc'>{$projpassperc}%</span><span id='projCountFail'>{$innerproj->FAILS}</span><span id='projCountFailPerc'>{$projfailperc}%</span><br />";
										
										$qres = mysql_query("SELECT manual_function_name AS 'FUNCTION_NAME'
																			, COUNT(IF(exec_result='0',1,Null)) + COUNT(IF(exec_result='1',1,Null)) AS 'TOTAL'
																			, COUNT(IF(exec_result='0',1,Null)) AS 'PASSES'
																			, COUNT(IF(exec_result='0',1,Null))/(COUNT(IF(exec_result='0',1,Null)) + COUNT(IF(exec_result='1',1,Null)))*100 AS 'PASS_PERC'
																			, COUNT(IF(exec_result='1',1,Null)) AS 'FAILS'
																			, COUNT(IF(exec_result='1',1,Null))/(COUNT(IF(exec_result='0',1,Null)) + COUNT(IF(exec_result='1',1,Null)))*100 AS 'FAIL_PERC'

																			FROM table_manual_exec, table_manual, table_vertical, table_client, table_project, table_relation

																			WHERE vertical_id = r_vertical
																			AND client_id = r_client
																			AND project_id = r_project
																			AND vertical_id = '{$vertical}'
																			AND client_id = '{$client}'
																			AND project_id = '{$innerproj->PROJECT_ID}'
																			AND manual_id = exec_manual_id
																			AND relation_id = manual_relation_id
																			AND MONTHNAME(FROM_UNIXTIME(exec_end)) = '{$month}'

																			GROUP BY manual_function_name");
									
									while($funcs = mysql_fetch_object($qres)){

																	echo "<div class='funcBox'>";
																		
																		$passperc = number_format($funcs->PASS_PERC, 2);
																		$failedperc = number_format($funcs->FAIL_PERC, 2);
																		
																		if($funcs->FUNCTION_NAME == ""){ $genfunc = "99 - UX & UI";  } else{  $genfunc = $funcs->FUNCTION_NAME; } 
																			
																		echo "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp<a href='javascript:(void);' class='funcName' id='funcName'> {$genfunc} </a><span id='funcCount'>{$funcs->TOTAL}</span><span id='funcPass'>{$funcs->PASSES}</span><span id='funcPassPerc'>{$passperc}%</span><span id='funcFail'>{$funcs->FAILS}</span><span id='funcFailPerc'>{$failedperc}%</span><br />";
																	
																	echo "</div><!--end funcBox-->";
									
									} 
									
									echo "</div><!--end project-->";		
									
								}
								
				echo  "</div><!--client -->";
	
				echo "</div><!--end mainContent-->";
			
		}//if not automation
?>



</body>
</html>