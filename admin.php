<?php
header("Content-type: text/html; charset=utf-8");  
error_reporting(E_ALL ^ E_NOTICE);
require "includes/config.php"; 
require "includes/sess.php";
session_start();

 if( !$_SESSION['fname'] || $_SESSION['role']  > 2 ){
	header('Refresh: 0; URL=login.php');
	exit;
} 
?>

<style>

#logout{
	display:block;
	position:absolute;
	top:10px;
	right:15px;
}

</style>

<html>
	<head>
		<title>UsableX</title>
		<link href="css/home-style.css" rel="stylesheet" type="text/css" media="all" /><br/>
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="js/jqueryUI/js/jqueryui.js"></script>
	</head>

	<body>
	<a onClick="window.location.href ='login.php?logout=true'" style="text-decoration:none">
		<button name="logout" id="logout" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
		<span class="ui-button-text">Logout</span></button>
	</a>
	
	<div id="main">

		<div id="icon">
		
		

		</div>

		<div id="icon">
			<a href="user_admin.php" name="navuserAdmin" id="navuserAdmin" >
				<img alt="userAdmin" id="userAdmin" src="img/user_Admin.png" height="130px" width="130px"  title="User Admin"/>
			</a>
		</div>

		<div id="icon">
			<a href="device_admin.php" name="navdeviceAdmin" id="navdeviceAdmin" >
				<img alt="deviceAdmin" id="deviceAdmin" src="img/device_Admin.png" height="130px" width="130px"  title="Device Admin"/>
			</a>
		</div>
		
		
		

		<div id="icon">
		
		

		</div>

		
		
		
	</div>
	</body>

	<script charset="UTF-8">
	
			///////////////////////////////////LOGOUT FUNCTION///////////////////////////////////////////////////////////////////////	
			$("#logout").click(function(){
							
							window.location.reload();
							window.location.href ="login.php?logout=true";
							
								$.ajax({											
								  type: "GET",
								  url: "login_mod.php",
								  cache: false,
								  data: "kill=kill",
								}).done(function( msg ) {
								
									if( is_loggedin(msg) ){		
									
										if (msg == "true"){
										
											window.location.href ="login.php?logout=true";
											
										}else{
										
											alert("Error logging out, try again");																
										}
									}																
										
								});		

			});// END LOGOUT 
	
	</script>
	
</html>