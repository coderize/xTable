<?php
header("Content-type: text/html; charset=utf-8");  
error_reporting(E_ALL ^ E_NOTICE);
require "includes/config.php"; 
require "includes/sess.php";
session_start();

if( !$_SESSION['fname'] || $_SESSION['role']  > 2 || $_SESSION['user_id']  === '107' ){
	 header('Refresh: 0; URL=login.php');
	 exit;
} 


?>

<!DOCTYPE html>
<html>
<head>
<title>UsableX - Administration - Devices</title>
<meta http-equiv="Content-Encoding" content="gzip">
<meta http-equiv="Accept-Encoding" content="gzip, deflate">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

<style>

body,pre{font-family:Verdana,Helvetica,san-serif,Arial;font-size:.6em}*{padding:0;margin:0}

.clearfix:after{content:".";display:block;clear:both;visibility:hidden;line-height:0;height:0}
.clearfix{display:inline-block}html[xmlns] 
.clearfix{display:block}* html 
.clearfix{height:1%}#createForm,

#iframeContainer{display:none;}

#mainContainer{padding-top:5px;min-width:960px;max-width:1500px;position:relative}

.inpFields{font:inherit;color:inherit;outline:0;cursor:text}pre{font-size:1em;white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word}

#search{margin-left:35%;margin-top:-15px;border:3px solid #7aa3cc;width:350px;height:20px;border-radius:15px;-webkit-border-radius:15px;border-top-right-radius:15px; border-top-left-radius:15px;border-bottom-right-radius:15px;border-bottom-left-radius:15px;font-size:1.2em}

.dragging{border:2px solid #0f0}

._filterText{width:99%;height:20px;font-style:italic;background-color:#f0f0f0;border-width:1px;font-size:14px!important}

#navigation a{float:left}

#navigation{/* position:relative;height:100px */}

#navigation 

#vertical-button, #client-button, #project-button{margin-left:5px!important}

#bodyContainer{z-index:1000;position:relative}

#execIframe{width:99%;height:97%}

#createForm select{width:200px}

#class-menu, #priority-menu, #function-menu{z-index:2000}#createForm textarea{max-width:630px;min-width:320px;max-height:95px;width:630px;height:95px}

#logout{margin:4px 0 0 30%;display:none}#myAcc{position:absolute;top:0;right:17%;height:30px;font-weight:bold;width:152px}#accChild{display:none}

#logout-confirm{display:none}#other{background-color:#ccc}

#indicator{font-size:14px;color:#7ec045;font-weight:bold}

#loading{display:none;position:absolute;top:41%;left:44%;z-index:10000}

#editSuccess{display:none;position:absolute;top:5px;left:44%;z-index:10000;font-size:20px;color:#3d5;font-weight:bold}

#account{width:152px}

.myAccOpen{border-radius:10px;height:145px!important;background-color:#fff;z-index:1002;border-right:2px solid #ccc;border-left:2px solid #ccc;border-bottom:2px solid #ccc}

#switcher{margin-top:3px}.function,.tcid,.priority,.class,.status{text-align:center!important}#pager{height:35px;padding:5px;font-weight:bold}#graph{width:100%;height:550px;border:0}#graph-all{position:absolute;top:165px;z-index:1;width:99%;overflow:hidden;height:500px;visibility:hidden}

#graph-controls{position:relative;margin-top:20px}#up{position:absolute;left:400px;top:0}.ui-selectmenu-menu{z-index:3000}#navBtns{position:absolute;bottom:0}#logged-out{display:none;text-align:center;font-size:1.3em}#logged-out img{display:block;margin:0 auto;padding:60px 0 5px 0}

#naviForm{
	display:none;

}
#box{
	border-radius: 0px 15px 15px 0px;

}
#reports,#pdf{
	height:0px;
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
#welcome{
	font-size:14px;
	margin: 5px 0px 20px 0px;
	display:block;
}
#main{
	margin-top:200px;
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

<link rel="stylesheet" type="text/css" href="css/base.css" />
<link rel="stylesheet" type="text/css" href="css/flick/jquery-ui-1.8.16.custom.css" />
<link rel="stylesheet" type="text/css" href="css/selectmenu.css" />
<!-- <link rel="stylesheet" type="text/css" href="css/calendar.css" /> -->
<link rel="stylesheet" type="text/css" href="css/contactable.css" />

<script src="js/userEdit.js" charset="UTF-8"></script>
<script src="js/addEdit.js" charset="UTF-8"></script>
<script src="js/deviceEdit.js" charset="UTF-8"></script>
<script src="js/jquery.min.js" charset="UTF-8"></script>
<script src="js/jquery.quicksearch.js" charset="UTF-8"></script>
<script src="js/jqueryUI/js/jqueryui.js" charset="UTF-8"></script>
<script src="http://jqueryui.com/themeroller/themeswitchertool/" charset="UTF-8"></script>
<script src="js/jquery.fixheadertable.js" charset="UTF-8"></script>
<script src="js/jquery.columnfilters.js" charset="UTF-8"></script>
<script src="js/columnFilters.js" charset="UTF-8"></script>
<script src="js/jquery.js" charset="UTF-8"></script>
<!-- <script src="js/calendar_db.js" charset="UTF-8"></script> -->
<script src="js/jquery.contactable.js" charset="UTF-8"></script>


<?php

$qlocation = mysql_query("SELECT location_id, location_name FROM table_location");
			
			echo "<script charset='UTF-8'>";
			echo "locationObj = {";
			while($qloc = mysql_fetch_object($qlocation)){
				
				$obj .=  "'". $qloc->location_id . "'" . ":" . "'". $qloc->location_name . "'" . ",";

			}
			echo substr($obj,0,-1);
			echo  "};";
			
$qgroup = mysql_query("SELECT devgroup_id, devgroup_name FROM table_devgroup");
				
		
			echo "groupObj = {";
			while($qgrp = mysql_fetch_object($qgroup)){
				
				$objgrp .=  "'". $qgrp->devgroup_id . "'" . ":" . "'". $qgrp->devgroup_name . "'" . ",";
				
			}
			echo substr($objgrp,0,-1);
			echo  "};";
			
$qtype = mysql_query("SELECT devtype_id, devtype_name FROM  table_devtype");

			echo "typeObj = {";
	while($qtyp = mysql_fetch_object($qtype)){
				
				$objtyp .=  "'". $qtyp->devtype_id . "'" . ":" . "'". $qtyp->devtype_name . "'" . ",";
				
			}
			echo substr($objtyp,0,-1);
			echo  "};";
	
			echo "</script>";

?>

</script>
</head>

<?php

$q = @mysql_query("SELECT device_id AS 'DID'			
									, devtype_name AS 'TYPE'	
									, devgroup_name as 'GROUP'
									, device_name AS 'NAME'
									, device_version AS 'VERSION'
									, device_mac AS 'MAC'
									, device_udid AS 'UDID'
									, device_serial AS 'SERIAL'
									, location_name AS 'LOCATION'
									 
									FROM table_device, table_location, table_devtype, table_devgroup
									
									WHERE devtype_id = device_type_id
									AND devgroup_id = device_group_id
									AND location_id = device_location_id
									 
									ORDER BY device_type_id, device_group_id, device_name") or die ("UNABLE TO GET DEVICES");
									
?>

</div>

<div id="bodyContainer">

 <table id="deviceTable" name='deviceTable'>
		   <thead>
		  
				<th class= 'midHeader'>DID</th>
				<th class= 'tblTR'>TYPE</th>
				<th class= 'tblTR'>GROUP</th>
				<th class= 'tblTR'>NAME</th> 
				<th class= 'tblTR'>VERSION</th> 
				<th class= 'tblTR'>MAC</th> 
				<th class= 'tblTR'>UDID</th>
				<th class= 'tblTR'>SERIAL</th>
				<th class= 'tblTR'>LOCATION</th>
	   
		   </thead>
	   <tbody>

     <?php  while($query_row = @mysql_fetch_object($q))  {  ?>     
				
			<tr>
				<td class= 'mid'><?php echo $query_row->DID; ?></td>
				<td class= 'rhw'><?php echo $query_row->TYPE; ?></td>
				<td class= 'rhw '><?php echo $query_row->GROUP; ?></td>			   
				<td class= 'tdw '><?php echo $query_row->NAME; ?></td>
				<td class= 'tdw '><?php echo $query_row->VERSION; ?></td>
				<td class= 'tdw '><?php echo $query_row->MAC; ?></td>
				<td class= 'tdw '><?php echo $query_row->UDID; ?></td>
				<td class= 'tdw tdh'><?php echo $query_row->SERIAL; ?></td>			   
				<td class= 'tdw tdh'><?php echo $query_row->LOCATION; ?></td>			   
			</tr>       
       
	<?php
		   }
	?>
		
	 </tbody>
	</table>
	<table id="header-fixed"></table>
	</div>


</div><!-- end main container -->

<?php
if( $_SESSION['role'] < 3 ){
?>
                                <div id='createForm'>
								
                                                <table class="form" id="createTable">
																<tr>
																	<td style='text-align:center;height:16px;' colspan='3'>
																		<span id='indicator'>Record inserted succesfully.</span>
																	</td>
																</tr>
																
																	<td id='tcheck' class='sib'><img class='error' src='img/denied.gif'/> </td>
																			<td><strong>TYPE:</strong></td>
																					<td id='stime'>
																					
																								   <select id="type" name="type" class="cf" style='text-align:left;'>
																									   <option value="na">Select a Type</option>
																									   <option value="1">Browser</option>
																									   <option value="2">Phone</option>
																									   <option value="3">Tablet</option>
																									   <option value="4">Accessories</option>
																								   </select>
																								   
																					</td>
																							
                                                                </tr>			
																
																	<td id='tcheck' class='sib'><img class='error' src='img/denied.gif'/> </td>
																			<td><strong>GROUP:</strong></td>
																					<td id='stime'>
																					
																								   <select id="group" name="group" class="cf" style='text-align:left;'>
																									   <option value="na">Select a Group</option>
																									   <option value="1">Android</option>
																									   <option value="2">Apple</option>
																									   <option value="3">BlackBerry</option>
																									   <option value="4">Google</option>
																									   <option value="5">Microsoft</option>
																									   <option value="6">Mozilla</option>
																									   <option value="7">Other</option>
																									   <option value="8">Windows</option>																									   
																								   </select>
																								   
																					</td>
																	
                                                                </tr>			
																
																<tr>
																<td id='' class='sib'> <img class='error' src='img/denied.gif'/></td>
																		<td><strong>NAME:</strong></td>
																			
																			<td style='text-align:left  !important;'>
																				<input style="text-align:left" name="name" id="name" class="cf" size="50" maxlength='50' />
																			</td>
																								
                                                                </tr>
																
                                                                <tr>
																<td id='pcheck' class='sib'> <img class='error' src='img/denied.gif'/></td>
																		<td><strong>VERSION:</strong></td>

																			<td style='text-align:left  !important;'>
																				<input style="text-align:left" name="version" id="version" class="cf" size="50" maxlength='50' />
																			</td>
																								
                                                                </tr>

                                                                <tr>
																<td id='pcheck' class='sib'> <img class='error' src='img/denied.gif'/></td>
																		<td><strong>MAC:</strong></td>

																			<td style='text-align:left  !important;'>
																				<input style="text-align:left" name="mac" id="mac" class="cf" size="50" maxlength='50' />
																			</td>
																								
                                                                </tr>

                                                                <tr>
																<td id='pcheck' class='sib'> <img class='error' src='img/denied.gif'/></td>
																		<td><strong>UDID:</strong></td>

																			<td style='text-align:left  !important;'>
																				<input style="text-align:left" name="udid" id="udid" class="cf" size="50" maxlength='50' />
																			</td>
																								
                                                                </tr>

																<tr>
																<td id='pcheck' class='sib'> <img class='error' src='img/denied.gif'/></td>
																		<td><strong>SERIAL:</strong></td>

																			<td style='text-align:left  !important;'>
																				<input style="text-align:left" name="serial" id="serial" class="cf" size="50" maxlength='50' />
																			</td>
																	
                                                                </tr>
																
                                                                <tr>
																	<td id='tcheck' class='sib'><img class='error' src='img/denied.gif'/> </td>
																			<td><strong>LOCATION:</strong></td>
																					<td id='stime'>
																					
																								   <select id="deviceloc" name="deviceloc" class="cf" style='text-align:left;'>
																									   <option value="na">Select a Location</option>
																									   <option value="1">New York</option>
																									   <option value="2">London</option>
																									   <option value="3">Dhaka</option>
																									   <option value="4">Italy</option>
																								   </select>
																								   
																					</td>
																							
                                                                </tr>															
																
                                                                <tr>
																		<td colspan="3" style='padding:3px'>
																				<input type="reset"  id='cancel' value="Cancel" />
																				<input type="submit"   id='add' value="Add" />
																				<input type="submit"  id='addAnother' value="Add Another" />
																				<input type="submit" id='addSimilar' value="Add Similar" />
																		</td>
                                                                </tr>

                                                </table>
                                                
                                
                                </div>
		<?php
		}
		?>

<div id='iframeContainer'></div>								

<div id="logout-confirm" title="Log out?">
	<p>You will be logged out. Are you sure?</p>
</div>

<div id="loading" ><img src='img/3MA_loadingcontent.gif' /></div>

<div id='logged-out'>

<img src='img/awsnap.gif' />
Aw Snap, Looks like you have been logged out!
<br/>

</div>

<div id="contactable"></div>
<script charset="UTF-8">
///////////////////////////////////////////////session checker/////////////////////////////////////////////////////

function is_loggedin(a){if(a=="INVALID_SESSION"){$("#logged-out").dialog({height:300,width:400,modal:true,resizable:false});function b(){window.location.href=window.location.href}setTimeout(b,2e3);return false}else{return true}}
///////////////////////////////////////////////session checker/////////////////////////////////////////////////////
 
 //////DISABLE CR/LF IN FIELDS///////
$('#search').keypress(function() { return event.keyCode != 13; });
$('._filterText').keypress(function() { return event.keyCode != 13; });
 //////DISABLE CR/LF IN FIELDS///////

/////////////////////////////////////////////////////////////EDITING AJAX////////////////////////////////////////////////////////////

///////////STRIP TAGS//////////////////
function strip_tags(a,b){b=(((b||"")+"").toLowerCase().match(/<[a-z][a-z0-9]*>/g)||[]).join("");var c=/<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,d=/<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;return a.replace(d,"").replace(c,function(a,c){return b.indexOf("<"+c.toLowerCase()+">")>-1?a:""})}
///////////STRIP TAGS//////////////////

function editAjax(par){

	var parent = $(par).parent().parent();	 
	var did =$(parent).children("td:nth-child(1)").html();
	var type = $(parent).children("td:nth-child(2)").html();
	var group = $(parent).children("td:nth-child(3)").html();
	var name = encodeURIComponent($(parent).children("td:nth-child(4)").html());
	var version = encodeURIComponent($(parent).children("td:nth-child(5)").html());
	var mac = encodeURIComponent($(parent).children("td:nth-child(6)").html());
	var udid = encodeURIComponent($(parent).children("td:nth-child(7)").html());
	var serial = encodeURIComponent($(parent).children("td:nth-child(8)").html());
	var deviceloc = $(parent).children("td:nth-child(9)").html();

	 $.ajax({
			type: "GET",													  
			url: "action.php",													  
			cache: false,	
			async: true,
			data: "deviceEdit=true&did=" + did+ "&type=" + type + "&group=" + group + "&name=" + name + "&version=" + version + "&mac=" + mac + "&udid=" + udid + "&serial=" + serial + "&deviceloc=" + deviceloc + "&crypto=<?php echo session_id() . 'zLsX7795d1d5AsCsD3wFGv'; ?>"
			}).done(function( msg ) {
			
				if( is_loggedin(msg) ){					
						
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


/////////////////////////////////////////////////////////////ADD TESTCASE FIELDS VALIDITY///////////////////////////////////////////
		function cFieldsCheck(){
									
									$(".cf").each(function(){
									
											if( $.trim($(this).val()) && $.trim($(this).val()) !='na'){
													
													$(this).parent().siblings(':first').html("<img class='success' src='img/accept.gif'/>");											
											
											}else{
											
													$(this).parent().siblings(':first').html("<img class='error' src='img/denied.gif'/>");
											}
									
									});	  					
								 
									$(".cf").keyup(function(){
									
										
											
											if( $.trim($(this).val()) ){
													
													$(this).parent().siblings(':first').html("<img class='success' src='img/accept.gif'/>");											
											
											}else{
											
													$(this).parent().siblings(':first').html("<img class='error' src='img/denied.gif'/>");
											}
									
									
									});
									
								 	$(".cf").change(function(){
									
									
									
											if( $(this).val() != 'na' && $(this).val() != 'other450311'  && $.trim($(this).val()) ){
													
													
													
													$(this).parent().siblings(':first').first().html("<img class='success' src='img/accept.gif'/>");
											
											}else{
													
													if($(this).val() =='other450311' && $.trim($("#newfunction").val()) ){
														
														
														$(this).parent().siblings(':first').html("<img class='success' src='img/accept.gif'/>");
													
													}else{														
													
														$(this).parent().siblings(':first').html("<img class='error' src='img/denied.gif'/>");
													}
											}
									
									
									});	 
			
		}
 /////////////////////////////////////////////////////////////END ADD TESTCASE FIELDS VALIDITY///////////////////////////////////////////

/////////////////////////////////////////////////////////////CREATE/ADD/ADD SIMILAR/ADD ANOTHER BUTTONS VALIDATION///////////////////////////////////////////	
	
		function validCreate(){

				$("#add").attr("disabled","true");
				$("#addAnother").attr("disabled","true");
				$("#addSimilar").attr("disabled","true");									
				
				$('#group,#type,#deviceloc').change(function (){			
				
							
							if( $("#type").val() != 'na' &&  $("#group").val() != 'na' &&  $.trim($("#name").val()) !='' && $.trim($("#version").val()) !='' && $.trim($("#mac").val()) != '' && $.trim($("#udid").val()) != '' && $.trim($("#serial").val()) != '' && $("#deviceloc").val() != 'na'){
									
										//alert("not disabled");
										$("#add").removeAttr("disabled");
										$("#addAnother").removeAttr("disabled");
										$("#addSimilar").removeAttr("disabled");									

									}else{
											//alert("disabled");
											$("#add").attr("disabled","true");
											$("#addAnother").attr("disabled","true");
											$("#addSimilar").attr("disabled","true");									
									}				
				
					  });		
				
				
				 $('.cf').bind("keyup", function() {
						
						
							if( $("#type").val() != 'na' &&  $("#group").val() != 'na' &&  $.trim($("#name").val()) !='' && $.trim($("#version").val()) !='' && $.trim($("#mac").val()) != '' && $.trim($("#udid").val()) != '' && $.trim($("#serial").val()) != '' && $("#deviceloc").val() != 'na'){
									
										//alert("not disabled");
										$("#add").removeAttr("disabled");
										$("#addAnother").removeAttr("disabled");
										$("#addSimilar").removeAttr("disabled");									

									}else{
											//alert("disabled");
											$("#add").attr("disabled","true");
											$("#addAnother").attr("disabled","true");
											$("#addSimilar").attr("disabled","true");									
									}				
						
				
					  });			 
		}
		

/////////////////////////////////////////////////////////////END CREATE/ADD/ADD SIMILAR/ADD ANOTHER BUTTONS VALIDATION///////////////////////////////////////////		


////////////////////////////////////////////////////CLEAN CREATE FORM FIELDS////////////////////////////////////////////////////		
	function cleanCreate(){
		
			$("#type").val("na");
			$("#group").val("na");
			$("#name").val("");
			$("#version").val("");
			$("#mac").val("");
			$("#udid").val("");
			$("#serial").val("");
			$("#deviceloc").val("na");
			$("#createForm select").selectmenu('destroy');
			$("#createForm select").selectmenu({style: 'dropdown', maxHeight: 400});				
			cFieldsCheck();
			
		}	
////////////////////////////////////////////////////END CLEAN CREATE FORM FIELDS////////////////////////////////////////////////////	


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
									$('input#search').quicksearch('#deviceTable tbody tr');	
									
					}  			
					
							 seleEdit.onblur = function(){				

									var ms  = $("#mySelect option:selected").text();
									$(elem).html(ms);
										

					}  
							  seleEdit.onkeyup = function(){		
					  
								 	var ms  = $("#mySelect option:selected").text();
									$(elem).html(ms);																	
									editAjax(elem.childNodes[0]);		
									$('input#search').quicksearch('#deviceTable tbody tr');	
									
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
							$('input#search').quicksearch('#deviceTable tbody tr');	

						}				
			}			
			
		}//END EDIT ELEMENT	
		
////////////////////////////////////////////////////END OTHER ELEMENTS EDITING////////////////////////////////////////////////////				
	
////////////////////////////////////////////////////END SET SELECTED DROPDOWN OPTIONS////////////////////////////////////////////////////	

	$(document).ready(function() { 							
		
						$('#deviceTable').columnFilters();
							
						var hght = ($(".mid").length==0) ? 125 : 157;
							
							$('#deviceTable').fixheadertable({ 
								caption     : ' ', 
								colratio    : [1,100,115, 200, 200, 150, 300, 160, 100],
								height      : window.innerHeight - hght,
								zebra       : false,
								sortable    : true,
								sortedColId : 1, 
								sortType    : ['integer','string', 'string', 'string', 'string', 'string', 'string', 'string', 'string'],
								dateFormat  : 'm/d/Y',
								pager       : false,
								rowsPerPage : 100, 
								showhide       : true,
								whiteSpace     : 'normal',
								resizeCol	: true,
								addTitles      : true,
								minColWidth    : 75
								
							});   	

							///////////////////////////////////FIX PAGINATION PROBLEM///////////////////////////////////////////////////////
							$(".t_fixed_header_main_wrapper").append("<div id='pager'></div>");
							
							$("#pager").html("Total number of devices: " + $(".did").length) ;
							
				
							/////////////////////////////////////CREATE BUTTON/////////////////////////////////////////////////
							
							$(".t_fixed_header_caption").append("<div id='hNavBtn'><button id='addBtn'>Add Device</button></div>");
			
							$("#hNavBtn").css("float","right");

							$("#pager").append("<div id='searchForm'><form id='search-form' name='search-form' method='#' action='#' onsubmit='javascript:return false;'><input value='Search...' type='text' id='search' style='text-align: left !important;' name='search'></form></div>");
							
							$("#search").blur(function(){
									this.value = 'Search...';
							});		
							$("#search").focus(function(){
									this.value = '';
							});
							
							$("#navigation select").selectmenu({style: 'dropdown', maxHeight: 400});							
							$("#createForm select").selectmenu({style: 'dropdown',maxHeight: 400});								
							$('input:text, input:password').button().addClass('inpField');	
							
							$('#contactable').contactable();
							///////////////////////////////////END NEW UI JAVASCRIPT//////////////////////////////////////////////
							
							//////////////////////////////////CUSTOM COLUMN FILTERS//////////////////////////////////////////////////////
								columnFilter();		
							//////////////////////////////////CUSTOM COLUMN FILTERS//////////////////////////////////////////////////////
							
							//////////////////////////////////MAIN SEARCH///////////////////////////////////////////////////////////////////////////////
								$('input#search').quicksearch('#deviceTable tbody tr');							
							//////////////////////////////////END MAIN SEARCH//////////////////////////////////////////////////////////////////////
							
/					////////////////////////////////// ADD DEVICE BUTTON/////////////////////////////////////////////////////		
							

					$("#addBtn").click(function(){
					
					
								 $.ajax({
								type: "GET",													  
								url: "action.php",
								cache: false,													  
								data: "crypto=<?php echo session_id() . 'zLsX7795d1d5AsCsD3wFGv'; ?>",													  
								}).done(function( msg ) {
										
								if( is_loggedin(msg) ){								
										
											cFieldsCheck();
											$("#createForm tr").css("display","table-row");
											$("#createForm").css("display","block");
											$("#test").css("display","block");
											$("#indicator").css("display","none");
										
											$( "#createForm" ).dialog({
												
													height: 527,
													width: 800,
													modal: true,
													resizable: false
													
												});										
												
													$("#cancel").click(function(){
												
													$("#createForm").dialog( "close" );												
												
												});	 					
											
											validCreate();
											cleanCreate();
											

								}
						});				
										
										
		});
						
							///////////////////////////////////END ADD DEVICE BUTTON/////////////////////////////////////////////////////		

							deviceEdit();	
							cFieldsCheck();							
						
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
													  type: "POST",
													  url: "login_mod.php",
													  cache: false,
													  data: "kill=kill",
													}).done(function( msg ) {
													
														if( is_loggedin(msg) ){		
														
															if (msg == "true"){
															
																window.location.href ="http://10.10.40.16/xtable/login.php?logout=true";
																
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

								});
							///////////////////////////////////END LOGOUT FUNCTION///////////////////////////////////////////////////////////////////////	
								

			
		
			
			/////////////////////////////////////////////////////////////INSERT NEW DEVICE///////////////////////////////////////////	


		function addCreate(action){
		
				//VALID CREATE//
				validCreate();	
					
				////GLOBAL SEARCH REINITIALIZATION///
				$('input#search').quicksearch('table tbody tr');
				
				
				////INSERT RECORD TO THE DATABASE////			
				 $.ajax({
					type: "GET",													  
					url: "action.php",
					cache: false,													  
					data: "cDevice=true&type=" + encodeURIComponent($("#type").val()) + "&group=" + encodeURIComponent($("#group").val())+ "&name=" + encodeURIComponent($("#name").val()) + "&version=" + encodeURIComponent($("#version").val()) + "&mac=" + encodeURIComponent($("#mac").val()) + "&udid=" + encodeURIComponent($("#udid").val()) + "&serial=" + encodeURIComponent($("#serial").val()) + "&deviceloc=" + encodeURIComponent($("#deviceloc").val()) + "&crypto=<?php echo session_id() . 'zLsX7795d1d5AsCsD3wFGv'; ?>",													  
					}).done(function( msg ) {
					
						if( is_loggedin(msg) ){	

								var myObj =  jQuery.parseJSON(msg);

									if(myObj.code == '200'){
																
										$("#indicator").css("display","block");					
										
											$("#indicator").fadeOut(2000, function(){											
											
											//VALID CREATE BUTTONS
											validCreate();
												
												if(action == "close"){
												
													$("#createForm").dialog( "close" ); 												
													
												}
												
												if(action == 'aa'){
																
													$("#createForm select").selectmenu('destroy');
													$("#createForm select").selectmenu({style: 'dropdown', maxHeight: 400});															

													cleanCreate();												
												
												}										
												
												if(action == 'as'){

													$("#createForm select").selectmenu('destroy');
													$("#createForm select").selectmenu({style: 'dropdown', maxHeight: 400});	
													
												}
										
										});
										 
										$("input").removeClass("ui-state-hover");								
										
										/////////////////////////////////////Insert into  table info///////////////////////////////////

										/*
										
										$('#deviceTable tbody').prepend('<tr><td class="mid ui-widget-content">' + myObj.mysql_last_id + '</td><td style="text-transform:uppercase;" ondblclick="javascript:editElement(this,locationObj,true,75);" class=" function rhw ui-widget-content" style="text-align:center;">' + custFunction + '</td><td ondblclick="javascript:editElement(this,statusObj,false,8);" class="tdw center ui-widget-content"  style="text-align:center;">' + 	$("#status option:selected").text() + '</td><td ondblclick="javascript:editElement(this,locationObj,true,5);" class="tdw center  ui-widget-content"  style="text-align:center;">' +	defaultTCID	 + '</td><td ondblclick="javascript:editElement(this,locationObj,false,8);" class="tdw center ui-widget-content"  style="text-align:center;">' + 	$("#priority option:selected").text() + '</td><td ondblclick="javascript:editElement(this,classObj,false,25);"  class="tdw center  ui-widget-content"  style="text-align:center;">' + $("#class option:selected").text() + '</td><td  ondblclick="javascript:editElement(this,locationObj,false,100);"  class="tdw center  ui-widget-content"  style="text-align:left;">' +$("#testname").val()+'</td><td  ondblclick="javascript:editSV(this);"  class="tdw tdh  ui-widget-content"><pre>' +  strip_tags($("#preConditions").val(), '<i><b>') +'</pre></td><td ondblclick="javascript:editSV(this);" class="tdw tdh  ui-widget-content"><pre>'+ 	strip_tags($("#scenario").val(), '<i><b>') +'</pre></td><td  ondblclick="javascript:editSV(this);" class="tdw tdh  ui-widget-content"><pre>'+   strip_tags($("#verification").val(), '<i><b>')	+'</pre></td></tr>');	

										*/

										$('input#search').quicksearch('#deviceTable tbody tr');


								}else{
									
											alert("Error contacting server");						
											$("#add").click(function(){ $("#createForm").dialog( "close" ); });
											
								} 
								
						}		
				
				});	 
				
		}
	
			/////////////////////////////////////////////////////////////END INSERT NEW TESTCASE//////////////////////////////////////////
			/////////////////////////////////////////ADD NEW / SIMILAR / ANOTHER////////////////////////////////////	
							
							$("#add").click(function(){addCreate("close"); });	
								
							$("#addAnother").click(function(){addCreate("aa"); });	
							
							$("#addSimilar").click(function(){addCreate("as"); });	
							
							
				/////////////////////////////////////////END ADD NEW / SIMILAR / ANOTHER//////////////////////////////////	


 
		$("#loading").ajaxStart(function(){	$(this).show(); });			
		$("#loading").ajaxStop(function(){	$(this).hide(); });
		
		
		$("#_filterText1").click(function(){
				
			$(this).val("");

		});
		
		$("#_filterText1").blur(function(){
				
			$(this).val("Search-->");

		});
		
			
		$("#_filterText1").val("Search-->");		
				
					
				$("#welcome").html("Welcome, <?php echo $_SESSION['fname']; ?>");
				$('#switcher').themeswitcher();
				

			
	}); //DOM Ready
	
							
						
	

</script>



</body>
</html>