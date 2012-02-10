/*
 * contactable 1.2.1 - jQuery Ajax contact form
 *
 * Copyright (c) 2009 Philip Beel (http://www.theodin.co.uk/)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) 
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * Revision: $Id: jquery.contactable.js 2010-01-18 $
 *
 */
 
//extend the plugin
(function($){

	//define the new for the plugin ans how to call it	
	$.fn.contactable = function(options) {
		//set default options  
		var defaults = {
			url: 'http://YourServerHere.com/contactable/mail.php',
			name: 'Name',
			email: 'Email',
			message : 'Message',
			subject : 'A contactable message',
			submit : 'SEND',
			recievedMsg : 'Thank you for your message',
			notRecievedMsg : 'Sorry but your message could not be sent, try again later',
			disclaimer: 'Please feel free to get in touch, we value your feedback',
			hideOnSubmit: false

		};

		//call in the default otions
		var options = $.extend(defaults, options);
		//act upon the element that is passed into the design    
		return this.each(function() {
			//construct the form
			var this_id_prefix = '#'+this.id+' ';
			$(this).html('<div id="contactable_inner" class="view over"></div><div id="box" style="z-index:1000;position:absolute;height:400px;width:295px;background-color:#ddd;margin-left:-300px;top:80px;border:1px solid #000;"><div id="menu" style="padding:15px;"><span id="welcome"></span><button name="logout" id="logout">Logout</button><div id="switcher"></div><div class="menu-icons"><a href="javascript:void(0);" name="genPdf" id="genPdf"><img title="Export to PDF" id="pdf" src="img/pdf.jpg" /></a></div></div><div id="main"><div id="icon"><a href="http://10.10.40.16/xtable/index.php?vertical=na" name="navXTable" id="navXTable" title="xTable"><img alt="XTable" id="XTable" src="img/xtable.png" height=" " width=" " /></a></div><div id="icon"><a href="dashboard.html" name="navDashboard" id="navDashboard" ><img alt="Dashboard" id="Dashboard" src="img/dashboard.png" height=" " width=" " title="Dashboard"/></a></div><div id="icon"><a target="_blank"  href="http://10.10.40.16/xtable/reportgen.php" name="navReporting" id="navReporting" title="Reporting"><img alt="Reporting" id="Reporting" src="img/reports_icon.jpg" height=" " width=" " /></a></div><div id="icon"><a href="administration.html" name="navAdministration" id="navAdministration"><img alt="Administration" id="Administration" src="img/admin.png" height=" " width=" " title="Administration"/></a></div></div></div>');
			//show / hide function
			$(this_id_prefix+'div#contactable_inner').toggle(function() {
				$(this_id_prefix+'#overlay').css({display: 'block'});
				$(this).animate({"marginLeft": "-=5px"}, "fast"); 
				$(this_id_prefix+'#box').animate({"marginLeft": "-=0px"}, "fast");
				$(this).animate({"marginLeft": "+=295px"}, "slow"); 
				$(this_id_prefix+'#box').animate({"marginLeft": "+=295px"}, "slow"); 
				$("#contactable_inner").css("background-image","url(img/menu-sn-close.png)");
				$("#contactable_inner").css("opacity","1");
			}, 
			function() {
				$(this_id_prefix+'#box').animate({"marginLeft": "-=295px"}, "slow");
				$(this).animate({"marginLeft": "-=295px"}, "slow").animate({"marginLeft": "+=5px"}, "fast"); 
				$(this_id_prefix+'#overlay').css({display: 'none'});
				$("#contactable_inner").css("background-image","url(img/menu-sn-open.png)");
				$("#contactable_inner").css("opacity",".7");
			});
			
			
		});
	};
 
})(jQuery);
