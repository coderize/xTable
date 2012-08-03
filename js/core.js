xTable = window.xTable || {};

xTable = {
is_loggedin : function(a){if(a=="INVALID_SESSION"){$("#logged-out").dialog({height:300,width:400,modal:true,resizable:false});function b(){window.location.reload();}setTimeout(b,2e3);return false}else{return true}},

pauser : function(){
var that = this;
function a(){var a=Math.round(+(new Date)/1e3);return a}$("#pauseIni").html(a());$("#pauseCur").html("0");$("#pauseDur").html("0");$("#pauseTotalDur").html("0");$("#pauseCount").html("0");$(".pauser, #addSimilar, #addAnother, #add").bind("click",function(){$("#pauseCur").html(a());var b=parseInt($("#pauseIni").html());var c=parseInt($("#pauseCur").html());var d=c-b;$("#pauseDur").html(d);var e=300;if(d<e){$("#pauseIni").html($("#pauseCur").html());that.validCreate()}else{var f=parseInt($("#pauseTotalDur").html());var f=f==0?d:f+d;var g=parseInt($("#pauseCount").html());var g=g==0?1:g+1;$("#pauseIni").html($("#pauseCur").html());$("#pauseTotalDur").html(f);$("#pauseCount").html(g)}})

},

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
	var that = this;
	var parent = $(par).parent().parent();	 
	
		
	//	var eid = $(parent).children("td:nth-child(1)").html();
	//	var result = $(parent).children("td:nth-child(6)").html();
	//	var dataObj =  {"resultsEdit":"true","eid":eid,"result":result};
	
		
		var mid  = encodeURIComponent($(parent).children("td:nth-child(1)").html());
		var func = encodeURIComponent($(parent).children("td:nth-child(2)").html());
		var status = encodeURIComponent($(parent).children("td:nth-child(3)").html());
		var tcid = encodeURIComponent($(parent).children("td:nth-child(4)").html());
		var priority = encodeURIComponent($(parent).children("td:nth-child(5)").html());
		var clas = encodeURIComponent($(parent).children("td:nth-child(6)").html());
		var name = encodeURIComponent($(parent).children("td:nth-child(7)").html());
		var prereq = encodeURIComponent($(parent).children("td:nth-child(8)").children("pre:nth-child(1)").html());
		var steps = encodeURIComponent($(parent).children("td:nth-child(9)").children("pre:nth-child(1)").html());
	//	var steps = $(parent).children("td:nth-child(9)").children("pre:nth-child(1)").html();
		var expected = encodeURIComponent($(parent).children("td:nth-child(10)").children("pre:nth-child(1)").html());
		var dataObj = {"tableEdit":"true", "mid":mid, "func":func, "status":status,"tcid":tcid, "priority":priority, "clas":clas, "name":name,"prereq":prereq, "steps":steps, "expected":expected}
		
		
	$.ajax({
	type: "POST",
	url: "action.php",
	cache: false,	
	async: false,
	data: dataObj
	}).done(function( msg ) {
			
		if( that.is_loggedin(msg) ){					
						
			if(msg =='200'){
					 	
				$(".editSuccess").css("display","block");
				$(".editSuccess").fadeOut(3000);

			}else{	alert ("Error: Server responded with:" + msg); }
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
	var that = this;
	var custFunction =  ( $("#newfunction").val() ) ? encodeURIComponent($("#newfunction").val()) :  encodeURIComponent($("#function").val());
	this.cFieldsCheck();
	this.validCreate();
				
				if( $("#function").val() == "other450311") {

							$.ajax({
								type: "POST",
								url: "action.php",
								cache: false,	
								async: false,
							        data: {"othertcid" : "true", "rel" : data.rel }
								}).done(function( msg ) {

								if( that.is_loggedin(msg) ){	
								
									if(msg){
									
										$("#tcid").val(msg);
										$("#tcid").change();									
										that.cFieldsCheck();
										that.validCreate();										
									}
								}
								
							});		

				}else if( $("#function").val() != 'na' && $("#function").val() !='other450311' ){
						
					$.ajax({
								type: "POST",													  
								url: "action.php",													  
								cache: false,	
								async: false,
								data: {"newtcid" : "true", "funcname" : custFunction, "rel" : data.rel}
								}).done(function( msg ) {
								
								if( that.is_loggedin(msg) ){	
								
									$("#tcid").val(msg);	
									$("#tcid").change();
									that.cFieldsCheck();					
									that.validCreate();
									
								}
									
							});
				
				
				
				}

},


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
	var that = this;
	$("<textarea id='myTextarea'></textarea>").html(ele.childNodes[0].innerHTML).appendTo("body");
	$( "#myTextarea" ).dialog({
				autoOpen: true,
				height: 500,
				width: 800,
				modal: true,
				title: 'Modify',
				resizable: false,
				buttons: { "Save": function() {
				
					ele.childNodes[0].innerHTML = that.strip_tags($("#myTextarea").val(), '<i><b>');
					that.editAjax(ele.childNodes[0], "editSV");
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


editElement : function (ele, obj, type, ml, tbn ){			
				var that = this;
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
						that.editAjax(elem.childNodes[0]);	
						$('input#search').quicksearch('#myTable tbody tr');	
					}  			
					
					 seleEdit.onblur = function(){				
						
						 var ms  = $("#mySelect option:selected").text();
						 $(elem).html(ms);
					 }

					 seleEdit.onkeyup = function(){		
					  	var ms  = $("#mySelect option:selected").text();
						$(elem).html(ms);																	
						that.editAjax(elem.childNodes[0]);	
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
							that.editAjax(ele.childNodes[0]);
							$('input#search').quicksearch('#myTable tbody tr');
						}				
			}			
			
},


footerCount : function (){
	
	var tcCount = $(".mid").length;
	var tcShownCount = 0;
	$("#myTable tr").each(function(){
		
		if( this.style.display != 'none'){

			tcShownCount++;
		}
 

	});

	$("#pagerText").html("Showing Testcases: " + tcShownCount + " of " + tcCount ) ;

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
			xTable.footerCount();
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
			async: false,
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
								async: false,
								data: "test=test"
							}).done(function( msg ) {
								
									$("#sCreateTime").html(msg);

							});
				

				}
			});				
										
										


},	



executeTestcase : function (){


		if( this.relCheck("Select a component first!") ){
		
			return;
		}
	
		var that = this;

		$.ajax({											
			type: "POST",
			url: "execution.php",
			cache: false,
			data: {"rel":data.rel}								  
			}).done(function( msg ) {
				
				if( that.is_loggedin(msg) ){	
		
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

},	


logout : function(){
	var that = this;
	$( "#logout-confirm" ).dialog({
		resizable: false,
		height:140,
		modal: true,
		buttons: {"Log out from xTable": function() {
					$.ajax({											
						type: "POST",
						url: "login_mod.php",
						cache: false,
						data: {"kill":"kill"}
						}).done(function( msg ) {
							if( that.is_loggedin(msg) ){		
								if (msg == "true"){
									window.location.href ="login.php?logout=true";
								}else{	alert("Error logging out, try again");	}
							}												
						});		
			},
		Cancel: function() {	$( this ).dialog( "close" );	}
		}
	});	
},


cellEdit : function(){
	
	var that = this;

		$("#myTable tr").each(function(index) {				
													
			this.childNodes[0].className = 'mid ui-widget-content';
			this.childNodes[1].className = 'function ui-widget-content';
			this.childNodes[1].ondblclick = function (){
																
				that.editElement(this, priorityObj,true,75);																	
			}
															
			this.childNodes[2].className = 'status ui-widget-content';
			this.childNodes[2].ondblclick = function (){
								
				that.editElement(this, statusObj,false,5);
			}
															
			this.childNodes[3].className = 'tcid ui-widget-content';
			this.childNodes[3].ondblclick = function (){
				
				that.editElement(this, priorityObj,true,5);
			}
															
			this.childNodes[4].className = 'priority ui-widget-content';
			this.childNodes[4].ondblclick = function (){
				
				that.editElement(this, priorityObj,false,8);
			}

			this.childNodes[5].className = 'class ui-widget-content';
			this.childNodes[5].ondblclick = function (){
			
				that.editElement(this, classObj,false,25);
			}
															
			this.childNodes[6].className = 'name ui-widget-content';
			this.childNodes[6].ondblclick = function (){
			
				that.editElement(this, priorityObj,true,100);
			}
														
			this.childNodes[7].className = 'prerequisite ui-widget-content';
			this.childNodes[7].ondblclick = function (){
													
				that.editSV(this);
			}
															
			this.childNodes[8].className = 'scenario ui-widget-content';
			this.childNodes[8].ondblclick = function (){
																	
				that.editSV(this);
			}
														
			/*this.childNodes[9].className = 'verification ui-widget-content';
			this.childNodes[9].ondblclick = function (){
															
				that.editSV(this);
			}*/
														
		});



},


createFunc : function(){

	 if( $("#function").val() == "other450311"  &&  $("#newfunction").length < 1 ) {

		$("#function").parent().append("<input type='text'  id='newfunction' class='cf pauser' name='newfunction' style='position:absolute; text-align:left; right:55px; top:25px; width:290px;' />");
		$('input:text, input:password').button().addClass('inpField');
		this.validCreate();
	
		$(".cf").keyup(function(){
			
			if( $.trim($(this).val()) ){
				
				$(this).parent().siblings(':first').html("<img class='success' src='img/accept.gif'/>");											
			}else{
				$(this).parent().siblings(':first').html("<img class='error' src='img/denied.gif'/>");
			}
										
		}); 
											
 }else{
	$("#newfunction").remove();
	this.validCreate();
 }

},



addTestcase : function (action){

	var that = this;

	//validates TC creation
	this.validCreate();	
	
	/////GET ETIME /////
	$.ajax({
		type: "GET",													  
		url: "time.php",													  
		cache: false,	
		async: false,
		data: "test=test",													  
		}).done(function( msg ) {
			
			if( that.is_loggedin(msg) ){	$("#eCreateTime").html(msg); }
				
		});		


	//////////VERIFY WHICH OTHER OR NEW FUNCTION///////////
	var custFunction = ($("#newfunction").val() ) ? $("#newfunction").val() : $("#function").val();

	//GETS TCID VAL
	var defaultTCID = $("#tcid").val();
	
			
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
		data: {"cTestcase":"true","tcid":encodeURIComponent($("#tcid").val()),"rel":data.rel,"function":encodeURIComponent(custFunction),"name":encodeURIComponent($("#testname").val()),"priority":encodeURIComponent($("#priority").val()),"class":encodeURIComponent($("#class").val()),"prereq":encodeURIComponent($("#preConditions").val()),"scenario":encodeURIComponent($("#scenario").val()),"expected":encodeURIComponent($("#verification").val()),"stime":encodeURIComponent($("#sCreateTime").html()),"etime":encodeURIComponent($("#eCreateTime").html()),"pc":encodeURIComponent(pc),"ptd":encodeURIComponent(ptd),"status":encodeURIComponent($("#status").val())} 
		}).done(function( msg ) {
			
			if( that.is_loggedin(msg) ){	
				
				var myObj =  jQuery.parseJSON(msg);

				if(myObj.code == '200'){
					$("#function").change();
					$("#indicator").css("display","block");					
								
					$("#indicator").fadeOut(2000, function(){

					//VALIDATE CREATE BUTTONS
					that.validCreate();
											
					if(action == "close"){	$("#createForm").dialog( "close" );}
						
					if(action == 'aa'){

						if ( $("#function").val() == 'other450311' ){
							
						       	$.ajax({
								type: "POST",
								url: "action.php",
								cache: false,
								data: {"popFuncs":"true","rel":data.rel}					  
								}).done(function( msg ) {	
													
									$("#function").html(msg);
									$("#createForm select").selectmenu('destroy');
									$("#createForm select").selectmenu({style: 'dropdown', maxHeight: 400});															
								});																
						}

						
						that.cleanCreate();										
					}										
					
					if(action == 'as'){
						
						if ( $("#function").val() == 'other450311' ){
							
							$.ajax({
								type: "POST",
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
$('#myTable tbody').prepend('<tr><td class="mid ui-widget-content">' + myObj.mysql_last_id + '</td><td style="text-transform:uppercase;" ondblclick="javascript:xTable.editElement(this,priorityObj,true,75);" class=" function rhw ui-widget-content" style="text-align:center;">' + custFunction + '</td><td ondblclick="javascript:xTable.editElement(this,statusObj,false,8);" class="tdw center ui-widget-content"  style="text-align:center;">' +$("#status option:selected").text() + '</td><td ondblclick="javascript:xTable.editElement(this,priorityObj,true,5);" class="tdw center  ui-widget-content"  style="text-align:center;">' +defaultTCID + '</td><td ondblclick="javascript:xTable.editElement(this,priorityObj,false,8);" class="tdw center ui-widget-content"  style="text-align:center;">' + $("#priority option:selected").text() + '</td><td ondblclick="javascript:xTable.editElement(this,classObj,false,25);"  class="tdw center  ui-widget-content"  style="text-align:center;">' + $("#class option:selected").text() + '</td><td  ondblclick="javascript:xTable.editElement(this,priorityObj,true,100);"  class="tdw center  ui-widget-content"  style="text-align:left;">' +$("#testname").val()+'</td><td  ondblclick="javascript:xTable.editSV(this);"  class="tdw tdh  ui-widget-content"><pre>' +  that.strip_tags($("#preConditions").val(), '<i><b>') +'</pre></td><td ondblclick="javascript:xTable.editSV(this);" class="tdw tdh  ui-widget-content"><pre>'+ that.strip_tags($("#scenario").val(), '<i><b>') +'</pre></td><td ondblclick="javascript:xTable.editSV(this);" class="tdw tdh  ui-widget-content"><pre>'+ that.strip_tags($("#verification").val(), '<i><b>') + '</pre></td></tr>');	
									
$('input#search').quicksearch('#myTable tbody tr');	
	
that.footerCount();

	}else{
		
		alert("Could not contact server");						
		$("#add").click(function(){ $("#createForm").dialog( "close" ); });									
	} 
							
					}		
			
			});	 

	////GLOBAL SEARCH REINITIALIZATION///
	$('input#search').quicksearch('#myTable tbody tr');


},

resultsEdit : function (){

	var that = this;
	$("#resultsTable tr").each(function(index) {				
		
		this.childNodes[1].className = 'eid ui-widget-content';
		this.childNodes[3].className = 'tcid ui-widget-content';
		this.childNodes[5].className = 'name ui-widget-content';
		this.childNodes[7].className = 'device ui-widget-content';
		this.childNodes[9].className = 'duration ui-widget-content';
		this.childNodes[11].className = 'result ui-widget-content';
		this.childNodes[11].ondblclick = function (){

			that.editElement(this, resultObj, false, 25, "execResult");
		}
	});
	      
},	


resize : function (){
	
	var hght = ($(".mid").length==0) ? 125 : 157;
	var finHght = parseInt(window.innerHeight - hght);
	$(".body").css("height", finHght);
},



bootstrap: function(){

	$('#myTable').columnFilters();
	var hght = ($(".mid").length==0) ? 125 : 157;
	$('#myTable').fixheadertable({ 
		caption     : ' ', 
		colratio    : [1, 150, 105, 65, 78, 150, 150, 150, 400],
		height      : window.innerHeight - hght,
		zebra       : false,
		sortable    : true,
		sortedColId : 2, 
		sortType    : ['integer','string', 'string', 'integer', 'string', 'string', 'string', 'string', 'string'],
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
	$(".t_fixed_header_main_wrapper").append("<div id='pager'><span id='pagerText'></span></div>");	
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

	//click evnt handler for cell editing
	this.cellEdit();

	//click event handler for create testcase method
	$("#addBtn").click(function(){ xTable.createTestcase();  });

	//click event handler for execute testcase
	$("#execBtn").click(function(){	xTable.executeTestcase(); });
	
	//click event handler for logeut
	$("#logout").click(function() { xTable.logout(); });
	
	//change event handler for createForm function selection
	$("#function").change(function(){ xTable.createFunc(); xTable.tcidLogic(); });
	
	//adds styling to buttons and inputs
	$( "button, input:submit, input:reset" ).button();	

	$("#loading").ajaxStart(function(){	$(this).show(); });			
	$("#loading").ajaxStop(function(){	$(this).hide(); });	
	$("#bodyContainer").css("visibility","visible");
	$("#search").css("display","block");
	
	$("#_filterText1").click(function(){ $(this).val(""); }).val("Search...");	
	$("#_filterText1").blur(function(){ $(this).val("Search.."); });
				

	
	$('#switcher').themeswitcher();

	$("#add").click(function(){		xTable.addTestcase("close");	});	
	$("#addAnother").click(function(){	xTable.addTestcase("aa");	xTable.pauser(); 	});	
	$("#addSimilar").click(function(){	xTable.addTestcase("as");	xTable.pauser();  });


}//end BOOTSTRAP



}
