/*******************************************************************/
/* Filters  */

/* [Permissions checked!] */

App.Filters = new function()
{
	var self = this;

	self.addLine = function(line_id)
	{
		var line = $('#filterLine-' + line_id);

		var operations = {};
		$('select option', line).each(function(ix, v)
		{
			var o = $(this);
			operations[o.val()] = o.text();
		});

		var add = $('.add', line);
		var busy = $('.addBusy', line);

		busy.show();
		add.hide();

		App.Ajax.call(
		{
			target: '/filters/ajax_render_row',
			arguments: {
				operations: JSON.stringify(operations),
				datepicker: $('input', line).hasClass('datepicker')
			},

			success: function(html)
			{
				add.show();
				busy.hide();
				$(html).insertAfter(line);

				var lines = line.siblings().andSelf();
				$('.deleteEnabled', lines).show();
				$('.deleteDisabled', lines).hide();

				App.applyDatepicker(lines); // For date controls
			},

			error: function(data)
			{
				add.show();
				busy.hide();
				App.Ajax.handleError(data);
			}
		});
	}

	self.removeLine = function(line_id)
	{
		var line = $('#filterLine-' + line_id);
		var siblings = line.siblings();

		if (siblings.length == 1)
		{
			$('.deleteDisabled', siblings).show();
			$('.deleteEnabled', siblings).hide();
		}

		line.remove();
	}

	self.toggle = function(filter_id)
	{
		var filter = $(App.escapeId('#filter-' + filter_id));
		var content = $('div.filterContent', filter);
		if (content.is(':visible'))
		{
			$('a.filterExpand', filter).show();
			$('a.filterCollapse', filter).hide();
			content.hide();
		}
		else
		{
			$('a.filterCollapse', filter).show();
			$('a.filterExpand', filter).hide();
			content.show();
		}
		if (filter_id == 'logs:date',
			typeof $('.custom_from.form-control.datepicker.hasDatepicker').data('events') !== "undefined" &&
			typeof $('.custom_from.form-control.datepicker.hasDatepicker').data('events').change == "undefined" &&
			typeof $(".custom_from.form-control.datepicker.hasDatepicker").datepicker("getDate") != 'undefined'
		) {
			$('.custom_from.form-control.datepicker.hasDatepicker').on('change', function () {
				$(".custom_to.form-control.datepicker.hasDatepicker").datepicker('option','minDate',$(".custom_from.form-control.datepicker.hasDatepicker").datepicker("getDate"));
			});
		}
	}

	self.getAll = function(context)
	{
		var filters = {};

		// Iterate through the available filters
		$('div.filter', context).each(function(ix, v)
		{
			var t = $(this);

			// We skip collapsed filters
			if (!$('.filterContent', t).is(':visible'))
			{
				return;
			}

			var filter = {};
			var filter_ident = $('.filterContent', t).attr('rel');

			// Add the filter properties based on the filter type.
			switch (filter_ident)
			{
				case 'date':
				case 'int':
				case 'string':
				case 'timespan':
					filter.mode = $('input[type=radio]:checked', t).attr('rel');
					filter.filters = [];
					$('table.filter-list tr', t).each(function(ix, v)
					{
						var row = $(this);
						var value = $.trim($('input', row).val());

						if (value)
						{
							filter.filters.push({
								'op': $('select', row).val(),
								'value': value
							});
						}
					});
					break;

				case 'daterange':
					filter.type = $('select', t).val();
					filter.custom_from = $('input.custom_from', t).val();
					filter.custom_to = $('input.custom_to', t).val();
					break;

				case 'bool':
					filter.value = $('select', t).val();
					break;

				case 'checkbox':
					filter.value = $('select', t).val();
					break;

				case 'dropdown':
					filter.values = $('select', t).val();
					if (!filter.values) return;
					break;

				case 'multiselect':
					filter.mode = $('input[type=radio]:checked', t).attr('rel');
					filter.values = $('select', t).val();
					if (!filter.values) return;
					break;
			}

			filters[t.attr('rel')] = filter;
		});

		var mode = '1';
		var mode_selection = $('input[name=filterMode]:checked', context);
		if (mode_selection.length > 0)
		{
			mode = $('input[name=filterMode]:checked', context).attr('rel');
		}

		return {
			mode: mode,
			filters: filters
		}
	}
}

;

