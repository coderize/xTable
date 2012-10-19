<?php
header("Content-type: text/html; charset=utf-8");
error_reporting(E_ALL ^ E_NOTICE);
require "includes/config.php";
require "includes/sess.php";
session_start();
if( $_SESSION['loggedIn'] === TRUE ){
	
	header('Refresh: 0; URL=home.php');
	exit;
} 
?>
<!DOCTYPE html>
<html>
<head>
<title>xTable Login</title>

<style>
body{margin:0; padding:0; font:100% Arial, sans-serif;}

#wrapper{
	width: 495px !important;
	position: absolute;
	left: 30%;
	top: 30%;
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
                        padding: 8px 0;
                        font: bold 17px/100% Tahoma, Geneva, sans-serif;
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
.smallText{
	
	font-size: 17px;
}


#msg{
	padding-bottom: 15px;

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


<?php

$logout = $_GET['logout'];

if($logout == "true"){
	
	echo "<div id='logout'>You have been logged out!</div>";
} 

?>

<div id="wrapper">
    <form id="form" name="test" action="login.php" method="POST">
    
    <ul id="menu">
       <li><a href="javascript:void(0) return false;" title="Login" id='tabTitle'>Login</a></li>
		<li><a href="#">Change Password</a></li>
    </ul>
    
        <div id="formWrapper">
		
            <div id="user" >
				<div id='msg'></div>
                <label class="no-placeholder-hide">Username</label><input type="text"  id='username' name="username" autocomplete="off" placeholder="Username" />
                <label class="no-placeholder-hide">Password</label><input type="password"  id='password' name="password" autocomplete="off" placeholder="Password" />
                <label class="no-placeholder-hide">Confirm Password</label><input type="password" style="display:none;" id='cnpassword' name="cnpassword" placeholder="Confirm Password" />				
                <input type="submit" id='loginBtn' name='loginBtn' value="Login" onclick="return false;" />
				
                    
            </div>
			  </form>
		</div>
</div>

<div id="loading" ><img src='img/3MA_loadingcontent.gif' /></div>

<script>
$(document).ready(function(){

	$("#modal").button();
	$( ".ui-dialog-content" ).css("padding","0px");
	$( ".ui-widget-header" ).css("display","none");
	$("#username").focus();
				
			
$("#loginBtn").click(function(){

	if( !$("#username").val() || !$("#password").val() ){
								
		$("#msg").html("Please provide valid username and password").attr("class","error smallText");

	}else{	
					
		$.ajax({
			type: "POST",
			url: "login_mod.php",
			cache: false,
			async: true,
			data: {username: $("#username").val(), password: $("#password").val()}
			}).done(function( msg ) {			
						
			$("#msg").html(msg);
			
			if( msg == "Password Change Required!"){
				
				$("#msg").fadeOut(1500, function(){
							
					window.location = 'change_pw.php'
						
				});	

			}						
	
			if( msg == 'Login Successful.'){
											
				window.location.href = 'home.php';
									
			}else{
								
				$("#msg").attr("class","error");
			}
														  
		});					
	}
					
});					
			
				
$("#logout").fadeOut(4000);

			
$("#close").click(function(){
	
	$( "#wrapper" ).dialog("close");
				
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
