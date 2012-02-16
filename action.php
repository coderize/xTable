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


	if ( $_GET['tableEdit'] == 'true' ) {

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


	///////////////////////////////////////////////////// POP FUNCTIONS  /////////////////////////////////////////////////////
	
	if( $_GET['popFuncs'] == 'true' ){

$rel = mysql_real_escape_string($_GET['rel']);

$qfunctions = mysql_query("SELECT DISTINCT manual_function_name FROM table_manual WHERE manual_relation_id = {$rel}");

echo  '<option value="na">Select a function</option>';

while($fns = mysql_fetch_object($qfunctions)){


	echo "<option value='{$fns->manual_function_name}'>{$fns->manual_function_name}</option>";
	
	
	}
	
	echo '<option id="other" value="other450311">Other</option>';
	
}
	
	
	
	
	
	///////////////////////////////////////////////////// POP FUNCTIONS  /////////////////////////////////////////////////////
	
	
	
	///////////////////////////////////////////////////// START MODIFY USER /////////////////////////////////////////////////////
	
	if ( $_GET['userEdit'] == 'true' ) {

			$uid = mysql_real_escape_string( $_GET['uid'] );
			$firstname = mysql_real_escape_string($_GET['firstname']);
			$lastname = mysql_real_escape_string($_GET['lastname']);
			$email = mysql_real_escape_string($_GET['email']);
			$password = mysql_real_escape_string(md5($_GET['password']));
			$group = mysql_real_escape_string($_GET['group']);
			$userloc = mysql_real_escape_string($_GET['userloc']);
			$status = mysql_real_escape_string($_GET['status']);
			$modtime = time();
			$modby = $_SESSION['user_id'];

			$q = mysql_query("UPDATE table_user SET user_firstname = '{$firstname}', user_lastname = '{$lastname}', user_email = '{$email}', user_password = '{$password}', user_group_id = (SELECT ugroup_id FROM table_ugroup WHERE ugroup_name = '{$group}'), user_location_id = (SELECT location_id FROM table_location WHERE location_name = '{$userloc}'), user_status_id = (SELECT ustatus_id FROM table_ustatus WHERE ustatus_name = '{$status}'), user_mod_dt = '{$modtime}', user_mod_by = '{$modby}' WHERE user_id = '{$uid}' ") or die(mysql_error());
	
			
			if ($q){

				echo "200";

			}else{
			
				echo "404";
				
			} 

		}
	
	///////////////////////////////////////////////////// END MODIFY USER /////////////////////////////////////////////////////	
		
		
		
		
	///////////////////////////////////////////////////// START INSERT NEW USER /////////////////////////////////////////////////////
	
	if( $_GET['cUser']=='true' ){

			$firstname = @mysql_real_escape_string($_GET['firstname']);
			$lastname = @mysql_real_escape_string($_GET['lastname']);
			$email = @mysql_real_escape_string($_GET['email']);
			$password = @mysql_real_escape_string(md5($_GET['password']));
			$settings = @mysql_real_escape_string($_GET['settings']);
			$group = @mysql_real_escape_string($_GET['group']);
			$location = @mysql_real_escape_string($_GET['location']);
			$status = @mysql_real_escape_string($_GET['status']);	
			$createtime = time();
			$modtime = time();
			$modby = $_SESSION['user_id'];			

			$q = mysql_query("INSERT INTO table_user (user_firstname, user_lastname, user_email, user_password, user_settings_id, user_group_id, user_location_id, user_status_id, user_create_dt, user_mod_dt, user_mod_by)
			VALUES ('{$firstname}', '{$lastname}', '{$email}', '{$password}', '{$settings}', '{$group}', '{$location}', '{$status}', '{$createtime}', '{$modtime}', '{$modby}')") or die('this is whats wrong-> ' . mysql_error());

			if($q){
				
				$mysqlid = mysql_insert_id();
				$array = array("code"=>200, "mysql_last_id"=>$mysqlid);
				
				echo json_encode($array);
				
				}else{
				
					echo "404";
					
				}		
		
	}

	///////////////////////////////////////////////////// END INSERT NEW USER /////////////////////////////////////////////////////	


	///////////////////////////////////////////////////// START MODIFY DEVICE /////////////////////////////////////////////////////
	
	if ( $_GET['deviceEdit'] == 'true' ) {

			$did = mysql_real_escape_string( $_GET['did'] );
			$type = mysql_real_escape_string($_GET['type']);
			$group = mysql_real_escape_string($_GET['group']);
			$name = mysql_real_escape_string($_GET['name']);
			$version = mysql_real_escape_string($_GET['version']);
			$mac = mysql_real_escape_string($_GET['mac']);
			$udid = mysql_real_escape_string($_GET['udid']);			
			$serial = mysql_real_escape_string($_GET['serial']);			
			$deviceloc = mysql_real_escape_string($_GET['deviceloc']);

			$q = mysql_query("UPDATE table_device SET device_type_id = (SELECT devtype_id FROM table_devtype WHERE devtype_name ='{$type}'), device_group_id = (SELECT devgroup_id FROM table_devgroup WHERE devgroup_name ='{$group}'), device_name = '{$name}', device_version = '{$version}', device_mac = '{$mac}', device_udid = '{$udid}', device_serial = '{$serial}', device_location_id = (SELECT location_id FROM table_location WHERE location_name = '{$deviceloc}') WHERE device_id = '{$did}' ") or die(mysql_error());
				
			if ($q){

				echo "200";

			}else{
			
				echo "404";
				
			} 

		}
	
	///////////////////////////////////////////////////// END MODIFY DEVICE /////////////////////////////////////////////////////	

	
	///////////////////////////////////////////////////// START INSERT NEW DEVICE /////////////////////////////////////////////////////
	
	if( $_GET['cDevice']=='true' ){

			$type = @mysql_real_escape_string($_GET['type']);
			$group = @mysql_real_escape_string($_GET['group']);
			$name = @mysql_real_escape_string($_GET['name']);
			$version = @mysql_real_escape_string($_GET['version']);
			$mac = @mysql_real_escape_string($_GET['mac']);
			$udid = @mysql_real_escape_string($_GET['udid']);
			$serial = @mysql_real_escape_string($_GET['serial']);
			$deviceloc = @mysql_real_escape_string($_GET['deviceloc']);
			
			$q = mysql_query("INSERT INTO table_device (device_type_id, device_group_id, device_name, device_version, device_mac, device_udid, device_serial, device_location_id)	VALUES ('{$type}', '{$group}', '{$name}', '{$version}', '{$mac}', '{$udid}', '{$serial}', '{$deviceloc}')") or die('this is whats wrong-> ' . mysql_error());

			if($q){
				
				$mysqlid = mysql_insert_id();
				$array = array("code"=>200, "mysql_last_id"=>$mysqlid);
				
				echo json_encode($array);
				
				}else{
				
					echo "404";
					
				}		
		
	}

	///////////////////////////////////////////////////// END INSERT NEW DEVICE /////////////////////////////////////////////////////
	
}else{

		echo "INVALID_SESSION";  
		session_destroy();	
		setcookie("PHPSESSID", "", time()-3600, "/", "10.10.40.16", 0,TRUE);
		exit;


}

?>