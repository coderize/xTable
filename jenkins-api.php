<?php
ob_start();
error_reporting(E_ALL ^ E_NOTICE);
require "includes/config.php"; 
require "includes/sess.php";
session_start();

 if( $_SESSION['loggedIn'] !== TRUE  ){
	
	header('HTTP/1.0 401 Unauthorized');
	exit;
} 

require_once("vendor/jenkins-php-api/Jenkins/__init__.php");
require_once("vendor/jenkins-php-api/Jenkins.php");

$jenkins = new Jenkins("http://10.0.90.82:8080");

if ( $_GET['jenkinsProjList'] === "true" ){

	if( $jenkins->isAvailable() ){
		
		 echo json_encode($jenkins->getAllJobs());

	}

}


if( $_POST['buildJob'] === "true" ){

$jobName = rawurldecode($_POST['jobName']);

 if( $jenkins->isAvailable() ){

	if( isset($jobName) && $jobName != "" ){	

		 $jenkins->launchJob($jobName);		

	}else{

		echo "Parameter not set: JobName"; 

	}
	

 }

}


if ( $_GET['projList'] === "true" ){

	$rel = mysql_real_escape_string((integer)$_GET['rel']);

	if( isset($rel) && $rel != "" && $rel != 0 ) {
		
		$rel_project_list = mysql_query("select relation_id AS rel, auto_name AS name From table_automation WHERE relation_id = '{$rel}'") or die("Can't get DB builds"); 

		if( $rel_project_list ){
			
			while ($projects = mysql_fetch_object($rel_project_list)){
				
				echo "<div id='auto-container'>";
				
				echo "<div class='related-builds'>{$projects->name}<button class='related-builds-btn' onclick='xTable.launchJob(this.value)' id='' value='{$projects->name}'>Execute</button></div>";
				
				echo "<div class='related-builds-real-time'><span class='realtime-results'>Real Time Results</span></div>";
				
				echo "</div>";	

			}

		}

	}else{ echo "Rel was not provided"; }

	
}







































?>
