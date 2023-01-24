/*******************************************************************/
/* Responsive  */

App.Responsive = new function()
{
	var self = this;

	self.clients = [];

	self._init = function()
	{
		$(window).resize(
			function()
			{
				self._check(false);
			}
		);

		$.subscribe(
			'body.changed',
			'responsive',
			function()
			{
				self.invalidate();
			}
		);
	}

	self._check = function(force)
	{
		var length = self.clients.length;

		for (var i = 0; i < length; i++)
		{
			var client = self.clients[i];

			if (!client.container.is(':visible'))
			{
				continue;
			}

			var w = client.container.outerWidth();

			// Was the threshold reached (from one side or
			// another)?
			var below = w < client.threshold;

			var trigger = force ||
				(!below && client.is_below) ||
				(below && !client.is_below);

			if (trigger)
			{
				client.is_below = below;
				self._trigger(client);
			}
		}
	}

	self._trigger = function(client)
	{
		client.callback(client.is_below);
	}

	self.register = function(container, threshold, callback)
	{
		if (self.clients.length == 0)
		{
			self._init();
		}

		var c = $(container);

		var client = {
			container: c,
			threshold: threshold,
			is_below: c.outerWidth() < threshold,
			callback: callback
		};

		self.clients.push(client);
		self._trigger(client);
	}

	self.registerMany = function(container, clients)
	{
		$.each(clients, function(threshold, callback)
		{
			self.register(container, threshold, callback);
		});
	}

	self.invalidate = function()
	{
		self._check(true); // Force trigger
	}
}

;

