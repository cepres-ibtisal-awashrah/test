/*******************************************************************/
/* Page related routines (e.g. load) */

/* [Permissions checked!] */

App.Page = new function()
{
	var self = this;
	
	self._formatUri = function(params)
	{
		var format = params[0];
		for (i = 1; i < params.length; i++)
		{
			format = format.replace('{' + (i - 1) + '}', params[i]);
		}
		return format;
	}

	self.formatUri = function()
	{
		return self._formatUri(arguments);
	}	

	self.load = function()
	{
		var uri = self._formatUri(arguments);
		if (uri && uri[0] != '/')
		{
			uri = '/' + uri;
		}
		document.location = Consts.ajaxBaseUrl + uri;
	}

	self.getQuery = function()
	{
		var uri = window.location.search;
		var ix = uri.indexOf('&');
		return ix >= 0 ? uri.substring(ix + 1) : '';
	}

	self.getQueryOptions = function()
	{
		var query = self.getQuery();
		var vars = query.split('&');

		var options = {};
		$.each(vars, function(i, v)
		{
			var ix = v.indexOf('=');
			if (ix >= 0)
			{
				options[v.substring(0, ix)] = v.substring(ix + 1);
			}
		});

		return options;
	}

	self.formatQueryOptions = function(options)
	{
		var s = '';
		for (var key in options)
		{
			if (s)
			{
				s += '&';
			}

			s += key;
			s += '=';
			s += options[key];
		}

		return s;
	}

	self.replaceState = function(uri, query)
	{
		if (!window.history || !window.history.replaceState)
		{
			return;
		}

		var url = Consts.ajaxBaseUrl + uri;
		if (query)
		{
			url += '&' + query;
		}

		window.history.replaceState({}, '', url);
	}

	self.updateMinWidth = function(delta)
	{
		if (delta == 0)
		{
			return;
		}

		var min = parseInt($('body').css('min-width'));
		min = Math.max(Consts.minWidth, min + delta);
		$('body').css('min-width', min + 'px');
	}

	self.getMinContent = function()
	{
		var min = parseInt($('body').css('min-width'));
		
		if (App.Sidebar.isVisible())
		{
			min -= App.Sidebar.getWidth() + 10;
		}

		if (App.QPane.isVisible())
		{
			min -= App.QPane.getWidth() + 10;
		}

		return Math.max(min, Consts.minWidth);
	}

	self.reflow = function()
	{
		$.publish('body.changed');
		$(window).resize();
	}
}

;

