(function($) {
	$.groupRows = function(el, options)
	{
		var base = this;
		
		// Access to jQuery and DOM versions of element
		base.$el = $(el);
		base.el = el;

		base.init = function()
		{
				base.options = $.extend({},$.groupRows.defaultOptions, options);
	
				var iColumnCount = base.el.rows[0].childNodes.length;
				var iRowCount = base.el.rows.length - 1; //-1 because of headers
				
				var group = 0;
				var groupRowCount = 0;
				var sPreviousColumnText = "_"; //dummy starter text
				$("tr", base.el).each(function(i)
				{
					if (!(base.options.ignoreFirstRow == true && i == 0))
					{
						var row = this;
						var sColumnText = $.trim($(row.cells[base.options.groupColumn]).text());
						//if found new group
						if (sColumnText != sPreviousColumnText)
						{
							//put row count with previous group
							base.setGroupRecordCount(group, groupRowCount);
							
							sPreviousColumnText = sColumnText;
							
							//add new group row
							group++;
							var sGroupText = (sPreviousColumnText == "") ? "[Blank]" : sPreviousColumnText;
							sGroupText = "<span class='groupRowTitle'>"+group+". "+sGroupText+"</span>";
							//include extra group row details
							if (base.options.columnsForGroupRow.length > 0)
							{
								sGroupText += ": ";
								var sGroupRowData = "";
								for (var i = 0; i < base.options.columnsForGroupRow.length; i++)
								{
									var iColumn = base.options.columnsForGroupRow[i];
									sGroupRowData += ", "+$.trim($(row.cells[iColumn]).text());
								}
								sGroupRowData = sGroupRowData.substring(2);
								sGroupText += sGroupRowData;
							}
							
							var groupRow = $("<tr class='groupRow group"+group+"'><td colspan='"+iColumnCount+"' class='group"+group+"'>"+sGroupText+"</td></tr>");
							$(groupRow).data("group", group);
							
							$(row).before(groupRow);
							
							groupRowCount = 0;
						}
						
						$(row).addClass("group"+group).addClass("groupData").data("group", group);
						groupRowCount++;
					}
				});
				
				//set record count for last group
				base.setGroupRecordCount(group, groupRowCount);
				
				//make group rows toggle their child records
				$(".groupRow", base.el).click(function()
				{
					var id = $(this).data("group");
					$("tr.group"+id+":not(.groupRow)", base.el).toggle();
				})
				.hover(function()
				{
					$(this).css("cursor", "pointer");
				});
				
				//hide all group data initially
				$(".groupData", base.el).hide();
		}
		
		base.setGroupRecordCount = function(groupId, count)
		{
			var sRecordCount = " ("+count+")";
			$("tr.group"+groupId+":not(.groupData) span.groupRowTitle", base.el).append(sRecordCount);
		}
		
		base.init();
	};
	
	$.groupRows.defaultOptions = {
		groupColumn: 0,
		columnsForGroupRow: [],
		ignoreFirstRow: true
	}
	
	$.groupRows.destroy = function(table)
	{
		$("tr.groupRow", table).remove();
		$("tr.groupData", table)
		.removeClass("groupData")
		.each(function()
		{
			$(this).removeClass("group"+$(this).data("group"));
		})
		.show();

	}
	
	$.fn.groupRows = function(options)
	{
		return this.each(function()
		{
			(new $.groupRows(this, options));
		});
	}

})(jQuery);
