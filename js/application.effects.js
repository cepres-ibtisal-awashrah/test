/*******************************************************************/
/* Effects */
 
/* [Permissions checked!] */

App.Effects = new function()
{
	var self = this;

	// Replaces one element 's' with another element 't'
	self.replace = function(s, t)
	{
		$(s).hide();
		$(t).show();
	}

	// Removes an element from the DOM (without effects)
	self.remove = function(selector, callback)
	{
		$(selector).remove();
		if (callback)
		{
			callback();
		}
	}

	// Shows an element (with effects). Note: use with care because
	// IE doesn't like effects very much.
	self.add = function(selector, callback)
	{
		var e = $(selector);

		e.css('opacity', 0);
		e.css('background-color', 'rgba(252,194,0,0.2)');
		e.show();

		e.fadeTo('fast', 1, function()
		{
			// Cleartype fix, see 
			// http://blog.sampsonvideos.com/2008/09/24/jquery-ie-and-cleartype/
			if ($.browser.msie)  
			{
				this.style.removeAttribute('filter');
			}
		
			e.css('background-color', '');			
			if (callback)
			{
				callback();
			}
		});
	}

	// Shows an element (without effects)
	self.show = function(selector, callback)
	{
		$(selector).show();
		if (callback)
		{
			callback();
		}
	}

	// Hides an element (without effects)
	self.hide = function(selector, callback)
	{
		$(selector).hide();
		if (callback)
		{
			callback();
		}
	}

	// Shows or hides an element (without effects)
	self.setVisible = function(selector, visible)
	{
		if (visible)
		{
			self.show(selector);
		}
		else 
		{
			self.hide(selector);
		}
	}
}

;

