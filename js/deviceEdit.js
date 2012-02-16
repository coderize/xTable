function deviceEdit(){

			$("#deviceTable tr").each(function(index) {				
													
															this.childNodes[0].className = 'did ui-widget-content';
		

															this.childNodes[1].className = 'type ui-widget-content';
															this.childNodes[1].ondblclick = function (){
																
																	editElement(this, typeObj,false,75);

															}
															
															this.childNodes[2].className = 'group ui-widget-content';
															this.childNodes[2].ondblclick = function (){
																
																	editElement(this, groupObj,false,75);
												
															}
															
															this.childNodes[3].className = 'name ui-widget-content';
															this.childNodes[3].ondblclick = function (){
																
																	editElement(this, typeObj,true,75);
															
															}
															
															this.childNodes[4].className = 'version ui-widget-content';
															this.childNodes[4].ondblclick = function (){
																
																	editElement(this, typeObj,true,75);
															
															}

															this.childNodes[5].className = 'mac ui-widget-content';
															this.childNodes[5].ondblclick = function (){
																
																	editElement(this, typeObj,true,75);
															
															}															
															
															this.childNodes[6].className = 'udid ui-widget-content';
															this.childNodes[6].ondblclick = function (){
																
																	editElement(this, typeObj,true,75);
															
															}															

															this.childNodes[7].className = 'serial ui-widget-content';
															this.childNodes[7].ondblclick = function (){
																
																	editElement(this, typeObj,true,75);
															
															}			
															
															this.childNodes[8].className = 'priority ui-widget-content';
															this.childNodes[8].ondblclick = function (){
																
																	editElement(this, locationObj,false,75);
															
															}
															
													});
			}