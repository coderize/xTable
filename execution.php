<?php 
error_reporting(E_ALL ^ E_NOTICE);
require "includes/config.php"; 
require "includes/sess.php"; 
session_start();


if($_SESSION['user_id']){
?>
<!DOCTYPE html>

<html>

<head>

<title>xTable Execution Editor</title>

<style>
#saveSuite{
	float: right;
}

#continue,#saveSuite,#execCancel{
	margin-top: 5px;

}
.ghead{
	font-weight: bold;
	font-size: 1.1em;
}


</style>

<body>
<?php

$rel = @mysql_real_escape_string($_GET['rel']);
?>

<form id='execForm' name='execForm' action="<?php $_SERVER['PHP_SELF']; ?>" method="GET" />
<table id="execTable"> 
<thead> 

<tr> 

	<th>FUNCTION</th> 
    <th><input type='checkbox' id='all' /></th> 
    <th>TCID</th> 
    <th>NAME</th> 
    <th>PRIORITY</th> 
    <th>CLASS</th> 
    <th>STATUS</th> 
    
</tr> 
</thead> 
<tbody> 

<?php




if( $_SESSION['role'] == 5 || $_SESSION['role'] == 4  ){
	
	$pmse = 3;

}else{
	
	$pmse = 4;

}

$er = @mysql_query("SELECT manual_function_name AS 'FUNCTION'

											FROM table_manual
											
											WHERE manual_relation_id = '{$rel}'
											AND manual_status < {$pmse}

											
											GROUP BY manual_function_name
											ORDER BY manual_tcid  
											
											") or die("UNABLE TO GET FUNCTIONS");
									
	$fnum=1;				
									
	while($query_row = @mysql_fetch_object($er))  { 	
	
	?>
							<tr> 							
								<td class='ghead' colspan='0'>
								<input type="checkbox" name='' group='func<?php echo $fnum; ?>' class='func parent' />&nbsp;&nbsp;<?php echo $query_row->FUNCTION; ?>
								</td> 
							</tr> 

	<?php								
		
				
			$erf = @mysql_query("SELECT manual_tcid AS 'TCID'
												, manual_name AS 'NAME'
												, class_name AS 'CLASS'
												, priority_name AS 'PRIORITY'
												,status_name AS 'STATUS'
												, manual_id AS 'MID'
												 
												FROM table_manual, table_class, table_priority,table_status
												 
												WHERE manual_relation_id = '{$rel}'
												AND manual_class_id = class_id
												AND manual_priority_id = priority_id
												AND manual_status = status_id
												AND manual_function_name = '{$query_row->FUNCTION}'
												AND manual_status < {$pmse}

												 
												ORDER BY manual_tcid ") or die("UNABLE TO DISPLAY FUNCTIONS");
												

					
					while($query_row2 = mysql_fetch_object($erf)){				
					?>					
					<tr> 
						<td> </td> 
						<td> <input type="checkbox" name='<?php echo $query_row2->MID; ?>' group='func<?php echo $fnum; ?>' class='func children' /> </td> 
						<td class='center'><?php echo  $query_row2->TCID; ?></td> 
						<td><?php echo  $query_row2->NAME; ?></td> 
						<td class='center'><?php echo  $query_row2->PRIORITY; ?></td> 
						<td class='center'><?php echo  $query_row2->CLASS; ?></td> 
						<td class='center'><?php echo  $query_row2->STATUS; ?></td> 
					</tr> 

					
					<?php
					}									
									
			$fnum +=1;	
		}
	
	
									
?>

</tbody> 
</table> 

<button id='execCancel' value='cancel'>Cancel</button>
<button id="continue" name="continue" value="Continue">Continue</button>
<!--<button id='saveSuite' name='saveSuite' value='saveSuite'>Save as Suite</button>-->

</form>

<script>
	$(document).ready(function() 
		{ 							
					$('#execTable').fixheadertable({ 
								caption     : '', 
								colratio    : [100, 30, 75, 400,100, 150,100],
								height      : 460,
								zebra       : false,
								sortable    : false,
								sortedColId : 1, 
								sortType    : ['string', 'string', 'string', 'string', 'string', 'string','string'],
								dateFormat  : 'm/d/Y',
								pager       : false,
								rowsPerPage : 100, 
								showhide       : true,
								whiteSpace     : 'normal',
								addTitles      : false,
								
							});   		
							
						$( "button, input:submit, input:reset" ).button();
////////////////////////////////////////////////////RE-SET CLASSES AND COLSPANS //////////////////////////////////////////////////////
						var rows = $("#execTable tr");							 
						rows.children("td:nth-child(1)").each(function() {						
									
									if( $(this).children(".parent").attr("class") == "func parent" ){									
										
										$(this).attr("colspan","7");									
										$(this).attr("class","ghead ui-widget-content");			
										
									} 									
									$("td:nth-child(2)").css("text-align","center");
									$("td:nth-child(3)").css("text-align","center");
									$("td:nth-child(5)").css("text-align","center");
									$("td:nth-child(6)").css("text-align","center");							
									$("td:nth-child(7)").css("text-align","center");							
							});
//////////////////////////////////////////////////// END RE-SET CLASSES AND COLSPANS //////////////////////////////////////////////////////

//////////////////////////////////////////////////// EXECUTION CHECKBOX VALIDATIONS //////////////////////////////////////////////////////
									$(".parent").change(function (){									
									
											if( $(this).attr("checked") == "checked"){
											
													var pname = $(this).attr("group");													
													
													$(".children").each(function(){
													
															if( $(this).attr("group") == pname){
															
																$(this).attr("checked","checked");
																
															
															}
													});		
											
											}else{
											
														var pname = $(this).attr("group");													
													
														$(".children").each(function(){
													
															if( $(this).attr("group") == pname){
															
																$(this).removeAttr("checked");	
																
															
															}
													});	
											
											}
									
									});
									
	
									$(".children").change(function (){									
									
											if( $(this).attr("checked") == "checked"){
											
													var cname = $(this).attr("group");													
													
													$(".parent").each(function(){
													
															if( $(this).attr("group") == cname){															
															
																$(this).attr("checked","checked");
																
															
															}
													});		
											
											}else{											
														var cname = $(this).attr("group");													
													
														$(".parent").each(function(){
														
															var pname = $(this).attr("group");
													
															if( $(this).attr("group") == cname){
															
																if ( $("input[group='" + pname + "']:checked").size() == 1){
																
																	$(this).removeAttr("checked");
																	
																
																}
															
															}
													});	
											
											}
									
									});								
									
									
									$("#all").click(function(){
										
										if( $(this).is(":checked") ){
										
											$(".children").each(function(){											
													
													$(this).attr("checked","checked");
													$(".parent").attr("checked","checked");																					
												
											});
											
										}else{
												
											$(".children").each(function(){										
												
													if ( $(this).is(":checked") ){
													
														$(this).removeAttr("checked");
														$(".parent").removeAttr("checked");
													
													}													
										
											});
										
										}
										
									});
									
									$("#execCancel").click(function(){									
											
											$("#iframeContainer").dialog("close");	
											testCaseArray = [];											
									
									});

									
//////////////////////////////////////////////////// END EXECUTION CHECKBOX VALIDATIONS //////////////////////////////////////////////////////				

				

				$("#continue").click(function(){		
									
									testCaseArray = [];

									$(".children:checked").each(function(){
										
											var item = $(this).attr("name");
										
											testCaseArray.push( item );	

									});	
									
									if(testCaseArray.length > 0){
											
										$.ajax({
											
													  type: "GET",													  
													  url: "devices.php",													  
													  cache: false,													  
													  data: "test=test",													  
													}).done(function( msg ) {
													
															$("#iframeContainer").html(msg); 
													  
													});								
							
										 $( "#iframeContainer" ).dialog({
										
												autoOpen: true,
												height: 580,
												width: 1000,
												modal: true,
												resizable: false
												
											});	
											
									}else{
									
										alert("Please select at least one testcase.");
									}
										

									//for(i=0;i< testCaseArray.length; i++){ alert(testCaseArray[i]) }
								
								});//EXECUTION BUTTON	
								
								
									
									

	});
	

</script>


</body>

</html>
<?php
}else{

		echo "INVALID_SESSION";  
		session_destroy();	
		setcookie("PHPSESSID", "", time()-3600, "/", "10.10.40.16", 0,TRUE);
		exit;
		
}
?>