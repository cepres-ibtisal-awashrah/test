/*******************************************************************/
/* Validation functions */

/* [Permissions checked!] */

App.Validation = new function()
{
	var self = this;

	self.hideErrors = function()
	{
		$('div.validationError, span.validationError').hide();
	}

	self.setError = function(selector, error)
	{
		$(selector).text(error).show();
	}
}

;

