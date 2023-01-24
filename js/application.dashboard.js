/*******************************************************************/
/* Projects  */

/* [Permissions checked!] */

App.Dashboard = new function()
{
	var self = this;

	self.selectActionDays = function()
	{
		App.Charts.selectTimeframe(
		{
			success: function(days)
			{
				self._reloadActionChart(days);
			}
		});
	}

	self._reloadActionChart = function(days)
	{
		App.Ajax.call(
		{
			target: '/dashboard/ajax_render_action_chart',

			arguments: {
				days: days
			},
			
			success: function(html)
			{
				App.Dialogs.closeTop();
				App.Charts.reload(
					App.Charts.action,
					'#actionContainer',
					html
				);
			},
			
			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self.loadTodos = function()
	{
		App.Ajax.call(
		{
			target: '/dashboard/ajax_render_todos',
			blockUI: false,

			success: function(html)
			{
				self._showTodos(html);
			},
			
			error: function(data)
			{
				// Do not an display an error for this (this is non-
				// critical). One possible way to trigger an error is to
				// to leave the page before the todos could be loaded.
				// This would abort the JS request and call this event
				// handler.
				self._showTodos('');
			}
		});
	}

	self._showTodos = function(html)
	{
		$('#todos').html(html);
		$('#todosBusy').hide();
		$('#todos').show();		
	}

	self.hideJiraHint = function()
	{
		App.Ajax.call(
		{		
			target: '/dashboard/ajax_hide_jira_hint',
			blockUI: false,
		
			success: function(data)
			{
				$('#jiraHint').hide();
			},
			
			error: function(data)
			{
				// Non-critical error, can be safely ignored.
			}
		});
	}
}

;

