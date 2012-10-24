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

if ( $_GET['projList'] === "true" ){

	if( $jenkins->isAvailable() ){
		
		 echo json_encode($jenkins->getAllJobs());

	}

}


if( $_GET['buildJob'] === "true" ){

$jobName = rawurldecode($_GET['jobName']);

 if( $jenkins->isAvailable() ){

	if( isset($jobName) && $jobName != "" ){

	

		if( $jenkins->launchJob($jobName) === TRUE ){

			echo json_encode(array("success"=>"true"));

		}else{

		
			echo json_encode(array("success"=>"false"));
		}
		

	}else{

		echo "Parameter not set: JobName"; 

	}
	

 }

}
	







































?>
