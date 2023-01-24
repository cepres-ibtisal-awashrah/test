/*******************************************************************/
/* Report plugin related routines (common functions that are used on
 * the forms of the report plugins) */

/* [Permissions checked!] */

App.ReportPlugins = new function()
{
	var self = this;
}

App.ReportPlugins.Columns = new function()
{
	var self = this;
}

App.ReportPlugins.Columns.Select = new function()
{
	var self = this;

	// Fields for keeping the current column state.
	self.columns = null;
	self.namespace = null;

	self.init = function()
	{
		self._initGrid();

		$(self._formatId('add')).click(
			function()
			{
				self._add();
			}
		);
	}

	self._initGrid = function()
	{
		App.Tables.applyDragDrop($(self._formatId('grid')));
	}

	self._formatId = function(control)
	{
		return '#' + self.namespace + '_' + control;
	}

	self._add = function()
	{
		self._addDialog(
		{
			submit: function(column)
			{
				self._addSubmit(column);
			}
		});
	}

	self._addDialog = function(o)
	{
		$('#addColumnForm').unbind('submit');
		$('#addColumnSubmit').removeClass('button-busy');
		
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

	self._addSubmit = function(column)
	{
		$('#addColumnSubmit').addClass('button-busy');

		App.Ajax.call(
		{
			target: '/report_plugins/ajax_render_column_row',
			
			arguments: {
				namespace: self.namespace,
				key: column.key,
				name: column.name
			},
			
			success: function(html)
			{
				$('#addColumnSubmit').removeClass('button-busy');
				App.Dialogs.closeTop();

				var row = $(html);
				row.appendTo($(self._formatId('grid')));
				self._removeFromDropdown(column.key);

				if ($('#addColumnItems option').length == 0)
				{
					$(self._formatId('add')).hide();
				}

				self._initGrid();
			},
			
			error: function(data)
			{
				$('#addColumnSubmit').removeClass('button-busy');
				App.Ajax.handleError(data);
			}
		});
	}

	self._removeFromDropdown = function(key)
	{
		$('#addColumn-' + App.escapeId(key)).remove();
	}

	self.remove = function(key)
	{
		self._addToDropdown(key);
		var row = $('#column-' + App.escapeId(key));
		row.remove();
		$(self._formatId('add')).show();
	}

	self._addToDropdown = function(key)
	{
		var option = $('<option></option>');
		option.attr('id', 'addColumn-' + key);
		option.val(key);
		option.text(self.columns[key]);
		option.appendTo('#addColumnItems');
	}

	self.onWidthChanged = function(e, event, max)
	{
		return App.Tables.onColumnWidthChanged(e, event, max, true);
	}
}

App.ReportPlugins.Runs = new function()
{
	var self = this;
}

App.ReportPlugins.Runs.Select = new function()
{
	var self = this;

	// Fields for keeping the current selection state etc.
	self.namespace = null;
	self.project_id = null;
	self.run_ids = null;
	self.filters = null;
	self.filters_add = null;
	self.multiple_suites = null;
	self.suite_ids = null;
	self.lang = null;

	self.init = function()
	{
		self._addInit();
		self._filterInit();
	}

	self._formatId = function(control)
	{
		return '#' + self.namespace + '_' + control;
	}

	self._addInit = function()
	{
		if (self.multiple_suites)
		{
			var suites = 'suites_ids';
		}
		else
		{
			var suites = 'suites_id';
		}

		// Track when the test suite selection changes. We also clear
		// the run selection in this case, if any.
		$(self._formatId(suites)).change(
			function()
			{
				var suite_ids = $(this).val();
				if ($.isArray(suite_ids))
				{
					self.suite_ids = suite_ids;
				}
				else 
				{
					if (suite_ids)
					{
						self.suite_ids = [suite_ids];						
					}
					else 
					{
						self.suite_ids = null;
					}
				}

				self.run_ids = null;
				$('tr.row', $(self._formatId('grid'))).remove();
			}
		);

		// Bind the Add link and show an error if no test suite is
		// selected. Otherwise we open the Add dialog.
		$(self._formatId('add')).click(
			function()
			{
				var can_add = self.suite_ids != null;
				if (!can_add)
				{
					can_add = $(self._formatId('suites_include_all')).
						is(':checked');
				}

				if (can_add)
				{
					self._add();
				}
				else 
				{
					App.Dialogs.error(
						self.lang['add_empty']
					);
				}
			}
		);
	}

	self._add = function()
	{
		self._addDialog(
		{
			submit: function(run_ids)
			{
				self._addSubmit(run_ids);
			}
		});
	}

	self._addDialog = function(o)
	{
		$('#addRunsForm').unbind('submit');
		$('#addRunsSubmit').removeClass('button-busy');
		
		$('#addRunsSubmit').unbind('click');
		$('#addRunsSubmit').bind('click', function()
		{
			o.submit(
				App.Tables.getSelected($('#addRunsTables'))
			);

			return false;
		});

		$('#addRunsClose').unbind('click');
		$('#addRunsClose').bind('click', function(e)
		{
			App.Dialogs.closeTop();
		});
		
		App.Dialogs.open({
			minWidth: 700,
			minHeight: 550,
			resizable: true,
			resizeStop: self._addResized,
			selector: '#addRunsDialog'
		});

		self._addLoad(o);
	}

	self._addLoad = function(o)
	{
		var dialog = $('#addRunsDialog');

		var container = $('#addRunsContent');
		var busy = $('#addRunsProgress');
		var height = dialog.find('.dialog-body').outerHeight();

		// Adjust the height of the progress div and show it
		busy.css('padding-top', Math.round((height / 2) - 60) + 'px');
		busy.show();

		container.hide();

		var suite_ids = null;
		if (self.multiple_suites)
		{
			if (!$(self._formatId('suites_include_all')).is(':checked'))
			{
				suite_ids = self.suite_ids;
			}
		}
		else 
		{
			suite_ids = self.suite_ids;
		}

		App.Ajax.call(
		{
			target: '/report_plugins/ajax_render_run_add',

			arguments: {
				project_id: self.project_id,
				suite_ids: suite_ids,
				run_exclude_ids: self.run_ids,
				filters: self.filters_add
			},

			success: function(html)
			{
				container.html(html);
				busy.hide();
				container.show();
			},

			error: function(data)
			{
				busy.hide();
				App.Ajax.handleError(data);
			}
		});
	}

	self._addResized = function(event, ui)
	{
		App.Ajax.call(
		{
			target: '/report_plugins/ajax_save_run_add_dialog_size',
			blockUI: false,

			arguments: {
				width: Math.round(ui.size.width),
				height: Math.round(ui.size.height)
			}
		});
	}

	self._addSubmit = function(run_ids)
	{
		$('#addRunsSubmit').addClass('button-busy');

		App.Ajax.call(
		{
			target: '/report_plugins/ajax_render_run_rows',

			arguments: {
				namespace: self.namespace,
				project_id: self.project_id,
				run_ids: run_ids
			},

			stop: function()
			{
				$('#addRunsSubmit').removeClass('button-busy');
			},

			success: function(html)
			{
				App.Dialogs.closeTop();

				var rows = $(html);
				rows.appendTo($(self._formatId('grid')));

				// Store selected runs for later
				if (self.run_ids)
				{
					self.run_ids = self.run_ids.concat(run_ids);
				}
				else
				{
					self.run_ids = run_ids; 
				}

				var filters = App.Filters.getAll($('#addRunsFilter'));
				self.filters_add = filters;
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self.addCheckAll = function()
	{
		var ctx = $('#addRunsTables');
		App.Tables.setCheckboxes(ctx, true);
	}

	self.addCheckNone = function()
	{
		var ctx = $('#addRunsTables');
		App.Tables.setCheckboxes(ctx, false);
	}

	self._addLoadRuns = function(o)
	{
		if (o.progress_start)
		{
			o.progress_start();
		}

		var filters = App.Filters.getAll($('#addRunsFilter'));

		App.Ajax.call(
		{
			target: '/report_plugins/ajax_render_run_add_partial',

			arguments: {
				project_id: self.project_id,
				suite_ids: self.suite_ids,
				run_exclude_ids: self.run_ids,
				filters: JSON.stringify(filters),
				is_partial: o.is_partial
			},

			success: function(html)
			{
				$('#addRunsMatchesInfo').remove();
				$('#addRunsTables').html(html);
				$('#addRunsMatchesInfo').appendTo('#addRunsMatches');
				$('#addRunsMatches').show();

				if (o.progress_end)
				{
					o.progress_end();
				}
			},

			error: function(data)
			{
				if (o.progress_end)
				{
					o.progress_end();
				}

				App.Ajax.handleError(data);
			}
		});
	}

	self.addFilterApplyAll = function()
	{
		self._addLoadRuns(
		{
			is_partial: false,
			progress_start: function() {
				$('#addRunsShowAll .showAll').hide();
				$('#addRunsShowAll .busy').show();
			},
			progress_end: function() {
				$('#addRunsShowAll .busy').hide();
				$('#addRunsShowAll .showAll').show();
			}
		});
	}

	self.addFilterApply = function()
	{
		self._addLoadRuns(
		{
			is_partial: true,
			progress_start: function() {
				$('#addRunsFilterApply').addClass('button-busy');
			},
			progress_end: function() {
				$('#addRunsFilterApply').removeClass('button-busy');
			}
		});
	}

	self.remove = function(run_id)
	{
		$(self._formatId('run-' + run_id)).remove();
		var ix = self.run_ids.indexOf(run_id);
		self.run_ids.splice(ix, 1);
	}

	self._filterInit = function()
	{
		var bubble = $(self._formatId('filter_change')).bubble(
		{
			bubble: '#filterRunsBubble',
			offsetY: -200,
			toggleEvent: 'null'
		});

		$(self._formatId('filter_change')).click(
			function()
			{
				self._filterLoad(
				{
					show: function() 
					{
						self._filterBind(
						{
							bubble: bubble
						});

						bubble.show();
					}
				});
			}
		);
	}

	self._filterLoad = function(o)
	{
		var busy = $(self._formatId('filter_busy'));
		busy.show();
		
		App.Ajax.call(
		{
			target: '/report_plugins/ajax_render_run_filter',

			arguments: {
				project_id: self.project_id,
				filters: self.filters
			},

			success: function(html)
			{
				busy.hide();
				$('#filterRunsContent').html(html);
				o.show();
			},

			error: function(data)
			{
				busy.hide();
				App.Ajax.handleError(data);
			}
		});
	}

	self._filterBind = function(o)
	{
		$('#filterRunsApply').click(
			function() 
			{
				self._filterApply(o);
			}
		);

		$('#filterRunsCancel').click(
			function() 
			{
				self._filterCancel(o);
			}
		);
	}

	self._filterApply = function(o)
	{
		var filters = App.Filters.getAll($('#filterRunsContent'));
		$('#filterRunsApply').addClass('button-busy');

		App.Ajax.call(
		{
			target: '/report_plugins/ajax_render_run_filter_info',

			arguments: {
				project_id: self.project_id,
				filters: filters
			},

			stop: function()
			{
				$('#filterRunsApply').removeClass('button-busy');
			},

			success: function(html)
			{
				$(self._formatId('filter_info')).html(html);
				o.bubble.hide();
				self.filters = filters; // Save for later
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});		
	}

	self._filterCancel = function(o)
	{
		o.bubble.hide();
	}
}

App.ReportPlugins.Cases = new function()
{
	var self = this;
}

App.ReportPlugins.Cases.Filter = new function()
{
	var self = this;

	// Fields for keeping the current selection state etc.
	self.namespace = null;
	self.project_id = null;
	self.filters = null;

	self.init = function()
	{
		var bubble = $(self._formatId('filter_change')).bubble(
		{
			bubble: '#filterCasesBubble',
			offsetY: -200,
			toggleEvent: 'null'
		});

		$(self._formatId('filter_change')).click(
			function()
			{
				self._load(
				{
					show: function() 
					{
						self._bind(
						{
							bubble: bubble
						});

						bubble.show();
					}
				});
			}
		);
	}

	self._formatId = function(control)
	{
		return '#' + self.namespace + '_' + control;
	}

	self._load = function(o)
	{
		var busy = $(self._formatId('filter_busy'));
		busy.show();
		
		App.Ajax.call(
		{
			target: '/report_plugins/ajax_render_case_filter',

			arguments: {
				project_id: self.project_id,
				filters: self.filters
			},

			success: function(html)
			{
				busy.hide();
				$('#filterCasesContent').html(html);
				o.show();
			},

			error: function(data)
			{
				busy.hide();
				App.Ajax.handleError(data);
			}
		});
	}

	self._bind = function(o)
	{
		$('#filterCasesApply').click(
			function() 
			{
				self._apply(o);
				return false;
			}
		);

		$('#filterCasesCancel').click(
			function() 
			{
				self._cancel(o);
				return false;
			}
		);
	}

	self._apply = function(o)
	{
		var filters = App.Filters.getAll($('#filterCasesContent'));
		$('#filterCasesApply').addClass('button-busy');

		App.Ajax.call(
		{
			target: '/report_plugins/ajax_render_case_filter_info',

			arguments: {
				project_id: self.project_id,
				filters: filters
			},

			stop: function()
			{
				$('#filterCasesApply').removeClass('button-busy');
			},

			success: function(html)
			{
				$(self._formatId('filter_info')).html(html);
				o.bubble.hide();
				self.filters = filters; // Save for later
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self._cancel = function(o)
	{
		o.bubble.hide();
	}	
}

App.ReportPlugins.Tests = new function()
{
	var self = this;
}

App.ReportPlugins.Tests.Filter = new function()
{
	var self = this;

	// Fields for keeping the current selection state etc.
	self.namespace = null;
	self.project_id = null;
	self.filters = null;

	self.init = function()
	{
		var bubble = $(self._formatId('filter_change')).bubble(
		{
			bubble: '#filterTestsBubble',
			offsetY: -200,
			toggleEvent: 'null'
		});

		$(self._formatId('filter_change')).click(
			function()
			{
				self._load(
				{
					show: function() 
					{
						self._bind(
						{
							bubble: bubble
						});

						bubble.show();
					}
				});
			}
		);
	}

	self._formatId = function(control)
	{
		return '#' + self.namespace + '_' + control;
	}

	self._load = function(o)
	{
		var busy = $(self._formatId('filter_busy'));
		busy.show();
		
		App.Ajax.call(
		{
			target: '/report_plugins/ajax_render_test_filter',

			arguments: {
				project_id: self.project_id,
				filters: self.filters
			},

			success: function(html)
			{
				busy.hide();
				$('#filterTestsContent').html(html);
				o.show();
			},

			error: function(data)
			{
				busy.hide();
				App.Ajax.handleError(data);
			}
		});
	}

	self._bind = function(o)
	{
		$('#filterTestsApply').click(
			function() 
			{
				self._apply(o);
				return false;
			}
		);

		$('#filterTestsCancel').click(
			function() 
			{
				self._cancel(o);
				return false;
			}
		);
	}

	self._apply = function(o)
	{
		var filters = App.Filters.getAll($('#filterTestsContent'));
		$('#filterTestsApply').addClass('button-busy');

		App.Ajax.call(
		{
			target: '/report_plugins/ajax_render_test_filter_info',

			arguments: {
				project_id: self.project_id,
				filters: filters
			},

			stop: function()
			{
				$('#filterTestsApply').removeClass('button-busy');
			},

			success: function(html)
			{
				$(self._formatId('filter_info')).html(html);
				o.bubble.hide();
				self.filters = filters; // Save for later
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self._cancel = function(o)
	{
		o.bubble.hide();
	}	
}

;

