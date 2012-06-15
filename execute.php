<?php 
error_reporting(E_ALL ^ E_NOTICE);
require "includes/config.php"; 
require "includes/sess.php";
session_start();
?>
<!DOCTYPE html>

<html>

<head>

<title>xTable Execute</title>

<style>
#saveSuite{
	float: right;
}

#continue,#saveSuite,#execCancel{
	margin-top: 5px;

}


#executionTable td{
	text-align:center !important;
}

#executionTable .ghead{
	font-weight: bold;
	font-size: 1.1em;
	text-align:left !important;

}

#executionTable th{
	text-align:left !important;

}

#executionTable textarea{

	height:150px !important;
	width:400px !importatnt;
	min-width:400px !important;
	min-height:150px !important;
	max-width:400px !important;
	max-height:150px !important;

}

#executionTable #scenario, #executionTable #verification{
	text-align:center !imporant;
}

#deviceImage{
	height: 225px;
	width: 300px;
	border: 1px solid black;
	margin: 0 auto;
	text-align:center;
	
}	

#dt, #dg, #dn,#dv{
	font-size:14px;

}

#pass,#fail,#skip{
	margin: 130px 0px 0px 0px;

}

#fail{
	margin-left: 73px;
}

#skip{
	margin-left: 74px;
}



</style>

<body>

<?php


$retIDS = mysql_real_escape_string($_GET['returnedExecIds']);
$startExec = mysql_real_escape_string($_GET['startExecution']);
$retIDS = explode(",", $retIDS);

$ids = mysql_real_escape_string( $_GET['id']);
$eoa = mysql_real_escape_string($_GET['eoa']);
$curTC = mysql_real_escape_string($_GET['curTC']);
$last =  end($retIDS);
$stime =  mysql_real_escape_string($_GET['stime']);


if( $eoa ){

	$last = $eoa ;

}

if( $startExec == 'true' ){

	if( $curTC  ){
		
		$next = $curTC;
	
	}else{
		
		$next = $retIDS[0];
		
	}

	$qse = mysql_query("SELECT manual_function_name
																, manual_tcid
																, priority_name
																, class_name
																, manual_name
																, manual_prereq
																, manual_steps
																, manual_expected
																, devtype_name
																, devgroup_name
																, device_name
																, device_version
																, exec_create_date
																, exec_creator_id
																 
																FROM table_manual, table_device, table_manual_exec, table_priority, table_class, table_devtype, table_devgroup
																 
																WHERE exec_manual_id = manual_id
																AND manual_priority_id = priority_id
																AND manual_class_id = class_id
																AND exec_device_id = device_id
																AND devtype_id = device_type_id
																AND devgroup_id = device_group_id
																AND exec_id = '{$next}' ") or die("QUERY ERROR");

?>

<form id='executionForm' name='executionForm' action="<?php $_SERVER['PHP_SELF']; ?>" method="GET" />

<table id="executionTable"> 
<thead>

<?php 

	while ($rows = mysql_fetch_object($qse)){

?>
	<tr> 
		<th colspan='4' style='text-align:left'>FUNCTION: <?php echo $rows->manual_function_name; ?></th>  
	</tr>
	
	<tr>
		<th colspan='2'  style='text-align:left'>TCID: <?php echo $rows->manual_tcid; ?></th>  
		<td id='exePri'  style='text-align:left'>PRIORITY: <?php echo $rows->priority_name; ?></td>
		<td id='exeCla'  style='text-align:left'>CLASS: <?php echo $rows->class_name; ?></td>
	</tr>
	
	<tr> 
		<th colspan='4'  style='text-align:left'>NAME: <?php echo $rows->manual_name; ?></th>  
	</tr>
	
	<tr> 
		<th colspan='4'  style='text-align:left'>PREREQUISITE: <?php echo $rows->manual_prereq; ?></th>  
	</tr> 

	<tr> 
		<td colspan='2' id='scenario'  style='text-align:center'>SCENARIO</td>	
		<td  colspan='2' id='verification'  style='text-align:center'>VERIFICATION</td>	
	</tr> 

	<tr> 
		<td  colspan='2'><textarea readonly='readonly'  style='height:150px; width:470px; max-width:470px !important; max-height:150px !important;'><?php echo $rows->manual_steps; ?></textarea></td>	
		<td  colspan='2'><textarea  readonly='readonly'  style='height:150px; width:470px; max-width:470px !important; max-height:150px !important;'><?php echo $rows->manual_expected; ?></textarea></td>		
	</tr> 

</thead> 
<tbody> 

</tbody> 

</table> 

<?php


 if ($_GET['curTC']){
	
	$curTC = $_GET['curTC'];

}else{
	
	$curTC = $retIDS[0];
	
} 

?>

	<div id='deviceImage'>
	
			<span id='dt'>Device Type: <b><?php echo $rows->devtype_name; ?></b></span><br />
			<span id='dg'>Device Group: <b><?php echo $rows->devgroup_name; ?></b></span><br />		
			<span id='dn'>Device Name: <b><?php echo $rows->device_name; ?></b></span><br />
			<span id='dv'>Device Version: <b><?php echo $rows->device_version; ?></b></span><br />	
		
			<button id='pass' onclick='javascript:next(<?php echo $curTC; ?>, <?php echo $last; ?>,0,<?php echo $stime; ?>)'>Pass</button>			
			<button id='fail' onclick='javascript:next(<?php echo $curTC; ?>, <?php echo $last; ?>,1,<?php echo $stime; ?>)'>Fail</button>			
			<button id='skip' onclick='javascript:next(<?php echo $curTC; ?>, <?php echo $last; ?>,2,<?php echo $stime; ?>)'>Skip</button>
	
	</div>

<button id='execCancel' value='cancel'>Stop Execution</button>

</form>

<?php

	$create_date = $rows->exec_create_date; 
	$creator = $rows->exec_creator_id;

	}//end while
	
}//end if

?>

<script>

	 function next(id, last,result,stime){		
		
		id = parseInt(id);
		last = parseInt(last);
		result = parseInt(result);
		version = $("#dv b").html();
		
			$.ajax({
				type: "GET",
				url: "action.php",
				cache: false,
				data: {"insertExec":"true","exec_id": id,"exec_start":stime,"exec_result":result,"exec_device_version":version}									  
			}).done(function( retTime ) {
					
					id = id+1;	
					if ( id <= last){	
						
					$.ajax({
						type: "GET", 
						url: "execute.php", 
						cache: false,
						data: {"startExecution":"true","curTC": id,"eoa":last,"stime":retTime}
						}).done(function( msgz ) {
										
							$("#iframeContainer").html(msgz);							
						});	

					}else{ 
										
						$.ajax({
							type: "GET",
							url: "exec_results.php",
							cache: false,
							data: {"create_date":"<?php echo $create_date; ?>","creator":"<?php echo $creator; ?>"}												  
							}).done(function( msg ) {
								
								if( xTable.is_loggedin(msg) ){	
											
									$("#iframeContainer").html(msg); 
									$( "#iframeContainer" ).dialog({
										autoOpen: true,
										height: 580,
										width: 1010,
										modal: true,
										resizable: false
									});	
								}
							});
											
					}	 
						
				});	
					

				
 } ///end function next 
	
	$(document).ready(function(){ 							
		
		$('#executionTable').fixheadertable({ 
			caption     : '', 
			colratio    : [100, 30, 75, 480,100, 150],
			height      : 0,
			zebra       : false,
			sortable    : false,
			sortedColId : 1, 
			sortType    : ['string', 'string', 'string', 'string', 'string', 'string'],
			dateFormat  : 'm/d/Y',
			pager       : false,
			rowsPerPage : 100, 
			showhide       : true,
			whiteSpace     : 'normal',
			addTitles      : false,
		});   		
							
		$( "button, input:submit, input:reset" ).button();
////////////////////////////////////////////////////RE-SET CLASSES AND COLSPANS //////////////////////////////////////////////////////
			var rows = $("#executionTable tr");	
			rows.children("td:nth-child(1)").each(function() {
				
				if( $(this).children(".parent").attr("class") == "func parent" ){							
					$(this).attr("class","ghead ui-widget-content");			
				} 				 				
									
				$(".ghead").each(function(){
			
					$(this).attr("colspan","4");	
				});									
									
				$("td:nth-child(2)").css("text-align","center");
				$("td:nth-child(3)").css("text-align","center");
				$("td:nth-child(5)").css("text-align","center");
				$("td:nth-child(6)").css("text-align","center");							
			});
//////////////////////////////////////////////////// END RE-SET CLASSES AND COLSPANS //////////////////////////////////////////////////////
	
		$("#execCancel").click(function(){
			
			$("#iframeContainer").dialog( "close" );
		
		});


});
	

</script>


</body>

</html>
