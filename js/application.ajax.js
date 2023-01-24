/*******************************************************************/
/* Communication / Ajax routines  */

/* [Permissions checked!] */

App.Ajax = {};

App.Ajax.inAction = false;

// Initiates an ajax call. Parameters:
// - o.target:      the uri to call
// - o.arguments:   arguments, as object (will be send as POST)
// - o.blockUI:     whether the UI should be blocked (default: true)
// - o.reflow:      reflow page on success (default: false)
// - o.start:       callback when ajax call starts (to start progress)
// - o.stop:        callback when ajax call stops (to stop progress)
// - o.success:     callback with data from server - function(data)
// - o.error:       callback for errors
App.Ajax.call = function(o)
{
	var p = $.extend(
		{
			arguments: {},
			reflow: false,
			blockUI: true,

			start: function()
			{

			},
			stop: function()
			{

			},
			success: function()
			{
				
			},
			error: function()
			{
				
			}
		},
		o
	);

	// Inject the user-specific csrf token into the ajax request which
	// validates the requests.
	p.arguments._token = Consts.ajaxCsrf;

	// Inject the application version of the client so that the server
	// can detect mismatches between client/server.
	p.arguments._version = Consts.ajaxVersion;

	// Bring the arguments into an acceptable format. We want boolean
	// values to be submitted as 0 and 1 (instead of false and true).
	// Also, if we do not filter out null/undefined values, jQuery
	// would submit these as key=null or key=undefined which also is
	// an unacceptable behavior.
	var data = {};	
	$.each(p.arguments, function(ix, v)
	{
		if (typeof v == 'function')
		{
			return;
		}

		if (v === null || v === undefined)
		{
			return;
		}

		if (v === false)
		{
			v = 0;
		}
		else if (v === true)
		{
			v = 1;
		}
		else if (v instanceof Array)
		{
			v = v.join(',');
		}
		else if (v instanceof Object)
		{
			v = JSON.stringify(v);
		}
	
		data[ix] = v;
	});
	
	// Indicate that we are starting a (blocking) AJAX request. This
	// will block the UI in case there are no other blocking AJAX
	// requests already active.
	if (p.blockUI)
	{
		App.Ajax.start();
	}

	p.start();

	return $.ajax(
	{
		cache: false,
		dataType: 'text',
		type: 'POST',
	
		data: data,
		url: Consts.ajaxBaseUrl + p.target,
		
		success: function(data, textStatus, jqXHR) 
		{
			p.stop();
			var type = jqXHR.getResponseHeader('Content-Type');
			
			if (!type)
			{
				p.error();
			}
			else 
			{
				switch (type.replace(/(;.*)/, ''))
				{
					case 'application/json':
						data = $.parseJSON(data);
						if (data.result)
						{
							p.success(data);
							if (p.reflow)
							{
								App.Page.reflow();
							}
						}
						else
						{
							p.error(data);
						}
						break;
						
					case 'text/html':
						p.success(data);
						if (p.reflow)
						{
							App.Page.reflow();
						}
						break;
				}
			}
		},
		
		error: function(jqXHR, textStatus, errorThrown)
		{
			if (textStatus != 'abort') // Aborted by us
			{
				p.stop();
				p.error();
			}
		},
		
		complete: function(jqXHR, textStatus)
		{
			// Complete is called after the success/error handlers
			// were run (and our error or success handler were
			// executed).
			if (p.blockUI)
			{
				App.Ajax.stop();
			}
		}
	});
}

App.Ajax.abort = function(request)
{
	request.abort();
}

App.Ajax.errorDialog = function()
{
	App.Dialogs.error(Consts.ajaxErrorMessage);
}

App.Ajax.handleError = function(data, errorSelector)
{
	// Did the server pass along an error message and should
	// we display the error inline, i.e. in a dialog?
	if (data && data.error)
	{		
		if (data.inline && errorSelector)
		{
			// Display the error inline. This is usually the
			// case for dialogs with validation sections.
			App.Validation.setError(errorSelector, data.error);
		}
		else
		{
			App.Dialogs.error(data.error);
		}
	}
	else 
	{	
		// Standard AJAX error message.
		App.Ajax.errorDialog();
	}
}

App.Ajax.activeCount = 0;

App.Ajax.start = function()
{	
	if (App.Ajax.activeCount == 0)
	{
		$.blockUI();
		App.Ajax.inAction = true;
	}
	
	App.Ajax.activeCount++
}

App.Ajax.stop = function()
{
	if (--App.Ajax.activeCount == 0)
	{
		App.Ajax.inAction = false;
		$.unblockUI();
	}
}

App.Ajax.isBusy = function()
{
	return App.Ajax.inAction;
}

;

