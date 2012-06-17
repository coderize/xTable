<?php 
header("Content-type: text/html; charset=utf-8");  
error_reporting(E_ALL ^ E_NOTICE);
require "includes/config.php"; 
require "includes/sess.php";
session_start();
?>
<!DOCTYPE html>

<style>

#saveSuite{
	float: right;
}

#continue,#saveSuite,#execCancel{
	margin-top: 5px;
}

#resultsTable .ghead{
	font-weight: bold;
	font-size: 1.1em;
	text-align:left !important;
}

</style>

<!--<script src="js/core.js" charset="UTF-8"></script>
-->
<script charset="UTF-8">resultObj = {'0':'Pass','1':'Fail'};</script>

</head>
<body>

	<table id="resultsTable"> 
			<thead>
				<tr>

					<th>EID</th>
					<th>TCID</th>
					<th>NAME</th>
					<th>DEVICE</th>
					<th>DURATION(seconds)</th>
					<th>RESULT</th>

				</tr>
			</thead>

			<?php

$user_id = mysql_real_escape_string($_SESSION['user_id']);
$create_date = mysql_real_escape_string($_GET['create_date']);
$creator = mysql_real_escape_string($_GET['creator']);
$qxres = mysql_query("SELECT exec_id AS 'EID'
			, manual_tcid AS 'TCID'
			, manual_name AS 'NAME'
			, device_name AS 'DEVICE'
			, exec_end - exec_start AS 'DURATION'
			, CASE exec_result WHEN 0 THEN 'Pass' WHEN 1 THEN 'Fail' WHEN 2 THEN 'Skip' END AS 'RESULT'
				
			FROM table_manual, table_device, table_manual_exec
			WHERE exec_manual_id = manual_id
			
			AND exec_device_id = device_id
			AND exec_creator_id = '{$creator}'
			AND exec_create_date = '{$create_date}'
			AND exec_user_id = '{$user_id}' ");
															
	while ($query_row = @mysql_fetch_object($qxres)){

?>				
			<tbody>					
				<tr>
					<td style='text-align:center;'><?php echo $query_row->EID; ?></td>
					<td style='text-align:center;'><?php echo $query_row->TCID; ?></td>
					<td style='text-align:left;'><?php echo $query_row->NAME; ?></td>
					<td style='text-align:center;'><?php echo $query_row->DEVICE; ?></td>
					<td style='text-align:center;'><?php echo $query_row->DURATION; ?></td>
					<td style='text-align:center;'><?php echo $query_row->RESULT; ?></td>
				</tr>			
					
<?php 					
	}
?>

			</tbody>
	</table>

<button id='execCancel' value='Cancel'>Close</button>

</form>

<script charset="UTF-8">

$(document).ready(function(){


$('#resultsTable').fixheadertable({ 
	caption     : '', 
	colratio    : [1,70, 400, 300, 134, 67],
	height      : 460,
	zebra       : false,
	sortable    : false,
	sortedColId : 1, 
	sortType    : ['int', 'string', 'string', 'string', 'string', 'string'],
	dateFormat  : 'm/d/Y',
	pager       : false,
	rowsPerPage : 100, 
	showhide       : true,
	whiteSpace     : 'normal',
	addTitles      : false,							
});   		
	$( "button" ).button();	
	
	xTable.resultsEdit();

	$("#execCancel").click(function () { 	$( "#iframeContainer" ).dialog("close"); } );
});



</script>

</body>

</html>
