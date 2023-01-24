/**********************************************************************************************/
/* Controls */

/* [Permissions checked!] */

App.Controls = {};

App.Controls.setComboboxIndex = function(selector, index)
{
	$(selector).each(function(i)
	{
		this.selectedIndex = index;
	});
}

App.Controls.resetCombobox = function(selector)
{
	App.Controls.setComboboxIndex(selector, 0);
}

App.Controls.disableCombobox = function(selector)
{
	$(selector).prop('disabled', true);
}

App.Controls.enableCombobox = function(selector)
{
	$(selector).prop('disabled', false);
}

App.Controls.clearCombobox = function(selector)
{
	$('option', $(selector)).remove();
}

App.Controls.fillCombobox = function(selector, items, required)
{
	var combo = $(selector);
	
	if (!required)
	{
		combo.append('<option value=""></option>');
	}
	
	for (var i = 0; i < items.length; i++)
	{
		var item = items[i];
		
		var option = $('<option></option>');
		option.val(item.value);
		option.text(item.name);
		option.appendTo(combo);
	}
}

App.Controls.Checkboxes  = new function()
{
	var self = this;

	self._check = function(field_id, checked)
	{
		var checkboxes = $('input', $('#' + field_id + '_control'));
		$.each(checkboxes, function(ix, v)
		{
			if (!$(v).attr('disabled'))
			{
				$(v).attr('checked', checked);
				$(v).trigger('input');
				if ($('.existing_id_' + v.value).length > 0) {
					$('.existing_id_' + v.value).remove();
				}
			}
		});
	}

	self.checkAll = function(field_id)
	{
		self._check(field_id, true);
	}

	self.checkOne = function(field_id, item_id)
	{
		var checkbox = $('#' + field_id + '_checkbox-' + item_id);
		$('input', checkbox).prop('checked', true).trigger('input');;
	}

	self.checkNone = function(field_id)
	{
		self._check(field_id, false);
	}

	self.getValues = function(field_id)
	{
		var checkboxes = 
			$('input:checked', $('#' + field_id + '_control'));

		var values = [];
		$.each(checkboxes, function(ix, v)
		{
			if (!$(v).attr('disabled'))
			{
				values.push(parseInt($(v).val()));
			}
		});

		return values;
	}

	self.getValuesAsString = function(field_id)
	{
		var checkboxes = 
			$('input:checked', $('#' + field_id + '_control'));

		var values = [];
		$.each(checkboxes, function(ix, v)
		{
			if (!$(v).attr('disabled'))
			{
				values.push($(v).val());
			}
		});

		return values;
	}	

	self.disableAll = function(field_id)
	{
		self._disable($('#' + field_id + '_control'));
	}

	self.disableById = function(field_id, id)
	{
		self._disable($('#' + field_id + '_checkbox-' + id));
	}

	self._disable = function(context)
	{
		$($('input', context)).attr('disabled', true);
		$($('label', context)).addClass('checkbox-disabled');
	}

	self.enableAll = function(field_id)
	{
		self._enable($('#' + field_id + '_control'));
	}

	self.enableById = function(field_id, id)
	{
		self._enable($('#' + field_id + '_checkbox-' + id));
	}

	self._enable = function(context)
	{
		$($('input', context)).removeAttr('disabled');
		$($('label', context)).removeClass('checkbox-disabled');
	}

	self.checkById = function(field_id, ids)
	{
		var id_lookup = {};
		for (i = 0; i < ids.length; i++)
		{
			id_lookup[ids[i]] = true;
		}

		var context = $('#' + field_id + '_control');
		$($('input', context)).each(function(ix, v)
		{
			var checked = id_lookup[v.value];
			$(v).prop('checked', checked ? true : false);
		});
	}
}

App.Controls.onNumberChanged = function(e, event, max, allow_0)
{
	// Note: this handler is for a keypress event. The key codes
	// are different for keydown/up events (e.g. numpad).
	var key = event.which ? event.which : event.keyCode;

	if (event.ctrlKey || event.metaKey)
	{
		return true;
	}

	// Backspace, enter and delete
	if (key == 8 || key == 13 || key == 46)
	{
		return true;
	}

	if (key >= 35 && key <= 40) // End/home + arrow keys
	{
		return !event.shiftKey;
	}

	var val = $.trim($(e).val());
	if (val == '')
	{
		if (!allow_0)
		{
			if (key == 48) // Disallow 0 at beginning
			{
				return false;
			}
		}
	}
	else if (val == '0')
	{
		return false;
	}

	if (key > 47 && key < 58)
	{
		if (event.shiftKey)
		{
			return false;
		}

		if (max)
		{
			var val_int = parseInt(val + String.fromCharCode(key));
			if (val_int > max)
			{
				return false;
			}
		}

		return true;
	}

	return false;
}

;

