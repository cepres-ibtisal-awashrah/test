/*******************************************************************/
/* Updater  */

/* [Permissions checked!] */

App.Update = {};

App.Update.runMigration = function()
{
	var $row = $('#step');
	$row.find('th, td').removeClass('inactive');
	$row.find('.busy').show();

	App.Ajax.call({
		target: '/updater/ajax_run_migration',

		success: function(data)
		{
			$row.find('.busy').hide();
			$row.find('.success').show();

			$('#update-success').show();
		},

		error: function(data)
		{
			$row.find('.busy').hide();
			$row.find('.error').show();

			var error = $('#update-error');
			error.find('.message').text(data.error);
			error.show();
		}
	});
}

App.Update.runSteps = function(from, to, callbackFunction)
{
	App.Update.runStep(from, to, callbackFunction);
}

App.Update.runStep = function(current, to, callbackFunction)
{
	var row = $('#step-' + current);
	row.find('th').removeClass('inactive');
	row.find('td').removeClass('inactive');
	row.find('.busy').show();

	App.Ajax.call(
	{
		target: '/updater/ajax_run_update',

		arguments:
		{
			step: current
		},

		success: function(data)
		{
			row.find('.busy').hide();
			row.find('.success').show();

			++current;
			if (current <= to)
			{
				App.Update.runStep(current, to, callbackFunction);
			}
			else
			{
				if (callbackFunction) {
					callbackFunction();
				} else {
					$('#update-success').show();
				}
			}
		},

		error: function(data)
		{
			row.find('.busy').hide();
			row.find('.error').show();
			var error = $('#update-error');
			error.find('.message').text(data.error);
			error.show();
		}
	});
}

App.Update.runFileCheck = function()
{
	var row = $('#filecheck');
	row.find('.busy').show();

	App.Ajax.call(
	{
		target: '/updater/ajax_check_files',

		success: function(data)
		{
			row.find('.busy').hide();
			row.find('.success').show();
			$('#update-disabled').hide();
			$('#update').show();
			$('#update-confirm').show();
		},

		error: function(data)
		{
			row.find('.busy').hide();
			row.find('.error').show();
			var error = $('#filecheck-error');
			error.find('.message').text(data.error);
			error.show();
		}
	});
}

App.Update.setLicense = function()
{
	App.Validation.hideErrors();

	// Initialize the dialog
	$('#setLicenseKey').val('');
	$('#setLicenseForm').unbind('submit');
	$('#setLicenseForm').submit(function(e)
	{
		App.Validation.hideErrors();
		App.Update._setLicenseSubmit($('#setLicenseKey').val());
		return false;
	});

	App.Dialogs.open(
	{
		selector: '#setLicenseDialog'
	});
}

App.Update._setLicenseSubmit = function(key)
{
	$('#setLicenseSubmit').addClass('button-busy');

	App.Ajax.call(
	{
		target: '/updater/ajax_set_license',

		arguments:
		{
			key: key
		},

		stop: function()
		{
			$('#setLicenseSubmit').removeClass('button-busy');
		},

		success: function(data)
		{
			App.Dialogs.closeTop();
			$('#update').click(); // Trigger the form submit again
		},

		error: function(data)
		{
			App.Ajax.handleError(data, '#setLicenseErrors');
		}
	});
}

;

