/*******************************************************************/
/* Help */

/* [Permissions checked!] */

App.Help = {};

// Shows the application About dialog.
App.Help.showAbout = function()
{
	var showDialog = function()
	{
		App.Dialogs.open(
		{
			selector: '#aboutDialog'
		});
	}

	// Load the about dialog, if needed
	if ($('#aboutDialog').length == 0)
	{
		App.Ajax.call(
		{
			target: '/help/ajax_get_about_dialog',
			
			success: function(html)
			{
				$('body').append(html);
				showDialog();
			},
			
			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}
	else
	{
		showDialog();
	}
}

// Shows the survey dialog.
App.Help.showSurvey = function()
{
	var showDialog = function()
	{
		App.Dialogs.open(
		{
			selector: '#surveyDialog'
		});
	}

	// Load the survey dialog
	if ($('#surveyDialog').length == 0)
	{
		App.Ajax.call(
		{
			target: '/help/ajax_get_survey_dialog',
			
			success: function(html)
			{
				$('body').append(html);
				showDialog();
			},
			
			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}
	else
	{
		showDialog();
	}
}

App.Help.subscribeNewsletter = function(email)
{
	$('#newsletter').val(email);
	$('#newsletterForm').submit();
}

;

