/*******************************************************************/
/* Hotkeys related routines */

/* [Permissions checked!] */

App.Hotkeys = new function()
{
	var self = this;

	self.handlers = {};

	self.isForm = function(is_form)
	{
		$.hotkeys.options.filterInputAcceptingElements = !is_form;
		$.hotkeys.options.filterTextInputs = !is_form;
		$.hotkeys.options.filterContentEditable = !is_form;
	}

	self.register = function(key, callback, removable)
	{
		var h = function()
		{
			callback();
			return false; // Make sure to prevent default action
		};

		if (removable)
		{
			self.handlers[key] = h; // Save for possible removal
		}

		$(document).on('keydown', null, key, h);
	}

	self.unregister = function(key)
	{
		$(document).off('keydown', self.handlers[key]);
		delete self.handlers[key];
	}

	self.registerModifier = function(key, callback)
	{
		self.register('ctrl+' + key, callback);
		self.register('meta+' + key, callback);
	}
	
	self.registerAlt = function(key, callback)
	{
		self.register('alt+' + key, callback);
	}
}

;

