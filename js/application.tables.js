/*******************************************************************/
/* Data Tables  */

/* [Permissions checked!] */

App.Tables = new function()
{
	var self = this;
	
	// Fields for keeping the current column/grouping state.
	self.columns = null;
	self.columns_stack = null;
	self.columns_for_user = null;
	self.group_by = '';
	self.group_order = '';

	// Fields for keeping the drag/drop state.
	self.dragged_row = null;

	//---------------------------------------------------------------
	// DRAG & DROP
	//---------------------------------------------------------------

	self.applyDragDrop = function(container)
	{
		var ctx = $(container);

		$('tr.row img.draggable, tr.row div.draggable', ctx).draggable(
		{
			addClasses: false,
			cursor: 'move',
			containment: 'document',
			cursorAt: { top: 10, left: 5 },
			scroll: true,
			scrollSensitivity: 50,		
			scrollSpeed: 40,
			scope: 'rows',
			start: self._dragStart,
			stop: self._dragStop,
			helper: self._dragHelper
		});

		$('tr.droppable', ctx).droppable(
		{
			addClasses: false,
			tolerance: 'pointer',
			scope: 'rows',
			hoverClass: 'jstree-dropping',
			over: self._dropEnter,
			out: self._dropLeave,
			drop: self._drop
		});
	}

	self._dragStart = function(event, ui)
	{
		self.dragged_row = $(this).closest('tr').get(0);
		App.DragDrop.start();
		$(ui.helper).show(); // See _dragHelper
	}

	self._dragStop = function(event, ui)
	{
		App.DragDrop.stop();
	}

	self._dragHelper = function(event)
	{
		var helper = $('td.dragHelper', $(this).closest('tr'));
		var html = '<div class="dragdrop-helper hidden">' + helper.html() + 
			'</div>';
		return $(html).get(0);
	}

	self._dropEnter = function(event, ui)
	{
		self._dropShowBorder(this);
	}

	self._dropShowBorder = function(e)
	{
		var columns = $('td, th', $(e));
		columns.addClass('row-dragged-show').removeClass('row-dragged-hide');
	}

	self._dropLeave = function(event, ui)
	{
		self._dropHideBorder(this);
	}

	self._dropHideBorder = function(e)
	{
		var row = $(e);
		$('th', row).addClass('row-dragged-hide').removeClass('row-dragged-show');
		$('td', row).addClass('row-dragged-hide').removeClass('row-dragged-show');
	}

	self._drop = function(event, ui)
	{		
		var dragged = $(self.dragged_row);
		var dropped = $(this);
		self._dropHideBorder(this);

		if ($(dragged).attr('id') != $(dropped).attr('id'))
		{
			dragged.insertAfter(dropped);
		}
	}

	//---------------------------------------------------------------
	// CHECKBOXES / SELECTION
	//---------------------------------------------------------------

	self.initializeToggleAll = function(selector)
	{
		// Iterate through all tables
		var tables = $(selector);
		$.each(tables, function(ix, t)
		{
			var table = $(t);

			// Iterate through all rows and get the checked state
			var checkboxes = $('tr.row input.selectionCheckbox', table);

			var checked = checkboxes.length > 0;
			$.each(checkboxes, function(ix, c)
			{
				if (!c.checked)
				{
					checked = false;
					return;
				}
			});
			
			// If all checkboxes have been checked, check the toggle all
			// checkbox, too.
			var toggleAll = $('tr.header input.selectionCheckbox', table);
			if (toggleAll.length == 1)
			{
				toggleAll.get(0).checked = checked;
			}
		});
	}

	self.onRowClick = function(e)
	{
		$(e).blur();
		var row = $(e).closest('.row');
		
		// Change css
		if (e.checked)
		{
			if (row.hasClass('odd'))
			{
				row.removeClass('odd');
				row.addClass('oddSelected');
			}
			else
			{
				row.removeClass('even');
				row.addClass('evenSelected');
			}
		}
		else
		{
			if (row.hasClass('oddSelected'))
			{
				row.removeClass('oddSelected');
				row.addClass('odd');
			}
			else
			{
				row.removeClass('evenSelected');
				row.addClass('even');
			}
		}
	}

	self.onToggleAllClick = function(e)
	{
		// Find the table element parent of the checkbox
		var table = $(e).closest('.grid-container');
		if (table.length != 1)
		{
			return false;
		}
		
		self.setCheckboxes(table, e.checked);
	}

	self.setCheckboxes = function(context, checked)
	{
		var checkboxes = $('tr input.selectionCheckbox', context);
		checkboxes.prop('checked', checked);
		self._updateSelection(context);
	}

	self._updateSelection = function(context)
	{
		var rows = $('tr.row', context);

		var i = 1;
		$.each(rows, function(index, value)
		{
			var row = $(value);
			var checked = false;
			
			// Check if the row is selected
			var checkbox = $('input.selectionCheckbox', row);
			if (checkbox)
			{
				checked = checkbox.prop('checked');
			}
		
			// Calculate the correct css class
			var css = '';
			if ((i & 1) == 0)
			{
				if (checked)
				{
					css = 'evenSelected';
				}
				else			
				{
					css = 'even';
				}
			}
			else
			{
				if (checked)
				{
					css = 'oddSelected';
				}
				else			
				{
					css = 'odd';
				}
			}
			
			// Update the css class
			row.removeClass('odd even oddSelected evenSelected');
			row.addClass(css);
			
			i++;
		});
	}

	self.setCheckboxesById = function(context, ids)
	{
		self._updateCheckboxesById(
			context,
			ids,
			function(found)
			{
				return found;	
			}
		);
	}

	self._updateCheckboxesById = function(context, ids, callback)
	{
		var id_lookup = {};
		for (i = 0; i < ids.length; i++)
		{
			id_lookup[ids[i]] = true;
		}

		$('tr input.selectionCheckbox', context).each(function(ix, v)
		{
			var checked = callback(id_lookup[v.value]);
			if (checked !== null)
			{
				$(v).prop('checked', checked ? true : false);
			}
		});

		self._updateSelection(context);
	}

	self.enableCheckboxesById = function(context, ids)
	{
		self._updateCheckboxesById(
			context,
			ids,
			function(found)
			{
				return found ? true : null;
			}
		);
	}

	self.disableCheckboxesById = function(context, ids)
	{
		self._updateCheckboxesById(
			context,
			ids,
			function(found)
			{
				return found ? false : null;	
			}
		);
	}

	self.getSelected = function(context)
	{
		var checkboxes = $('tr.row input.selectionCheckbox:checked', 
			context);
		
		var selected = new Array();
		
		$.each(checkboxes, function(i, v)
		{
			selected.push(parseInt(v.value));
		});
		
		return selected;
	}

	//---------------------------------------------------------------
	// COLUMNS
	//---------------------------------------------------------------

	self.onColumnWidthChanged = function(e, event, max, allow_0)
	{
		return App.Controls.onNumberChanged(e, event, max, allow_0);
	}

	self.setGrouping = function(column)
	{
		if (self.group_by == column)
		{
			self.group_order = self.group_order == 'asc' ? 'desc' : 'asc';
		}
		else
		{
			self.group_order = 'asc';
			self.group_by = column;
		}
	}

	self.pushColumns = function(columns_for_user)
	{
		if (!self.columns_stack)
		{
			self.columns_stack = [];	
		}

		self.columns_stack.push(self.columns_for_user);
		self.columns_for_user = columns_for_user;
	}

	self.popColumns = function()
	{
		if (!self.columns_stack || !self.columns_stack.length)
		{
			return null;
		}

		var columns_for_user = self.columns_for_user;
		self.columns_for_user = self.columns_stack.pop();
		return columns_for_user;
	}

	self.selectColumns = function(o)
	{
		var actions = $('#selectColumns-' + o.group_id);
		var select = $('.select', actions);
		var busy = $('.busy', actions);

		select.hide();
		busy.show();

		App.Ajax.call(
		{
			target: '/columns/ajax_render_rows',
			
			arguments: {
				project_id: o.project_id,
				area_id: o.area_id,
				columns: self.columns_for_user,
				group_by: self.group_by,
				group_order: self.group_order
			},
			
			success: function(html)
			{
				let selectColumnsGridContainerSelector = '#selectColumnsGridContainer';
				busy.hide();
				select.show();
				$(selectColumnsGridContainerSelector).html(html);
				$(document).on(
					'click',
					selectColumnsGridContainerSelector
						+ ' tr > td,'
						+ selectColumnsGridContainerSelector
						+ ' tr > td.action > a.hidden',
					function(event) {
						event.preventDefault();
						event.stopPropagation();
					}
				);
				self._selectColumnsDialog(
				{
					submit: function()
					{
						self._selectColumnsSubmit(o);
					}
				});
			},
			
			error: function(data)
			{
				busy.hide();
				select.show();			
				App.Ajax.handleError(data);
			}
		});
	}

	self._selectColumnsDialog = function(o)
	{
		App.Validation.hideErrors();

		// Initialize the dialog
		$('#selectColumnsForm').unbind('submit');	
		$('#selectColumnsSubmit').removeClass('button-busy');

		// Fill the dropdown of the Add Column dialog with those columns
		// that are not selected by the user.
		$('#addColumnItems').empty();
		$.each(self.columns, function(key, name)
		{
			if (self.columns_for_user[key] === undefined)
			{
				self._addColumnToDropdown(key);
			}
		});
		
		$('#selectColumnsForm').submit(function(e)
		{
			App.Validation.hideErrors();
			$('#selectColumnsErrors').empty();

			var valid = true;

			$('#selectColumnsGrid tr.row').each(function(i, v)
			{
				var value = $('input[type=text]', $(this)).val();
				if (value == '')
				{
					App.Validation.setError(
						'#selectColumnsErrors', 
						selectColumnsDialogValidation['width_required']
					);

					valid = false;
				}
				else
				{
					var width = Number(value);

					if (width < 25 || width > 1000)
					{
						App.Validation.setError(
							'#selectColumnsErrors', 
							selectColumnsDialogValidation['width_min_max']
						);

						valid = false;
					}
				}

				return valid;
			});

			if (valid)
			{
				o.submit();
			}

			return false;
		});
		
		App.Dialogs.open(
		{
			selector: '#selectColumnsDialog'
		});
	}

	self._selectColumnsSubmit = function(o)
	{
		$('#selectColumnsSubmit').addClass('button-busy');
		var columns = self._getColumnsForUser();

		App.Ajax.call(
		{
			target: '/columns/ajax_save_for_user',
			
			arguments: { 
				project_id: o.project_id,
				area_id: o.area_id,
				columns: columns,
				group_by: self.group_by,
				group_order: self.group_order
			},
			
			success: function(data)
			{
				$('#selectColumnsSubmit').removeClass('button-busy');
				App.Dialogs.closeTop();

				var old_columns = self.columns_for_user;
				self.columns_for_user = columns;

				if (o.submit)
				{
					self._selectColumnsRefresh(
					{
						group_id: o.group_id,
						submit: o.submit,
						container: o.container,
						old_columns: old_columns,
						new_columns: columns
					});
				}
			},
			
			error: function(data)
			{
				$('#selectColumnsSubmit').removeClass('button-busy');
				App.Ajax.handleError(data);
			}
		});
	}

	self._getColumnsForUser = function()
	{
		var columns = {};

		$('#selectColumnsGrid tr.row').each(function(i, v)
		{
			var key = $(this).attr('rel');
			var id = '#columnWidth-' + App.escapeId(key);
			columns[key] = $(id).val();
		});

		return columns;
	}

	self._selectColumnsRefresh = function(o)
	{
		var actions = $('#selectColumns-' + o.group_id);
		var select = $('.select', actions);
		var busy = $('.busy', actions);

		var container = o.container || 'body';

		// Before refreshing the grid content, we need to take into
		// account the changed container/page width due to different
		// column definitions. When the old definition is smaller
		// than those of the new columns, we increase the container/
		// page size before refreshing the content. Likewise, if the
		// new definition is smaller, we decrease the width after
		// refreshing the content.

		var old_min_width = self._getColumnMinWidth(o.old_columns);
		var new_min_width = self._getColumnMinWidth(o.new_columns);

		if (old_min_width < new_min_width)
		{
			self._setColumnMinWidth(container, new_min_width);
		}

		select.hide();
		busy.show();

		o.submit(
		{
			success: function()
			{
				if (old_min_width > new_min_width)
				{
					self._setColumnMinWidth(container, new_min_width);
				}
			},

			error: function(data)
			{
				select.show();
				busy.hide();
			}
		});
	}

	self._getColumnMinWidth = function(columns)
	{
		return Consts.minWidthOffset + self._getColumnWidth(columns);
	}

	self._getColumnWidth = function(columns)
	{
		var width = 0;
		
		$.each(columns, function(i, v)
		{
			width += v != 0 ? Number(v) : Consts.minWidthVariable;
		});

		return width;
	}

	self._setColumnMinWidth = function(container, min_width)
	{
		// There's a minimum width for the actual document (body). We
		// also need to add the sidebar and qpane in this case (if
		// visible).

		if (container == 'body')
		{
			min_width = Math.max(min_width, Consts.minWidth);

			if (App.Sidebar.isVisible())
			{
				min_width += App.Sidebar.getWidth() + 10;
			}
		
			if (App.QPane.isVisible())
			{
				min_width += App.QPane.getWidth() + 10;
			}
		}

		$(container).css('min-width', min_width);
	}

	self.addColumn = function()
	{
		self._addColumnDialog(
		{
			submit: self._addColumnSubmit
		});
	}

	self._addColumnSubmit = function(column)
	{
		$('#addColumnSubmit').addClass('button-busy');

		App.Ajax.call(
		{
			target: '/columns/ajax_render_row',
			
			arguments: { 
				key: column.key,
				name: column.name
			},
			
			success: function(html)
			{
				$('#addColumnSubmit').removeClass('button-busy');
				App.Dialogs.closeTop();

				var row = $(html);
				row.appendTo($('#selectColumnsGrid'));
				$('.moveDown', row.prev()).show();

				// Remove the option from the dropdown (add dialog)
				// and disable the add link if there are no more
				// columns to add.
				$('#addColumn-' + App.escapeId(column.key)).remove();

				if ($('#addColumnItems option').length == 0)
				{
					$('#selectColumnsAdd').hide();
				}
			},
			
			error: function(data)
			{
				$('#addColumnSubmit').removeClass('button-busy');
				App.Ajax.handleError(data);
			}
		});
	}

	self._addColumnDialog = function(o)
	{
		// Initialize the dialog
		$('#addColumnForm').unbind('submit');	
		$('#addColumnAccept').show();
		$('#addColumnBusy').hide();
		
		$('#addColumnForm').submit(function(e)
		{
			var dropdown = $('#addColumnItems');

			o.submit({
				key: dropdown.val(),	
				name: $.trim($('option:selected', dropdown).text())
			});

			return false;
		});
		
		App.Dialogs.open(
		{
			selector: '#addColumnDialog'
		});
	}

	self.removeColumn = function(key)
	{
		self._addColumnToDropdown(key);
		
		var row = $('#column-' + App.escapeId(key));
		if (row.next().length == 0)
		{
			$('.moveDown', row.prev()).hide();
		}

		row.remove();
		$('#selectColumnsAdd').show();
	}

	self._addColumnToDropdown = function(key)
	{
		var option = $('<option></option>');
		option.attr('id', 'addColumn-' + key);
		option.val(key);
		option.text(self.columns[key]);
		option.appendTo('#addColumnItems');
	}

	self.moveColumnUp = function(key)
	{
		var row = $('#column-' + App.escapeId(key));
		var prev = row.prev();
		row.insertBefore(prev);
	}

	self.moveColumnDown = function(key)
	{
		var row = $('#column-' + App.escapeId(key));
		var next = row.next();
		row.insertAfter(next);
	}

	self._syncColumnMoveButtons = function(s, t)
	{
		var sUp = $('.moveUp', s).is(':visible');
		var sDown = $('.moveDown', s).is(':visible');
		var tUp = $('.moveUp', t).is(':visible');
		var tDown = $('.moveDown', t).is(':visible');
		App.Effects.setVisible($('.moveUp', s), tUp);
		App.Effects.setVisible($('.moveDown', s), tDown);
		App.Effects.setVisible($('.moveUp', t), sUp);
		App.Effects.setVisible($('.moveDown', t), sDown);
	}

	self.getColumnName = function(key)
	{
		return self.columns[key];
	}

	self.matchesColumns = function(columns)
	{
		var keys_a = Object.keys(self.columns_for_user),
			keys_b = Object.keys(columns);

		if (keys_a.length != keys_b.length)
		{
			return false;
		}

		var i = 0;
		$.each(self.columns_for_user, function(key, width)
		{
			if (keys_b[i] != key || columns[key] != width)
			{
				return false;
			}

			i++;
		});

		return true;
	}

	self.getColumnWidthDelta = function(columns)
	{
		var width_a = self._getColumnMinWidth(self.columns_for_user);
		var width_b = self._getColumnMinWidth(columns);
		return Math.max(width_a, Consts.minWidth) - 
			Math.max(width_b, Consts.minWidth);
	}

	//---------------------------------------------------------------
	// ROW NAVIGATION
	//---------------------------------------------------------------

	self.nextRow = function(row)
	{
		// Check if there's another row right after the current one
		// (in the same table).
		var next = row.next('tr.row');
		if (next.length)
		{
			return next;
		}

		// If not, we check the following tables (childs or siblings).
		var group = row.closest('.group');
		while (group.length > 0)
		{
			// We first try to find a matching row in the sub-groups.

			next = group.find('.group tr.row:first');
			if (next.length)
			{
				return next;
			}

			// If there's no group or row in these groups, we take a
			// look at the next sibling. If there's no sibling, we go
			// up in the tree to find a sibling for a direct/indirect
			// parent.

			var group_n = group.next();
			
			if (!group_n.length)
			{
				var parent = group.parents('.group:first');

				while (parent.length)
				{
					group_n = parent.next();
					if (group_n.length)
					{
						break;
					}

					parent = parent.parents('.group:first');
				}
			}

			group = group_n;

			// Once we found a subsequent group, we try to return the
			// first row (otherwise, we proceed with its sub-groups and
			// direct/indirect siblings).

			if (group.length)
			{
				next = group.find('tr.row:first');
				if (next.length)
				{
					return next;
				}
			}
		}

		return null;
	}

	self.prevRow = function(row)
	{
		// Check if there's another row right before the current one
		// (in the same table).		
		var prev = row.prev('tr.row');
		if (prev.length)
		{
			return prev;
		}

		// If not, we check the previous tables (parents or siblings).
		var group = row.closest('.group');
		while (group.length > 0)
		{
			// We first check if there's a previous sibling.
			
			var group_p = group.prev();

			// If there's none, we go up the in tree and check the
			// parents. We can either return the last direct row of
			// a direct/indirect parent or continue with a previous
			// sibling of a direct/indirect parent.

			if (!group_p.length)
			{
				var parent = group.parents('.group:first');
				
				while (parent.length)
				{
					prev = parent.find('> table tr.row:last');
					if (prev.length)
					{
						return prev;
					}

					group_p = parent.prev();
					if (group_p.length)
					{
						break;
					}

					parent = parent.parents('.group:first');
				}
			}

			group = group_p;

			// Once we found a direct/indirect previous table, we can
			// simply return the last row in this group (this will
			// also take into account possible sub-groups).

			if (group.length)
			{
				prev = group.find('tr.row:last');
				if (prev.length)
				{
					return prev;
				}
			}
		}

		return null;		
	}

	//---------------------------------------------------------------
	// EVENTS
	//---------------------------------------------------------------

	self.bindClick = function(callback)
	{
		$(document).on(
			'click.table',
			'tr.row',
			function(e)
			{
				var t = $(e.target);

				// Make sure to ignore clicked links, checkboxes, etc.
				if (t.is('td') && !t.is('td.clickable'))
				{
					callback($(this));
				}
			}
		);
	}

	self.unbindClick = function()
	{
		$(document).off('click.table');
	}

    self.getRunsColumnName = function(key) {
        return self.runsColumns[key];
    }
}

;

