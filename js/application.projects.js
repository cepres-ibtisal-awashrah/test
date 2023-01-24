/*******************************************************************/
/* Projects  */

/* [Permissions checked!] */

App.Projects = {};

App.Projects.showHistory = function(project_id)
{
	$('#activitiesLink').removeClass('text-active');
	$('#history').show();
	$('#historyLink').addClass('text-active');
	$('#activities').hide();
}

App.Projects.loadHistory = function(project_id)
{
	$('#showHistory .showMore').hide();
	$('#showHistory .busy').show();
	
	App.Ajax.call(
	{
		target: '/projects/ajax_get_history',
		
		arguments: 
		{
			project_id: project_id
		},
		
		success: function(html)
		{
			$('#showHistory .busy').hide();
			$('#history').html(html);
		},
		
		error: function(data)
		{
			$('#showHistory .busy').hide();
			App.Ajax.handleError(data);
		}
	});
}

App.Projects.showedActivities = false;

App.Projects.showActivities = function(project_id)
{
	var doShowActivities = function()
	{
		$('#historyLink').removeClass('text-active');
		$('#activities').show();
		$('#activitiesLink').addClass('text-active');
		$('#history').hide();
	};
	
	if (!App.Projects.showedActivities)
	{
		App.Projects.showedActivities = true;
		$('#activityBusy').show();

		App.Ajax.call(
		{
			target: '/projects/ajax_get_activities',
			
			arguments: 
			{
				project_id: project_id
			},
			
			success: function(html)
			{
				$('#activityBusy').hide();
				doShowActivities();
				
				if (html)
				{
					$('#activities').html(html);
				}
				else
				{
					$('#noActivities').show();
				}
			},
			
			error: function(data)
			{
				$('#activityBusy').hide();
				App.Ajax.handleError(data);
			}
		});
	}
	else
	{
		doShowActivities();
	}
}

App.Projects.toggleDetails = function(link, project_id)
{
	var project = $(link).closest('.project');

	if ($('.details', project).is(':visible'))
	{
		App.Effects.hide($('.details', project));
		$('.expand', project).show();
		$('.collapse', project).hide();
	}
	else
	{
		if ($('.details .table', project).length > 0)
		{
			App.Effects.show($('.details', project));
			$('.expand', project).hide();
			$('.collapse', project).show();
		}
		else
		{
			$('.buttons', project).hide();
			$('.busy', project).show();

			App.Ajax.call(
			{
				target: 'projects/ajax_get_details',
				
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
					$('.expand', project).hide();
					$('.collapse', project).show();
					App.Effects.show($('.details', project));
				},
				
				error: function(data)
				{
					App.Ajax.handleError(data);
				}
			});
		}
	}
}

App.Projects.hideUpdate = function(version)
{
	App.Ajax.call(
	{
		target: '/projects/ajax_hide_update',

		arguments: 
		{
			version: version
		},
		
		success: function(data)
		{
			App.Effects.hide('#updateAvailable');
		},
		
		error: function(data)
		{
			App.Ajax.handleError(data);
		}
	});
}

App.Projects.hideSupport = function()
{
	App.Ajax.call(
	{
		target: '/projects/ajax_hide_support',
		
		success: function(data)
		{
			App.Effects.hide('#supportExpired');
		},
		
		error: function(data)
		{
			App.Ajax.handleError(data);
		}
	});
}

App.Projects.onDefectPluginChange = function(project_id)
{
	var plugin = $('#defect_plugin').val();
	$('#defect_config').val('');
	
	if (plugin)
	{
		$('#defectBusy').show();
		
		App.Ajax.call(
		{		
			target: '/admin/projects/ajax_get_defect_config',
		
			arguments: 
			{
				project_id: project_id,
				plugin: plugin
			},

			stop: function()
			{
				$('#defectBusy').hide();
			},
			
			success: function(data)
			{
				$('#defect_config').val(data.config).trigger('input');

				if (plugin == 'Jira_REST' || plugin == 'Jira')
				{
					$('#defectJiraBanner').show();
				}
				else 
				{
					$('#defectJiraBanner').hide();
				}
			},
			
			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}
	else 
	{
		$('#defectJiraBanner').hide();
		$('#defect_config').trigger('input');
	}
}

App.Projects.onReferencePluginChange = function(project_id)
{
	var plugin = $('#reference_plugin').val();
	$('#reference_config').val('');
	
	if (plugin)
	{
		$('#referenceBusy').show();
		
		App.Ajax.call(
		{		
			target: '/admin/projects/ajax_get_reference_config',
		
			arguments: 
			{
				project_id: project_id,
				plugin: plugin
			},

			stop: function()
			{
				$('#referenceBusy').hide();
			},
			
			success: function(data)
			{
				$('#reference_config').val(data.config).trigger('input');

				if (plugin == 'Jira_REST' || plugin == 'Jira')
				{
					$('#referenceJiraBanner').show();
				}
				else 
				{
					$('#referenceJiraBanner').hide();
				}
			},
			
			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}
	else 
	{
		$('#referenceJiraBanner').hide();
		$('#reference_config').trigger('input');
	}
}

App.Projects.loadCompleted = function()
{
	$('#showCompleted .showAll').hide();
	$('#showCompleted .busy').show();
	
	App.Ajax.call(
	{
		target: '/projects/ajax_get_completed',
		arguments: {},
		
		success: function(html)
		{
			$('#showCompleted .busy').hide();
			$('#completed').html(html);
		},
		
		error: function(data)
		{
			$('#showCompleted .busy').hide();
			App.Ajax.handleError(data);
		}
	});
}

App.Projects.selectActivityDays = function(project_id)
{
	App.Charts.selectTimeframe(
	{
		success: function(days)
		{
			App.Ajax.call(
			{
				target: '/projects/ajax_render_activity_chart',

				arguments: {
					project_id: project_id,
					days: days
				},
				
				success: function(html)
				{
					App.Dialogs.closeTop();
					App.Charts.reload(
						App.Charts.activity,
						'#activityContainer',
						html
					);
				},
				
				error: function(data)
				{
					App.Ajax.handleError(data);
				}
			});
		}
	});
}

App.Projects.loadTodos = function(project_id)
{
	App.Ajax.call(
	{
		target: '/projects/ajax_render_todos',
		blockUI: false,

		arguments: {
			project_id: project_id
		},

		success: function(html)
		{
			App.Projects._showTodos(html);
		},
		
		error: function(data)
		{
			// Do not an display an error for this (this is non-
			// critical). One possible way to trigger an error is to
			// to leave the page before the todos could be loaded.
			// This would abort the JS request and call this event
			// handler.
			App.Projects._showTodos('');
		}
	});
}

App.Projects._showTodos = function(html)
{
	$('#todos').html(html);
	$('#todosBusy').hide();
	$('#todos').show();
}

App.Projects.star = function(link, project_id)
{
	var busy = $('.fav-busy', $(link).closest('.project'));
	busy.show();

	App.Ajax.call(
	{
		target: '/projects/ajax_star',

		arguments: {
			project_id: project_id
		},

		stop: function() {
			busy.hide();
		},
		
		success: function(html)
		{
			$('#favs > .table').prepend(html);
			$('#favs').show();
			$('#activeHeader').show();
			$('#project-star-' + project_id).hide();
			$('#project-starred-' + project_id).show();
		},
		
		error: function(data)
		{
			App.Ajax.handleError(data);
		}
	});
}

App.Projects.unstar = function(link, project_id)
{
	var busy = $('.fav-busy', $(link).closest('.project'));
	busy.show();

	App.Ajax.call(
	{
		target: '/projects/ajax_unstar',

		arguments: {
			project_id: project_id
		},

		stop: function() {
			busy.hide();
		},

		success: function(html)
		{
			$('#fav-' + project_id).remove();
			$('#project-starred-' + project_id).hide();
			$('#project-star-' + project_id).show();

			if ($('#favs > .table > .row').length == 0)
			{
				$('#favs').hide();
				$('#activeHeader').hide();
			}
		},
		
		error: function(data)
		{
			App.Ajax.handleError(data);
		}
	});
}
;

