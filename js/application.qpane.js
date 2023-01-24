/*******************************************************************/
/* QPane  */

App.QPane = new function()
{
	var self = this;

	self.qpane = $('#qpane');
	self.pos = 0;
	self.offset = 0;
	self.width = 0;
	self.min = 500;
	self.max = 1000;
	self.visible = false;
	self.splitter = null;
	self.document = null;
	self.current = null;    // The current table row shown in QPane
	self.current_id = null; // The corresponding row ID
	self.loading = null;    // The currently loading table row
	self.loading_id = null; // The corresponding row ID
	self.callbacks = null;
	self.context = null;    // For tracking the status for the user
	self.timer = null;
	self.timer_resize = null;
	self.timer_visible = null;

	self.init = function(context, isActive)
	{
		isActive = isActive || false;
		self._setResizable();
		self._setAutoHeight();
		self.context = context;

		if (!isActive) {
			$(function() {
				self.hide();
			});
		}
	}

	//---------------------------------------------------------------
	// SHOW/HIDE & WIDTH
	//---------------------------------------------------------------

	self.isVisible = function()
	{
		return self.visible;
	}

	self.hide = function()
	{
		if (!self.visible)
		{
			return;
		}

		self._hide();

		if (self.callbacks)
		{
			// Trigger the hide event to restore the previously active
			// state before the qpane (e.g. to refresh the table
			// columns).
			self.callbacks.hide();
		}
	}

	self._hide = function()
	{
		self.qpane.hide();
		self.splitter.hide();
		self.visible = false;
		self._resizePage(-self.qpane.width()); // Decrease min-width
		self._resizeChanged();
		self._visibleSave(false);
	}

	self._visibleSave = function(is_active)
	{
		if (self.timer_visible)
		{
			clearTimeout(self.timer_visible);
			self.timer_visible = null;
		}

		// To prevent dozens of requests per second, we rate-limit the
		// saving of hide/show events and the active status for the
		// qpane.

		self.timer_visible = setTimeout(
			function()
			{
				self._visibleDoSave(is_active);
			},
			250
		);
	}

	self._visibleDoSave = function(is_active)
	{
		App.Ajax.call(
		{
			target: 'mysettings/ajax_set_qpane',
			blockUI: false,

			arguments:
			{
				context: self.context,
				is_active: is_active
			},

			success: function(data)
			{
			},

			error: function(data)
			{
				// Do not an display an error for this (this is non-
				// critical). One possible way to trigger an error is to
				// to leave the page directly after changing the qpane
				// width and while the JS request is still in progress
				// (unlikely, but still possible). This would abort the
				// JS request and call this event handler.
			}
		});
	}

	self.show = function()
	{
		if (self.visible)
		{
			return;
		}

		// Find out the width of the container (window). It's important
		// to do this before calling the event because the event might
		// change the page behavior (e.g. hide the scrollbar, depending
		// on page height) and this also changes the window width. Even
		// with this in mind, the window may still change if the event
		// loads a different result set but this is far less likely and
		// the max-width calculation for the qpane would only be off by
		// a few pixels in the worst case anyway.

		var container_width = $(window).width();

		if (self.callbacks)
		{
			// Trigger the show event to prepare the page for the new
			// qpane state (e.g. to load a different table column
			// layout).
			self.callbacks.show();
		}

		self._show(container_width);
	}

	self._show = function(container_width)
	{
		var width = parseInt(self.qpane.css('width'));
		self.width = self._limitWidth(width, container_width);
		self.qpane.width(self.width);
		self.qpane.show();
		self.splitter.show();
		self.visible = true;
		self._setBodyHeight(); // Correct initial height
		self._resizePage(self.width); // Increase min-width
		self._resizeChanged();
		self._visibleSave(true);
	}

	self.clear = function()
	{
		$('#qpane-content').html('');
		self._setBodyHeight();
	}

	self.startUpdate = function()
	{
		self.qpane.addClass('qpane-loading');
	}

	self.update = function(html)
	{
		$('#qpane-content').html(html);
		self._setBodyHeight();
	}

	self.stopUpdate = function()
	{
		self.qpane.removeClass('qpane-loading');
	}

	self.getWidth = function()
	{
		return self.qpane.width();
	}

	//---------------------------------------------------------------
	// RESIZE & ALIGN
	//---------------------------------------------------------------

	self._setResizable = function()
	{
		self.document = $(document);
		self.splitter = $('#qpane-splitter');
		self.splitter.bind('mousedown.qpane', self._resizeStart);
		self.splitter.dblclick(self._resizeAlign);
	}

	self._resizeAlign = function(e)
	{
		self.width = self.qpane.width(); // Current
		var total = self._getTotalContentWidth();
		var width = parseInt(total / 2);
		self._setWidth(Math.min(total - App.Page.getMinContent(), width) - 10);
		self._resizeSave();
		return false;
	}

	self._getTotalContentWidth = function(container_width)
	{
		var max = container_width || $(window).width();

		if (App.Sidebar.isVisible())
		{
			max -= App.Sidebar.getWidth() + 10;
		}

		return Math.min($('#content').width() + self.width + 10, max);
	}

	self._resizeStart = function(e)
	{
		self.pos = self._getResizePosition(e);
		self.width = self.qpane.width(); // Current
		self.offset = self.width; // Initial width
		self.document.bind('mousemove.qpane', self._resize);
		self.document.bind('mouseup.qpane', self._resizeStop);
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
		var delta = self.pos - self._getResizePosition(e);
		self._setWidth(delta + self.offset);
		return false;
	}

	self._setWidth = function(width)
	{
		width = self._limitWidth(width);
		var delta = width - self.width;
		self.width = Math.round(width);
		self.qpane.width(self.width);
		self._resizePage(delta);
		self._resizeChanged();
	}

	self._limitWidth = function(width, container_width)
	{
		var max = Math.min(
			self.max,
			self._getTotalContentWidth(container_width)
				- App.Page.getMinContent() - 10
		);

		return Math.max(Math.min(width, max), self.min);
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
		self.document.unbind('.qpane');
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
		if (self.timer_resize)
		{
			clearTimeout(self.timer_resize);
			self.timer_resize = null;
		}

		// The double click event for aligning the qpane triggers two
		// mousedowns + ups and a double click. This would result in a
		// total of three save attempts. The timer makes sure to send
		// only one update within a certain time frame.

		self.timer_resize = setTimeout(self._resizeDoSave, 250);
	}

	self._resizeDoSave = function()
	{
		App.Ajax.call(
		{
			target: 'mysettings/ajax_set_qpane_width',
			blockUI: false,

			arguments:
			{
				width: Math.round(self.qpane.width())
			},

			success: function(data)
			{
			},

			error: function(data)
			{
				// Do not an display an error for this (this is non-
				// critical). One possible way to trigger an error is to
				// to leave the page directly after changing the qpane
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

	//---------------------------------------------------------------
	// AUTO-HEIGHT
	//---------------------------------------------------------------

	self._setAutoHeight = function()
	{
		var w = $(window);
		w.scroll(self._setBodyHeight);
		w.resize(self._setBodyHeight);
		$.subscribe('body.changed', 'qpane', self._setBodyHeight);
		self._setBodyHeight();
	}

	self._setBodyHeight = function()
	{
		if (!self.visible)
		{
			return;
		}

		var body = $('#qpane-body');
		if (!body.length)
		{
			return;
		}

		var top = body.offset().top - self.document.scrollTop();
		var height = $(window).height() - top - 15 -
			$('#goals-banner').height();

		body.height(height);
	}

	//---------------------------------------------------------------
	// GRID & ROWS
	//---------------------------------------------------------------

	self.bindRowEvents = function(callbacks)
	{
		self.callbacks = callbacks;
	}

	self.checkRow = function(ctx, backwards)
	{
		if (!self.visible)
		{
			return;
		}

		// This function is called in various places whenever the tree
		// changed (e.g. after a filter was applied or items were
		// deleted). We check if the currently selected row for the
		// qpane is still available. If not, we use the first available
		// row. If we haven't found a row we clear the qpane state and
		// hide the qpane. If we did, we ensure the qpane state and
		// this may also involve loading the qpane content (in case the
		// row changed).

		var row_id = self.current_id;
		var row = row_id ? $('#row-' + row_id) : null;

		if (!row || row.length == 0)
		{
			if (backwards)
			{
				row = $('tr.row:last', ctx);
				if (row.length)
				{
					row[0].scrollIntoView();
				}
			}
			else
			{
				row = $('tr.row:first', ctx);
			}
		}

		if (row.length == 0)
		{
			self.current = null;
			self.current_id = null;
			self._toggleShowEmpty();
			self.clear();
		}
		else if (self.visible)
		{
			row_id = row.attr('rel');
			if (self.current_id == row_id)
			{
				self._toggleShow(row, row_id);
			}
			else
			{
				self._toggleLoad(row, row_id);
			}
		}
	}

	self.clearRow = function()
	{
		self.current = null;
		self.current_id = null;
	}

	self._toggleShowEmpty = function()
	{
		// Because of IE <= 11 bug with div table-cell and 100% heights
		// we need to calculate the qpane-empty top position manually
		// based on the current qpane height. This also means that window
		// resizes are not ideal with the fixed top position. top: 50%
		// would be ideal/preferred, but this is not possible/feasible
		// with IE currently.

		var height = $('#qpane').outerHeight();
		$('#qpane-inner').hide();
		$('#qpane-empty').css('top', Math.round(height / 2) + 'px');
		$('#qpane-empty').show();
	}

	self._toggleHideEmpty = function()
	{
		$('#qpane-empty').hide();
		$('#qpane-inner').show();
	}

	self.toggleRow = function(row_id)
	{
		self._toggleRow(row_id, false);
	}

	self._toggleRow = function(row_id, delay)
	{
		var is_current = false;

		if (self.current)
		{
			is_current = self.current_id == row_id;
		}

		var show = !self.visible;

		if (!is_current && self.current)
		{
			show = true; // Keep qpane active, just change content
		}

		if (self.loading)
		{
			self._unmarkRow(self.loading);
		}

		App.Tables.unbindClick();

		if (!show)
		{
			self._toggleHide();
		}
		else
		{
			var row = $('#row-' + row_id);
			if (is_current || !self.callbacks)
			{
				self._toggleShow(row, row_id);
			}
			else
			{
				// Don't show the pane before the content was loaded
				// via the change event.
				self._toggleLoad(row, row_id, delay);
			}
		}
    self._closeEditMode();
	}

	self._toggleHide = function()
	{
		self.hide();
		if (self.current)
		{
			self._unmarkRow(self.current);
		}
	}

	self._toggleLoad = function(row, row_id, delay)
	{
		if (self.timer)
		{
			clearTimeout(self.timer);
			self.timer = null;
		}

		if (self.current)
		{
			self.current.removeClass('highlighted');
		}

		var was_loading = self.loading_id != null;
		var $tablechart_Id = $('#tablechart_testun');
		self.loading = row;
		self.loading_id = row_id;
		self.loading.addClass('highlighted');

		if ($tablechart_Id.hasClass('table')) {
			$tablechart_Id.removeClass('table');
			$tablechart_Id.addClass('table-extended');
		}

		if (delay)
		{
			// Add a small delay to avoid a high number of requests
			// in a short period of time when stepping through the
			// rows.
			self.timer = setTimeout(
				function()
				{
					self._toggleDoLoad(row, row_id);
				},
				was_loading ? 500 : 100
			);
		}
		else
		{
			self._toggleDoLoad(row, row_id);
		}
	}

	self._toggleDoLoad = function(row, row_id)
	{
		self._busyRow(row);
		self.startUpdate();

		self.callbacks.change(
			row_id,
			function(html)
			{
				// Only update the qpane if the HTML is really for the
				// currently loading row.
				if (row_id == self.loading_id)
				{
					self.update(html);
					self._toggleShow(row, row_id);
					self.stopUpdate();
				}
			}
		);
	}

	self._toggleShow = function(row, row_id)
	{
		self.loading = null;
		self.loading_id = null;

		// Make sure to unmark the current row. Table rows may have been
		// reloaded in the meantime, so we need to refresh the object
		// here.
		if (self.current_id)
		{
			self._unmarkRow($('#row-' + self.current_id));
		}

		self.current = row;
		self.current_id = row_id;
		self._markRow(self.current);
		self._toggleHideEmpty();
		self.show();

		// Also make sure to support clicking on rows to change the
		// current.
		App.Tables.bindClick(
			function(row)
			{
				var row_id = row.attr('rel');
				if (row_id != self.current_id)
				{
					self.toggleRow(row_id);
				}
			}
		);
	}

	self._markRow = function(row)
	{
		row.addClass('highlighted');
		row.find('.action-expand, .action-expanding').hide();
		row.find('.action-collapse').show();
	}

	self._busyRow = function(row)
	{
		row.addClass('highlighted');
		row.find('.action-expand').hide();
		row.find('.action-expanding').show();
	}

	self._unmarkRow = function(row)
	{
		row.removeClass('highlighted');
		row.find('.action-collapse, .action-expanding').hide();
		row.find('.action-expand').show();
	}

	self.tryToggleRow = function()
	{
		if (self.current_id)
		{
			self.toggleRow(self.current_id);
			var $table_chartrunid = $('#tablechart_testun');
			$table_chartrunid.removeClass('table');
			$table_chartrunid.addClass('table-extended');
		}
	}

	self._closeEditMode = function()
	{
    $("#qpane").removeClass("edit-mode");
    $(".save-case-in-qpane").prop('disabled', false);
    App.Cases.resetFormBody();
    App.Tests.resetFormBody();

	}

	self.nextRow = function()
	{
		if (!self.current || !self.visible)
		{
			return;
		}

		var next = App.Tables.nextRow(self.loading || self.current);

		if (!next)
		{
			return;
		}

		if (self.current_id == next.attr('rel'))
		{
			// Skip the currently selected row and go to next. This can
			// happen if we are currently loading another row and go
			// forward to the current row.
			next = App.Tables.nextRow(self.current);
			if (!next)
			{
				return;
			}
		}

		self._toggleRow(next.attr('rel'), true);

		var delta = next.offset().top + next.outerHeight() -
			$(window).height() - $(document).scrollTop();
		if (delta >= 0)
		{
			window.scrollBy(0, delta + 8);
		}
	}

	self.prevRow = function()
	{
		if (!self.current || !self.visible)
		{
			return;
		}

		var prev = App.Tables.prevRow(self.loading || self.current);

		if (!prev)
		{
			return;
		}

		if (self.current_id == prev.attr('rel'))
		{
			// Skip the currently selected table_chartrunidrow and go to previous. This
			// can happen if we are currently loading another row and
			// go back to the current row.
			prev = App.Tables.prevRow(self.current);
			if (!prev)
			{
				return;
			}
		}

		self._toggleRow(prev.attr('rel'), true);

		var delta = $(document).scrollTop() - prev.offset().top +
			$('#contentSticky').outerHeight();
		if (delta > 0)
		{
			window.scrollBy(0, -delta);
		}
	}

	self.getCurrentRowID = function()
	{
		return self.current_id;
	}
}

;

