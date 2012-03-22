<?php 
error_reporting(E_ALL ^ E_NOTICE);
require "includes/config.php"; 
require "includes/sess.php";
session_start();
?>
<!DOCTYPE html>

<html>

<head>

<title>xTable Device Selection</title>

<style>
#saveSuite{
	float: right;
}

#continue,#saveSuite,#execCancel{
	margin-top: 5px;

}


#deviceTable td{
	text-align:center !important;
}

#deviceTable .ghead{
	font-weight: bold;
	font-size: 1.1em;
	text-align:left !important;

}

</style>

<body>

<form id='deviceForm' name='deviceForm' action="<?php $_SERVER['PHP_SELF']; ?>" method="GET" />
<table id="deviceTable"> 
<thead> 

<tr> 

	<th>TYPE</th>  
    <th>GROUP</th> 
    <th>NAME</th> 
    <th>VERSION</th> 

    
</tr> 
</thead> 
<tbody> 

<?php

$userloc = $_SESSION['loc'];

$er = @mysql_query("SELECT devtype_name
															 
															FROM table_device, table_devtype
															
															WHERE device_location_id = '{$userloc}'
															AND device_type_id = devtype_id
															 
															GROUP BY devtype_name
															
															ORDER BY devtype_name") or die("UNABLE TO GET DEVICES");
									
			
									
	while($query_row = @mysql_fetch_object($er))  { 	
	
	?>
							<tr> 							
								<td class='ghead' colspan='0'>	
									<?php echo  strtoupper($query_row->devtype_name); ?>
								</td> 
							</tr> 
							
<?php			

				$dq = mysql_query("SELECT device_id, devgroup_name, device_name, device_version
 
														FROM table_device, table_devtype, table_devgroup
														
														WHERE devtype_id = device_type_id
														AND devgroup_id = device_group_id
														AND device_location_id = '{$userloc}'
														AND devtype_name = '{$query_row->devtype_name}'
														 
														GROUP BY devtype_name, devgroup_name, device_name, device_version														
														 
														ORDER BY devtype_name, devgroup_name, device_name, device_version");
														

					while ($query_row2 = @mysql_fetch_object($dq)){
?>						<tr>
								<td><input type='checkbox' name='<?php echo $query_row2->device_id;?>' id='' class='deviceList' /></td>
								<td style='text-align:center;'><?php echo $query_row2->devgroup_name; ?></td>
								<td style='text-align:center;'><?php echo $query_row2->device_name; ?></td>
								<td style='text-align:center;'><?php echo $query_row2->device_version; ?></td>
							</tr>
							
					
					
					
<?php 					
					}
?>

<?php
	}
?>


</tbody> 
</table> 

<button id='execCancel' value='cancel'>Cancel</button>
<button id="execNow" name="execNow" value="Execute Now">Execute Now</button>
<!--<button id='saveSuite' name='saveSuite' value='saveSuite'>Save as Suite</button>-->

</form>

<script>
	$(document).ready(function() 
		{ 							
					$('#deviceTable').fixheadertable({ 
								caption     : '', 
								colratio    : [100, 30, 75, 480,100, 150],
								height      : 460,
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
						 var rows = $("#deviceTable tr");	
						
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

			

					$("#cancel").click(function(){
							
							$(".children:checked").each(function(){
							
									alert( $(this).attr("name") );
							
							
							});

					});


					$("#execCancel").click(function(){
					
						$("#iframeContainer").dialog( "close" )
					
					});
					
					$("#execNow").click(function(){
						
						deviceArray = [];
						
						$(".deviceList:checked").each(function(){
							
							var item = $(this).attr("name");
							
							deviceArray.push( item );	

						});
					
					if( deviceArray.length > 0 ){
					
							
							$.ajax({
								type: "GET",													  
								url: "action.php",													  
								cache: false,													  
								data: "execute=true&testcasearray="+ testCaseArray +"&devicearray="+deviceArray+"&crypto=<?php echo session_id() . 'zLsX7795d1d5AsCsD3wFGv'; ?>",													  
								}).done(function( msg ) {
									//alert(msg);
									returnedExecIds = msg;	
										
										 $.ajax({
												type: "GET",													  
												url: "time.php",													  
												cache: false,	
												async: false,
												data: "test=test",													  
												}).done(function( stime ){
													
													nstime = stime;
									
										
										 
											$.ajax({
													type: "GET",													  
													url: "execute.php",													  
													cache: false,													  
													data: "startExecution=true&returnedExecIds=" + msg+"&stime="+nstime,													  
													}).done(function( msgi ) {
														
														$("#iframeContainer").html(msgi); 
													});	

												
										});		
												
								});///return Execution IDs		
						
						
					}else{ alert("Please select at least one device."); }
						
						
						
						
					
					
					});
					
					
					
					
					
					
					
					
					
					



	});
	

</script>


</body>

</html>