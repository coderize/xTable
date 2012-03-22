<?php 
error_reporting(E_ALL & ~E_NOTICE); 
require "includes/config.php"; 
?>
<html>
	<head>
	
		<title>Report Generator</title>
		
		<link rel="stylesheet" type="text/css" href="css/base.css" />
		<link rel="stylesheet" type="text/css" href="css/redmond/jquery-ui-1.8.16.custom.css" />
		<link rel="stylesheet" type="text/css" href="css/selectmenu.css" />
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="js/jqueryUI/js/jqueryui.js"></script>
		<script src="js/jquery.js"></script>
		<style>
		 *{margin:0px;padding:0px; font-size: 12px;}
		 
		#mainContainer{
			padding: 5px;
		 }
		 
		 .ui-selectmenu, ul{
			width:170px !important;
		 
		 }
		 
		#navigation a {
		float:left;
		margin-left:5px;
		
		
		}
		
		#generate{
			position:absolute;
			top:100px;
			right: 15%;
		
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
	
<?php	 while($qverts = mysql_fetch_object($verts)){ 
?>
	
				<option value="<?php echo $qverts->vertical_id; ?>"><?php echo $qverts->vertical_name; ?></option>

<?php	 } 
?>
		
	</select>	
	
<?php
		
		if($vert){
?>		
		<select name='client' id='client' onchange="javascript:reload();">	
		<option value=''>Client Selection</option>
<?php				
				$clients = mysql_query("SELECT client_id, client_name 
											FROM table_client, table_vertical, table_relation
											 
											WHERE vertical_id = r_vertical
											AND vertical_id= '{$vert}'
											AND client_id = r_client
											 
											GROUP BY client_id
											ORDER BY client_name ASC
											");
		
				while($qclients = mysql_fetch_object($clients)){
?>			
					
				<option value="<?php echo $qclients->client_id; ?>"><?php echo $qclients->client_name; ?></option>
				
				
<?php
				}	
		
		}		
		
?>
</select>

<select id='month' name='month'>

	<option value='na'>Select a month</option>
	<option value='January'>January</option>
	<option value='Feburary'>Feburary</option>
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
<?php 

$days_passed_this_month = date("j");
 
$timestamp_last_month = time() - $days_passed_this_month *24*60*60;
 
$last_month = date("F", $timestamp_last_month);



?>

<script>

			function reload(){
	
			 	ddvert = document.getElementById('vertical'); 				
				ddclient = document.getElementById('client');							
				vertpath = 'reportgen.php?vertical=' + ddvert.value;
				window.location = vertpath;				
				clientpath = vertpath + "&client=" + ddclient.value;
				window.location = clientpath;				
             }    
			 
$(document).ready(function() { 	

		document.getElementById("vertical").value = "<?php  echo $vert;  ?>";
		document.getElementById("client").value = "<?php  echo $client;  ?>";
		document.getElementById("month").value = "<?php  echo $last_month;  ?>";	
	

	$( "button, input:submit, input:reset" ).button();
	$("select").selectmenu({style: 'dropdown', maxHeight: 400});	



		
		$("#generate").click(function(){		
		
		var url  = "http://10.10.40.31/usablex/monthlyreport.php?";
		
		var vertical = url + "vertical=" + $("#vertical").val();
		
		var client = vertical + "&client=" + $("#client").val();
		
		var full_url = client + "&month=" + $("#month").val();
		
		
		
			
			var name =  new Date().getTime();
			
			window.open( full_url , name );
		
		
		});
		
		
		
		
	});
</script>

</body>
</html>
