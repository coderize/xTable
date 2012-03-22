<?php 
ob_start();
header("Content-type: text/html; charset=utf-8");  
error_reporting(E_ALL ^ E_NOTICE);
require "includes/config.php"; 
require "includes/sess.php";
session_start();

 if( !$_SESSION['fname'] ){
	header('Refresh: 0; URL=login.php');
	exit;
} 
?>
<html>
	<head>
	
		<title>Report Generator</title>
		
		<link rel="stylesheet" type="text/css" href="css/base.css" />
		<link rel="stylesheet" type="text/css" href="css/flick/jquery-ui-1.8.16.custom.css" />
		<link rel="stylesheet" type="text/css" href="css/selectmenu.css" />
		<link rel="stylesheet" type="text/css" href="css/contactable.css" />
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="js/jqueryUI/js/jqueryui.js"></script>
		<script src="js/jquery.js"></script>
		<script src="http://jqueryui.com/themeroller/themeswitchertool/" charset="UTF-8"></script>
		<script src="js/jquery.contactable.js" charset="UTF-8"></script>

		<style>
		
			body{
				font-family: verdana, Helvetica, san-serif;
			}
			
			*{margin:0px;padding:0px; font-size: 12px;}
			 
			#mainContainer{
				padding: 5px;
			}
			
			#vertical{
				min-width: 200px !important;
			}

			#client{
				min-width:375px !important;
			}
			 
			#navigation a {
				float:left;
				margin-left:5px;		
			}
			
			#generate{
				margin-top: -5px;
				margin-left: 5px;	
			}
			
			#box{
				border-radius: 0px 15px 15px 0px;
			}
			
			#reports,#pdf{
				height:100px;
				border-radius: 10px;
			}

			.menu-icons img{
				margin: 15px;
			}

			.over{
				opacity: .7;
			}

			.over:hover{
				opacity: 1 !important;
			}

			#logout{
				display:block;
				position:absolute;
				top:10px;
				right:15px;
			}
			
			#logout-confirm{display:none}			

			#welcome{
				font-size:14px;
				margin: 5px 0px 20px 0px;
				display:block;
			}

			#main{
				margin-top:100px;
				border: 1px solid #000;
			}

			#icon img{
				height:60px;
				width:60px;
				display:inline;
				float:left;
				margin:5px;
				border-radius:10px;
			}

			#XTable{
				margin-left:10px !important;
			}

		</style>
		
	</head>
<body>


<?php 
	$vert = mysql_real_escape_string($_GET['vertical']);
	$client = mysql_real_escape_string($_GET['client']);	

	$verts = mysql_query("SELECT vertical_id, vertical_name FROM table_vertical WHERE vertical_id < 5 ORDER BY vertical_name ASC");	
?>

	<div id='mainContainer'>
	<div id='navigation'>
	<form name='naviForm' id='naviForm' action="index.php" method="GET">
	<select name='vertical' id='vertical' onchange="javascript:reload();">
	<option value='na'>Vertical Selection</option>
	
<?php
	
	while($qverts = mysql_fetch_object($verts)){ 

?>
	
	<option value="<?php echo $qverts->vertical_id; ?>"><?php echo $qverts->vertical_name; ?></option>

<?php	 

	} 

?>
		
	</select>	
	
	<select name='client' id='client' onchange="javascript:reload();">	
	<option value=''>Client Selection</option>
		
<?php				

$vert = ($vert && $vert != 'na' && $vert !='6') ? $vert : $_COOKIE['vertical'];

				$clients = mysql_query("SELECT client_id, client_name
				
													FROM table_client, table_vertical, table_relation
													 
													WHERE vertical_id = r_vertical
														AND vertical_id= '{$vert}'
														AND client_id = r_client
													 
													GROUP BY client_id
													
													ORDER BY client_name ASC");
		
				while($qclients = mysql_fetch_object($clients)){

?>			

				<option value="<?php echo $qclients->client_id; ?>"><?php echo $qclients->client_name; ?></option>
	
<?php

				}

?>

	</select>

	<select id='month' name='month'>

		<option value='na'>Select a month</option>
		<option value='January'>January</option>
		<option value='February'>February</option>
		<option value='March'>March</option>
		<option value='April'>April</option>
		<option value='May'>May</option>
		<option value='June'>June</option>
		<option value='July'>July</option>
		<option value='August'>August</option>
		<option value='September'>September</option>
		<option value='October'>October</option>
		<option value='November'>November</option>
		<option value='December'>December</option>
		
	</select>

</form>

</div><!-- end nav -->

</div> <!-- end main container -->

<button id='generate'>Generate</button>
<div id="contactable"></div>

<?php 

	$days_passed_this_month = date("j");
	 
	$timestamp_last_month = time() - $days_passed_this_month *24*60*60;
	 
	$last_month = date("F", $timestamp_last_month);

?>

<div id='iframeContainer'></div>								
								
<div id="logout-confirm" title="Log out?">
	<p>You will be logged out. Are you sure?</p>
</div>								

<div id="contactable"></div>

<script>

///////////////////////////////////////////////session checker/////////////////////////////////////////////////////

function is_loggedin(a){if(a=="INVALID_SESSION"){$("#logged-out").dialog({height:300,width:400,modal:true,resizable:false});function b(){window.location.href=window.location.href}setTimeout(b,2e3);return false}else{return true}}
///////////////////////////////////////////////session checker/////////////////////////////////////////////////////

 		function reload(){
	
			 	ddvert = document.getElementById('vertical'); 				
				ddclient = document.getElementById('client');							
				vertpath = 'reportgen.php?vertical=' + ddvert.value;
				window.location = vertpath;				
				clientpath = vertpath + "&client=" + ddclient.value;
				window.location = clientpath;				
             }   
			 
	$(document).ready(function() { 		

		$( "button, input:submit, input:reset" ).button();
		$("select").selectmenu({style: 'dropdown', maxHeight: 400});	
		
				$("#generate").click(function(){		

					var url  = "monthlyreport.php?";
					
					var vertical = url + "vertical=" + $("#vertical").val();
					
					var client = vertical + "&client=" + $("#client").val();
					
					var full_url = client + "&month=" + $("#month").val();		
					
					var name =  new Date().getTime();
						
					window.open( full_url , name );		
				
				});
		
			$('#contactable').contactable();
			$("#welcome").html("Welcome, <?php echo $_SESSION['fname']; ?>");
			$('#switcher').themeswitcher();
			$('button').button();
			$("#navReporting").attr("href","javascript:void(0)");
			$("#Reporting").css("border","3px solid #ff7777");
			$("#Reporting").css("-webkit-box-shadow","0px 0px 2px 2px #ff7777");
			
			$("#pdf").click(function(){
				
					alert("Exporting on this page is not supported.");
					
			});
			
			///////////////////////////////////END EXECUTE BUTTON////////////////////////////////////////////////////////////////////////////						
			$( "button, input:submit, input:reset" ).button();
			
			///////////////////////////////////LOGOUT FUNCTION///////////////////////////////////////////////////////////////////////	
								$("#logout").click(function(){
									
									$( "#logout-confirm" ).dialog({
											resizable: false,
											height:140,
											modal: true,
											buttons: {
												"Log out from xTable": function() {
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
												},
												Cancel: function() {
													$( this ).dialog( "close" );
												}
											}
									});

								});// END LOGOUT 
	});	
		
			
		document.getElementById("vertical").value = "<?php  echo $vert = ($vert && $vert != 'na' && $vert !='6') ? $vert : $_COOKIE['vertical'];  ?>";
		
		document.getElementById("client").value = "<?php  echo $client = ($client && $vert !='na' && $vert !='267') ? $client : $_COOKIE['client'];  ?>";
			
		document.getElementById("month").value = "<?php  echo $last_month;  ?>";		
		
</script>

</body>
</html>