function userEdit(){

			$("#userTable tr").each(function(index) {				
													
															this.childNodes[0].className = 'uid ui-widget-content';
		

															this.childNodes[1].className = 'firstname ui-widget-content';
															this.childNodes[1].ondblclick = function (){
																
																	editElement(this, locationObj,true,75);

															}
															
															this.childNodes[2].className = 'lastname ui-widget-content';
															this.childNodes[2].ondblclick = function (){
																
																	editElement(this, locationObj,true,75);
												
															}
															
															this.childNodes[3].className = 'email ui-widget-content';
															this.childNodes[3].ondblclick = function (){
																
																	editElement(this, locationObj,true,75);
															
															}
															
															this.childNodes[4].className = 'password ui-widget-content';
															this.childNodes[4].ondblclick = function (){
																
																	editElement(this, locationObj,true,75);
															
															}
															
															this.childNodes[5].className = 'group ui-widget-content';
															this.childNodes[5].ondblclick = function (){
																
																	editElement(this, groupObj,false,25);
															
															}
															
															this.childNodes[6].className = 'location ui-widget-content';
															this.childNodes[6].ondblclick = function (){
																
																	editElement(this, locationObj,false,100);

															}
														
															this.childNodes[7].className = 'status ui-widget-content';
															this.childNodes[7].ondblclick = function (){
																
																	editElement(this, statusObj,false,100);

															}
																													
													});
													
			}