/*******************************************************************/
/* External/Integrations  */

App.Ext = new function()
{
	var self = this;

	self.resized = function()
	{
		$.publish('body.changed');
	}
}

App.Ext.Dashboard = new function()
{
	var self = this;

	self.load = function()
	{
		App.Ajax.call(
		{
			target: 'ext/common/ajax_render_dashboard',
			
			success: function(html)
			{
				$('#content').html(html);
				App.Ext.resized();
				$.publish('dashboard.loaded');
			},
			
			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}
}

App.Ext.Projects = new function()
{
	var self = this;

	self.load = function(project_id)
	{
		App.Ajax.call(
		{
			target: 'ext/common/ajax_render_project',
			
			arguments:
			{
				project_id: project_id
			},

			success: function(html)
			{
				$('#content').html(html);
				App.Ext.resized();
				$.publish(
					'project.loaded',
					{
						project_id: project_id
					}
				);
			},
			
			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self.toggleDetails = function(project_id)
	{
		var project = $('#project-' + project_id);
		
		if ($('.details', project).is(':visible'))
		{
			self._hideDetails(project_id);
		}
		else
		{
			if ($('.details .table', project).length > 0) // Loaded?
			{
				self._showDetails(project_id);
			}
			else
			{
				self._loadDetails(project_id);
			}
		}
	}

	self._showDetails = function(project_id)
	{
		var project = $('#project-' + project_id);
		$('.expand', project).hide();
		$('.collapse', project).show();
		$('.details', project).show();
		App.Ext.resized();
	}

	self._hideDetails = function(project_id)
	{
		var project = $('#project-' + project_id);
		$('.details', project).hide();
		$('.expand', project).show();
		$('.collapse', project).hide();
		App.Ext.resized();
	}

	self._loadDetails = function(project_id)
	{
		var project = '#project-' + project_id;
		$('.buttons', project).hide();
		$('.busy', project).show();
		
		App.Ajax.call(
		{
			target: 'ext/common/ajax_render_project_details',
			
			arguments: 
			{
				project_id: project_id
			},

			stop: function()
			{
				$('.busy', project).hide();
				$('.buttons', project).show();
			},

			success: function(html)
			{
				$('.details', project).append(html);
				self._showDetails(project_id);
			},
			
			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self.loadCompleted = function()
	{
		$('#showCompleted .showAll').hide();
		$('#showCompleted .busy').show();
		
		App.Ajax.call(
		{
			target: 'ext/common/ajax_render_projects_completed',
			
			stop: function()
			{				
				$('#showCompleted').remove();
			},

			success: function(html)
			{
				$('#completed').html(html);
				App.Ext.resized();
			},
			
			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}
}

;

