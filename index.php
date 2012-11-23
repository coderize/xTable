<?php 
header("Content-type: text/html; charset=utf-8");  
error_reporting(E_ALL ^ E_NOTICE);
require "includes/config.php"; 
require "includes/sess.php";
session_start();

 if( $_SESSION['loggedIn'] !== TRUE  ){
	
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
<link rel="stylesheet" type="text/css" href="css/contactable.css" />
<script src="js/userEdit.js" charset="UTF-8"></script>
<script src="js/deviceEdit.js" charset="UTF-8"></script>
<script src="js/jquery.min.js" charset="UTF-8"></script>
<script src="js/jquery.quicksearch.js" charset="UTF-8"></script>
<script src="js/jqueryUI/js/jqueryui.js" charset="UTF-8"></script>
<script src="js/jquery.fixheadertable.js" charset="UTF-8"></script>
<script src="js/jquery.columnfilters.js" charset="UTF-8"></script>
<script src="js/jquery.js" charset="UTF-8"></script>
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
			echo " data = {\"rel\": $rel, \"firstName\" : \"{$_SESSION['fname']}\", \"lastName\": \"{$_SESSION['lname']}\" }; "; 

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
	<!--	<th  class='tblTR'>VERIFICATION</th> -->
   
       </thead>
	   <tbody>

     <?php  while($query_row = @mysql_fetch_object($q))  {    ?>     
				
			<tr>
			   <td class='mid'><?php echo $query_row->MID ?></td>
			   <td class= 'rhw'><?php echo $query_row->FUNCTION; ?></td>
			   <td class= 'rhw center'><?php echo $query_row->STATUS; ?></td>			   
			   <td class= 'tdw center'><?php echo $query_row->TCID; ?></td>
			   <td class= 'tdw center'><?php echo $query_row->PRIORITY; ?></td>
			   <td class= 'tdw center'><?php echo $query_row->CLASS; ?></td>
			   <td class= 'tdw center'><?php echo $query_row->NAME; ?></td>
			  
			   <td class= 'tdw tdh'><pre><?php echo $query_row->PREREQUISITE; ?></pre></td>			   
			   <td  class= 'tdw tdh'><pre><?php echo $query_row->SCENARIO;  ?></pre></td> 
			  <!--  <td  class= 'tdw tdh'><pre><?php //echo $query_row->VERIFICATION; ?></pre></td>-->
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
<script type="text/javascript" src='js/core.js?v=4' charset="utf-8"></script>


<script type="text/javascript" charset="utf-8">
	
$(document).ready(function(){
	
	$('#contactable').contactable();
	xTable.bootstrap();
	//$("#myTable").tableDnD( { onDragClass: "dragging"} );
		
	document.getElementById("hvertical").value = "<?php  echo $vert;  ?>";
	document.getElementById("hclient").value = "<?php  echo $client;  ?>";
	document.getElementById("hproject").value = "<?php  echo $project;  ?>";

	$("#navXTable").attr("href","javascript:void(0)");
	$("#XTable").css("border","3px solid #ff7777");
	$("#XTable").css("-webkit-box-shadow","0px 0px 2px 2px #ff7777");
	$("#welcome").html("Welcome, " + data.firstName);

});

window.onresize = function(event) {
	xTable.resize();
}

</script>
</body>
</html>
