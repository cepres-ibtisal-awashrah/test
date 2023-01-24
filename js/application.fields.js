/*******************************************************************/
/* Custom Fields  */

/* [Permissions checked!] */

App.Fields = {};

App.Fields.is_system = false; // If we are dealing with a system field

App.Fields.moveUp = function(id)
{
	var field = $('#field-' + id);
	$('.moveUp', field).hide();
	$('.moveUpBusy', field).show();

	App.Ajax.call(
	{
		target: '/admin/fields/ajax_move_up',

		arguments:
		{
			field_id: id
		},

		success: function(data)
		{
			$('.moveUp', field).show();
			$('.moveUpBusy', field).hide();

			var prev = field.prev();
			field.insertBefore(prev);

			App.Fields.syncMoveButtons(field, prev);
			if ($('td', field).hasClass('separator'))
			{
				$('td', field).removeClass('separator');
				$('td', prev).addClass('separator');
			}
		},

		error: function(data)
		{
			$('.moveUp', field).show();
			$('.moveUpBusy', field).hide();
			App.Ajax.handleError(data);
		}
	});
}

App.Fields.moveDown = function(id)
{
	var field = $('#field-' + id);
	$('.moveDown', field).hide();
	$('.moveDownBusy', field).show();

	App.Ajax.call(
	{
		target: '/admin/fields/ajax_move_down',

		arguments:
		{
			field_id: id
		},

		success: function(data)
		{
			$('.moveDown', field).show();
			$('.moveDownBusy', field).hide();

			var next = field.next();
			field.insertAfter(next);

			App.Fields.syncMoveButtons(field, next);
			if ($('td', next).hasClass('separator'))
			{
				$('td', next).removeClass('separator');
				$('td', field).addClass('separator');
			}
		},

		error: function(data)
		{
			$('.moveDown', field).show();
			$('.moveDownBusy', field).hide();
			App.Ajax.handleError(data);
		}
	});
}

App.Fields.syncMoveButtons = function(s, t)
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

App.Fields.configDialog = function(o)
{
	App.Validation.hideErrors();
	$('#fieldOptionsErrors').empty();

	var ident = App.Fields.getIdent();

	$('#fieldOptionsForm').unbind('submit');
	$('#fieldOptionsForm').submit(function(e)
	{
		App.Validation.hideErrors();
		$('#fieldOptionsErrors').empty();
		if ($('input[name="fieldOptionsProjectSelection[]"]:checked').length) {
			App.Controls.Checkboxes.enableAll('fieldOptionsProjectSelection');
		}

		// Fill the config. We call the type specific getOptions
		// function to get, well, the type specific options (default
		// value, etc.) and fill the context (global or specific
		// projects).

		var config = {
			context: App.Fields.getConfigContext(),
			options: App.Fields.getConfigOptions(ident)
		};

		o.submit({ config: config });
		return false;
	});

	App.Dialogs.open(
	{
		selector: '#fieldOptionsDialog',

		show: function()
		{
			App.Fields.resetConfigDialog(o.config);
			App.Fields.defaultInit(o.config);
			App.callFunction(App.Fields, ident + 'Init', o.config);
		}
	});
}

App.Fields.resetConfigDialog = function(config)
{
	// Activate/show the correct tab.
	var dialog = $('#fieldOptionsDialog');
	App.Tabs.activate($('.tabs .tab-header a.tab1', dialog));

	var projectList = $('#fieldOptionsProjectSelection');
	var selectableProjects = App.Fields.getSelectableProjects(config);

	// And select the (previously selected) projects of the
	// config, if available.
	var field_id_name = 'fieldOptionsProjectSelection';
	if (config) {
		if (config.context.is_global) {
			App.Controls.Checkboxes.checkAll(field_id_name);
		} else {
			App.Controls.Checkboxes.checkById(field_id_name,
				config.context.project_ids);
		}
	} else {
		App.Controls.Checkboxes.checkNone(field_id_name);
	}

	// Disable all projects first and then selectively enable
	// those projects which can be selected.
	App.Controls.Checkboxes.disableAll('fieldOptionsProjectSelection');
	$.each(selectableProjects, function(ix, v)
	{
		App.Controls.Checkboxes.enableById('fieldOptionsProjectSelection',
			v);
	});

	let option_fields = [
		'fieldOptionsRequired',
		'fieldOptionsDefault',
		'fieldOptionsItems',
		'fieldOptionsFormat',
		'fieldOptionsHasAdditional',
		'fieldOptionsHasReference',
		'fieldOptionsRows',
		'fieldOptionsHasExpected'
	];
	let other_projects_count = $('#fieldOptionsProjectSelection_control input:checked:disabled').length;
	let assigned_projects_count = $('#fieldOptionsProjectSelection_control input:checked:enabled').length;
	
	option_fields.forEach(function (option_field) {
		let $field_item = $('#' + option_field);
		if (!$('#fieldOptionsGlobal').length) {
			if ($field_item.length) {
				$field_item.prop('disabled', other_projects_count > 0 || assigned_projects_count <= 0);
			}
		}
	});

	$('#fieldOptionsGlobalItem').show();
	if (selectableProjects.length != availableProjects.length)
	{
		isGlobal = false;
		$('#fieldOptionsGlobalItem').hide();
	}
	else
	{
		if (config)
		{
			isGlobal = config.context.is_global;
		}
		else
		{
			isGlobal = true;
		}
	}

	// Reset/initialize the context (global vs. projects)
	if (isGlobal)
	{
		$('#fieldOptionsGlobal').prop('checked', true);
		$('#fieldOptionsProjects').prop('checked', false);
		$('#fieldOptionsProjectsContainer').hide();
	}
	else
	{
		$('#fieldOptionsGlobal').prop('checked', false);
		$('#fieldOptionsProjects').prop('checked', true);
		$('#fieldOptionsProjectsContainer').show();
	}

	$('#fieldOptionsProjectSelection_control input:checkbox').on('change', function() {
		option_fields.forEach(function (option_field) {
			let field_item = $('#' + option_field);

			if (field_item.length) {
				field_item.prop(
					'disabled',
					other_projects_count > 0 || $('#fieldOptionsProjectSelection_control input:checked:enabled').length === 0
				);
			}
		});
	});
}

App.Fields.getSelectableProjects = function(config)
{
	var selected = {};
	var hasGlobal = false;

	$.each(fieldConfigs, function(ix, v)
	{
		if (config && v.id == config.id)
		{
			return true;
		}

		if (v.context.is_global)
		{
			hasGlobal = true;
			return false;
		}

		$.each(v.context.project_ids, function(jx, w)
		{
			selected[w] = true;
		});
	});

	if (hasGlobal)
	{
		return [];
	}
	else
	{
		var selectable = [];

		$.each(availableProjects, function(ix, v)
		{
			if (!selected[v])
			{
				selectable.push(v);
			}
		});

		return selectable;
	}
}

App.Fields.loadConfig = function(o)
{
	var typeId = $('#type_id').val();

	$('#fieldOptionsSubmit').addClass('button-busy');

	App.Ajax.call(
	{
		target: '/admin/fields/ajax_render_config',

		arguments:
		{
			type_id: typeId,
			config: JSON.stringify(o.config)
		},

		success: function(data)
		{
			$('#fieldOptionsSubmit').removeClass('button-busy');
			o.success(data);
		},

		error: function(data)
		{
			$('#fieldOptionsSubmit').removeClass('button-busy');
			App.Ajax.handleError(data, '#fieldOptionsErrors');
		}
	});
}

App.Fields.getConfigContext = function()
{
	var context = {
		is_global: $('#fieldOptionsGlobal').is(':checked'),
		project_ids: App.Controls.Checkboxes.getValues(
			'fieldOptionsProjectSelection'
		)
	};

	return context;
}

App.Fields.getConfigOptions = function(ident)
{
	var options = App.callFunction(App.Fields, ident + 'GetOptions');
	return options ? options : App.Fields.defaultGetOptions();
}

App.Fields.initConfigDialog = function(o)
{
	if ($('#fieldOptionsDialog').length != 0)
	{
		// Already loaded.
		o.success();
	}
	else
	{
		// Dynamically load the options dialog.
		App.Fields.loadConfigDialog(o);
	}
}

App.Fields.loadConfigDialog = function(o)
{
	var typeId = $('#type_id').val();
	var isAssignedProjectsAreConfigs = $('#is_assigned_projects_are_configs').val();
	var isProjectAdminManager = $('#is_project_admin_manager').val();
	var isEdit = $('#is_edit').val();
	var isGlobal = $('#is_global').val();
	App.Ajax.call(
	{
		target: '/admin/fields/ajax_render_dialog',

		arguments:
		{
			type_id: typeId,
			is_assigned_projects_are_configs: isAssignedProjectsAreConfigs,
			is_project_admin_manager: isProjectAdminManager,
			is_edit: isEdit,
			is_global: isGlobal,
			is_system: App.Fields.is_system
		},

		success: function(html)
		{
			$('body').append(html);
			o.success();
		},

		error: function(data)
		{
			App.Ajax.handleError(data);
		}
	});
}

App.Fields.updateAddConfigLink = function()
{
	var selectable = App.Fields.getSelectableProjects();
	if (selectable.length == 0)
	{
		$('#addConfig').hide();
	}
	else
	{
		$('#addConfig').show();
	}
}

App.Fields.updateEmptyMessage = function()
{
	if (App.getCount(fieldConfigs) == 0)
	{
		$('#noConfigs').show();
	}
	else
	{
		$('#noConfigs').hide();
	}
}

App.Fields.addConfig = function()
{
	var submit = function(o)
	{
		App.Fields.loadConfig(
		{
			config: o.config,
			success: function(data)
			{
				App.Dialogs.close('#fieldOptionsDialog');
				$('#configsTable').append(data.code);
				App.Fields.addConfigToArray(data.id, o.config);
				App.Fields.updateAddConfigLink();
				App.Fields.updateEmptyMessage();
				App.Fields.updateConfigs();
			}
		});
	};

	App.Fields.initConfigDialog(
	{
		success: function()
		{
			App.Fields.configDialog(
			{
				submit: submit
			});
		}
	});
}

App.Fields.updateConfigs = function()
{
	var input = $('#configs_str');
	input.val(App.Fields.configsToString());
	input.trigger('change');

	var dirtyTrackableInput = $('#dialog_values_trackable');
	dirtyTrackableInput.val(App.Fields.getConfigsForDirtyCheck());
	dirtyTrackableInput.trigger('input');
}

App.Fields.addConfigToArray = function(id, config)
{
	config.id = id;
	fieldConfigs[id] = config;
}

App.Fields.editConfig = function(id)
{
	var submit = function(o)
	{
		App.Fields.loadConfig(
		{
			config: o.config,
			success: function(data)
			{
				App.Dialogs.close('#fieldOptionsDialog');
				App.Fields.removeConfigFromArray(id);
				$('#config-' + id).replaceWith(data.code);
				App.Fields.addConfigToArray(data.id, o.config);
				App.Fields.updateAddConfigLink();
				App.Fields.updateConfigs();
			}
		});
	};

	App.Fields.initConfigDialog(
	{
		success: function()
		{
			App.Fields.configDialog(
			{
				config: App.Fields.getConfigFromArray(id),
				submit: submit
			});
		}
	});
}

App.Fields.getConfigFromArray = function(id)
{
	return fieldConfigs[id];
}

App.Fields.removeConfig = function(id)
{
	$('#config-' + id).remove();
	App.Fields.removeConfigFromArray(id);
	App.Fields.updateAddConfigLink();
	App.Fields.updateEmptyMessage();
	App.Fields.updateConfigs();
}

App.Fields.removeConfigFromArray = function(id)
{
	delete fieldConfigs[id];
}

App.Fields.onContextClicked = function(global, radio)
{
	var showProjects = false;
	if (global)
	{
		if (!radio.checked)
		{
			showProjects = true;
		}
	}
	else
	{
		if (radio.checked)
		{
			showProjects = true;
		}
	}

	if (showProjects)
	{
		App.Effects.show('#fieldOptionsProjectsContainer');
	}
	else
	{
		App.Effects.hide('#fieldOptionsProjectsContainer');

		//Need to uncheck values to not save old checked values in hidden input for dirty checker
		$('#fieldOptionsProjectsContainer input').each(function(){
			$(this).prop("checked", false);
		});
	}
}

App.Fields.onTemplatesClicked = function(all, radio)
{
	var showTemplates = false;
	if (all)
	{
		if (!radio.checked)
		{
			showTemplates = true;
		}
	}
	else
	{
		if (radio.checked)
		{
			showTemplates = true;
		}
	}

	if (showTemplates)
	{
		App.Effects.show('#includeSpecificContainer');
	}
	else
	{
		App.Effects.hide('#includeSpecificContainer');
	}
}

App.Fields.getIdent = function()
{
	var typeId = $('#type_id').val();
	return fieldTypes[typeId];
}

App.Fields.getConfigCount = function()
{
	return App.getCount(fieldConfigs);
}

App.Fields.onTypeChange = function(e)
{
	var newValue = $(e).val();

	var doChange = function()
	{
		fieldConfigs = {};
		$('#configsTable tr.config').remove();
		$('#fieldOptionsDialog').remove();
		fieldType = newValue; // Form variable
		App.Fields.updateAddConfigLink();
		App.Fields.updateEmptyMessage();
	};

	if (App.Fields.getConfigCount() > 0)
	{
		// To prevent the change after canceling a possible confirm,
		// we need to restore the previous value before changing
		// the select. We only set the new value in case the user
		// confirms the change.
		var curValue = fieldType;
		$(e).val(curValue);

		var confirm = $('#typeChangeConfirm').html();
		App.Dialogs.confirm(confirm, function()
		{
			doChange();
			$(e).val(newValue);
		});
	}
	else
	{
		doChange();
	}
}

App.Fields.configsToString = function()
{
	var configs = [];

	$.each(fieldConfigs, function(ix, v)
	{
		configs.push(v);
	});

	return JSON.stringify(configs);
}

App.Fields.getConfigsForDirtyCheck = function(){
	var configs = [];
	var fieldConfigs = JSON.parse(App.Fields.configsToString());

	$.each(fieldConfigs, function(ix, v)
	{
		delete v.id;
		v.context.project_ids = v.context.project_ids  == null ? [] : v.context.project_ids;
		configs.push(v);
	});

	return JSON.stringify(configs);
}

//---------------------------------------------------------------------
// TYPE-SPECIFIC
//---------------------------------------------------------------------

App.Fields.checkboxInit = function(config)
{
	$('#fieldOptionsDefault').val(config ? config.options.default_value : '0');
}

App.Fields.defaultGetOptions = function()
{
	var options = {
		is_required: $('#fieldOptionsRequired').is(':checked'),
		default_value: $('#fieldOptionsDefault').val()
	};

	return options;
}

App.Fields.defaultInit = function(config)
{
	var defaultValue = '';
	var isRequired = false;

	if (config)
	{
		defaultValue = config.options.default_value;
		isRequired = config.options.is_required;
	}

	$('#fieldOptionsDefault').val(defaultValue);
	$('#fieldOptionsRequired').prop('checked', isRequired);
}

App.Fields.dropdownGetOptions = function()
{
	var options = App.Fields.defaultGetOptions();
	options.items = $('#fieldOptionsItems').val();
	return options;
}

App.Fields.dropdownInit = function(config)
{
	var items = '';
	var defaultValue = '';

	if (config)
	{
		items = config.options.items;
		defaultValue = config.options.default_value;
	}

	$('#fieldOptionsItems').val(items);
	App.Fields.dropdownUpdateDefault(defaultValue);
}

App.Fields.dropdownItemsLeave = function()
{
	App.Fields.dropdownUpdateDefault();
}

App.Fields.dropdownUpdateDefault = function(defaultValue)
{
	var values = $('#fieldOptionsItems').val().split(/\r?\n/);

	if (!defaultValue)
	{
		defaultValue = $('#fieldOptionsDefault').val();
	}

	var items = [];
	$.each(values, function(ix, v)
	{
		if (v.match(/^(^\d+),([^,]+)(,(-|\+))?$/))
		{
			var a = v.split(/,/);
			items.push({ name: a[1], value: a[0] });
		}
	});

	App.Controls.clearCombobox('#fieldOptionsDefault');
	App.Controls.fillCombobox('#fieldOptionsDefault', items);
	$('#fieldOptionsDefault').val(defaultValue);
}

App.Fields.multiselectGetOptions = function()
{
	var options = App.Fields.defaultGetOptions();
	options.items = $('#fieldOptionsItems').val();
	return options;
}

App.Fields.multiselectInit = function(config)
{
	var items = '';

	if (config)
	{
		items = config.options.items;
	}

	$('#fieldOptionsItems').val(items);
}

App.Fields.multiselectToString = function(field_name)
{
	var values = $('#' + field_name + '_select').val();
	return values ? values.join(',') : '';
}

App.Fields.textGetOptions = function()
{
	var options = App.Fields.defaultGetOptions();
	options.format = $('#fieldOptionsFormat').val();
	options.rows = $('#fieldOptionsRows').val();
	return options;
}

App.Fields.textInit = function(config)
{
	$('#fieldOptionsFormat').val(config ? config.options.format : 'markdown');
	$('#fieldOptionsRows').val(config ? config.options.rows : '');
}

App.Fields.stepsGetOptions = function()
{
	var options = App.Fields.defaultGetOptions();
	options.format = $('#fieldOptionsFormat').val();
	options.has_expected = $('#fieldOptionsHasExpected').is(':checked');
	options.has_additional = $('#fieldOptionsHasAdditional').is(':checked');
	options.has_reference = $('#fieldOptionsHasReference').is(':checked');
	options.rows = $('#fieldOptionsRows').val();
	return options;
}

App.Fields.stepsInit = function(config)
{
	var format = 'markdown';
	if (config)
	{
		format = config.options.format;
	}

	$('#fieldOptionsFormat').val(format);
	var rows = 5;
	if (config && config.options.rows)
	{
		rows = config.options.rows;
	}

	$('#fieldOptionsRows').val(rows);

	// Default is enabled for new fields and false for existing
	// fields.
	var has_expected = true;
	var has_additional = false;
	var has_reference = false;
	if (config)
	{
		has_expected = config.options.has_expected !== undefined ?
			config.options.has_expected : false;
		has_additional = config.options.has_additional !== undefined ?
			config.options.has_additional : false;
		has_reference = config.options.has_reference !== undefined ?
			config.options.has_reference : false;
	}

	$('#fieldOptionsHasExpected').prop('checked', has_expected);
	$('#fieldOptionsHasAdditional').prop('checked', has_additional);
	$('#fieldOptionsHasReference').prop('checked', has_reference);
}

App.Fields.resultsGetOptions = function()
{
	var options = App.Fields.defaultGetOptions();
	options.format = $('#fieldOptionsFormat').val();
	options.has_expected = $('#fieldOptionsHasExpected').is(':checked');
	options.has_additional = $('#fieldOptionsHasAdditional').is(':checked');
	options.has_reference = $('#fieldOptionsHasReference').is(':checked');
	options.has_actual = $('#fieldOptionsHasActual').is(':checked');
	return options;
}

App.Fields.resultsInit = function(config)
{
	var format = 'markdown';
	if (config)
	{
		format = config.options.format;
	}

	$('#fieldOptionsFormat').val(format);

	// Default is enabled for new fields and false for existing
	// fields.
	var has_expected = true;
	var has_additional = false;
	var has_reference = false;
	if (config)
	{
		has_expected = config.options.has_expected !== undefined ?
			config.options.has_expected : false;
		has_additional = config.options.has_additional !== undefined ?
			config.options.has_additional : false;
		has_reference = config.options.has_reference !== undefined ?
			config.options.has_reference : false;
	}

	$('#fieldOptionsHasExpected').prop('checked', has_expected);
	$('#fieldOptionsHasAdditional').prop('checked', has_additional);
	$('#fieldOptionsHasReference').prop('checked', has_reference);

	// Default is disabled for new and existing fields.
	var has_actual = false;
	if (config)
	{
		has_actual = config.options.has_actual !== undefined ?
			config.options.has_actual : false;
	}

	$('#fieldOptionsHasActual').prop('checked', has_actual);
}

App.Fields.setTemplateCheckboxes = function (projectsAssigned) {
	App.Controls.Checkboxes.disableAll('project_ids');
	$.each(projectsAssigned, function (index, value) {
		App.Controls.Checkboxes.enableById('project_ids',
			value);
	});
}

$(document).ready(function() {
	$('#form').submit(function() {
		let inc_all = $('#includeAll');
		let is_active = $('#is_active');

		if (inc_all.is(':enabled') === false) {
			inc_all.prop('disabled', false);
		}

		if (is_active.is(':enabled') === false) {
			is_active.prop(
			   'disabled',
			   is_active.is(':enabled')
			);
		}
	});
});

;

