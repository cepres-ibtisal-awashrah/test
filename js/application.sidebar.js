/*******************************************************************/
/* Sidebar  */

App.Sidebar = new function()
{
	var self = this;

	self.sidebar = $('#sidebar');
	self.pos = 0;
	self.offset = 0;
	self.width = 0;
	self.min = 250;
	self.max = 500;
	self.visible = true;
	self.splitter = null;
	self.document = null;

	self.init = function()
	{
		self._setResizable();
	}

	//---------------------------------------------------------------
	// SHOW/HIDE & WIDTH
	//---------------------------------------------------------------

	self.isVisible = function()
	{
		return self.visible;
	}

	self.getWidth = function()
	{
		return self.sidebar.width();
	}

	//---------------------------------------------------------------
	// RESIZE
	//---------------------------------------------------------------

	self._setResizable = function()
	{
		self.document = $(document);
		self.splitter = $('#sidebar-splitter');
		self.splitter.bind('mousedown.sidebar', self._resizeStart);
	}

	self._resizeStart = function(e)
	{
		self.pos = self._getResizePosition(e);
		self.width = self.sidebar.width(); // Current
		self.offset = self.width; // Initial width
		self.document.bind('mousemove.sidebar', self._resize);
		self.document.bind('mouseup.sidebar', self._resizeStop);
		self._resizeShowProgress();
		return false;
	}

	self._resizeShowProgress = function()
	{
		$('body').css('cursor', 'ew-resize');
		self.splitter.addClass('splitter-resizing');
	}

	self._resize = function(e)
	{
		var width = self._resizeWidth(e);
		var delta = width - self.width;
		self.width = Math.round(width);
		self.sidebar.width(self.width);
		self._resizePage(delta);
		self._resizeChanged();
		return false;
	}

	self._resizeWidth = function(e)
	{
		var delta = self.pos - self._getResizePosition(e);
		var width = delta + self.offset;
		return Math.min(Math.max(width, self.min), self.max);
	}

	self._resizeChanged = function()
	{
		// To refresh charts or sticky elements, for example
		$(window).trigger('resize');
	}

	self._resizePage = function(delta)
	{
		App.Page.updateMinWidth(delta);
	}

	self._resizeStop = function(e)
	{
		self.document.unbind('.sidebar');
		self._resizeHideProgress();
		self._resizeSave();
		self._resizeChanged();

		/** Reflow all on resize */
		Highcharts.charts.forEach(function (ref) {
			if (!ref) {
				return;
			}

			ref.reflow()
		});

		return false;
	}

	self._resizeHideProgress = function()
	{
		self.splitter.removeClass('splitter-resizing');
		$('body').css('cursor', '');
	}

	self._resizeSave = function() 
	{
		App.Ajax.call(
		{
			target: 'mysettings/ajax_set_sidebar_width',
			blockUI: false,
			
			arguments: 
			{
				width: Math.round(self.sidebar.width())
			},
			
			success: function(data)
			{
			},
			
			error: function(data)
			{
				// Do not an display an error for this (this is non-
				// critical). One possible way to trigger an error is to
				// to leave the page directly after changing the sidebar
				// width and while the JS request is still in progress
				// (unlikely, but still possible). This would abort the
				// JS request and call this event handler.
			}
		});
	}

	self._getResizePosition = function(e)
	{
		return self.document.scrollLeft() + e.clientX;
	}
}

;

