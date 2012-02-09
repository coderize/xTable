function addEdit(){

			$("#myTable tr").each(function(index) {				
													
															this.childNodes[0].className = 'mid ui-widget-content';
		

															this.childNodes[1].className = 'function ui-widget-content';
															this.childNodes[1].ondblclick = function (){
																
																	editElement(this, priorityObj,true,75);
																	
															
															}
															
															this.childNodes[2].className = 'status ui-widget-content';
															this.childNodes[2].ondblclick = function (){
																
																	editElement(this, statusObj,false,5);
															
															}
															
															this.childNodes[3].className = 'tcid ui-widget-content';
															this.childNodes[3].ondblclick = function (){
																
																	editElement(this, priorityObj,true,5);
															
															}
															
															this.childNodes[4].className = 'priority ui-widget-content';
															this.childNodes[4].ondblclick = function (){
																
																	editElement(this, priorityObj,false,8);
															
															}
															
															this.childNodes[5].className = 'class ui-widget-content';
															this.childNodes[5].ondblclick = function (){
																
																	editElement(this, classObj,false,25);
															
															}
															
															this.childNodes[6].className = 'name ui-widget-content';
															this.childNodes[6].ondblclick = function (){
																
																	editElement(this, priorityObj,true,100);
															
															}
														
															this.childNodes[7].className = 'prerequisite ui-widget-content';
															this.childNodes[7].ondblclick = function (){
																
																	editSV(this);
																	
															
															}
															
															this.childNodes[8].className = 'scenario ui-widget-content';
															this.childNodes[8].ondblclick = function (){
																
																	editSV(this);
															
															}
														
														
															this.childNodes[9].className = 'verification ui-widget-content';
															this.childNodes[9].ondblclick = function (){
																
																	editSV(this);
															
															}
														
													});
													
			}