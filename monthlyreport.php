<?php

ob_start();
header("Content-type: text/html; charset=utf-8");  
error_reporting(E_ALL & ~E_NOTICE); 
require "includes/config.php"; 
require "includes/sess.php";
session_start();

?>

 <!DOCTYPE HTML>
<html>
<head>
<title></title>
<style>
	*{margin:0px;padding:0px;}
	/* body,html{height:100%;} */
	
	body{font-family:Calibri;}

	#main{
		position:relative;
		height:100%;
		/* border: 2px solid #000; */
		padding: 0px 20px 0px 20px;
	}

	#header{
		/* border: 1px solid #000; */
		text-align:center;
	}
	
	#header img{ 
		margin: 0 auto;
	}

	#manual, #automation, #defects{
		border:1px solid #000;
		padding-bottom:20px;
		margin-top:50px;
		-moz-border-radius-bottomright: 20px;
		border-bottom-right-radius: 20px;
		-moz-border-radius-bottomleft: 20px;
		border-bottom-left-radius: 20px;
		-moz-border-radius-topright: 20px;
		border-top-right-radius: 20px;
		-moz-border-radius-topleft: 20px;
		border-top-left-radius: 20px;
	}	

	.innerheader{
		color:#E20037;
		text-align:center;
		font-weight:bold;
		font-size:24px;
	}

	.para{
		margin-top:15px;
		margin-bottom:10px;
		padding:15px;
		text-align:left;
	}

	table{
		border:1px solid black;
	}

	td{
		text-align:center;
	}

	table{
		height:300px;
		margin:0 auto;
		width:100%;
	}

	.projdefects{
		margin-bottom:20px;
		width:99%;
	}

	/* .projdefects td{
		height: 25px;
	} */

	#defects{
		margin-bottom:50px;
	}

	#manual, #automation, #defects{
		width:1130px;
		margin: 0 auto;
		margin-top: 100px;
	}

	#automation{
		margin-top: 20px;
		margin-bottom:20px;
	}

	#innermanual,#innerautomation{
		width:1100px;
		margin: 0 auto;
	}

	.thProjectName{
		width:250px;
	}

	th{
		background-color:#D9E1E3;
	}

	.projdefects{
		width:95%;
	}

	.paradefect{
		padding-left:30px;
	}

	#defects{
		margin-bottom:30px;
		padding-bottom:0px;
	}

	#nodefects{
		margin-left: 70px;
		color:#f00;
		font-weight:bold;
		margin-bottom:20px;
	}
 
<?php

$vertical = @mysql_real_escape_string($_GET['vertical']);
$client = @mysql_real_escape_string($_GET['client']);
$month = @mysql_real_escape_string($_GET['month']);

$qc = mysql_query("SELECT client_name FROM table_client WHERE client_id = '{$client}' ");

$client_name  = mysql_fetch_object($qc);
$client_name = $client_name->client_name;

?>

</style>

</head>

<body>


<div id='main'>


	<div  id="header">
	<!--<img src="img/monthly_report_header.png" />-->

	</div><!-- end header -->	

	<div id="manual">
	<div class='innerheader'>Manual Testing Results</div>
		<div id="innermanual">			
		
			<p class='para'>The following results are for: <?php echo $client_name;  ?>  </p>	
			
			<?php 
			
				echo  $table = file_get_contents("http://localhost/xtable/metrics.php?vertical={$vertical}&client={$client}&month={$month}"); 
			
			?>
		
		</div><!--innermanual-->
	
	</div><!-- end manual -->
	
  
 </tbody>
</table>

	<!--</div> end defects -->

</div><!-- end main div -->

</body>

</html>