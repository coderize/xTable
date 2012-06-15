function resultsEdit(){

		$("#resultsTable tr").each(function(index) {				
														
					this.childNodes[1].className = 'eid ui-widget-content';

					this.childNodes[3].className = 'tcid ui-widget-content';
					
					this.childNodes[5].className = 'name ui-widget-content';

					this.childNodes[7].className = 'device ui-widget-content';

					this.childNodes[9].className = 'duration ui-widget-content';

					this.childNodes[11].className = 'result ui-widget-content';
					this.childNodes[11].ondblclick = function (){
						
							xTable.editElement(this, resultObj, false, 25);
					

					}
		});
			
	}
