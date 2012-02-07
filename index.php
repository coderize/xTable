<?php 
header("Content-type: text/html; charset=utf-8");  
error_reporting(E_ALL ^ E_NOTICE);
require "includes/config.php"; 
require "includes/sess.php";
session_start();

 if( !$_SESSION['fname'] ){
	echo "Error, you need to login first";
	header('Refresh: 1; URL=http://10.10.40.16/xtable/login.php');
	exit;
} 

$vert = mysql_real_escape_string($_GET['vertical']);
$client = mysql_real_escape_string($_GET['client']);
$project = mysql_real_escape_string($_GET['project']);

?>
<!DOCTYPE html>
<html>
<head>
<title>UsableX - xTable</title>
<meta http-equiv="Content-Encoding" content="gzip">
<meta http-equiv="Accept-Encoding" content="gzip, deflate">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

<style>
body,pre{font-family:Verdana,Helvetica,san-serif,Arial;font-size:.6em}*{padding:0;margin:0}.clearfix:after{content:".";display:block;clear:both;visibility:hidden;line-height:0;height:0}.clearfix{display:inline-block}html[xmlns] .clearfix{display:block}* html .clearfix{height:1%}#createForm,#iframeContainer{display:none}#mainContainer{padding-top:5px;min-width:960px;max-width:1500px;position:relative}.inpFields{font:inherit;color:inherit;outline:0;cursor:text}pre{font-size:1em;white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word}#search{margin-left:35%;margin-top:-15px;display:none;border:3px solid #7aa3cc;width:350px;height:20px;border-radius:15px;-webkit-border-radius:15px;border-top-right-radius:15px;border-top-left-radius:15px;border-bottom-right-radius:15px;border-bottom-left-radius:15px;font-size:1.2em}.dragging{border:2px solid #0f0}._filterText{width:99%;height:20px;font-style:italic;background-color:#f0f0f0;border-width:1px;font-size:14px!important}#navigation a{float:left}#navigation{/* position:relative;height:100px */}#navigation #vertical-button,#client-button,#project-button{margin-left:5px!important}#bodyContainer{z-index:1000;position:relative}#execIframe{width:99%;height:97%}#createForm select{width:200px}#class-menu,#priority-menu,#function-menu{z-index:2000}#createForm textarea{max-width:630px;min-width:320px;max-height:95px;width:630px;height:95px}#logout{margin:4px 0 0 30%;display:none}#myAcc{position:absolute;top:0;right:17%;height:30px;font-weight:bold;width:152px}#accChild{display:none}#logout-confirm{display:none}#other{background-color:#ccc}#indicator{font-size:14px;color:#7ec045;font-weight:bold}#loading{display:none;position:absolute;top:41%;left:44%;z-index:10000}#editSuccess{display:none;position:absolute;top:5px;left:44%;z-index:10000;font-size:20px;color:#3d5;font-weight:bold}#account{width:152px}.myAccOpen{border-radius:10px;height:145px!important;background-color:#fff;z-index:1002;border-right:2px solid #ccc;border-left:2px solid #ccc;border-bottom:2px solid #ccc}#switcher{margin-top:3px}.function,.tcid,.priority,.class,.status{text-align:center!important}#pager{height:35px;padding:5px;font-weight:bold}#graph{width:100%;height:550px;border:0}#graph-all{position:absolute;top:165px;z-index:1;width:99%;overflow:hidden;height:500px;visibility:hidden}#graph-controls{position:relative;margin-top:20px}#up{position:absolute;left:400px;top:0}.ui-selectmenu-menu{z-index:3000}#navBtns{position:absolute;bottom:0}#logged-out{display:none;text-align:center;font-size:1.3em}#logged-out img{display:block;margin:0 auto;padding:60px 0 5px 0}



#naviForm{
	display:none;

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
#welcome{
	font-size:14px;
	margin: 5px 0px 20px 0px;
	display:block;
}

</style>

<link rel="stylesheet" type="text/css" href="css/base.css" />
<link rel="stylesheet" type="text/css" href="css/flick/jquery-ui-1.8.16.custom.css" />
<link rel="stylesheet" type="text/css" href="css/selectmenu.css" />
<!-- <link rel="stylesheet" type="text/css" href="css/calendar.css" /> -->
<link rel="stylesheet" type="text/css" href="css/contactable.css" />

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
<script src="js/jquery.validate.pack.js" charset="UTF-8"></script>


<?php
	if( $_SESSION['role'] != 5 &&  $_SESSION['role'] != 4){
?>

<script src="js/addEdit.js" charset="UTF-8"></script>
<?php
}
?>
<?php
$qpriority = mysql_query("SELECT priority_id, priority_name FROM table_priority");
			
			echo "<script charset='UTF-8'>";
			echo "priorityObj = {";
			while($qpri = mysql_fetch_object($qpriority)){
				
				$obj .=  "'". $qpri->priority_id . "'" . ":" . "'". $qpri->priority_name . "'" . ",";

			}
			echo substr($obj,0,-1);
			echo  "};";
			

			
$qclass = mysql_query("SELECT class_id, class_name FROM table_class");
				
		
			echo "classObj = {";
			while($qcla = mysql_fetch_object($qclass)){
				
				$objcl .=  "'". $qcla->class_id . "'" . ":" . "'". $qcla->class_name . "'" . ",";
				
			}
			echo substr($objcl,0,-1);
			echo  "};";
			
			
$qstatus = mysql_query("SELECT status_id, status_name FROM  table_status");

			echo "statusObj = {";
	while($qs = mysql_fetch_object($qstatus)){
				
				$objst .=  "'". $qs->status_id . "'" . ":" . "'". $qs->status_name . "'" . ",";
				
			}
			echo substr($objst,0,-1);
			echo  "};";
	
			
			echo "</script>";

?>

</head>

<body id="bod">
<?php 

	$verts = mysql_query("SELECT vertical_id, vertical_name FROM table_vertical WHERE vertical_id < 7 ORDER BY vertical_name ASC");	
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

<?php
		
		
		
?>		
		<select name='project' id='project' onchange="javascript:reload();">	
		<option value=''>Project Selection</option>
<?php				
				$projects = mysql_query("SELECT project_id, project_name
 
															FROM table_project, table_client, table_vertical, table_relation
															 
															WHERE vertical_id = r_vertical
															AND vertical_id = '{$vert}'
															AND client_id = r_client
															AND client_id = '{$client}'
															AND project_id = r_project
															 
															GROUP BY project_id
															ORDER BY project_name ASC															
															");
		
				while($qprojects = mysql_fetch_object($projects)){
?>			
					
				<option value="<?php echo $qprojects->project_id; ?>"><?php echo $qprojects->project_name; ?></option>
				
				
<?php
				}
	
				
		
?>

	</select>

</form>


<?php 
////////////////////////////TODO: CHECK VALID SELECTIONS FIRST/////////////////////////////////////////////////////////////////
$iq = @mysql_query("SELECT relation_id AS rel
												FROM table_relation, table_vertical, table_client, table_project
												
												WHERE r_vertical =  '{$vert}'
												AND r_client =  '{$client}'
												AND r_project =  '{$project}'
												
												GROUP BY relation_id 
												LIMIT 1"); //or die("UNABLE TO GET REL");
$iq = mysql_fetch_object($iq);									

if( $_SESSION['role'] != 5 && $_SESSION['role'] != 4  ){
											
/////////////////////////////////////////////////////NOT SE AND PM/////////////////////////////////////////////////
$q = @mysql_query("SELECT manual_function_name AS 'FUNCTION'			
									, manual_id as 'MID'	
									, status_name as 'STATUS'
									, manual_tcid AS 'TCID'
									, priority_name AS 'PRIORITY'
									, class_name AS 'CLASS'
									, manual_name AS 'NAME'
									, manual_prereq AS 'PREREQUISITE'
									, manual_steps AS 'SCENARIO'
									, manual_expected AS 'VERIFICATION'
									 
									FROM table_manual, table_class, table_relation, table_priority, table_status
									 
									WHERE manual_relation_id = {$iq->rel}
									AND manual_relation_id = relation_id
									AND manual_class_id = class_id
									AND manual_priority_id = priority_id
									AND manual_status = status_id
									AND manual_status <>  4
									
									ORDER BY status_name, manual_tcid
								
									"); //or die ("UNABLE TO GET TESTCASES");
/////////////////////////////////////////////////////NOT SE AND PM/////////////////////////////////////////////////
}else{
/////////////////////////////////////////////////////GET ALL TYPES OF TESTCASES/////////////////////////////////////////////////
$q = @mysql_query("SELECT manual_function_name AS 'FUNCTION'			
									, manual_id as 'MID'	
									, status_name as 'STATUS'
									, manual_tcid AS 'TCID'
									, priority_name AS 'PRIORITY'
									, class_name AS 'CLASS'
									, manual_name AS 'NAME'
									, manual_prereq AS 'PREREQUISITE'
									, manual_steps AS 'SCENARIO'
									, manual_expected AS 'VERIFICATION'
									 
									FROM table_manual, table_class, table_relation, table_priority, table_status
									 
									WHERE manual_relation_id = {$iq->rel}
									AND manual_relation_id = relation_id
									AND manual_class_id = class_id
									AND manual_priority_id = priority_id
									AND manual_status = status_id
									AND manual_status < 3
									
									
									ORDER BY status_name, manual_tcid
								
									"); //or die ("UNABLE TO GET TESTCASES");
/////////////////////////////////////////////////////GET ALL TYPES OF TESTCASES/////////////////////////////////////////////////
}


?>


<!--
<div id='myAcc'>

	<button name='account' id='account'><?php echo $_SESSION['fname'] . "'s Account"; ?></button>
		<div id='accChild'>
			
		</div>
		
		<button>Generate Report</button>
		
		<button>Generate PDF</button>
		

		
</div>-->


</div><!-- end navigation -->

<div id="bodyContainer" style="visibility:hidden;">




 <table id="myTable" name='myTable'>
       <thead>
      
		<th class='midHeader'>MID</th>
		<th class='tblTR'>FUNCTION</th>
		<th class='tblTR'>STATUS</th>
		<th class='tblTR'>TCID</th> 
		<th class='tblTR'>PRIORITY</th> 
		<th  class='tblTR'>CLASS</th> 
		<th  class='tblTR'>NAME</th> 
		<th  class='tblTR'>PREREQUISITE</th>
		<th  class='tblTR'>SCENARIO</th>
		<th  class='tblTR'>VERIFICATION</th>
   
       </thead>
	   <tbody>

     <?php  while($query_row = @mysql_fetch_object($q))  {    ?>     
				
			<tr>
				<td class='mid'><?php echo $query_row->MID; ?></td>
			   <td  class= 'rhw'><?php echo $query_row->FUNCTION; ?></td>
			   <td  class= 'rhw center'><?php echo $query_row->STATUS; ?></td>			   
			   <td class= 'tdw center'><?php echo $query_row->TCID; ?></td>
			   <td class= 'tdw center'><?php echo $query_row->PRIORITY; ?></td>
			   <td class= 'tdw center'><?php echo $query_row->CLASS; ?></td>
			   <td class= 'tdw center'><?php echo $query_row->NAME; ?></td>
			  
			  <td class= 'tdw tdh'><pre><?php echo strip_tags($query_row->PREREQUISITE); ?></pre></td>			   
			   <td  class= 'tdw tdh'><pre><?php echo strip_tags($query_row->SCENARIO); ?></pre></td>			   
			   <td  class= 'tdw tdh'><pre><?php echo strip_tags($query_row->VERIFICATION); ?></pre></td>		
			</tr>       
       
<?php
	   }
    ?>
		
	 </tbody>
	</table>
	<table id="header-fixed"></table>
	</div>


</div><!-- end main container -->



                                <div id='createForm'>
								
                                                <table class="form" id="createTable">
															<tr>
																<td style='text-align:center;height:16px;' colspan='3'>
																	<span id='indicator'>Record inserted succesfully.</span>
																</td>
															</tr>
                                                                <tr>
																<td id='fcheck' class='sib'> <img class='error' src='img/denied.gif'/></td>
                                                                                <td><strong>Function:</strong></td>
                                                                                                <td style='text-align:left !important;'>
                                                                                                              
																											
																															<select id="function" name="function" class="cf pauser" style="width:310px;">
																															
																																<option>default</option>
																															
																															</select>
																												
                                                                                                </td>
                                                                </tr>
																
																       <tr>
																	   <td id='tcheck' class='sib'> <img class='error' src='img/denied.gif'/></td>
                                                                                <td><strong>TCID:</strong></td>
                                                                                                <td style='text-align:left  !important;'>
                                                                                                                <input style="text-align:left" name="tcid" id="tcid" class="cf pauser" size="10" maxlength='5' readonly='readonly' />
                                                                                                </td>
																								
                                                                </tr >
																
																     <tr>
																<td id='' class='sib'> <img class='error' src='img/denied.gif'/></td>
                                                                                <td><strong>Status:</strong></td>
                                                                                                <td>
																								
                                                                                                               <select id="status" name="status" class="cf" style='text-align:left;'>
																											   
																												   <option value="na">Select a Status</option>
																												   <option value="1">Live</option>
																												   <option value="2">Demo</option>
																												   <option value="3">In-Progress</option>
																												</select>
																											   
																										
																											   
                                                                                                </td>
																								
                                                                </tr>
                                                                <tr>
																<td id='pcheck' class='sib'> <img class='error' src='img/denied.gif'/></td>
                                                                                <td><strong>Priority:</strong></td>
                                                                                                <td id='stime'>
																								
                                                                                                               <select id="priority" name="priority" class="cf" style='text-align:left;'>
																												   <option value="na">Select a Priority</option>
																												   <option value="1">Critical</option>
																												   <option value="2">High</option>
																												   <option value="3">Medium</option>
																												   <option value="4">Low</option>
																											   </select>
																											   
																										
																											   
                                                                                                </td>
																								
                                                                </tr>

                                                                <tr>
																<td id='ccheck' class='sib'> <img class='error' src='img/denied.gif'/></td>
                                                                                <td><strong>Class:</strong></td>
                                                                                                <td id='etime'>
																								
																											<select id="class" name="class" class="cf" style='text-align:left;'>
																												<option value="na">Select a Class</option>
																												<option value="1">Data Handling</option>																												
																												<option value="3">Exception Handling</option>
																												<option value="4">Functional</option>																												
																												<option value="6">Performance</option>
																												<option value="7">Boundary</option>
																												<option value="8">UI</option>
																												<option value="9">Usability</option>
																											</select>
																											
                                                                                                                 
                                                                                                </td>
																								
                                                                </tr>

                                                                <tr>
																	<td id='tcheck' class='sib'><img class='error' src='img/denied.gif'/> </td>
                                                                                <td><strong>Test Name:</strong></td>
                                                                                                <td style='text-align:left  !important;'>
                                                                                                      <input style="text-align:left" name="testname" id="testname" size="50"  class="cf pauser"/>
                                                                                                </td>
																							
                                                                </tr>															
																
																
                                                                <tr>
																<td id='pccheck' class='sib'> <img class='error' src='img/denied.gif'/></td>
                                                                                <td><strong>Pre-Conditions:</strong></td>
                                                                                                <td>
                                                                                                                <textarea style='height:75px;' cols="50" rows="5" name="preConditions" id="preConditions"  class="cf pauser"></textarea>
                                                                                                </td>
																								
                                                                </tr>

                                                                <tr>
																<td id='scheck' class='sib'><img class='error' src='img/denied.gif'/> </td>
                                                                                <td><strong>Scenario:</strong></td>
                                                                                                <td>
                                                                                                                <textarea cols="50" rows="5" name="scenario" id="scenario"  class="cf pauser"></textarea>
                                                                                                </td>
																								
                                                                </tr>

                                                                <tr>
																<td id='vcheck' class='sib'><img class='error' src='img/denied.gif'/> </td>
                                                                                <td><strong>Verification:</strong></td>
                                                                                                <td>
                                                                                                                <textarea cols="50" rows="5" name="verification" id="verification"  class="cf pauser"></textarea>
                                                                                                </td>
																								
                                                                </tr>

                                                                <tr>
                                                                                <td colspan="3" style='padding:3px'>
                                                                                                <input type="reset"  id='cancel' value="Cancel" />
                                                                                                <input type="submit"   id='add' value="Add" />
                                                                                                <input type="submit"  id='addAnother' value="Add Another" />
                                                                                                <input type="submit" id='addSimilar' value="Add Similar" />
																								<span id='sCreateTime' class='createTime' style='visibility:hidden'></span>
																								<span id='eCreateTime' class='createTime' style='visibility:hidden'></span>
																								<span id='pauseIni' class='' style='visibility:hidden'></span>
																								<span id='pauseCur' class='' style='visibility:hidden'></span>
																								<span id='pauseDur' class='' style='visibility:hidden'></span>
																								<span id='pauseTotalDur' class='' style='visibility:hidden'></span>
																								<span id='pauseCount' class='' style='visibility:hidden'></span>
                                                                                </td>
                                                                </tr>

                                                </table>
                                                
                                
                                </div>
								
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

//////////////////////////////////////PAUSER FUNCTION////////////////////////////////////////////////////
function pauser(){function a(){var a=Math.round(+(new Date)/1e3);return a}$("#pauseIni").html(a());$("#pauseCur").html("0");$("#pauseDur").html("0");$("#pauseTotalDur").html("0");$("#pauseCount").html("0");$(".pauser, #addSimilar, #addAnother, #add").bind("click keyup",function(){$("#pauseCur").html(a());var b=parseInt($("#pauseIni").html());var c=parseInt($("#pauseCur").html());var d=c-b;$("#pauseDur").html(d);var e=300;if(d<e){$("#pauseIni").html($("#pauseCur").html());validCreate()}else{var f=parseInt($("#pauseTotalDur").html());var f=f==0?d:f+d;var g=parseInt($("#pauseCount").html());var g=g==0?1:g+1;$("#pauseIni").html($("#pauseCur").html());$("#pauseTotalDur").html(f);$("#pauseCount").html(g)}})}
//////////////////////////////////////END PAUSER FUNCTION////////////////////////////////////////////////////

 /////////////////////////////////////////////////////////////HOME DROPDOWNS -VCP///////////////////////////////////////////
function reload(){ddvert=document.getElementById("hvertical");ddclient=document.getElementById("hclient");ddproject=document.getElementById("hproject");vertpath="index.php?vertical="+ddvert.value;window.location=vertpath;clientpath=vertpath+"&client="+ddclient.value;window.location=clientpath;projectpath=clientpath+"&project="+ddproject.value;window.location=projectpath}
 /////////////////////////////////////////////////////////////END HOME DROPDOWNS -VCP///////////////////////////////////////////	
 
 //////DISABLE CR/LF IN FIELDS///////
$('#search').keypress(function() { return event.keyCode != 13; });
$('._filterText').keypress(function() { return event.keyCode != 13; });
 //////DISABLE CR/LF IN FIELDS///////

/////////////////////////////////////////////////////////////JAVASCRIPT COOKIES///////////////////////////////////////////
function setCookie(a,b,c){var d=new Date;d.setDate(d.getDate()+c);var e=escape(b)+(c==null?"":"; expires="+d.toUTCString());document.cookie=a+"="+e}function getCookie(a){var b,c,d,e=document.cookie.split(";");for(b=0;b<e.length;b++){c=e[b].substr(0,e[b].indexOf("="));d=e[b].substr(e[b].indexOf("=")+1);c=c.replace(/^\s+|\s+$/g,"");if(c==a){return unescape(d)}}}
/////////////////////////////////////////////////////////////END JAVASCRIPT COOKIES//////////////////////////////////

/////////////////////////////////////////////////////////////EDITING AJAX////////////////////////////////////////////////////////////
<?php
	if( $_SESSION['role'] != 5 &&  $_SESSION['role'] != 4){
?>	
///////////STRIP TAGS//////////////////
function strip_tags(a,b){b=(((b||"")+"").toLowerCase().match(/<[a-z][a-z0-9]*>/g)||[]).join("");var c=/<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,d=/<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;return a.replace(d,"").replace(c,function(a,c){return b.indexOf("<"+c.toLowerCase()+">")>-1?a:""})}
///////////STRIP TAGS//////////////////

function editAjax(par){

	var parent = $(par).parent().parent();	 
	var mid =$(parent).children("td:nth-child(1)").html();
	var func = encodeURIComponent($(parent).children("td:nth-child(2)").html());
	var status =$(parent).children("td:nth-child(3)").html();
	var tcid = $(parent).children("td:nth-child(4)").html();
	var priority = $(parent).children("td:nth-child(5)").html();
	var clas = $(parent).children("td:nth-child(6)").html();
	var name = encodeURIComponent($(parent).children("td:nth-child(7)").html());
	var prereq = encodeURIComponent($(parent).children("td:nth-child(8)").children("pre:nth-child(1)").html());
	var steps = encodeURIComponent($(parent).children("td:nth-child(9)").children("pre:nth-child(1)").html());
	var expected = encodeURIComponent($(parent).children("td:nth-child(10)").children("pre:nth-child(1)").html());

	 $.ajax({
			type: "GET",													  
			url: "action.php",													  
			cache: false,	
			async: true,
			data: "tableEdit=true&mid="+mid+"&func="+func+"&status="+status+"&tcid="+tcid+"&priority="+priority+"&clas="+clas+"&name="+name+"&prereq="+prereq+"&steps="+steps+"&expected="+expected+"&crypto=<?php echo session_id() . 'zLsX7795d1d5AsCsD3wFGv'; ?>"
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
				
				$('#priority,#class,#function,#status').change(function (){			

					if( $("#function").val() == "other450311"){
								
									var fval = $("#newfunction").val();
								
								}else{
								
									var fval = $("#function").val();
								}				
			
							
							if( $("#priority").val() != 'na' &&  $("#class").val() != 'na' &&  $.trim($("#status").val()) !='na' && $.trim(fval) != 'na' && $.trim(fval) !='' && $("#tcid").val() != '' && $.trim($("#testname").val()) != '' && $.trim($("#preConditions").val()) != '' && $.trim($("#scenario").val()) != '' && $.trim($("#verification").val()) != ''){
									
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
				
				
				 $('.cf').bind("keyup click", function() {
						
						
						if( $("#function").val() == "other450311"){
									
										var fval = $("#newfunction").val();
									
									}else{
									
										var fval = $("#function").val();
									}				
				
				
									
					if( $("#priority").val() != 'na' &&  $("#class").val() != 'na' && $.trim(fval) != 'na' && $.trim($("#status").val()) !='na' && $.trim(fval) !='' && $.trim($("#tcid").val()) != '' && $.trim($("#testname").val()) != '' && $.trim($("#preConditions").val()) != '' && $.trim($("#scenario").val()) != '' && $.trim($("#verification").val()) != ''){
									
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

/////////////////////////////////////////////////////////////TCID LOGIC /////////////////////////////////////////////////////////////////////	
	
 $("#function").change(function(){	

			if( $("#newfunction").val() ){
			
				var custFunction = $("#newfunction").val();
				
			}else{
			
				var custFunction = $("#function").val();
			}
				cFieldsCheck();
				validCreate();
				
				if( $(this).val() == "other450311") {

							$.ajax({
								type: "GET",													  
								url: "action.php",													  
								cache: false,	
								async: false,
								data: "othertcid=true&rel=<?php echo $iq->rel; ?>"+"&crypto=<?php echo session_id() . 'zLsX7795d1d5AsCsD3wFGv'; ?>"											  
								}).done(function( msg ) {							
								
								if( is_loggedin(msg) ){	
								
									if(msg){
									
										$("#tcid").val(msg);
										$("#tcid").change();									
										cFieldsCheck();
										validCreate();										
									}
								}
								
							});		

				}else if( $(this).val() != 'na' && $(this).val() !='other450311' ){
						
					$.ajax({
								type: "GET",													  
								url: "action.php",													  
								cache: false,	
								async: false,
								data: "newtcid=true&funcname="+ custFunction +"&rel=<?php echo $iq->rel; ?>"+"&crypto=<?php echo session_id() . 'zLsX7795d1d5AsCsD3wFGv'; ?>"											  
								}).done(function( msg ) {
								
								if( is_loggedin(msg) ){	
								
									$("#tcid").val(msg);	
									$("#tcid").change();
									cFieldsCheck();					
									validCreate();
									
								}
									
							});
				
				
				
				}

});
 
	

/////////////////////////////////////////////////////////////END TCID LOGIC /////////////////////////////////////////////////////////////////////		

////////////////////////////////////////////////////CLEAN CREATE FORM FIELDS////////////////////////////////////////////////////		
	function cleanCreate(){
		
			$("#function").val("");
			$("#tcid").val("");
			$("#status").val("");
			$("#priority").val("na");
			$("#class").val("na");
			$("#testname").val("");
			$("#preConditions").val("");
			$("#scenario").val("");
			$("#verification").val(""); 
			$("#createForm select").selectmenu('destroy');
			$("#createForm select").selectmenu({style: 'dropdown', maxHeight: 400});				
			$("#newfunction").remove();		
			cFieldsCheck();
			
		}	
////////////////////////////////////////////////////END CLEAN CREATE FORM FIELDS////////////////////////////////////////////////////	

////////////////////////////////////////////////////SCENARIO / VERIFICATION EDITING////////////////////////////////////////////////////	
	
								function editSV(ele){				
													
														$("<textarea id='myTextarea'></textarea>").html(ele.childNodes[0].innerHTML).appendTo("body");

														 $( "#myTextarea" ).dialog({
										
																						autoOpen: true,
																						height: 500,
																						width: 800,
																						modal: true,
																						title: 'Modify',
																						resizable: false,
																						buttons: { "Save": function() {
																						
																									ele.childNodes[0].innerHTML = strip_tags($("#myTextarea").val(), '<i><b>');																
																									
																									editAjax(ele.childNodes[0]);																										
																										
																									$("#myTextarea").remove();																									
																									$(this).dialog("close"); 																									
																								
																								},"Cancel":function(){
																							
																										$("#myTextarea").remove();
																									}																								
																						},
																						close: function(event, ui) {
																									$("#myTextarea").remove();
																							

																						}
																						
																		});	


														$("#myTextarea").css("width","780px");
														$("#myTextarea").css("height","450px");
														$("#myTextarea").css("max-width","780px");
														$("#myTextarea").css("max-height","450px");
														$("#myTextarea").css("font-size","1.2em");

													 
								}//END EDITSV
	
////////////////////////////////////////////////////END SCENARIO / VERIFICATION EDITING////////////////////////////////////////////////////	

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
									
					}  			
					
							 seleEdit.onblur = function(){				

									var ms  = $("#mySelect option:selected").text();
									$(elem).html(ms);
										

					}  
							  seleEdit.onkeyup = function(){		
					  
								 	var ms  = $("#mySelect option:selected").text();
									$(elem).html(ms);																	
									editAjax(elem.childNodes[0]);		
									
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

						}				
			}			
			
		}//END EDIT ELEMENT	
		
<?php
}
?>	
////////////////////////////////////////////////////END OTHER ELEMENTS EDITING////////////////////////////////////////////////////				
	
////////////////////////////////////////////////////SET SELECTED DROPDOWN OPTIONS////////////////////////////////////////////////////			
	document.getElementById("vertical").value = "<?php  echo $vert;  ?>";		
		
	document.getElementById("client").value = "<?php  echo $client;  ?>";
	
	<?php echo $client;  if($client == ''){ $project = "na";} ?>
	
	document.getElementById("project").value = "<?php  echo $project;  ?>";	

////////////////////////////////////////////////////END SET SELECTED DROPDOWN OPTIONS////////////////////////////////////////////////////	

	$(document).ready(function() 
		{ 							
		
						$('#myTable').columnFilters();
							
						var hght = ($(".mid").length==0) ? 125 : 157;
							
							$('#myTable').fixheadertable({ 
								caption     : ' ', 
								colratio    : [1,150,80, 65, 78, 140,150, 150, 260, 260],
								height      : window.innerHeight - hght,
								zebra       : false,
								sortable    : true,
								sortedColId : 2, 
								sortType    : ['integer','string', 'string', 'integer', 'string', 'string', 'string', 'string', 'string', 'string'],
								dateFormat  : 'm/d/Y',
								pager       : false,
								rowsPerPage : 100, 
								showhide       : true,
								whiteSpace     : 'normal',
								resizeCol	: true,
								addTitles      : true,
								minColWidth    : 75
								
							});   	
														
							//////////////////////////////////DRAG AND DROP/////////////////////////////////////////////////////////////////////////
								//$("#myTable").tableDnD( { onDragClass: "dragging"} );	
							//////////////////////////////////END DRAG AND DROP////////////////////////////////////////////////////////////////		

							///////////////////////////////////FIX PAGINATION PROBLEM///////////////////////////////////////////////////////
							$(".t_fixed_header_main_wrapper").append("<div id='pager'></div>");
							
							$("#pager").html("Total number of testcases: " + $(".mid").length) ;
							
							///////////////////////////////////NEW UI JAVASCRIPT//////////////////////////////////////////////
		
							
							$(".t_fixed_header_caption").prepend( "<div id='hnav'><select name='hvertical' id='hvertical' onchange='javascript:reload();'>" + $("#vertical").html() + "</select> <select name='hclient' id='hclient' onchange='javascript:reload();'>"+$("#client").html()+"</select>"+" <select name='hproject' id='hproject' onchange='javascript:reload();'>" + $("#project").html() + "</select></div>" );
							
							$("#hnav").css("float","left");
								
							$(".t_fixed_header_caption").append("<div id='hNavBtn'><button id='addBtn'>Create Testcase</button><button id='execBtn'>Execute</button></div>");
							
							$("#hNavBtn").css("float","right");
								
								
								document.getElementById("hvertical").value = "<?php  echo $vert;  ?>";
								document.getElementById("hclient").value = "<?php  echo $client;  ?>";
								document.getElementById("hproject").value = "<?php  echo $project;  ?>";
							
								
							
							$("#pager").append("<div id='searchForm'><form id='search-form' name='search-form' method='#' action='#' onsubmit='javascript:return false;'>		<input value='Search...' type='text' id='search' style='text-align: left !important;' name='search'></form></div>");
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
								$('input#search').quicksearch('#myTable tbody tr');							
							//////////////////////////////////END MAIN SEARCH//////////////////////////////////////////////////////////////////////
							
/////////////////////////////////// CREATE TESTCASE BUTTON/////////////////////////////////////////////////////		
							
<?php
	if( $_SESSION['role'] != 5 &&  $_SESSION['role'] != 4){
?>	
					$("#addBtn").click(function(){
					
						pauser();
							
								 $.ajax({
								type: "GET",													  
								url: "action.php",
								cache: false,													  
								data: "popFuncs=true&rel=<?php echo $iq->rel; ?>&crypto=<?php echo session_id() . 'zLsX7795d1d5AsCsD3wFGv'; ?>",													  
								}).done(function( msg ) {
										
								if( is_loggedin(msg) ){								
									
										$("#function").html(msg);			
								
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
											
												$.ajax({
												type: "GET",													  
												url: "time.php",													  
												cache: false,													  
												data: "test=test",													  
												}).done(function( msg ) {
																
														$("#sCreateTime").html(msg);
														
													});		

									}
						});				
										
										
		});
							
							
	
							
<?php
}
?>
							///////////////////////////////////END CREATE TESTCASE BUTTON/////////////////////////////////////////////////////						
							
			///////////////////////////////////EXECUTE BUTTON////////////////////////////////////////////////////////////////////////////
<?php
	if( $_SESSION['role'] != 5){
?>						
							
							$("#execBtn").click(function(){				
							
											$.ajax({
											
													  type: "GET",													  
													  url: "execution.php",													  
													  cache: false,													  
													  data: "rel=<?php echo $iq->rel; ?>",													  
													}).done(function( msg ) {
													
														if( is_loggedin(msg) ){	
													
															$("#iframeContainer").html(msg); 
															
															
															 $( "#iframeContainer" ).dialog({
										
																			autoOpen: true,
																			height: 580,
																			width: 1000,
																			modal: true,
																			resizable: false
																			
																});	
															
															
														}
													  
													});								
							
										

							
							});//EXECUTION BUTTON	

<?php
}
?>							
							///////////////////////////////////END EXECUTE BUTTON////////////////////////////////////////////////////////////////////////////


			
							
<?php
	if( $_SESSION['role'] != 5 &&  $_SESSION['role'] != 4){
?>
							addEdit();	
							cFieldsCheck();							
<?php
}
?>							
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

								});// END LOGOUT 
							///////////////////////////////////END LOGOUT FUNCTION///////////////////////////////////////////////////////////////////////	
								
								///////////////////////////////////SHOW TABLE IF ALL VCP///////////////////////////////////////////////////////////////////////	
									<?php
									 //  if($vert && $client && $project){
			
											echo '$("#bodyContainer").css("visibility","visible");';
											echo  '$("#search").css("display","block");';
	   
										//}								
									?>
									<?php
										  if($vert && $client && $project){
										  
												echo '$("#graph-all").css("visibility","visible");';
										  }
									?>
								///////////////////////////////////END SHOW TABLE IF ALL VCP///////////////////////////////////////////////////////////////////////
			
 <?php
	if( $_SESSION['role'] != 5 &&  $_SESSION['role'] != 4){
?>  			
			
					///////////////////////////////////ADD NEW FUNCTION////////////////////////////////////////////////////////////////////////////
						$("#function").change(function(){
							
							if( $(this).val() == "other450311"  && $("#newfunction").length < 1 ) {

						
										$(this).parent().append("<input type='text'  id='newfunction' class='cf pauser' name='newfunction' style='position:absolute; text-align:left; right:55px; top:25px; width:290px;' />");		
										$('input:text, input:password').button().addClass('inpField');
										validCreate()
								
								 $(".cf").keyup(function(){
										
												if( $.trim($(this).val()) ){
														
														$(this).parent().siblings(':first').html("<img class='success' src='img/accept.gif'/>");											
												
												}else{
												
														$(this).parent().siblings(':first').html("<img class='error' src='img/denied.gif'/>");
												}
										
										
										}); 
											

							}else{
							
									$("#newfunction").remove();
									validCreate();
							
							}
						
						}); 
					///////////////////////////////////END ADD NEW FUNCTION////////////////////////////////////////////////////////////////////////////

			
			
			/////////////////////////////////////////////////////////////INSERT NEW TESTCASE///////////////////////////////////////////	


		function addCreate(action){

			//VALID CREATE//
			validCreate();	
			
			var defaultTCID = $("#tcid").val();			
			
			/////GET ETIME /////
			$.ajax({
			type: "GET",													  
			url: "time.php",													  
			cache: false,	
			async: false,
			data: "test=test",													  
			}).done(function( msg ) {
			
				if( is_loggedin(msg) ){	
				
					$("#eCreateTime").html(msg);		
				}
			});		

			//////////VERIFY WHICH OTHER OR NEW FUNCTION///////////
			if( $("#newfunction").val() ){
			
				var custFunction = $("#newfunction").val();				
				
			}else{
			
				var custFunction = $("#function").val();
				
			}
	

			////GLOBAL SEARCH REINITIALIZATION///
			$('input#search').quicksearch('table tbody tr');
			
			//UPDATE PAUSE DURATION & COUNT VALUES
			document.getElementById("testname").click();
			
			//GET PAUSER VARS
			var ptd = parseInt($("#pauseTotalDur").html());
			var pc = parseInt($("#pauseCount").html());
			
			////INSERT RECORD TO THE DATABASE////			
		 	 $.ajax({
				type: "GET",													  
				url: "action.php",
				cache: false,													  
				data: "cTestcase=true&tcid="+ encodeURIComponent($("#tcid").val()) +"&rel=<?php echo $iq->rel; ?>&function="+ encodeURIComponent(custFunction) +"&name="+ encodeURIComponent($("#testname").val()) +"&priority="+ encodeURIComponent($("#priority").val()) +"&class="+ encodeURIComponent($("#class").val()) +"&prereq="+ encodeURIComponent($("#preConditions").val()) +"&scenario="+ encodeURIComponent($("#scenario").val()) +"&expected="+ encodeURIComponent($("#verification").val()) +"&stime="+ encodeURIComponent($("#sCreateTime").html()) +"&etime="+ encodeURIComponent($("#eCreateTime").html()) + "&pc="+ encodeURIComponent(pc) + "&ptd=" + encodeURIComponent(ptd) + "&status="+ encodeURIComponent($("#status").val()) +"&crypto=<?php echo session_id() . 'zLsX7795d1d5AsCsD3wFGv'; ?>",													  
				}).done(function( msg ) {
				
					if( is_loggedin(msg) ){	
				
						var myObj =  jQuery.parseJSON(msg);

							if(myObj.code == '200'){
							
								$("#function").change();
								
								$("#indicator").css("display","block");					
								
									$("#indicator").fadeOut(2000, function(){
											
										
										//VALID CREATE BUTTONS
										validCreate();
											
											if(action == "close"){
											
												$("#createForm").dialog( "close" ); 												
												
											}
											
											if(action == 'aa'){
											
												if ( $("#function").val() == 'other450311' ){
															 $.ajax({
																	type: "GET",													  
																	url: "action.php",
																	cache: false,													  
																	data: "popFuncs=true&rel=<?php echo $iq->rel; ?>&crypto=<?php echo session_id() . 'zLsX7795d1d5AsCsD3wFGv'; ?>",													  
																	}).done(function( msg ) {	
																		
																		$("#function").html(msg);
																		
																					$("#createForm select").selectmenu('destroy');
																					$("#createForm select").selectmenu({style: 'dropdown', maxHeight: 400});	
														
																});
																
												}
											
												cleanCreate();	
												
											
											}
											
											
											if(action == 'as'){
											
												if ( $("#function").val() == 'other450311' ){
															 $.ajax({
																	type: "GET",													  
																	url: "action.php",
																	cache: false,													  
																	data: "popFuncs=true&rel=<?php echo $iq->rel; ?>&crypto=<?php echo session_id() . 'zLsX7795d1d5AsCsD3wFGv'; ?>",													  
																	}).done(function( msg ) {	
																		
																		$("#function").html(msg);
																		
																					$("#createForm select").selectmenu('destroy');
																					$("#createForm select").selectmenu({style: 'dropdown', maxHeight: 400});	
														
																});
																
												}

											}
									
									});
									 
									 
									$("input").removeClass("ui-state-hover");								
									
									/////////////////////////////////////Insert into  table info///////////////////////////////////
									$('#myTable tbody').prepend('<tr><td class="mid ui-widget-content">' + myObj.mysql_last_id + '</td><td style="text-transform:uppercase;" ondblclick="javascript:editElement(this,priorityObj,true,75);" class=" function rhw ui-widget-content" style="text-align:center;">' + custFunction + '</td><td ondblclick="javascript:editElement(this,statusObj,false,8);" class="tdw center ui-widget-content"  style="text-align:center;">' + 	$("#status option:selected").text() + '</td><td ondblclick="javascript:editElement(this,priorityObj,true,5);" class="tdw center  ui-widget-content"  style="text-align:center;">' +	defaultTCID	 + '</td><td ondblclick="javascript:editElement(this,priorityObj,false,8);" class="tdw center ui-widget-content"  style="text-align:center;">' + 	$("#priority option:selected").text() + '</td><td ondblclick="javascript:editElement(this,classObj,false,25);"  class="tdw center  ui-widget-content"  style="text-align:center;">' + $("#class option:selected").text() + '</td><td  ondblclick="javascript:editElement(this,priorityObj,true,100);"  class="tdw center  ui-widget-content"  style="text-align:left;">' +$("#testname").val()+'</td><td  ondblclick="javascript:editSV(this);"  class="tdw tdh  ui-widget-content"><pre>' +  strip_tags($("#preConditions").val(), '<i><b>') +'</pre></td><td ondblclick="javascript:editSV(this);" class="tdw tdh  ui-widget-content"><pre>'+ 	strip_tags($("#scenario").val(), '<i><b>') +'</pre></td><td  ondblclick="javascript:editSV(this);" class="tdw tdh  ui-widget-content"><pre>'+   strip_tags($("#verification").val(), '<i><b>')	+'</pre></td></tr>');	
									

							}else{
								
										alert("Error contacting server");						
										$("#add").click(function(){ $("#createForm").dialog( "close" ); });
										
							} 
							
					}		
			
			});	 
			

		}
	
/////////////////////////////////////////////////////////////END INSERT NEW TESTCASE//////////////////////////////////////////
/////////////////////////////////////////ADD NEW / SIMILAR / ANOTHER////////////////////////////////////	
							
							$("#add").click(function(){			
									
										addCreate("close");											

							});	
								
								$("#addAnother").click(function(){			
									
										addCreate("aa");	
										pauser();

							});	
							
							$("#addSimilar").click(function(){			
									
										addCreate("as");	
										pauser();

							});	
							
							
				/////////////////////////////////////////END ADD NEW / SIMILAR / ANOTHER//////////////////////////////////	

<?php
	}
?>	
 
 
			$("#loading").ajaxStart(function(){
				
				$(this).show();
				
			});
			
			$("#loading").ajaxStop(function(){
			
				$(this).hide();
				
			});
		

		$("#genReport").click(function(){
			
			window.open( "reportgen.php?vertical=<?php echo $vert; ?>&client=<?php echo $client; ?>", "reportWin", "status = 1, height = 440, width = 600, toolbars=no,menubar=no,location=no,scrollbars=no,resizable=no,status=no" );
			
		
		});
			
		$("#genPdf").click(function(){
		
			var cproj= $.trim($("#project option:selected").text());
			cproj = cproj.replace(/\s+/g," ");
			cproj = cproj.split('%20').join("_");
			
			var ccli = $.trim($("#client option:selected").text()) 
			ccli = ccli.replace(/\s+/g," ");
			ccli = ccli.split('%20').join("_");
			
			window.open( "http://10.10.40.31/usablex/exporter.php?project="+ cproj +"&client="+ ccli +"&rel=<?php echo $iq->rel; ?>", "PDFWin", "status = 1, height = 440, width = 600, toolbars=no,menubar=no,location=no,scrollbars=no,resizable=no,status=no" );
			
		
		});
		
		
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