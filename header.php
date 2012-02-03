<?php 
ob_start();
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/New_York');
$db = mysql_connect("localhost", "root", "testing450311");
$dbz = mysql_select_db("usablex");

$rel = $_GET['rel'];

$q = mysql_query("SELECT project_name FROM table_project, table_relation WHERE relation_id = '{$rel}'  AND  r_project = project_id");

$name = mysql_fetch_array($q);
$project_name = $name[0];

?>
<!DOCTYPE html>
<html>
<head>
<title>UsableX - Export</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="css/jquery.ui.theme.css" />

<style>
*{margin:0px; padding:0px;}

table{
border-collapse:collapse;
position:absolute;
bottom:0px;
}
table td{
	height:15px;

}

#quick-details{
	
}#quick-details img{
	height: 30px;
	float: left;

}
#quick-details-time{
	float: right;
	margin-right: 10px;
	
}
#quick-details{
		
		background: url("img/um_logo.gif") no-repeat left top;
		background-size: 30px;
		
		
		text-align:center;
}
#project-name{
	display:inline-block;
	font-family: Arial;
	font-size:18px;
	font-weight: bold;


}
body,html{

	height:50px;
	padding-left:4px;
}

</style>

</head>
<body>

<div id ='quick-details'>
	
	<img src='img/um_logo.gif' /> 
	<span id='project-name'><?php echo $project_name; ?></span>
	
	<span id='quick-details-time' class="ui-widget-content  ui-widget " style='border:0px !important;'>Generated on <?php echo date("l, F d, Y h:i:s A", time()); ?></span>
</div>

<table id='xport' name='xport' class='ui-widget-content  ui-widget '>
       <tr class='ui-widget-header ui-widget-content ui-widget'>
      
		<td class='tblTR ui-widget-header ui-widget-content ui-widget ui-state-default' style='width:156px;text-align:center;'>FUNCTION</td>
		
		<td class='tblTR ui-widget-header  ui-widget-content ui-widget ui-state-default' style='width:78px;text-align:center;'>TCID</td> 
		<td class='tblTR ui-widget-header  ui-widget-content ui-widget ui-state-default' style='width:79px;text-align:center;'>PRIORITY</td> 
		<td  class='tblTR ui-widget-header  ui-widget-content ui-widget ui-state-default' style='width:80px;text-align:center;'>CLASS</td> 
		<td  class='tblTR ui-widget-header  ui-widget-content ui-widget ui-state-default' style='width:160px;text-align:center;'>NAME</td> 
		<td  class='tblTR ui-widget-header  ui-widget-content ui-widget ui-state-default' style='width:159px;text-align:center;'>PREREQUISITE</td>
		<td  class='tblTR ui-widget-header  ui-widget-content ui-widget ui-state-default' style='width:313px;text-align:center;'>SCENARIO</td>
		<td  class='tblTR ui-widget-header  ui-widget-content ui-widget ui-state-default' style='width:313px;text-align:center;'>VERIFICATION</td>
   
       </tr>

</table>



	
	

	

</body>
</html>
	