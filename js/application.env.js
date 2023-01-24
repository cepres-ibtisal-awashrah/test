/*******************************************************************/
/* Environment (Browser/OS) */

/* [Permissions checked!] */

App.Env = new function()
{
	var self = this;

	self.vendor = null;
	self.platform = null;

	if ('navigator' in window)
	{
		self.vendor = 'vendor' in navigator ? 
			navigator.vendor.toLowerCase() : ''; 
		self.platform = 'platform' in navigator ? 
			navigator.platform.toLowerCase() : ''; 
	}

	self.isChrome = function()
	{
		return self._isVendor('google');
	}

	self.isFirefox = function() {
		return !!$.browser.mozilla;
	}

	self.isSafari = function() {
		return /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);
	}

	self._isVendor = function(vendor)
	{
		return self.vendor ? 
			self.vendor.indexOf(vendor.toLowerCase()) >= 0 : false;
	}

	self._isPlatform = function(platform)
	{
		return self.platform ? 
			self.platform.indexOf(platform.toLowerCase()) >= 0 : false;
	}

	self.isMac = function()
	{
		return self._isPlatform('mac');
	}

	self.isWindows = function()
	{
		return self._isPlatform('win');
	}

	self.request_get_parameters = function()
	{
		return window.location.search
			.substring(1)
			.split('&')
			.filter(Boolean)
			.reduce(
				function (acc, param) {
					var param_data = param.split('=');
					acc[param_data[0]] = param_data[1];
					return acc;
				},
				{}
			)
	}

	self.sleep = function(timeout)
	{
		var date = Date.now();
		var now = null;
		do {
			now = Date.now();
		} while (now - date < timeout)
	}
}

;

