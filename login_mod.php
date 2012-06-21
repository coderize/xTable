<?php
error_reporting(E_ALL ^ E_NOTICE);
require "includes/config.php";
require "includes/sess.php";
session_start();

$kill = @mysql_real_escape_string($_POST['kill']);


if( $kill ){
	
	if( session_destroy() ){
		echo "true";
		exit;
	}else{
		echo "false";
		exit;
	}
} 

$email = @mysql_real_escape_string($_POST['username']);
$password = @mysql_real_escape_string($_POST['password']);


if($email && $password){
	
	if(filter_var($email, FILTER_VALIDATE_EMAIL)){
		
		$q = mysql_query("SELECT * FROM table_user WHERE table_user.user_email = '" . $email . "' limit 1");
	
		if (mysql_num_rows($q) > 0){	
		
			while ($user = mysql_fetch_object($q)){

				if($user->user_status_id == '1' ){
			
				if($email == $user->user_email && MD5($password) == $user->user_password){
						
					session_start();
					//initialize user info
					$_SESSION['fname'] = $user->user_firstname;
					$_SESSION['lname'] = $user->user_lastname;
					$_SESSION['user_id'] = $user->user_id;
					$_SESSION['role'] = $user->user_group_id;
					$_SESSION['loc'] = $user->user_location_id;
					$_SESSION['email'] = $user->user_email;
					$_SESSION['loggedIn'] = TRUE;
					

					//check for un_ in $password
					if (substr($password,0,3) == "un_"){
							
							echo "Password Change Required!";
							exit;
						}	
							
										
					echo "Login Successful.";
					
				
				
				}else{
				
					echo "Login/Password combination is incorrect!";
				
				}
				
			}else{ echo "Your account is currently disabled.";}
		}//end while
		
		}else{
		
		echo "Login/Password combination is incorrect!";		
		}
		
	}else{
		
		echo "Please enter a valid E-mail!";
		
	 }
}else{

	echo "Please provide valid username and password";
}


?>
