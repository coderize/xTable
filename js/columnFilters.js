
function columnFilter(){

				var rows = $("#myTable tr");
							
							 $("#_filterText1").keyup( function(){
							 
								rows.children("td:nth-child(2)").each(function() {									
								
										var reg = document.getElementById("_filterText1").value;										
										
										var html = this.childNodes[0].nodeValue;
											
											var patt = new RegExp(""+ reg +"","i");
									
											var res = patt.test(""+html+""); 		
										
									if ( res ) {
										
										 $(this).parent().css("display","table-row");							
										 
									
									}else{
									
										 $(this).parent().css("display","none");										 
									} 							
										
								}); 
							
							});//END KEYUP
							
							
							
							 $("#_filterText2").keyup( function(){
							 
								rows.children("td:nth-child(3)").each(function() {									
								
										var reg = document.getElementById("_filterText2").value;										
										
										var html = this.childNodes[0].nodeValue;
											
											var patt = new RegExp(""+ reg +"","i");
									
											var res = patt.test(""+html+""); 		
										
								if ( res ) {
										
										 $(this).parent().css("display","table-row");	
										 
										 											
									
									}else{
									
										 $(this).parent().css("display","none");										 
									} 							
										
								}); 
							
							});//END KEYUP
							
							 $("#_filterText3").keyup( function(){
							 
								rows.children("td:nth-child(4)").each(function() {									
								
										var reg = document.getElementById("_filterText3").value;										
										
										var html = this.childNodes[0].nodeValue;
											
											var patt = new RegExp(""+ reg +"","i");
									
											var res = patt.test(""+html+""); 		
										
								if ( res ) {
										
										 $(this).parent().css("display","table-row");	
										 
										 											
									
									}else{
									
										 $(this).parent().css("display","none");										 
									} 							
										
								}); 
							
							});//END KEYUP
							
							
								 $("#_filterText4").keyup( function(){
							 
								rows.children("td:nth-child(5)").each(function() {									
								
										var reg = document.getElementById("_filterText4").value;										
										
										var html = this.childNodes[0].nodeValue;
											
											var patt = new RegExp(""+ reg +"","i");
									
											var res = patt.test(""+html+""); 		
										
								if ( res ) {
										
										 $(this).parent().css("display","table-row");	
										 
																				
									
									}else{
									
										 $(this).parent().css("display","none");										 
									} 							
										
								}); 
							
							});//END KEYUP
							
								 $("#_filterText5").keyup( function(){
							 
								rows.children("td:nth-child(6)").each(function() {									
								
										var reg = document.getElementById("_filterText5").value;										
										
										var html = this.childNodes[0].nodeValue;
											
											var patt = new RegExp(""+ reg +"","i");
									
											var res = patt.test(""+html+""); 		
										
								if ( res ) {
										
										 $(this).parent().css("display","table-row");	
										 
																			
									
									}else{
									
										 $(this).parent().css("display","none");										 
									} 							
										
								}); 
							
							});//END KEYUP
							
							
							 $("#_filterText6").keyup( function(){
							 
								rows.children("td:nth-child(7)").each(function() {									
								
										var reg = document.getElementById("_filterText6").value;										
										
										var html = this.childNodes[0].nodeValue;
											
											var patt = new RegExp(""+ reg +"","i");
									
											var res = patt.test(""+html+""); 		
										
								if ( res ) {
										
										 $(this).parent().css("display","table-row");	
										 
																			
									
									}else{
									
										 $(this).parent().css("display","none");										 
									} 							
										
								}); 
							
							});//END KEYUP
							
							
							
							
								 $("#_filterText7").keyup( function(){
							 
								rows.children("td:nth-child(8)").each(function() {									
								
										var reg = document.getElementById("_filterText7").value;										
										
									var html = this.childNodes[0].childNodes[0].nodeValue;
											
											var patt = new RegExp(""+ reg +"","i");
									
											var res = patt.test(""+html+""); 		
										
								if ( res ) {
										
										 $(this).parent().css("display","table-row");	
										 
										 												
									
									}else{
									
										 $(this).parent().css("display","none");										 
									} 							
										
								}); 
							
							});//END KEYUP
							
							
								 $("#_filterText8").keyup( function(){
							 
								rows.children("td:nth-child(9)").each(function() {									
								
										var reg = document.getElementById("_filterText8").value;										
										
										var html = this.childNodes[0].childNodes[0].nodeValue;
											
											var patt = new RegExp(""+ reg +"","i");
									
											var res = patt.test(""+html+""); 		
										
								if ( res ) {
										
										 $(this).parent().css("display","table-row");	
										 
																				
									
									}else{
									
										 $(this).parent().css("display","none");										 
									} 							
										
								}); 
							
							});//END KEYUP
							
								 $("#_filterText9").keyup( function(){
							 
								rows.children("td:nth-child(10)").each(function() {									
								
										var reg = document.getElementById("_filterText9").value;										
										
										var html = this.childNodes[0].childNodes[0].nodeValue;
											
											var patt = new RegExp(""+ reg +"","i");
									
											var res = patt.test(""+html+""); 		
										
								if ( res ) {
										
										 $(this).parent().css("display","table-row");																				
									
									}else{
									
										 $(this).parent().css("display","none");										 
									} 							
										
								}); 
							
							});//END KEYUP
							
							
						
							
							
							
		}				