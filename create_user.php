<?php

error_reporting(E_ALL & ~E_NOTICE);

	mysql_connect("10.10.40.31","root","testing450311") OR die ('Could Not Connect: ' . mysql_error());	//connect to server

	mysql_select_db('usablex') OR die ('Cannot Use usablex: ' . mysql_error());	//select defects db

		$user_firstname=mysql_real_escape_string($_GET['fname']);
		$user_lastname=mysql_real_escape_string($_GET['lname']);
		$user_email=mysql_real_escape_string($_GET['email']);
		$user_password=mysql_real_escape_string($_GET['pword']);
		$user_group_id=mysql_real_escape_string($_GET['usergrp']);
		$user_location_id=mysql_real_escape_string($_GET['userloc']);
		$user_status=mysql_real_escape_string($_GET['userstatus']);
		$save_btn=mysql_real_escape_string($_GET['save']);
		
		/**if($save_btn)
			{
			
			$validation = mysql_query("SELECT data_url FROM table_data WHERE data_url = '{$url_data}'");
						
			if(mysql_num_rows($validation)<=0)
			
				{
					$load=mysql_query("INSERT INTO table_user (fname, lname, email, pword, usergrp, userloc, userstatus, usercreatedate) VALUES ('$user_firstname', '$user_lastname', '$user_email', '$user_password', '$user_group_id', '$user_location_id', '$user_status', '$user_create_dt')") OR die ('Could not insert : ' . mysql_error());	//select defects db;
					echo "<div id='confirm'> Record was submitted successfully</div>";
										
				}else
					{
						echo "The URL entered already exists.";
						exit;
					}
			}**/		
			

					function createRandomPassword() { 

						$chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
						srand((double)microtime()*1000000); 
						$i = 0; 
						$pass = '' ; 

						while ($i <= 6) { 
							$num = rand() % 33; 
							$tmp = substr($chars, $num, 1); 
							$pass = $pass . $tmp; 
							$i++; 
						} 

						return $pass; 

					} 

					// Usage 
					$password = "un_" . createRandomPassword(); 

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<script src="http://code.jquery.com/jquery-latest.js"></script>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<style type="text/css">

/* General styles */
body { margin: 0; padding: 0; font: 80%/1.5 Arial,Helvetica,sans-serif; color: #111; background-color: #FFF; }
h2 { margin: 0px; padding: 10px; font-family: Georgia, "Times New Roman", Times, serif; font-size: 200%; font-weight: normal; color: #FFF; background-color: #657383; border-bottom: #BBB 2px solid; }
p#copyright { margin: 20px 10px; font-size: 90%; color: #999; }

/* Form styles */
div.form-container { margin: 10px; padding: 5px; background-color: #FFF; border: #EEE 1px solid; }

p.legend { margin-bottom: 1em; }
p.legend em { color: #C00; font-style: normal; }

div.errors { margin: 0 0 10px 0; padding: 5px 10px; border: #FC6 1px solid; background-color: #FFC; }
div.errors p { margin: 0; }
div.errors p em { color: #C00; font-style: normal; font-weight: bold; }

div.form-container form p { margin: 0; }
div.form-container form p.note { margin-left: 170px; font-size: 90%; color: #333; }
div.form-container form fieldset { margin: 10px 0; padding: 10px; border: #999 1px solid; }
div.form-container form legend { font-size: 16px; font-weight: bold; color: #666; }
div.form-container form fieldset div { padding: 0.25em 0; }
div.form-container label, 
div.form-container span.label { margin-right: 5px; width: 165px; display: block; float: left; text-align: right; position: relative; }
div.form-container label.error, 
div.form-container span.error { color: #C00; }
div.form-container label em, 
div.form-container span.label em { position: absolute; right: 0; font-size: 120%; font-style: normal; color: #C00; }
div.form-container input.error { border-color: #C00; background-color: #FEF; }
div.form-container input:focus,
div.form-container input.error:focus, 
div.form-container textarea:focus {	background-color: #FFC; border-color: #FC6; }
div.form-container div.controlset label, 
div.form-container div.controlset input { display: inline; float: none; }
div.form-container div.controlset div { margin-left: 170px; }
div.form-container div.buttonrow { margin-left: 180px; }

/* Confirmation */
#confirm
	{
		position: absolute;
		top: 120px;
		left: 300px;
		font-size: 20px;
		color: green;
	}

</style>

</head>

<body>

<div id="wrapper">

	<h2>User Creation Form</h2>

	<div class="form-container">

		<form name="myForm" action="#" onsubmit ="return validateForm()" method="get">
		
	<fieldset>
	
		<legend>Company Details</legend>
		
			<div><label for="fname" title="Please enter a First Name"><strong>First Name:</strong></label> <input id="fname" type="text" name="fname" value="" size="30" /></div>
			<div><label for="lname" title="Please enter a Last Name"><strong>Last Name:</strong></label> <input id="lname" type="text" name="lname" value="" size="35" /></div>
			<div><label for="email" title="Please enter an Email"><strong>Email:</strong></label> <input id="email" type="text" name="email" value="" size="50" /></div>

			<div>
				<label for="usergrp" title="Please select the User Group."><strong>User Group:</strong></label>
				<select id="usergrp" name="usergrp" type="text">
					<option value='na'>Select a user group</option>
					<option value='2'>QA Lead</option>
					<option value='3'>QA Analyst</option>
					<option value='4'>QA Tester</option>
					<option value='5'>PM</option>
				</select>
			</div>
			
			<div>
				<label for="userloc" title="Please select the User Location."><strong>User Location:</strong></label>
				<select id="userloc" name="userloc" type="text">
					<option value='na'>Select a user group</option>
					<option value='1'>New York</option>
					<option value='2'>London</option>
					<option value='3'>Dhaka</option>
					<option value='4'>Italy</option>
				</select>
			</div>
			
			<div>
				<label for="userstatus" title="Please select the User Status."><strong>User Status:</strong></label>
				<select id="userstatus" name="userstatus" type="text">
					<option value='na'>Select a user group</option>
					<option value='Y'>Active</option>
					<option value='N'>Inactive</option>
					<option value='D'>Disabled</option>
				</select>
			</div>		

	</fieldset>
	
	<div class="buttonrow">
		<input name="save" type="submit" value="Save" class="button"  />
		<input name="reset" type="button" value="Reset" class="button" onClick="window.location.reload()"/>		
		
	</div>

	</form>
	
	</div><!-- /form-container -->
		
</div><!-- /wrapper -->

</body>
</html>

		<script language=JavaScript>
		
			function validateForm()
					{
					var x=document.forms["myForm"]["cname"].value;
						if (x==null || x=="")
							  {
							  alert("Please complete the Company Name field.");
							  return false;
							  }
							  
					var x=document.forms["myForm"]["url"].value;
						if (x==null || x=="")
							  {
							  alert("Please complete the Company URL field.");
							  return false;
							  }

					var x=document.forms["myForm"]["industry"].value;
						if (x=="Select an industry" || x=="")
							  {
							  alert("Please select an industry.");
							  return false;
							  }								  
					}

		</script>
		
		<script>
		
			$("#confirm").fadeOut(3000);
			
	
		</script>