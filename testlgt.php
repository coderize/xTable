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
<title>UsableX - xTable</title>

<meta http-equiv="Content-Encoding" content="gzip">
<meta http-equiv="Accept-Encoding" content="gzip, deflate">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
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

<script src="js/addEdit.js" charset="UTF-8"></script>
<script src="js/userEdit.js" charset="UTF-8"></script>
<script src="js/deviceEdit.js" charset="UTF-8"></script>
<script src="js/jquery.min.js" charset="UTF-8"></script>
<script src="js/jquery.quicksearch.js" charset="UTF-8"></script>
<script src="js/jqueryUI/js/jqueryui.js" charset="UTF-8"></script>
<script src="http://jqueryui.com/themeroller/themeswitchertool/" charset="UTF-8"></script>
<script src="js/jquery.fixheadertable.js" charset="UTF-8"></script>
<script src="js/jquery.columnfilters.js" charset="UTF-8"></script>
<script src="js/columnFilters.js" charset="UTF-8"></script>
<script src="js/jquery.js" charset="UTF-8"></script>
<script src="js/jquery.contactable.js" charset="UTF-8"></script>

</head>

<body id="bod">

<div id='mainContainer'>

<div id='navigation'>
<form name='naviForm' id='naviForm' action="index.php" method="GET">
	
	<select name='vertical' id='vertical' onchange="javascript:reload();">
		<option value='na'>Vertical Selection</option>	
	</select>	
	
	<select name='client' id='client' onchange="javascript:reload();">	
		<option value=''>Client Selection</option>
	</select>
	
	<select name='project' id='project' onchange="javascript:reload();">	
		<option value=''>Project Selection</option>
	</select>

</form>



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
		
	 </tbody>
	</table>
	<table id="header-fixed"></table>
	</div>


</div><!-- end main container -->


								
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

	$(document).ready(function() { 							
									
							$("#navigation select").selectmenu({style: 'dropdown', maxHeight: 400});							
							$("#createForm select").selectmenu({style: 'dropdown',maxHeight: 400});								
							$('input:text, input:password').button().addClass('inpField');	
							
							$('#contactable').contactable();
							///////////////////////////////////END NEW UI JAVASCRIPT//////////////////////////////////////////////							
							
							///////////////////////////////////END EXECUTE BUTTON////////////////////////////////////////////////////////////////////////////						
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
													  type: "GET",
													  url: "login_mod.php",
													  cache: false,
													  data: "kill=kill",
													}).done(function( msg ) {
													
														if( is_loggedin(msg) ){		
														
															if (msg == "true"){
															
																window.location.href ="login.php?logout=true";
																window.location.reload();
																
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
								
	
	}); //DOM Ready
	

</script>


</body>
</html>
