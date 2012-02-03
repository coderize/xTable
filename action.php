<?php
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/New_York');
require "includes/config.php"; 
require "includes/sess.php";
session_start();

 
$crypto = @mysql_real_escape_string($_GET['crypto']);
$crypto = substr($crypto, 0, -22);


	 if( $crypto == session_id()  && $_SESSION['user_id']){


	if( $_GET['cTestcase']=='true' ){

		$tcid = @mysql_real_escape_string($_GET['tcid']);
		$rel = @mysql_real_escape_string($_GET['rel']);
		$funciton = @mysql_real_escape_string($_GET['function']);
		$name = @mysql_real_escape_string($_GET['name']);
		$priority = @mysql_real_escape_string($_GET['priority']);
		$class = @mysql_real_escape_string($_GET['class']);
		$prereq = @mysql_real_escape_string($_GET['prereq']);
		$scenario = @mysql_real_escape_string($_GET['scenario']);
		$expected = @mysql_real_escape_string($_GET['expected']);
		$stime = @mysql_real_escape_string($_GET['stime']);
		$etime = @mysql_real_escape_string($_GET['etime']);
		$status = @mysql_real_escape_string($_GET['status']);
		$author = @mysql_real_escape_string($_SESSION['user_id']);
		$prereq = strip_tags($prereq, '<i><b>');
		$scenario = strip_tags($scenario, '<i><b>');
		$expected = strip_tags($expected, '<i><b>');
		$pc = @mysql_real_escape_string($_GET['pc']);
		$ptd = @mysql_real_escape_string($_GET['ptd']);
		


	$q = mysql_query("INSERT INTO table_manual (manual_tcid, manual_relation_id, manual_function_name, manual_name, manual_priority_id, manual_class_id, manual_prereq, manual_steps, manual_expected, manual_start, manual_end, manual_pauseduration, manual_pausecount, manual_status, manual_author_id)
	VALUES ('{$tcid}', '{$rel}', '{$funciton}', '{$name}', '{$priority}', '{$class}', '{$prereq}', '{$scenario}', '{$expected}', '{$stime}', '{$etime}', '{$ptd}', '{$pc}', '{$status}', '{$author}')") or die('this is whats wrong-> ' . mysql_error());


		if($q){
		
		$mysqlid = mysql_insert_id();
		$array = array("code"=>200, "mysql_last_id"=>$mysqlid);
		
		echo json_encode($array);
		
		}else{
			echo "404";
		}
		
		
		
	}

	if($_GET['newtcid'] ){

		$funcname = $_GET['funcname'];
		$rel =  mysql_real_escape_string($_GET['rel']);

		$q = mysql_query("SELECT MAX(manual_tcid) +.01 AS 'NEW_TCID'
												FROM table_manual
												WHERE manual_relation_id = {$rel}
												AND manual_function_name  = '{$funcname}'");
												

		$newTCID = mysql_fetch_object($q);
		echo $newTCID->NEW_TCID;
											
											
	}



	if($_GET['othertcid'] == "true" ){

		$rel = mysql_real_escape_string($_GET['rel']);
		$q = mysql_query("SELECT FLOOR(MAX(manual_tcid)) + 1.01 AS 'OTH_TCID'
													FROM table_manual
													WHERE manual_relation_id = {$rel}") or die("Error: Other TCID SQL". mysql_error());
													
		$newTCID = @mysql_fetch_object($q);
		$newTCID->OTH_TCID;
		
		if($newTCID->OTH_TCID){
		
			
			echo  $newTCID->OTH_TCID;

										
											
		}else{
		
		echo "1.01";	
		
		}

	}

	if ($_GET['execute'] ){


		$testcases = mysql_real_escape_string($_GET['testcasearray']);
		$author = $_SESSION['user_id'];
		$devices = mysql_real_escape_string($_GET['devicearray']);
		$now = time();
		$nat = explode(",", $testcases);
		$nad = explode(",", $devices);
		$lir = array();

			for( $i =0; $i<count($nat); $i++){
		

				for($j = 0; $j<count($nad); $j++){

					
					$q =  mysql_query("INSERT INTO table_manual_exec (exec_manual_id, exec_creator_id, exec_device_id, exec_create_date)
														VALUES ('{$nat[$i]}', '{$author}', '{$nad[$j]}', '{$now}') ") ;
					if($q){

						array_push($lir, mysql_insert_id());
					
					}else{
						echo "INSERT ERROR";
					}
														
				

				}
				

			}
			


		echo $lir = implode(",",$lir);


	}



	if( $_GET['insertExec'] ){

		$exec_id = mysql_real_escape_string($_GET['exec_id']);
		$exec_user_id = mysql_real_escape_string($_SESSION['user_id']);
		$exec_start = mysql_real_escape_string($_GET['exec_start']);
		$exec_end = time();
		$exec_result = mysql_real_escape_string($_GET['exec_result']);
		$exec_device_version = mysql_real_escape_string($_GET['exec_device_version']);

		$insertExec = @mysql_query("UPDATE table_manual_exec SET exec_user_id = '{$exec_user_id}', exec_start = '{$exec_start}', exec_end = '{$exec_end}', exec_result = '{$exec_result }', exec_device_version = '{$exec_device_version}' WHERE exec_id = '{$exec_id}' ");

		if( $insertExec ){
			
			echo time();

		}else{
			
			echo "SQL ERROR";
		}

																	


	}


	if ( $_GET['tableEdit'] == 'true' ){	
	
		$mid = mysql_real_escape_string( $_GET['mid'] );
		$func = mysql_real_escape_string($_GET['func']);
		$status = mysql_real_escape_string($_GET['status']);
		$tcid = mysql_real_escape_string($_GET['tcid']);
		$priority = mysql_real_escape_string($_GET['priority']);
		$clas = mysql_real_escape_string($_GET['clas']);
		$name = mysql_real_escape_string($_GET['name']);
		$prereq = mysql_real_escape_string($_GET['prereq']);
		$steps = mysql_real_escape_string($_GET['steps']);
		$expected =mysql_real_escape_string($_GET['expected']);
		$prereq = strip_tags($prereq, '<i><b>');
		$steps = strip_tags($steps, '<i><b>');
		$expected = strip_tags($expected, '<i><b>');

		//TODO: STATUS QUERY CHANGE LIKE CLASS ID AND PRIORITY

		$q = mysql_query("UPDATE table_manual SET manual_function_name = '{$func}', manual_tcid = '{$tcid}', manual_priority_id = (SELECT priority_id FROM table_priority WHERE priority_name = '{$priority}'), manual_class_id = (SELECT class_id FROM table_class WHERE class_name = '{$clas}'), manual_name = '{$name}', manual_prereq = '{$prereq}', manual_steps = '{$steps}', manual_expected = '{$expected}' , manual_status = (SELECT status_id FROM table_status WHERE status_name = '{$status}') WHERE manual_id = '{$mid}' ") or die(mysql_error());
		


		if ($q){

			echo "200";

		}else{
			echo "404";
		} 


	}


	if( $_GET['popFuncs'] == 'true' ){

	$rel = mysql_real_escape_string($_GET['rel']);

	$qfunctions = mysql_query("SELECT DISTINCT manual_function_name FROM table_manual WHERE manual_relation_id = {$rel}");
		
					echo  '<option value="na">Select a function</option>';
					
						while($fns = mysql_fetch_object($qfunctions)){
				

							echo "<option value='{$fns->manual_function_name}'>{$fns->manual_function_name}</option>";
		
						} 
					echo '<option id="other" value="other450311">Other</option>';
						
	}


}else{

		echo "INVALID_SESSION";  
		session_destroy();	
		setcookie("PHPSESSID", "", time()-3600, "/", "10.10.40.16", 0,TRUE);
		exit;



}





?>