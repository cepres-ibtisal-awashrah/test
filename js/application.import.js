/*******************************************************************/
/* Import dialogs and routines  */

/* [Permissions checked!] */

App.Import = new function()
{
	var self = this;

	self.upload = function(o)
	{
		// Inject the user-specific csrf token into the ajax request
		// which validates the requests.
		o.data._token = Consts.ajaxCsrf;

		// Inject the application version of the client so that the
		// server can detect mismatches between client/server.
		o.data._version = Consts.ajaxVersion;
		
		$.ajaxFileUpload(
		{
			url: App.Page.formatUri(
				'{0}/{1}/&is_upload=1&is_import=1',
				Consts.ajaxBaseUrl,
				o.target
			),

			secureuri: false,
			fileElementId: o.fileElementId,
			data: o.data,
			
			success: function (data, status)
			{
				o.success(data, status);
			},
			
			error: function (data, status, e)
			{
				o.error(data, status, e);
			}
		});
	}
}

;

