<?php
ob_start();
date_default_timezone_set('America/New_York');

//////Variables////////

$now = time();
$db = mysql_connect("localhost", "root", "eM45uGCc");
$sdb = mysql_select_db("test");

//////NYC Creation////////

$a = "SELECT vertical_name AS 'VERTICAL'
			, client_name AS 'CLIENT'
			, project_name AS 'PROJECT'
			, manual_function_name AS 'FUNCTION'
			, manual_tcid AS 'TCID'
			, manual_name AS 'TEST_NAME'
			, user_email AS 'CREATED_BY'
			, manual_end - manual_start AS 'TOTAL_DURATION'
			, manual_pauseduration AS 'PAUSE_DURATION'
			, (manual_end - manual_start) - manual_pauseduration AS 'ACTUAL_DURATION'
			, manual_pausecount AS 'TIMES_PAUSED'
			
		FROM table_vertical, table_client, table_project, table_manual, table_relation, table_priority, table_class, table_user

		WHERE vertical_id = r_vertical
			AND client_id = r_client
			AND project_id = r_project
			AND relation_id = manual_relation_id
			AND priority_id = manual_priority_id
			AND class_id = manual_class_id
			AND manual_author_id = user_id
			AND user_location_id = 1
			AND manual_end BETWEEN ($now - 43200) AND $now

		GROUP BY vertical_name, client_name, project_name, manual_function_name, manual_tcid

		ORDER BY vertical_name, client_name, project_name, manual_function_name, manual_tcid";

		
//////NYC Execution////////		
		
$b = "SELECT vertical_name AS 'VERTICAL'
			, client_name AS 'CLIENT'
			, project_name AS 'PROJECT'
			, manual_function_name AS 'FUNCTION'
			, manual_tcid AS 'TCID'
			, manual_name AS 'TEST_NAME'
			, device_name AS 'DEVICE' 
			, user_email AS 'TESTED_BY'
			, exec_end - exec_start AS 'DURATION'
			, DATE(FROM_UNIXTIME(exec_end)) AS 'EXEC_DATE'
			, TIME(FROM_UNIXTIME(exec_end)) AS 'EXEC_TIME'
			, CASE exec_result WHEN 0 THEN 'Pass' WHEN 1 THEN 'Fail' WHEN 2 THEN 'Skip' END AS 'RESULT'
			
		FROM table_vertical, table_client, table_project, table_manual, table_relation, table_manual_exec, table_priority, table_class, table_user, table_device

		WHERE vertical_id = r_vertical
			AND client_id = r_client
			AND project_id = r_project
			AND relation_id = manual_relation_id
			AND priority_id = manual_priority_id
			AND class_id = manual_class_id
			AND user_location_id = 1
			AND exec_manual_id = manual_id
			AND user_id = exec_user_id
			AND device_id = exec_device_id
			AND exec_end BETWEEN ($now - 43200) AND $now

		ORDER BY exec_end, vertical_name, client_name, project_name, manual_function_name, manual_tcid";
		
		
//////UK Creation////////		

$c = "SELECT vertical_name AS 'VERTICAL'
			, client_name AS 'CLIENT'
			, project_name AS 'PROJECT'
			, manual_function_name AS 'FUNCTION'
			, manual_tcid AS 'TCID'
			, manual_name AS 'TEST_NAME'
			, user_email AS 'CREATED_BY'
			, manual_end - manual_start AS 'TOTAL_DURATION'
			, manual_pauseduration AS 'PAUSE_DURATION'
			, (manual_end - manual_start) - manual_pauseduration AS 'ACTUAL_DURATION'
			, manual_pausecount AS 'TIMES_PAUSED'
				
		FROM table_vertical, table_client, table_project, table_manual, table_relation, table_priority, table_class, table_user

		WHERE vertical_id = r_vertical
			AND client_id = r_client
			AND project_id = r_project
			AND relation_id = manual_relation_id
			AND priority_id = manual_priority_id
			AND class_id = manual_class_id
			AND manual_author_id = user_id
			AND user_location_id = 2
			AND manual_end BETWEEN ($now - 43200) AND $now

		GROUP BY vertical_name, client_name, project_name, manual_function_name, manual_tcid

		ORDER BY vertical_name, client_name, project_name, manual_function_name, manual_tcid";
		
		
//////UK Execution////////			

$d = "SELECT vertical_name AS 'VERTICAL'
			, client_name AS 'CLIENT'
			, project_name AS 'PROJECT'
			, manual_function_name AS 'FUNCTION'
			, manual_tcid AS 'TCID'
			, manual_name AS 'TEST_NAME'
			, device_name AS 'DEVICE' 
			, user_email AS 'TESTED_BY'
			, exec_end - exec_start AS 'DURATION'
			, DATE(FROM_UNIXTIME(exec_end)) AS 'EXEC_DATE'
			, TIME(FROM_UNIXTIME(exec_end)) AS 'EXEC_TIME'
			, CASE exec_result WHEN 0 THEN 'Pass' WHEN 1 THEN 'Fail' WHEN 2 THEN 'Skip' END AS 'RESULT'
	
		FROM table_vertical, table_client, table_project, table_manual, table_relation, table_manual_exec, table_priority, table_class, table_user, table_device

		WHERE vertical_id = r_vertical
			AND client_id = r_client
			AND project_id = r_project
			AND relation_id = manual_relation_id
			AND priority_id = manual_priority_id
			AND class_id = manual_class_id
			AND user_location_id = 2
			AND exec_manual_id = manual_id
			AND user_id = exec_user_id
			AND device_id = exec_device_id
			AND exec_end BETWEEN ($now - 43200) AND $now

		ORDER BY exec_end, vertical_name, client_name, project_name, manual_function_name, manual_tcid";


	
//////SE Execution////////		
		
$e = "SELECT vertical_name AS 'VERTICAL'
			, client_name AS 'CLIENT'
			, project_name AS 'PROJECT'
			, manual_function_name AS 'FUNCTION'
			, manual_tcid AS 'TCID'
			, manual_name AS 'TEST_NAME'
			, device_name AS 'DEVICE' 
			, user_email AS 'TESTED_BY'
			, exec_end - exec_start AS 'DURATION'
			, DATE(FROM_UNIXTIME(exec_end)) AS 'EXEC_DATE'
			, TIME(FROM_UNIXTIME(exec_end)) AS 'EXEC_TIME'
			, CASE exec_result WHEN 0 THEN 'Pass' WHEN 1 THEN 'Fail' WHEN 2 THEN 'Skip' END AS 'RESULT'
			
		FROM table_vertical, table_client, table_project, table_manual, table_relation, table_manual_exec, table_priority, table_class, table_user, table_device

		WHERE vertical_id = r_vertical
			AND client_id = r_client
			AND project_id = r_project
			AND relation_id = manual_relation_id
			AND priority_id = manual_priority_id
			AND class_id = manual_class_id
			AND user_location_id = 3
			AND exec_manual_id = manual_id
			AND user_id = exec_user_id
			AND device_id = exec_device_id
			AND exec_end BETWEEN ($now - 43200) AND $now

		ORDER BY exec_end, vertical_name, client_name, project_name, manual_function_name, manual_tcid";
		

//////Italy Creation////////

$f = "SELECT vertical_name AS 'VERTICAL'
			, client_name AS 'CLIENT'
			, project_name AS 'PROJECT'
			, manual_function_name AS 'FUNCTION'
			, manual_tcid AS 'TCID'
			, manual_name AS 'TEST_NAME'
			, user_email AS 'CREATED_BY'
			, manual_end - manual_start AS 'TOTAL_DURATION'
			, manual_pauseduration AS 'PAUSE_DURATION'
			, (manual_end - manual_start) - manual_pauseduration AS 'ACTUAL_DURATION'
			, manual_pausecount AS 'TIMES_PAUSED'
			
		FROM table_vertical, table_client, table_project, table_manual, table_relation, table_priority, table_class, table_user

		WHERE vertical_id = r_vertical
			AND client_id = r_client
			AND project_id = r_project
			AND relation_id = manual_relation_id
			AND priority_id = manual_priority_id
			AND class_id = manual_class_id
			AND manual_author_id = user_id
			AND user_location_id = 4
			AND manual_end BETWEEN ($now - 43200) AND $now

		GROUP BY vertical_name, client_name, project_name, manual_function_name, manual_tcid

		ORDER BY vertical_name, client_name, project_name, manual_function_name, manual_tcid";

		
//////Italy Execution////////		
		
$g = "SELECT vertical_name AS 'VERTICAL'
			, client_name AS 'CLIENT'
			, project_name AS 'PROJECT'
			, manual_function_name AS 'FUNCTION'
			, manual_tcid AS 'TCID'
			, manual_name AS 'TEST_NAME'
			, device_name AS 'DEVICE' 
			, user_email AS 'TESTED_BY'
			, exec_end - exec_start AS 'DURATION'
			, DATE(FROM_UNIXTIME(exec_end)) AS 'EXEC_DATE'
			, TIME(FROM_UNIXTIME(exec_end)) AS 'EXEC_TIME'
			, CASE exec_result WHEN 0 THEN 'Pass' WHEN 1 THEN 'Fail' WHEN 2 THEN 'Skip' END AS 'RESULT'
			
		FROM table_vertical, table_client, table_project, table_manual, table_relation, table_manual_exec, table_priority, table_class, table_user, table_device

		WHERE vertical_id = r_vertical
			AND client_id = r_client
			AND project_id = r_project
			AND relation_id = manual_relation_id
			AND priority_id = manual_priority_id
			AND class_id = manual_class_id
			AND user_location_id = 4
			AND exec_manual_id = manual_id
			AND user_id = exec_user_id
			AND device_id = exec_device_id
			AND exec_end BETWEEN ($now - 43200) AND $now

		ORDER BY exec_end, vertical_name, client_name, project_name, manual_function_name, manual_tcid";
		
		
function csvCreate($query, $qchose, $name){

$fTime =  date("M d o");
$fTime = explode(" ", $fTime);
$fTime = implode("_", $fTime);

$nyct = mysql_query("$query") or die("Error" . mysql_error());

			
			$nycsv = fopen("/var/www/html/xtable/csv/" . $name ."_" . $fTime . ".csv", "a+");


			if($qchose=='true'){
			
					$fna = array(mysql_field_name($nyct, 0),mysql_field_name($nyct, 1),mysql_field_name($nyct, 2),mysql_field_name($nyct, 3),mysql_field_name($nyct, 4),mysql_field_name($nyct, 5),mysql_field_name($nyct, 6),mysql_field_name($nyct, 7),mysql_field_name($nyct, 8),mysql_field_name($nyct, 9),mysql_field_name($nyct, 10));
					
			}else{
			
					$fna = array(mysql_field_name($nyct, 0),mysql_field_name($nyct, 1),mysql_field_name($nyct, 2),mysql_field_name($nyct, 3),mysql_field_name($nyct, 4),mysql_field_name($nyct, 5),mysql_field_name($nyct, 6),mysql_field_name($nyct, 7),mysql_field_name($nyct, 8),mysql_field_name($nyct, 9),mysql_field_name($nyct, 10),mysql_field_name($nyct, 11),mysql_field_name($nyct, 12));
			
			}			
			
				fputcsv($nycsv,$fna);		
				
	while($nyrows = mysql_fetch_array($nyct, MYSQL_NUM)){
		
				fputcsv($nycsv, $nyrows);

}

	fclose($nycsv);
	
}

$ctime = date("gA");

/////////////////////EMAILER/////////////////////

if ($ctime == '5PM'){
	
	//$distribution_list = array("joel.lassiter@test.com");	
	$distribution_list  = array();
	$q = mysql_query("SELECT user_email  FROM  table_user WHERE user_status_id =1 AND user_location_id = 1 AND user_group_id < 3 AND user_rights_id = 1");	
	while ($dis = mysql_fetch_array($q)){
		
		array_push($distribution_list, $dis[0]);
 }

	csvCreate($a, $qchose='true', $name='ny_creation');
	csvCreate($b, $qchose='false', $name='ny_execution');
	
	require_once '/var/www/html/xtable/phpmailer/class.phpmailer.php';
	
	$mail = new PHPMailer(true); 
	$abbr = substr($name, 0, 2);
	$abbr = strtoupper($abbr);
	
	try {
					  $mail->AddReplyTo("test@test.com", "test");
					  
					  for($x=0;$x<count($distribution_list);$x++){
					  
							$mail->AddAddress("{$distribution_list[$x]}", "test Inc");
					  
					  }
					  
					  $mail->SetFrom("test@test.com", "test");
					  $mail->Subject = "test - $abbr Daily Report";
					  $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional - MsgHTML will create an alternate automatically
					  
					  $mail->MsgHTML("<html><head></head>
					  <body>						 
						Please see the attached file(s) for the $abbr daily report.
					<br />
						Please do not reply to this email.
					<br />
					<br />
					<br />					
					
					  Enjoy, 
					  <br />
					  <br />
					  test Team
					  </body>
					  </html>
					  ");
					  
					  $base = "/var/www/html/xtable/csv/";
					  $csvdir = scandir($base);

					  foreach ($csvdir as $csv){
					  
						if ($csv == '.' || $csv == '..') continue;
						
						$mail->AddAttachment("$base$csv");   
						
					 }
					 
					 $mail->Send();
					  echo "Message Sent OK</p>\n";
					} catch (phpmailerException $e) {
					  echo $e->errorMessage(); //Pretty error messages from PHPMailer
					} catch (Exception $e) {
					  echo $e->getMessage(); //Boring error messages from anything else!
					}

					$base = "/var/www/html/xtable/csv/";
					 $csvdir = scandir($base);

					  foreach ($csvdir as $csv){
					  
						if ($csv == '.' || $csv == '..') continue;
						
						@unlink("$base$csv");   
						
					 }
}

if ($ctime == '11AM'){
	
	//$distribution_list = array("joel.lassiter@test.com");
	$distribution_list = array();
 	$q = mysql_query("SELECT user_email FROM  table_user WHERE  user_status_id = 1 AND user_group_id < 4 AND user_rights_id = 1");	
	//$distribution_list = mysql_fetch_array($q, MYSQL_NUM);
	while ($dis = mysql_fetch_array($q)){
		
			array_push($distribution_list, $dis[0]);
 }
 
	csvCreate($e, $qchose='false', $name='se_execution');
	
	require_once '/var/www/html/xtable/phpmailer/class.phpmailer.php';
	$mail = new PHPMailer(true); 
	$abbr = substr($name, 0, 2);
	$abbr = strtoupper($abbr);
	
	try {
					  $mail->AddReplyTo("test@test.com", "test");
					  
					  for($x=0;$x<count($distribution_list);$x++){
					  
							$mail->AddAddress("{$distribution_list[$x]}", "test Inc");
					  
					  }							  
					  $mail->SetFrom("test@test.com", "test");
					  $mail->Subject = "test - $abbr Daily Report";
					  $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional - MsgHTML will create an alternate automatically
					  
					  $mail->MsgHTML("<html><head></head>
					  <body>						 
						Please see the attached file(s) for the $abbr daily report.
					<br />
						Please do not reply to this email.
					<br />
					<br />
					<br />					
					
					  Enjoy, 
					  <br />
					  <br />
					  test Team
					  </body>
					  </html>
					  ");
					  
					  $base = "/var/www/html/xtable/csv/";
					  $csvdir = scandir($base);

					  foreach ($csvdir as $csv){
					  
						if ($csv == '.' || $csv == '..') continue;
						
						$mail->AddAttachment("$base$csv");   
						
					 }
					 
					 $mail->Send();
					  echo "Message Sent OK</p>\n";
					} catch (phpmailerException $e) {
					  echo $e->errorMessage(); //Pretty error messages from PHPMailer
					} catch (Exception $e) {
					  echo $e->getMessage(); //Boring error messages from anything else!
					}


					$base = "/var/www/html/xtable/csv/";
					 $csvdir = scandir($base);

					  foreach ($csvdir as $csv){
					  
						if ($csv == '.' || $csv == '..') continue;
						
						@unlink("$base$csv");   
						
					 }
	
}

if ($ctime == '1PM'){
	
	//$distribution_list = array("joel.lassiter@test.com");
	$distribution_list = array();
	$q = mysql_query("SELECT user_email FROM  table_user WHERE  user_status_id = 1 AND user_rights_id = 1 AND user_group_id = 2 AND user_location_id = 2 OR user_email = 'joel.lassiter@test.com'");	
	//$distribution_list = mysql_fetch_array($q, MYSQL_NUM);
	while ($dis = mysql_fetch_array($q)){
		
			array_push($distribution_list, $dis[0]);
 }
 
	csvCreate($c, $qchose='true', $name='uk_creation');
	csvCreate($d, $qchose='false', $name='uk_execution');
	
	require_once '/var/www/html/xtable/phpmailer/class.phpmailer.php';
	$mail = new PHPMailer(true); 
	$abbr = substr($name, 0, 2);
	$abbr = strtoupper($abbr);
	
	try {
					  $mail->AddReplyTo("test@test.com", "test");
					  
					  for($x=0;$x<count($distribution_list);$x++){
					  
							$mail->AddAddress("{$distribution_list[$x]}", "test Inc");
					  
					  }							  
					  $mail->SetFrom("test@test.com", "test");
					  $mail->Subject = "test - $abbr Daily Report";
					  $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional - MsgHTML will create an alternate automatically
					  
					  $mail->MsgHTML("<html><head></head>
					  <body>						 
						Please see the attached file(s) for the $abbr daily report.
					<br />
						Please do not reply to this email.
					<br />
					<br />
					<br />					
					
					  Enjoy, 
					  <br />
					  <br />
					  test Team
					  </body>
					  </html>
					  ");
					  
					  $base = "/var/www/html/xtable/csv/";
					  $csvdir = scandir($base);

					  foreach ($csvdir as $csv){
					  
						if ($csv == '.' || $csv == '..') continue;
						
						$mail->AddAttachment("$base$csv");   
						
					 }
					 
					 $mail->Send();
					  echo "Message Sent OK</p>\n";
					} catch (phpmailerException $e) {
					  echo $e->errorMessage(); //Pretty error messages from PHPMailer
					} catch (Exception $e) {
					  echo $e->getMessage(); //Boring error messages from anything else!
					}

					$base = "/var/www/html/xtable/csv/";
					 $csvdir = scandir($base);

					  foreach ($csvdir as $csv){
					  
						if ($csv == '.' || $csv == '..') continue;
						
						@unlink("$base$csv");   
						
					 }	

}


if ($ctime == '12PM'){
	
	//$distribution_list = array("joel.lassiter@test.com");
	$distribution_list = array();
	$q = mysql_query("SELECT user_email FROM  table_user WHERE  user_status_id = 1 AND user_rights_id = 1 AND user_group_id < 3 AND user_location_id = 4 OR user_email = 'joel.lassiter@test.com'");	
	//$distribution_list = mysql_fetch_array($q, MYSQL_NUM);
	while ($dis = mysql_fetch_array($q)){
		
			array_push($distribution_list, $dis[0]);
 }
 
	csvCreate($f, $qchose='true', $name='it_creation');
	csvCreate($g, $qchose='false', $name='it_execution');
	
	require_once '/var/www/html/xtable/phpmailer/class.phpmailer.php';
	$mail = new PHPMailer(true); 
	$abbr = substr($name, 0, 2);
	$abbr = strtoupper($abbr);
	
	try {
					  $mail->AddReplyTo("test@test.com", "test");
					  
					  for($x=0;$x<count($distribution_list);$x++){
					  
							$mail->AddAddress("{$distribution_list[$x]}", "test Inc");
					  
					  }							  
					  $mail->SetFrom("test@test.com", "test");
					  $mail->Subject = "test - $abbr Daily Report";
					  $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional - MsgHTML will create an alternate automatically
					  
					  $mail->MsgHTML("<html><head></head>
					  <body>						 
						Please see the attached file(s) for the $abbr daily report.
					<br />
						Please do not reply to this email.
					<br />
					<br />
					<br />					
					
					  Enjoy, 
					  <br />
					  <br />
					  test Team
					  </body>
					  </html>
					  ");
					  
					  $base = "/var/www/html/xtable/csv/";
					  $csvdir = scandir($base);

					  foreach ($csvdir as $csv){
					  
						if ($csv == '.' || $csv == '..') continue;
						
						$mail->AddAttachment("$base$csv");   
						
					 }
					 
					 $mail->Send();
					  echo "Message Sent OK</p>\n";
					} catch (phpmailerException $e) {
					  echo $e->errorMessage(); //Pretty error messages from PHPMailer
					} catch (Exception $e) {
					  echo $e->getMessage(); //Boring error messages from anything else!
					}

					$base = "/var/www/html/xtable/csv/";
					 $csvdir = scandir($base);

					  foreach ($csvdir as $csv){
					  
						if ($csv == '.' || $csv == '..') continue;
						
						@unlink("$base$csv");   
						
					 }	

}
?>
