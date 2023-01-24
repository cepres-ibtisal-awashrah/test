/*******************************************************************/
/* Dropdowns / context popup  */

/* [Permissions checked!] */

App.Dropdowns = {};

App.ready(function()
{
	$(document).on({
		click: function(e)
		{
			App.Dropdowns.open(this);
			return false;
		}},
		'a.dropdownLink'
	);

	$(document).on({
		click: function()
		{
			App.Dropdowns.closeAll();
		}},
		'a.popupLink'
	);
});

// Closes all open dropdowns
App.Dropdowns.closeAll = function()
{
	App.Dropdowns.deactivateCloseEvents();
	$('div.dropdown').hide();
}

// Initializes close events such as document.click
App.Dropdowns.activateCloseEvents = function()
{
	$(document).bind('click.dropdowns', function()
	{
		App.Dropdowns.closeAll();
	});
}

// Deactivates close events such as document.click
App.Dropdowns.deactivateCloseEvents = function()
{
	$(document).unbind('click.dropdowns');
}

App.Dropdowns.getHref = function(anchor)
{
	var href = anchor.attr('href');
	var index = href.indexOf('#');
	
	if (index > 0)
	{
		return href.substring(index);
	}
	else 
	{
		return href;
	}
}

// The event handler for dropdown anchors
App.Dropdowns.open = function(e)
{
	var anchor = $(e);	
	var dropdown = $(App.Dropdowns.getHref(anchor));
	var offset = anchor.offset();
	var isVisible = dropdown.is(':visible');

	App.Dropdowns.closeAll();
	
	if (isVisible)
	{
		// If the dropdown is associated with the same
		// anchor, do not show it again (to allow toggle)
		if (dropdown.data('anchor') == anchor.attr('rel'))
		{
			dropdown.data('anchor', null);
			return;
		}
	}
	
	// Associate the dropdown with the anchor
	dropdown.data('anchor', anchor.attr('rel'));
	
	// Calculate the drop position based on the position modus.
	var top;
	var left;	
	var modus = dropdown.attr('rel');
	var noticeOffset = $('#notice').outerHeight() || 0;
	
	if (modus == "right")
	{
		left = offset.left + anchor.outerWidth() + 1;
		top = offset.top;
	}
	else if (modus == "bottomLeft")
	{
		left = offset.left - dropdown.outerWidth() + 
			anchor.outerWidth();
		top = offset.top + anchor.outerHeight() + 1;
	}
	else if (modus == "helpMenu")
	{
		left = offset.left - dropdown.outerWidth() + 
			anchor.outerWidth() + 5;
		top = 26 + noticeOffset;
	}
	else if (modus == "userMenu")
	{
		left = offset.left - dropdown.outerWidth() + 
			anchor.outerWidth() + 200;
		top = 26 + noticeOffset;
	}
	else if (modus == "toolbarMenu")
	{		
		left = offset.left - 5;
		var toolbar = $('#content-header');
		top = toolbar.offset().top + toolbar.outerHeight();
		
		// Check if the menu overlaps with the sidebar. If
		// so, we move the menu a little to the left.
		var diff = left + dropdown.outerWidth() - 
			toolbar.outerWidth();
		if (diff > 0)
		{
			left -= diff - 1;
		}
	}
	else if (modus == "itemPrev")
	{
		var prev = anchor.prev();
		left = prev.offset().left;
		top = prev.offset().top + prev.outerHeight() + 1; 
	}
	else
	{
		left = offset.left;
		top = offset.top + anchor.outerHeight();
	}

	App.Dropdowns.setTag(dropdown, anchor.attr('rel'));
	App.Dropdowns._show(dropdown, left, top);

	setTimeout(App.Dropdowns.activateCloseEvents, 0);
}

App.Dropdowns.show = function(selector, x, y)
{
	App.Dropdowns._show($(selector), x, y);
}

App.Dropdowns._show = function(dropdown, x, y)
{
	var d = $(document);
	var w = $(window);

	// Compute max x/y depending on view port (window + scroll)
	var max_x = w.width() + d.scrollLeft() - dropdown.outerWidth();
	var max_y = w.height() + d.scrollTop() - dropdown.outerHeight();

	dropdown.css('left', Math.min(max_x - 10, x));
	dropdown.css('top', Math.min(max_y - 10, y));
	dropdown.show();
}

App.Dropdowns.hide = function(selector)
{
	$(selector).hide();
}

// Sets the tag value for a dropdown
App.Dropdowns.setTag = function(selector, value)
{
	$(selector).data('tag', value);
}

// Returns the tag value of a dropdown
App.Dropdowns.getTag = function(selector)
{
	return $(selector).data('tag');
}

;

