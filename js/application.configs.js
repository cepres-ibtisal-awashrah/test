/*******************************************************************/
/* Configurations  */

/* [Permissions checked!] */

App.Configs = {};

App.Configs.remove = function(config_id)
{	
	var busy = $('#configBusy-' + config_id);
	busy.show();

	App.Ajax.call(
	{
		target: '/configs/ajax_delete',
		
		arguments: 
		{
			config_id: config_id
		},
		
		success: function(data)
		{
			busy.hide();
			App.Effects.remove('#config-' + config_id);
			App.Configs.refreshNeeded = true;
		},
		
		error: function(data)
		{
			busy.hide();
			App.Ajax.handleError(data);
		}
	});
}

App.Configs.removeGroup = function(group_id)
{
	var busy = $('#groupBusy-' + group_id);
	busy.show();

	App.Ajax.call(
	{
		target: '/configs/ajax_delete_group',
		
		arguments: 
		{
			group_id: group_id
		},
		
		success: function(data)
		{
			busy.hide();
			App.Effects.remove('#group-' + group_id);
			App.Configs.refreshNeeded = true;
		},
		
		error: function(data)
		{
			busy.hide();
			App.Ajax.handleError(data);
		}
	});
}

App.Configs.add = function(group_id)
{
	App.Configs.setEditType('addConfig');
	
	App.Configs.editDialog(
	{
		name: '',
		titleSelector: '.addConfig',		
		submit: function(name)
		{
			App.Ajax.call(
			{
				target: '/configs/ajax_add',
				
				arguments:
				{
					group_id: group_id,
					name: name
				},
				
				success: function(html)
				{
					var row = $(html);
					var group = $('#configurations #group-' + group_id);
					row.appendTo(group.find('table'));
					App.Configs.editSuccess(row);
				},
				
				error: function(data)
				{
					$('#addConfigSubmit').removeClass('button-busy');
					App.Ajax.handleError(data, '#addConfigErrors');
				}
			});	
		}
	});
}

App.Configs.edit = function(config_id)
{
	App.Configs.setEditType('editConfig');
	var selector = '#config-' + config_id;
	var name = 	$('.configName', $(selector)).text();
	
	App.Configs.editDialog(
	{
		name: name,
		titleSelector: '.editConfig',		
		submit: function(name)
		{
			App.Ajax.call(
			{
				target: '/configs/ajax_edit',
				
				arguments:
				{
					config_id: config_id,
					name: name
				},
				
				success: function(data)
				{
					$('.configName', $(selector)).text(name);
					App.Configs.editSuccess(selector + ' .configName');
					App.Configs.refreshNeeded = true;
				},
				
				error: function(data)
				{
					$('#addConfigSubmit').removeClass('button-busy');
					App.Ajax.handleError(data, '#addConfigErrors');
				}
			});	
		}
	});
}

App.Configs.addGroup = function(project_id)
{
	App.Configs.setEditType('addGroup');
	
	App.Configs.editDialog(
	{
		name: '',
		titleSelector: '.addGroup',		
		submit: function(name)
		{
			App.Ajax.call(
			{
				target: '/configs/ajax_add_group',
				
				arguments: 
				{
					project_id: project_id,
					name: name
				},
				
				success: function(html)
				{
					var row = $(html);
					row.appendTo($('#configurations div.groups'));
					App.Configs.editSuccess(row);
				},
				
				error: function(data)
				{
					$('#addConfigSubmit').removeClass('button-busy');
					App.Ajax.handleError(data, '#addConfigErrors');
				}
			});	
		}
	});
}

App.Configs.editGroup = function(group_id)
{
	App.Configs.setEditType('editGroup');
	var selector = '#group-' + group_id;
	var name = 	$('.groupName', $(selector)).text();
	
	App.Configs.editDialog(
	{
		name: name,
		titleSelector: '.editGroup',		
		submit: function(name)
		{
			App.Ajax.call(
			{
				target: '/configs/ajax_edit_group',
				
				arguments:
				{
					group_id: group_id,
					name: name
				},
				
				success: function(data)
				{
					$('.groupName', $(selector)).text(name);
					App.Configs.editSuccess(selector + ' .groupName');
					App.Configs.refreshNeeded = true;
				},
				
				error: function(data)
				{
					$('#addConfigSubmit').removeClass('button-busy');
					App.Ajax.handleError(data, '#addConfigErrors');
				}
			});	
		}
	});
}

App.Configs.toggleGroup = function(group_id)
{
	var t = $('#groupToggle-' + group_id);	
	var checked = t.val() == '1' ? false : true;
	t.val(checked ? '1' : '0');
	$('input', $('#group-' + group_id)).prop('checked', checked);
}

App.Configs.editSuccess = function(selector)
{
	$('#addConfigSubmit').removeClass('button-busy');
	App.Effects.add(selector);
	App.Dialogs.close('#addConfigDialog');
}

App.Configs.setEditType = function(type)
{
	$('#addConfigDialog .addConfig').hide();
	$('#addConfigDialog .editConfig').hide();
	$('#addConfigDialog .addGroup').hide();
	$('#addConfigDialog .editGroup').hide();
	$('#addConfigDialog .' + type).show();
}

App.Configs.editDialog = function(o)
{
	App.Validation.hideErrors();

	// Initialize the dialog
	$('#addConfigName').val(o.name);
	$('#addConfigSubmit').removeClass('button-busy');
	
	$('#addConfigForm').unbind('submit');	
	$('#addConfigForm').submit(function(e)
	{
		App.Validation.hideErrors();

		var name = $.trim($('#addConfigName').val());
		
		// Signal busy
		$('#addConfigSubmit').addClass('button-busy');

		o.submit(name);
		return false;
	});
	
	App.Dialogs.open(
	{
		selector: '#addConfigDialog',
		focusedControl: '#addConfigName',
		selectedControl: '#addConfigName',
		titleSelector: o.titleSelector
	});
}

App.Configs.getSelected = function()
{
	var checkboxes = $('#configurations input.selectionCheckbox');
	var selected = new Array();
	
	$.each(checkboxes, function(i, v)
	{
		if (v.checked)
		{
			var n = parseInt(v.value);
			selected.push(n);
		}
	});
	
	return selected;
}

App.Configs.setSelected = function(selected)
{
	// Uncheck all first.
	$('#configurations input.selectionCheckbox').prop('checked', false);
	
	if (!selected)
	{
		return;
	}
	
	// Then check the requested boxes.
	for (i = 0; i < selected.length; i++)
	{
		var id = selected[i];
		var selector = '#configurations #configCheckbox-' + id;
		$(selector).prop('checked', true);
	}
}

App.Configs.select = function(o)
{
	$('#selectConfigsForm').unbind('submit');	
	$('#selectConfigsForm').submit(function(e)
	{
		var selected = App.Configs.getSelected();
		
		o.submit(
		{
			selected: selected,
			refreshAll: App.Configs.refreshNeeded
		});
		
		return false;
	});

	$('#selectConfigsForm .dialogActionClose').unbind('click');
	$('#selectConfigsForm .dialogActionClose').click(
		function(e)
		{
			o.cancel(
			{
				refreshAll: App.Configs.refreshNeeded
			});
		}
	);
	
	App.Configs.setSelected(o.selected);
	App.Configs.refreshNeeded = false; // Reset, see remove
	
	App.Dialogs.open(
	{
		selector: '#selectConfigsDialog'
	});
}

;

