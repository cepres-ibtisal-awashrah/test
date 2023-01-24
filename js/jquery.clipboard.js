/*
 * Clipboard - jQuery plugin for working with pasted images
 * Version: 1.0.0 (12/03/2015)
 * Copyright 2010-2020 Gurock Software GmbH
 * Licensed under the MIT License: http://en.wikipedia.org/wiki/MIT_License
 * Requires: jQuery v1.3+
*/
;(function($)
{
	$.fn.clipboard = function(options)
	{
		if (!window.FileReader)
		{
			return this; // FileReader API not supported
		}

		var settings = $.extend(
			{},
			$.fn.clipboard.defaults,
			options
		);

		var re_accept = new RegExp(settings.accept),
			re_ext = new RegExp("/\(.*\)");

		this.on(
			'paste',
			function(e)
			{
				// Support for the clipboardData API and its items is
				// currently limited.

				var e = e.originalEvent;
				if (!e.clipboardData || !e.clipboardData.items)
				{
					return;
				}

				_processItems(e, e.clipboardData.items);
			}
		);

		function _processItems(e, items)
		{
			// We go through the list of items and try to extract the
			// file blob. We also check if the file matches the allowed
			// mime types and assign a file name (based on mime type,
			// file index and current date).

			var files = [];

			for (var i = 0; i < items.length; i++)
			{
				var file = items[i].getAsFile();
				if (!file)
				{
					continue;
				}

				if (!file.type.match(re_accept))
				{
					continue;
				}

				var matches = re_ext.exec(file.type);

				if (!file.name && matches)
				{
					var extension = matches[1];
					file.name = _formatFileName(i, extension);
				}

				files.push(file);
			}

			if (!files.length)
			{
				return; // No valid files found
			}

			// We then use the FileReader API to get the actual images
			// and call the paste event for each file.

			for (let i = 0; i < files.length; i++)
			{
				let file = files[i],
					reader = new FileReader();

				reader.onloadend = function()
				{
					settings.paste(e, file, files.length, i);
				}

      			reader.readAsDataURL(file);
			}

			e.preventDefault();
			e.stopPropagation();
		}

		function _formatFileName(ix, extension)
		{
			var date = _formatDate(new Date());
			return settings.prefix + ix + '-' + date + '.' + extension;
		}

		function _formatDate()
		{
			var now = new Date();

			var y = now.getYear() + 1900,
				m = _padZero(now.getMonth()),
				d = _padZero(now.getDay()),
				h = _padZero(now.getHours()),
				n = _padZero(now.getMinutes()),
				s = _padZero(now.getSeconds());

			return y + '-' + m + '-' + d + '-' + h + '-' + n + '-' + s;
		}

		function _padZero(n)
		{
			return n < 10 ? ('0' + n) : n;
		}

		return this;
	}

	$.fn.clipboard.defaults = {
		accept: 'image/.*',
		prefix: 'image-'
	};
})(jQuery);

;

