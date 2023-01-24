/*******************************************************************/
/* Tooltips */

/* [Permissions checked!] */

App.Tooltips = new function()
{
	var self = this;

	App.ready(
		function()
		{
			self._init();
		}
	);	

	self._init = function()
	{
		$(document).on(
			'mouseenter', 
			'.link-tooltip', 
			function()
			{
				// We initialize the tooltips as late as possible just
				// when the mouse hovers over the element for the first
				// time. This avoids the need to reapply the tooltip
				// functionality every time the page elements change.
				
				var t = $(this);
				if (!t.data('tooltip'))
				{
					t.data('tooltip', true);
					self._apply(t);
				}
			}
		);
	}

	self._apply = function(t)
	{
		t.tooltip({ tooltip: t.attr('tooltip-id') || '#tooltip' });
		t.trigger('mouseover'); // Trigger show (timeout)
	}
}

;

