<?php 
	header("Content-type: text/html; charset=utf-8");  
	error_reporting(E_ALL ^ E_NOTICE);
	require "includes/config.php"; 
	require "includes/sess.php";
	session_start();
?>

<!DOCTYPE html>

<html>
<head>
<title>Execution Results</title>
<meta http-equiv="Content-Encoding" content="gzip">
<meta http-equiv="Accept-Encoding" content="gzip, deflate">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

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

<script src="js/resultsEdit.js" charset="UTF-8"></script>

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
<!--<button id='execNow' name='execNow' value='Execute Now'>Execute Now</button>-->

</form>

<script charset="UTF-8">

/////////////////////////////////////////////////////////////EDITING AJAX////////////////////////////////////////////////////////////

///////////STRIP TAGS//////////////////
function strip_tags(a,b){b=(((b||"")+"").toLowerCase().match(/<[a-z][a-z0-9]*>/g)||[]).join("");var c=/<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,d=/<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;return a.replace(d,"").replace(c,function(a,c){return b.indexOf("<"+c.toLowerCase()+">")>-1?a:""})}
///////////STRIP TAGS//////////////////

	function editAjax(par){

		var parent = $(par).parent().parent();	 
		var eid =$(parent).children("td:nth-child(1)").html();
		// var tcid = encodeURIComponent($(parent).children("td:nth-child(2)").html());
		// var name = encodeURIComponent($(parent).children("td:nth-child(3)").html());
		// var device = encodeURIComponent($(parent).children("td:nth-child(4)").html());
		// var duration = encodeURIComponent($(parent).children("td:nth-child(5)").html());
		var result = $(parent).children("td:nth-child(6)").html();

		 $.ajax({
					type: "GET",													  
					url: "action.php",													  
					cache: false,
					async: true,
					data: {"resultsEdit":"true","eid":eid,"result":result}
		}).done(function( msg ) {
				
					if( xTable.is_loggedin(msg) ){			

							
							if(msg =='200'){
								
								$("editSuccess").css("display","block");
								$("editSuccess").fadeOut(3000);

							}else{
							
								alert ("Something went wrong while saving, try again");
								
							}
					
					}
								
			}); 

	}

/////////////////////////////////////////////////////////////END EDITING AJAX///////////////////////////////////////////

////////////////////////////////////////////////////OTHER ELEMENTS EDITING////////////////////////////////////////////////////			
		function editElement(ele,obj,type,ml){			
				
				var elem = ele;
				var objm = obj;
				var typem = type;
				var mlm = ml;

			if(type==false){	
			
					$("#mySelect").remove();
					var seleEdit = document.createElement("select");
					seleEdit.id = 'mySelect';
						
					for (var i in objm){		

						
						if(elem.innerHTML == objm[i]){
							
							
							seleEdit.appendChild(new Option(objm[i], i,0,1 ));							
						
						}else{
						
							seleEdit.appendChild(new Option(objm[i], i ));
						}			
					}		
		
					elem.appendChild(seleEdit);										
					elem.removeChild(elem.firstChild);						
					seleEdit.focus();

					  seleEdit.onchange = function(){		
					  
									var ms  = $("#mySelect option:selected").text();
									$(elem).html(ms);																	
									editAjax(elem.childNodes[0]);	
									$('input#search').quicksearch('#resultsTable tbody tr');	
									
					}  			
					
							 seleEdit.onblur = function(){				

									var ms  = $("#mySelect option:selected").text();
									$(elem).html(ms);
										

					}  
							  seleEdit.onkeyup = function(){		
					  
								 	var ms  = $("#mySelect option:selected").text();
									$(elem).html(ms);																	
									editAjax(elem.childNodes[0]);		
									$('input#search').quicksearch('#resultsTable tbody tr');	
									
					}


			}else if(type==true){	
					
					$("#inpt").remove();
					var inp = document.createElement("input");
					inp.type = "text";
					inp.name = 'test';
					inp.id = "inpt";
					inp.size = ele.innerHTML.length;	
					inp.maxLength = ml;
					inp.style.height = "20px";
					inp.style.textAlign = "center";
					inp.value = ele.innerHTML;			
					ele.appendChild(inp);
					ele.removeChild(ele.firstChild);
					inp.focus();
						
						inp.onblur = function(){
						
							ele.innerHTML = inp.value;
						}
						inp.onchange = function(){
							
							ele.innerHTML = inp.value;
							editAjax(ele.childNodes[0]);
							$('input#search').quicksearch('#resultsTable tbody tr');	

						}				
			}			
			
		}//END EDIT ELEMENT	


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
				
			$( "button, input:submit, input:reset" ).button();

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
						data: {"execute":"true","testcasearray":testCaseArray,"devicearray":deviceArray}													  
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
