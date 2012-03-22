	function resultsEdit(){

				$("#resultsTable tr").each(function(index) {				
														
					this.childNodes[0].className = 'eid ui-widget-content';

					this.childNodes[1].className = 'tcid ui-widget-content';
					
					this.childNodes[2].className = 'name ui-widget-content';

					this.childNodes[3].className = 'device ui-widget-content';

					this.childNodes[4].className = 'duration ui-widget-content';

					this.childNodes[5].className = 'result ui-widget-content';
					this.childNodes[5].ondblclick = function (){
						
							editElement(this, resultObj, false, 25);
					
					}
															
				});
	}