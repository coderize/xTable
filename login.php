<?php
header("Content-type: text/html; charset=utf-8");  
error_reporting(E_ALL ^ E_NOTICE);
require "includes/config.php"; 
require "includes/sess.php";
session_start();

 if( $_SESSION['fname'] ){
	header('Refresh: 0; URL=http://localhost/usablex/xtable/home.php');
	exit;
} 
?>
<!DOCTYPE html>
<html>
<head>
<title>UsableX Login</title>

<style>
body{margin:0; padding:0; font:100% Arial, sans-serif;}

#frame{
	width:300px; height:300px; margin:200px auto 0; 
	-webkit-perspective:500;
}
#rframe{
	width:300px; height:300px; position:relative; 
	-webkit-transform-style:preserve-3d;
	-webkit-animation:spin 10s linear infinite;
}
#rframe > div{
	position:absolute; top:0; left:0;
	height:300px; width:300px; 
	-webkit-border-radius:20px; 
	border-radius:20px;
	background-color:#09F; opacity:.7;
	font-size:30px; line-height:300px; text-align:center; color:#000; text-shadow:1px 1px 0 rgba(255, 255, 255, .5); 
	-webkit-backface-visibility:visible; 
}

#rframe > div:nth-child(1){-webkit-transform:rotateY(270deg) translateZ(160px);}
#rframe > div:nth-child(2){-webkit-transform:rotateY(180deg) translateZ(160px);}
#rframe > div:nth-child(3){-webkit-transform:rotateY(90deg) translateZ(160px);}
#rframe > div:nth-child(4){-webkit-transform:rotateX(90deg) translateZ(160px);}
#rframe > div:nth-child(5){-webkit-transform:rotateX(270deg) translateZ(160px);}
#rframe > div:nth-child(6){-webkit-transform:translateZ(160px);}

@-webkit-keyframes spin{
 	from{-webkit-transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);}
 	to{-webkit-transform:rotateX(360deg) rotateY(360deg) rotateZ(360deg);}
}

/* LOGIN CSS */

    ul {
        margin: 0;
        padding: 0;
    }

    ul li { display: inline-table; }
    
        .no-placeholder-hide { /* Will appear only if the browser doesn't support placeholders */
            float: left;
            font: bold 14px/100% Tahoma, Geneva, sans-serif;
            color: #305183;
            text-transform: uppercase;
            margin: 0 0 10px 0;
            display: none;
        }

html {
    width: 100%;
    height: 100%;
    background-image: radial-gradient(top, #546673, #1f242a);
    background-image: -moz-radial-gradient(50% 50%, farthest-side, #546673, #1f242a);
    background-image: -webkit-gradient(radial, 50% 50%, 0, 50% 50%, 700, from(#546673), to(#1f242a));
    background-image: -o-linear-gradient(#1f242a, #546673);
                      -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#546673', endColorstr='#1f242a')";
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#546673', endColorstr='#1f242a');
}

        #wrapper {
		display:none;

        }
        
            /* Form General Style */
    
            #form {
                width: 100%;
                float: left;
                background: #fff;
                border-radius: 10px;
                -moz-border-radius: 10px;
                -webkit-border-radius: 10px;
                box-shadow: 0px 0px 0px 8px #57636d;
                -moz-box-shadow: 0px 0px 0px 8px #57636d;
                -webkit-box-shadow: 0px 0px 0px 8px #57636d;
            }
            
                #formWrapper {
                    width: 385px;
                    padding: 23px;
                    float: left;
                    border-top: none;
                    border-bottom: none;
                    border-radius: 0 0 8px 8px;
                }
            
                /* Form Menu Style */
            
                ul#menu {
                    width: 100%;
                    float: left;
                    list-style: none;
                    background: #617798;
                    border-radius: 8px 8px 0 0;
                }

                ul#menu li {    
                    width: 33%;
                    float: left;
                    border-left: 1px solid #305183;
                    border-radius: 8px 8px 0 0;
                }
                ul#menu li.client { border: none; }
                
                ul#menu li:hover,
                ul#menu li.active {
                    box-shadow: none !important;
                    background: #fff;
                    background: rgba(0,0,0,0.1) 0px 0px 8px;
                    background: -moz-linear-gradient(top, #fff, #eee 1px, #fff 25px);
                    background: -webkit-gradient(linear, left top, left 25, from(#fff), color-stop(4%, #eee), to(#fff));
                    background: -o-linear-gradient(#eee, #fff);
                }

                    ul#menu li a {
                        display: block;
                        padding: 15px 0;
                        font: bold 18px/100% Tahoma, Geneva, sans-serif;
                        color: #fff;
                        text-decoration: none;
                        text-align: center;
                        text-shadow: #305183 0 1px 0;
                    }
                    ul#menu li a:hover,
                    ul#menu li.active a { color: #617798; text-shadow: none; }
    
                /* Form Content Style */
                    
                .hide { display: none; }

                
                        /* Client Menu Options */
                
                        ul#options {
                            width: 150px;
                            height: 44px;
                            float: left;
                        }
                        
                            ul#options li a {
                                display: block;
                                margin: 5px 0;
                                font: normal 12px/100% Tahoma, Geneva, sans-serif;
                                text-transform: uppercase;
                                text-decoration: none;
                                color: #617798;
                            } 
                            
                            ul#options li a:hover { color: #305183; }
            
        /* Form Fields */
        
            /* Input Fields */
        
            input[type="text"], input[type="password"] {
                width: 96.7%;
                font: normal 13px/100% Tahoma, Geneva, sans-serif;
                color: #c4c4c4;
                margin: 0 0 12px 0;
                padding: 13px 0 13px 10px;
                border: 1px solid #e5e5e5;
                background: rgba(0,0,0,0.1) 0px 0px 8px;
                background: -moz-linear-gradient(top, #fff, #eee 1px, #fff 25px);
                background: -webkit-gradient(linear, left top, left 25, from(#fff), color-stop(4%, #eee), to(#fff));
                background: -o-linear-gradient(#eee, #fff);
                            -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#eeeeee', endColorstr='#ffffff')";
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#eeeeee', endColorstr='#ffffff');
            }

                input:hover,
                input:focus {
                    border-color: #c9c9c9;
                    -moz-box-shadow: rgba(0,0,0,0.15) 0px 0px 8px;
                    -webkit-box-shadow: rgba(0,0,0,0.15) 0px 0px 8px;
                    -o-box-shadow: rgba(0,0,0,0.15) 0px 0px 8px;
                }
                
                input:focus { border-color: #999999 !important; }
                
                    input:-webkit-input-placeholder { color: #c4c4c4; }
                    input:-moz-placeholder { color: #c4c4c4; }
            
            /* Label Fields (Keep Login) */
            
            label {
                margin: 9px;
                float: right;
            }
            
                input[type="checkbox"] {
                    margin: 6px;
                     /* Only for Opera, sadly */
                    border: 1px solid #305183;
                    background: #617798;
                    color: #fff;
                }

                    label p {
                        margin: 7px 0;
                        float: left;
                        font: normal 11px/100% Tahoma, Geneva, sans-serif;
                        text-transform: uppercase;
                        color: #617798;
                    }

            /* Buttons */

            input[type="submit"] {
                float: right;
                padding: 12px 17px 11px 17px;
                font: bold 14px/100% Tahoma, Geneva, sans-serif;
                color: #fff;
                text-shadow: #305183 0 1px 0;
                background: #617798;
                cursor: pointer;
                border: 1px solid #305183;
            }

                input[type="submit"]:hover, input[type="submit"]:focus { border-color: #142d52; }
                input[type="submit"]:active { background: #617789; }
                
                /* Forget Password special Stylings */
                
                input[type="text"].inputForget {
                    width: 68.2%;
                    margin-bottom: 0;
                }
                
            
    /* Chrome */
    
    @media not screen and (orientation) {

        /* Client Menu Options */

        ul#menu li.client { width: 34%;    }
    
        /* Client Menu Options */
        
        ul#options li a { margin: 4px 0; } 
    
        /* Buttons */
        
        input[type="submit"] {
            margin: 0;
            padding: 14px 20px 14px 20px !important;
        }
    }

#modal{
	position:absolute;
	top:10px;
	right: 20px;

}
	
#close,#selectionClose{
	float: right;
	color: #fff;
	text-decoration:none;
	margin:5px 5px 0px 0px;

}

.success{

	color: #7EC045;
}
.error{

	color: #E20037;
}

#msg{
	padding-bottom: 15px;

}
#logout{
	position:absolute;
	top:65px;
	right: 2%;
	color:#09F;
	font-weight: bold;
	font-size: 1.2em;

}


#dropdowns{
	width: 400px;
	display:none;
}


.vcp{
	width:400px
	height:30px;
	margin-bottom: 10px;

}

#loading{
	display:none;
	position:absolute;
	top:41%;
	left:44%;
	z-index: 10000;
	
}

</style>
<link rel="stylesheet" type="text/css" href="css/base.css" />
<link rel="stylesheet" type="text/css" href="css/redmond/jquery-ui-1.8.16.custom.css" />
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/jqueryUI/js/jqueryui.js"></script>



</head>
<body>

<div id="frame">
	<div id="rframe">
		<div>quality</div>
		<div>people</div>
		<div>success</div>
		<div>patience</div>
		<div>positivity</div>
		<div>professionalism</div>
	</div>
</div>


<button name="modal" id="modal">Click to Login</button>
<?php
$logout = @mysql_real_escape_string($_GET['logout']);

if($logout=="true"){
	
	echo "<div id='logout'>You have been logged out!</div>";
} 

?>

<div id="wrapper">
    <form id="form" name="test" action="login.php" method="POST">
    
    <ul id="menu">
       <li><a href="javascript:void(0) return false;" title="Login" id='tabTitle'>Login</a></li>
       <!--  <li><a href="javascript:void(0) return false;" title="Login">Clients</a></li>
        <li><a href="javascript:void(0) return false;" title="Login">Visitors</a></li>
		<li><a href="#">Change Password</a></li>-->
		<a href='javascript:void(0) return false;' id='close'>Close</a>
    </ul>
    
        <div id="formWrapper">
		
            <div id="user" >
				<div id='msg'></div>
                <label class="no-placeholder-hide">Username</label><input type="text"  id='username' name="username" autocomplete="on" placeholder="Username" />
                <label class="no-placeholder-hide">Password</label><input type="password"  id='password' name="password" placeholder="Password" />
                <label class="no-placeholder-hide">Confirm Password</label><input type="password" style="display:none;" id='cnpassword' name="cnpassword" placeholder="Confirm Password" />
				
                <input type="submit" id='loginBtn' name='loginBtn' value="Login" onclick="return false;" />
				
                    <!--<label><p>Keep Login</p><input type="checkbox" name="remember" /></label>-->
            </div>
			  </form>
		</div>
  <!--
            <div id="client" class="hide">
                <label class="no-placeholder-hide">Username</label><input type="text" name="username" placeholder="Username" />
                <label class="no-placeholder-hide">Password</label><input type="password" name="password" placeholder="Password" />
                <label class="no-placeholder-hide">PIN</label><input type="text" name="pin" placeholder="Enter PIN Code" />
                <input type="submit" value="Login" />
                    <label><p>Keep Login</p><input type="checkbox" name="remember" /></label>
                
                <ul id="options">
                    <li><a href="#account">Request Account</a></li>
                    <li><a href="#forget">Forgot Password?</a></li>
                </ul>
            </div>

                <div id="account" class="hide">
                    <label class="no-placeholder-hide">Username</label><input type="text" name="username" placeholder="Username" />
                    <label class="no-placeholder-hide">Password</label><input type="password" name="password" placeholder="Password" />
                    <label class="no-placeholder-hide">E-Mail</label><input type="text" name="email" placeholder="Email" />
                    <label class="no-placeholder-hide">Company</label><input type="text" name="company" placeholder="Company" />
                    <input type="submit" value="Submit Request" />
                </div>
                
                <div id="forget" class="hide">
                    <label class="no-placeholder-hide">Username or E-mail Address</label><input type="text" name="forgetInput" class="inputForget" placeholder="Enter your Username or Email address">
                    <input type="submit" value="Send" />
                </div>
        
            <div id="visitor" class="hide">
                <label class="no-placeholder-hide">Username</label><input type="text" name="username" placeholder="Username" />
                <label class="no-placeholder-hide">Password</label><input type="password" name="password" placeholder="Password" />
                <label class="no-placeholder-hide">PIN</label><input type="text" name="pin" placeholder="Enter PIN Code" />
                <input type="submit" value="Login" />
            </div>
            
   //-->
</div>

<!-- /////////////////////////////////////////Drop downs////////////////////////////////// -->
<div id="dropdowns">
    <form id="form" name="test" action="login.php" method="POST">
    
    <ul id="menu">
       <li><a href="javascript:void(0) return false;" title="Login" id='tabTitle'>Selection</a></li>

		<a href='javascript:void(0) return false;' id='selectionClose'>Close</a>
    </ul>
    
        <div id="formWrapper">
		
            <div id="user" >
				<div id='selectionMsg'></div>
                <label class="no-placeholder-hide">Vertical</label>
								
					<select placeholder="Vertical" name='vertical' id='vertical' class='vcp'>
						<option value='na'>Select a Vertical</>
						<option value='1'>Booking</>
						<option value='2'>Retail</>
						<option value='3'>Self-Service</>
						<option value='4'>UK</>
					
					</select><br />
				
                <label class="no-placeholder-hide">Client</label>
					<select  id='client' name="client" placeholder="Client" class='vcp'>
					
					</select><br />
					
					
                <label class="no-placeholder-hide">Project</label>
					<select id='project' name="project" placeholder="Project" class='vcp'>
					
					</select>
				
                 
            </div>
			  </form>
		</div>

</div>
<!-- /////////////////////////////////////////Drop downs////////////////////////////////// -->




<div id="loading" ><img src='img/3MA_loadingcontent.gif' /></div>

<script>
	$(document).ready(function() 
		{ 		
			$("#modal").button();
			$("#modal").click(function(){

				$( "#wrapper" ).dialog({
									
										width: 445,
										modal: true,
										hide: "explode",
										show: 'slide',
										draggable: false,										
										resizable: false										
									});		

				$( ".ui-dialog-content" ).css("padding","0px");
				$( ".ui-widget-header" ).css("display","none");
				
			
				
		
			});
			
			$("#loginBtn").click(function(){	
					
					if( !$("#username").val() || !$("#password").val() ){
							
							$("#msg").html("Please provide valid username and password");
							$("#msg").attr("class","error");
					}else{	
					
						$.ajax({
						type: "POST",
						url: "login_mod.php",
						cache: false,
						async: true,
						data: "username="+ $("#username").val() +"&password="+ $("#password").val()
						}).done(function( msg ) {			
						
								$("#msg").html(msg);
										
									if( msg == "Password Change Required!"){
									
										$("#msg").fadeOut(1500, function(){
											
											window.location = 'http://10.10.40.16/xtable/change_pw.php'
						
										});	

									}						
	
								if( msg == 'Login Successful.'){
									
									window.location.href = 'http://localhost/usablex/xtable/home.php';
									
									
				/* 						$("#selectionMsg").html(msg);
										$("#selectionMsg").attr("class","success");										
										$("#selectionMsg").fadeOut("slow");
										$("#selectionMsg").css("margin-bottom","10px");
										
										$( "#wrapper" ).dialog("close");
										
											$( "#dropdowns" ).dialog({
												
													width: 445,
													modal: true,													
													hide: "explode",
													show: 'slide',
													draggable: false,										
													resizable: false										
												});		
												
												$("#selectionClose").click(function(){
				
													$( "#dropdowns" ).dialog("close");
												
												});
												
													$( ".ui-dialog-content" ).css("padding","0px");
													$( ".ui-widget-header" ).css("display","none");
													$( ".vcp" ).css("width","400px");
													$( ".vcp" ).css("height","30px");
													$( ".vcp" ).css("margin-bottom","15px");
													
													
													$("#selectionMsg").fadeOut(3000); */
													
								}else{
								
										$("#msg").attr("class","error");
								}
								
															  
						});				
					}
					
					
			
				});//LOGIN BUTTON
				
				$("#logout").fadeOut(4000);
			
				$("#vertical").change(function(){
				
					if( $("#vertical").val() ){
					
						$.ajax({
							type: "GET",
							url: "dd.php",
							cache: false,
							async: true,
							data: "vert="+ $("#vertical").val() + "&client=1"
							}).done(function( msg ) {	
								
									$("#client").html(msg);
								
								});
						}
				
				});
			
			
			
			$("#client").change(function(){
				
					if( $("#vertical").val() && $("#client").val() ){
					
						$.ajax({
							type: "GET",
							url: "dd.php",
							cache: false,
							async: true,
							data: "vert="+ $("#vertical").val() + "&client="+  $("#client").val() + "&project=1"
							}).done(function( msg ) {	
								
									$("#project").html(msg);
								
								});
						}
				
				});
			
			
			
			
				$("#close").click(function(){
				
					$( "#wrapper" ).dialog("close");
				
				});
			
				
				$("#project").change(function(){
				
					var url = "http://10.10.40.16/xtable/index.php?vertical="+$("#vertical").val()+"&client="+$("#client").val()+"&project="+$("#project").val()
					
					window.location.href = url;
				
				});
			
				$("#loading").ajaxStart(function(){
				
				$(this).show();
				
			});
			
			$("#loading").ajaxStop(function(){
			
				$(this).hide();
				
			});
			
			
				

		});

</script>
</body>
</html>