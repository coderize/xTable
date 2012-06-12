<?php 
header("Content-type: text/html; charset=utf-8");  
error_reporting(E_ALL ^ E_NOTICE);
require "includes/config.php"; 
require "includes/sess.php";
session_start();

 if( !$_SESSION['fname'] ){
	header('Refresh: 0; URL=login.php');
	exit;
} 

$vert = mysql_real_escape_string($_GET['vertical']);
$client = mysql_real_escape_string($_GET['client']);
$project = mysql_real_escape_string($_GET['project']);

if($vert == '' && $client == '' && $project == ''){
	
	echo "Invalid URL arguments...";
	header('Refresh: 1; URL=index.php?vertical=na');
	exit;

}

?>
<!DOCTYPE html>
<html>
<head>
<title>Coderize - xTable</title>

<meta http-equiv="Content-Encoding" content="gzip">
<meta http-equiv="Accept-Encoding" content="gzip, deflate">

<meta http-equiv="content-type" content="text/html; charset=UTF-8">

<style>
body,pre{font-family:Verdana,Helvetica,san-serif,Arial;font-size:.6em}*{padding:0;margin:0}.clearfix:after{content:".";display:block;clear:both;visibility:hidden;line-height:0;height:0}.clearfix{display:inline-block}html[xmlns] .clearfix{display:block}* html .clearfix{height:1%}#createForm,#iframeContainer{display:none}#mainContainer{padding-top:5px;min-width:960px;position:relative}.inpFields{font:inherit;color:inherit;outline:0;cursor:text}pre{font-size:1em;white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word}#search{margin-left:35%;margin-top:-15px;display:none;border:3px solid #7aa3cc;width:350px;height:20px;border-radius:15px;-webkit-border-radius:15px;border-top-right-radius:15px;border-top-left-radius:15px;border-bottom-right-radius:15px;border-bottom-left-radius:15px;font-size:1.2em}.dragging{border:2px solid #0f0}._filterText{width:99%;height:20px;font-style:italic;background-color:#f0f0f0;border-width:1px;font-size:14px!important}#navigation a{float:left}#navigation{/* position:relative;height:100px */}#navigation #vertical-button,#client-button,#project-button{margin-left:5px!important}#bodyContainer{z-index:1000;position:relative}#execIframe{width:99%;height:97%}#createForm select{width:200px}#class-menu,#priority-menu,#function-menu{z-index:2000}#createForm textarea{max-width:630px;min-width:320px;max-height:95px;width:630px;height:95px}#logout{margin:4px 0 0 30%;display:none}#myAcc{position:absolute;top:0;right:17%;height:30px;font-weight:bold;width:152px}#accChild{display:none}#logout-confirm{display:none}#other{background-color:#ccc}#indicator{font-size:14px;color:#7ec045;font-weight:bold}#loading{display:none;position:absolute;top:41%;left:44%;z-index:10000}#editSuccess{display:none;position:absolute;top:5px;left:44%;z-index:10000;font-size:20px;color:#3d5;font-weight:bold}#account{width:152px}.myAccOpen{border-radius:10px;height:145px!important;background-color:#fff;z-index:1002;border-right:2px solid #ccc;border-left:2px solid #ccc;border-bottom:2px solid #ccc}#switcher{margin-top:3px}.function,.tcid,.priority,.class,.status{text-align:center!important}#pager{height:35px;padding:5px;font-weight:bold}#graph{width:100%;height:550px;border:0}#graph-all{position:absolute;top:165px;z-index:1;width:99%;overflow:hidden;height:500px;visibility:hidden}#graph-controls{position:relative;margin-top:20px}#up{position:absolute;left:400px;top:0}.ui-selectmenu-menu{z-index:3000}#navBtns{position:absolute;bottom:0}#logged-out{display:none;text-align:center;font-size:1.3em}#logged-out img{display:block;margin:0 auto;padding:60px 0 5px 0}
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

#main{
	margin-top:100px;
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
<script src="js/addEdit.js" charset="UTF-8"></script>
<script src="js/userEdit.js" charset="UTF-8"></script>
<script src="js/deviceEdit.js" charset="UTF-8"></script>
<script src="js/jquery.min.js" charset="UTF-8"></script>
<script src="js/jquery.quicksearch.js" charset="UTF-8"></script>
<script src="js/jqueryUI/js/jqueryui.js" charset="UTF-8"></script>
<script src="http://jqueryui.com/themeroller/themeswitchertool/" charset="UTF-8"></script>
<script src="js/jquery.fixheadertable.js" charset="UTF-8"></script>
<script src="js/jquery.columnfilters.js" charset="UTF-8"></script>
<!--<script src="js/columnFilters.js" charset="UTF-8"></script> -->
<script src="js/jquery.js" charset="UTF-8"></script>
<!-- <script src="js/calendar_db.js" charset="UTF-8"></script> -->
<script src="js/jquery.contactable.js" charset="UTF-8"></script>
<!--<script src="js/jquery.tablednd.js" charset="UTF-8"></script>-->


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
	
			echo "resultObj = {'0':'Pass','1':'Fail'};";




$iq = @mysql_query("SELECT relation_id AS rel
			FROM table_relation, table_vertical, table_client, table_project
			WHERE r_vertical =  '{$vert}'
			AND r_client =  '{$client}'
			AND r_project =  '{$project}'
			GROUP BY relation_id 
			LIMIT 1");

			$iq = mysql_fetch_object($iq);
			$rel = ($iq->rel) ? $iq->rel : '0';
			echo " data = {'rel': $rel, 'fisrtName' : '{$_SESSION['fname']}', 'lastName': '{$_SESSION['lname']}' }; "; 

			echo "</script>";

?>

</head>

<body id="bod">
<?php 

	$verts = mysql_query("SELECT vertical_id, vertical_name FROM table_vertical WHERE vertical_id < 9 ORDER BY vertical_name ASC");	
?>
<div id='mainContainer'>

<div id='navigation'>
<form name='naviForm' id='naviForm' action="index.php" method="GET">
	<select name='vertical' id='vertical'>
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
		<select name='client' id='client'>	
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
		<select name='project' id='project'>	
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
								
									");//or die ("UNABLE TO GET TESTCASES");
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
								
									");//or die ("UNABLE TO GET TESTCASES");
/////////////////////////////////////////////////////GET ALL TYPES OF TESTCASES/////////////////////////////////////////////////
}


?>

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
			   <td class= 'rhw'><?php echo $query_row->FUNCTION; ?></td>
			   <td class= 'rhw center'><?php echo $query_row->STATUS; ?></td>			   
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

<?php
// TESTCASE CREATION HTML TEMPLATE>
require("create_testcase_template.html");

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
<script type="text/javascript" charset="utf-8">


xTable = {
is_loggedin : function(a){if(a=="INVALID_SESSION"){$("#logged-out").dialog({height:300,width:400,modal:true,resizable:false});function b(){window.location.reload();}setTimeout(b,2e3);return false}else{return true}},

pauser : function(){function a(){var a=Math.round(+(new Date)/1e3);return a}$("#pauseIni").html(a());$("#pauseCur").html("0");$("#pauseDur").html("0");$("#pauseTotalDur").html("0");$("#pauseCount").html("0");$(".pauser, #addSimilar, #addAnother, #add").bind("click",function(){$("#pauseCur").html(a());var b=parseInt($("#pauseIni").html());var c=parseInt($("#pauseCur").html());var d=c-b;$("#pauseDur").html(d);var e=300;if(d<e){$("#pauseIni").html($("#pauseCur").html());validCreate()}else{var f=parseInt($("#pauseTotalDur").html());var f=f==0?d:f+d;var g=parseInt($("#pauseCount").html());var g=g==0?1:g+1;$("#pauseIni").html($("#pauseCur").html());$("#pauseTotalDur").html(f);$("#pauseCount").html(g)}})},

reload : function(){ddvert=document.getElementById("hvertical");ddclient=document.getElementById("hclient");ddproject=document.getElementById("hproject");vertpath="index.php?vertical="+ddvert.value;window.location=vertpath;clientpath=vertpath+"&client="+ddclient.value;window.location=clientpath;projectpath=clientpath+"&project="+ddproject.value;window.location=projectpath},

relCheck : function(error){

		if(data.rel === 0 || data.rel === undefined){
			alert("Error: " + error);
			return true;

		}
	return false;
}, 

strip_tags : function (a,b){b=(((b||"")+"").toLowerCase().match(/<[a-z][a-z0-9]*>/g)||[]).join("");var c=/<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,d=/<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;return a.replace(d,"").replace(c,function(a,c){return b.indexOf("<"+c.toLowerCase()+">")>-1?a:""})},

editAjax : function (par){

	var parent = $(par).parent().parent();	 
	var mid  = encodeURIComponent($(parent).children("td:nth-child(1)").html());
	var func = encodeURIComponent($(parent).children("td:nth-child(2)").html());
	var status = encodeURIComponent($(parent).children("td:nth-child(3)").html());
	var tcid = encodeURIComponent($(parent).children("td:nth-child(4)").html());
	var priority = encodeURIComponent($(parent).children("td:nth-child(5)").html());
	var clas = encodeURIComponent($(parent).children("td:nth-child(6)").html());
	var name = encodeURIComponent($(parent).children("td:nth-child(7)").html());
	var prereq = encodeURIComponent($(parent).children("td:nth-child(8)").children("pre:nth-child(1)").html());
	var steps = encodeURIComponent($(parent).children("td:nth-child(9)").children("pre:nth-child(1)").html());
	var expected = encodeURIComponent($(parent).children("td:nth-child(10)").children("pre:nth-child(1)").html());

	$.ajax({
		type: "POST",													  
		url: "action.php",													  
		cache: false,	
		async: true,
		data: {"tableEdit":"true", "mid":mid, "func":func, "status":status,
				 "tcid":tcid, "priority":priority, "clas":clas, "name":name,
				 "prereq":prereq, "steps":steps, "expected":expected}
		}).done(function( msg ) {
			
			if( this.is_loggedin(msg) ){					
						
				if(msg =='200'){
					 	
					$(".editSuccess").css("display","block");
					$(".editSuccess").fadeOut(3000);

				}else{
					
					alert ("Something went wrong while saving, try again");
						
				}
			
			}
							
			}); 

},


cFieldsCheck : function (){
		
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
			
},

validCreate : function (){

$("#add").attr("disabled","true");
$("#addAnother").attr("disabled","true");
$("#addSimilar").attr("disabled","true");									
				
	$('#priority,#class,#function,#status').change(function (){			

		 var fval = ($("#function").val() == "other450311") ?  $("#newfunction").val() : $("#function").val();				
							
			if( $("#priority").val() != 'na' &&  $("#class").val() != 'na' &&  $.trim($("#status").val()) !='na' && $.trim(fval) != 'na' && $.trim(fval) !='' && $("#tcid").val() != '' && $.trim($("#testname").val()) != '' && $.trim($("#preConditions").val()) != '' && $.trim($("#scenario").val()) != '' && $.trim($("#verification").val()) != ''){
									
										$("#add").removeAttr("disabled");
										$("#addAnother").removeAttr("disabled");
										$("#addSimilar").removeAttr("disabled");									

									}else{
										$("#add").attr("disabled","true");
										$("#addAnother").attr("disabled","true");
										$("#addSimilar").attr("disabled","true");									
									}				
				
					  });		
				
				
	$('.cf').bind("keyup click", function() {
						
		var fval =  ($("#function").val() == "other450311") ? $("#newfunction").val() :  $("#function").val();				
										
			if( $("#priority").val() != 'na' &&  $("#class").val() != 'na' && $.trim(fval) != 'na' && $.trim($("#status").val()) !='na' && $.trim(fval) !='' && $.trim($("#tcid").val()) != '' && $.trim($("#testname").val()) != '' && $.trim($("#preConditions").val()) != '' && $.trim($("#scenario").val()) != '' && $.trim($("#verification").val()) != ''){
									
										$("#add").removeAttr("disabled");
										$("#addAnother").removeAttr("disabled");
										$("#addSimilar").removeAttr("disabled");									

									}else{
										$("#add").attr("disabled","true");
										$("#addAnother").attr("disabled","true");
										$("#addSimilar").attr("disabled","true");									
									}				
						
				
					  });			 
},


tcidLogic : function(){

$("#function").change(function(){	

	var custFunction =  ( $("#newfunction").val() ) ? encodeURIComponent($("#newfunction").val()) :  encodeURIComponent($("#function").val());
	this.cFieldsCheck();
	this.validCreate();
				
				if( $(this).val() == "other450311") {

							$.ajax({
								type: "POST",
								url: "action.php",
								cache: false,	
								async: false,
							        data: {"othertcid" : "true", "rel" : data.rel }
								}).done(function( msg ) {

								if( this.is_loggedin(msg) ){	
								
									if(msg){
									
										$("#tcid").val(msg);
										$("#tcid").change();									
										this.cFieldsCheck();
										this.validCreate();										
									}
								}
								
							});		

				}else if( $(this).val() != 'na' && $(this).val() !='other450311' ){
						
					$.ajax({
								type: "POST",													  
								url: "action.php",													  
								cache: false,	
								async: false,
								data: {"newtcid" : "true", "funcname" : custFunction, "rel" : data.rel}
								}).done(function( msg ) {
								
								if( this.is_loggedin(msg) ){	
								
									$("#tcid").val(msg);	
									$("#tcid").change();
									this.cFieldsCheck();					
									this.validCreate();
									
								}
									
							});
				
				
				
				}

})},


cleanCreate : function(){		

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
this.cFieldsCheck();
			
},



editSV : function (ele){	

	$("<textarea id='myTextarea'></textarea>").html(ele.childNodes[0].innerHTML).appendTo("body");
	$( "#myTextarea" ).dialog({
				autoOpen: true,
				height: 500,
				width: 800,
				modal: true,
				title: 'Modify',
				resizable: false,
				buttons: { "Save": function() {
				
					ele.childNodes[0].innerHTML = this.strip_tags($("#myTextarea").val(), '<i><b>');
					this.editAjax(ele.childNodes[0]);
					$('input#search').quicksearch('#myTable tbody tr');
					$("#myTextarea").remove();
					$(this).dialog("close");

					},"Cancel":function(){	$("#myTextarea").remove(); }
					},close: function(event, ui) {	$("#myTextarea").remove(); }
				});	
	

	$("#myTextarea").css("width","780px");
	$("#myTextarea").css("height","450px");
	$("#myTextarea").css("max-width","780px");
	$("#myTextarea").css("max-height","450px");
	$("#myTextarea").css("font-size","1.2em");
},


editElement : function (ele,obj,type,ml){			
				
				var elem = ele;
				var objm = obj;
				var typem = type;
				var mlm = ml;

			if( type == false ){	
			
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
						this.editAjax(elem.childNodes[0]);	
						$('input#search').quicksearch('#myTable tbody tr');	
					}  			
					
					 seleEdit.onblur = function(){				
						
						 var ms  = $("#mySelect option:selected").text();
						 $(elem).html(ms);
					 }

					 seleEdit.onkeyup = function(){		
					  	var ms  = $("#mySelect option:selected").text();
						$(elem).html(ms);																	
						this.editAjax(elem.childNodes[0]);		
						$('input#search').quicksearch('#myTable tbody tr');									
					}


			}else if( type == true ){	
					
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
							this.editAjax(ele.childNodes[0]);
							$('input#search').quicksearch('#myTable tbody tr');
						}				
			}			
			
},


footerCount : function (){

							
	$("#pager").html("Total number of testcases: " + $(".mid").length) ;

},
	




columnFilter : function(){
	

	$("#_filterText1, #_filterText2, #_filterText3, #_filterText4, #_filterText5, #_filterText6, #_filterText7, #_filterText8, #_filterText9").keyup(function(){    
		var that = this;	
		var position = this.id[this.id.length - 1];
		var posTD = parseInt(position) + 1;
		var rows = $("#myTable tr");

		rows.children("td:nth-child("+ posTD +")").each(function() {
	
			var reg = that.value;
			var html = this.childNodes[0].nodeValue || this.childNodes[0].childNodes[0].nodeValue;
			var patt = new RegExp(""+ reg +"","i");
			var res = patt.test(""+html+""); 		
			var matches = ( res ) ?  $(this).parent().css("display","table-row") : $(this).parent().css("display","none");
													
		});


	});


					
},

createTestcase : function(){

		if( this.relCheck("Select a component first!") ){
			return;
		}
		
		var that = this;

		this.pauser();

		$.ajax({
			type: "POST",
			url: "action.php",
			cache: false,
			data: {"popFuncs":"true", "rel":data.rel}
			}).done(function( msg ) {

				if( that.is_loggedin(msg) ){								
			
					$("#function").html(msg);			
					that.cFieldsCheck();
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
							
							that.validCreate();
							that.cleanCreate();
											
							$.ajax({
								type: "GET",
								url: "time.php",
								cache: false,
								data: "test=test"
							}).done(function( msg ) {
								
									$("#sCreateTime").html(msg);

								});
				}
			});				
										
										


},	


bootstrap: function(){

	$('#myTable').columnFilters();

	var hght = ($(".mid").length==0) ? 125 : 157
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
	//remove enter key from textfields
	$('#search, .filterText').keypress(function() { return event.keyCode != 13; });


	//adds header select menus
	$(".t_fixed_header_caption").prepend( "<div id='hnav'><select name='hvertical' id='hvertical' onchange='javascript:xTable.reload();'>" + $("#vertical").html() + "</select> <select name='hclient' id='hclient' onchange='javascript:xTable.reload();'>"+$("#client").html()+"</select>"+" <select name='hproject' id='hproject' onchange='javascript:xTable.reload();'>" + $("#project").html() + "</select></div>" );	$("#hnav").css("float","left");



	//adds CT and Execute buttons
	$(".t_fixed_header_caption").append("<div id='hNavBtn'><button id='addBtn'>Create Testcase</button><button id='execBtn'>Execute</button></div>");
	$("#hNavBtn").css("float","right");


	//adds footer div for count
	$(".t_fixed_header_main_wrapper").append("<div id='pager'></div>");	
	this.footerCount();

	//adds footer search
	$("#pager").append("<div id='searchForm'><form id='search-form' name='search-form' method='#' action='#' onsubmit='javascript:return false;'><input value='Search...' type='text' id='search' style='text-align: left !important;' name='search'></form></div>")


	//adds search blur & focus methods
	$("#search").blur(function(){ this.value = 'Search...';}).focus(function(){ this.value = '';});
							
	$("#createForm select").selectmenu({style: 'dropdown',maxHeight: 400});								
	$('input:text, input:password').button().addClass('inpField');	


	//adds column filtering ability
	this.columnFilter();		

	//Search functionality for global search
	$('input#search').quicksearch('#myTable tbody tr');


	//click event handler for create testcase method
	
	$("#addBtn").click(function(){ xTable.createTestcase();  });





}//end BOOTSTRAP



}

$(document).ready(function(){

	xTable.bootstrap();
	//$("#myTable").tableDnD( { onDragClass: "dragging"} );
	$('#contactable').contactable();
	

});

////////////////////////////////////////////////////OTHER ELEMENTS EDITING////////////////////////////////////////////////////			
//END EDIT ELEMENT	
		
	
////////////////////////////////////////////////////END OTHER ELEMENTS EDITING////////////////////////////////////////////////////				
	
////////////////////////////////////////////////////SET SELECTED DROPDOWN OPTIONS////////////////////////////////////////////////////			
	document.getElementById("vertical").value = "<?php  echo $vert;  ?>";		
		
	document.getElementById("client").value = "<?php  echo $client;  ?>";
	
	<?php if($client == ''){ $project = "na";} ?>
	
	document.getElementById("project").value = "<?php  echo $project;  ?>";	

////////////////////////////////////////////////////END SET SELECTED DROPDOWN OPTIONS////////////////////////////////////////////////////	

	$(document).ready(function() { 							





///////////////////////////////////END NEW UI JAVASCRIPT//////////////////////////////////////////////
//////////////////////////////////CUSTOM COLUMN FILTERS//////////////////////////////////////////////////////

//////////////////////////////////CUSTOM COLUMN FILTERS//////////////////////////////////////////////////////
							
//////////////////////////////////MAIN SEARCH///////////////////////////////////////////////////////////////////////////////
							
//////////////////////////////////END MAIN SEARCH//////////////////////////////////////////////////////////////////////
							
				
							
///////////////////////////////////EXECUTE BUTTON////////////////////////////////////////////////////////////////////////////
	$("#execBtn").click(function(){				
	
		if( xTable.relCheck("Select a component first!") ){
		
			return;
		}

		$.ajax({											
			type: "POST",
			url: "execution.php",
			cache: false,
			data: {"rel":data.rel}								  
			}).done(function( msg ) {
				
				if( xTable.is_loggedin(msg) ){	
		
					$("#iframeContainer").html(msg); 
					$("#iframeContainer").dialog({
						autoOpen: true,
						height: 580,
						width: 1010,
						modal: true,
						resizable: false
					});	
															
				}
			});								
							
										
		});							
///////////////////////////////////END EXECUTE BUTTON////////////////////////////////////////////////////////////////////////////
	addEdit();	
	xTable.cFieldsCheck();							
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
											data: {"kill":"kill"}
											}).done(function( msg ) {
													
												if( xTable.is_loggedin(msg) ){		
												
													if (msg == "true"){
														window.location.href ="login.php?logout=true";
																
													}else{	alert("Error logging out, try again");	}
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
$("#bodyContainer").css("visibility","visible");
$("#search").css("display","block");
	   
							
///////////////////////////////////END SHOW TABLE IF ALL VCP///////////////////////////////////////////////////////////////////////
///////////////////////////////////ADD NEW FUNCTION////////////////////////////////////////////////////////////////////////////
$("#function").change(function(){
	
 if( $(this).val() == "other450311"  &&  $("#newfunction").length < 1 ) {

	$(this).parent().append("<input type='text'  id='newfunction' class='cf pauser' name='newfunction' style='position:absolute; text-align:left; right:55px; top:25px; width:290px;' />");
	$('input:text, input:password').button().addClass('inpField');
	validCreate();
	
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
			
				if( xTable.is_loggedin(msg) ){	$("#eCreateTime").html(msg); }
				
			});		

			//////////VERIFY WHICH OTHER OR NEW FUNCTION///////////
			var custFunction = ($("#newfunction").val() ) ? $("#newfunction").val() : $("#function").val();
	

			////GLOBAL SEARCH REINITIALIZATION///
			$('input#search').quicksearch('table tbody tr');
			
			//UPDATE PAUSE DURATION & COUNT VALUES
			document.getElementById("testname").click();
			
			//GET PAUSER VARS
			var ptd = parseInt($("#pauseTotalDur").html());
			var pc = parseInt($("#pauseCount").html());
			
			////INSERT RECORD TO THE DATABASE////			
		 	 $.ajax({
				type: "POST",										  
				url: "action.php",
				cache: false,										  
				data: "cTestcase=true&tcid="+ encodeURIComponent($("#tcid").val()) +"&rel="+ data.rel +"&function="+ encodeURIComponent(custFunction) +"&name="+ encodeURIComponent($("#testname").val()) +"&priority="+ encodeURIComponent($("#priority").val()) +"&class="+ encodeURIComponent($("#class").val()) +"&prereq="+ encodeURIComponent($("#preConditions").val()) +"&scenario="+ encodeURIComponent($("#scenario").val()) +"&expected="+ encodeURIComponent($("#verification").val()) +"&stime="+ encodeURIComponent($("#sCreateTime").html()) +"&etime="+ encodeURIComponent($("#eCreateTime").html()) + "&pc="+ encodeURIComponent(pc) + "&ptd=" + encodeURIComponent(ptd) + "&status="+ encodeURIComponent($("#status").val()) 
				}).done(function( msg ) {
				
					if( xTable.is_loggedin(msg) ){	
				
						var myObj =  jQuery.parseJSON(msg);

						if(myObj.code == '200'){
							$("#function").change();
							$("#indicator").css("display","block");					
								
								$("#indicator").fadeOut(2000, function(){

									//VALID CREATE BUTTONS
									validCreate();
											
									if(action == "close"){	$("#createForm").dialog( "close" );}
						
										if(action == 'aa'){

											if ( $("#function").val() == 'other450311' ){
												 $.ajax({
													type: "GET",
													url: "action.php",
													cache: false,
													data: {"popFuncs":"true","rel":data.rel}					  
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
												data: {"popFuncs":"true","rel":data.rel}
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
									
									$('input#search').quicksearch('#myTable tbody tr');	

							}else{
								
									alert("Could not contact server");						
									$("#add").click(function(){ $("#createForm").dialog( "close" ); });
										
							} 
							
					}		
			
			});	 
			

		}
	
/////////////////////////////////////////////////////////////END INSERT NEW TESTCASE//////////////////////////////////////////
/////////////////////////////////////////ADD NEW / SIMILAR / ANOTHER////////////////////////////////////	
$("#add").click(function(){		addCreate("close");	});	
$("#addAnother").click(function(){		addCreate("aa");		xTable.pauser(); 	});	
$("#addSimilar").click(function(){	addCreate("as"); 	xTable.pauser();  });	
							
							
/////////////////////////////////////////END ADD NEW / SIMILAR / ANOTHER//////////////////////////////////	
$("#loading").ajaxStart(function(){	$(this).show(); });			
$("#loading").ajaxStop(function(){	$(this).hide(); });
		

		
		
		$("#_filterText1").click(function(){
				
			$(this).val("");

		});
		
		$("#_filterText1").blur(function(){
				
			$(this).val("Search..");

		});
		
			
		$("#_filterText1").val("Search...");		
				
					
				$("#welcome").html("Welcome, " + data.firstName );
				$('#switcher').themeswitcher();
				
			document.getElementById("hvertical").value = "<?php  echo $vert;  ?>";
			document.getElementById("hclient").value = "<?php  echo $client;  ?>";
			document.getElementById("hproject").value = "<?php  echo $project;  ?>";


			$("#navXTable").attr("href","javascript:void(0)");
			$("#XTable").css("border","3px solid #ff7777");
			$("#XTable").css("-webkit-box-shadow","0px 0px 2px 2px #ff7777");
			
			
			
			
}); //DOM Ready
	
							
		
	

</script>
</body>
</html>
