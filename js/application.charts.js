/*******************************************************************/
/* Chart related routines */

/* [Permissions checked!] */

App.Charts = new function()
{
	var self = this;

	// The chart objects that may be created by the individual pages.
	self.status = null;
	self.activity = null;
	self.action = null;
	self.burndown = null;
	self.defects = null;

	self.selectTimeframe = function(o)
	{
		self._selectTimeframeDialog(o);
	}

	self._selectTimeframeDialog = function(o)
	{
		$('#selectTimeframeSubmit').removeClass('button-busy');

		$('#selectTimeframeForm').unbind('submit');
		$('#selectTimeframeForm').submit(function(e)
		{
			var days = $('#select_timeframe').val();
			if (o.success)
			{
				$('#selectTimeframeSubmit').addClass('button-busy');
				o.success(days)
			}
			return false;
		});

		App.Dialogs.open(
		{
			selector: '#selectTimeframeDialog',
			focusedControl: '#select_timeframe'
		});
	}

	self.reload = function(chart, container, html)
	{
		if (chart)
		{
			// Cleanup the previously created chart, if any. Note:
			// A UI script may have destroyed/recreated the chart in
			// the meantime and this checks if destroy has been called
			// on this chart before (calling destroy twice would give
			// an error).
			if (chart.renderTo !== undefined)
			{
				chart.destroy();
			}
		}
		
		$(container).html(html);		
	}
}
;

