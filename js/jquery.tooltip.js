/*
 * Bubble - jQuery plugin for displaying tooltips (popups that replace
 *          traditional browser hints)
 * Version: 1.0.0 (06/13/2014)
 * Copyright 2010-2020 Gurock Software GmbH
 * Licensed under the MIT License: http://en.wikipedia.org/wiki/MIT_License
 * Requires: jQuery v1.3+
*/
;(function($)
{
	var hideDelayTimer = null;
	var showDelayTimer = null;
	var shown = false;
	var currentTooltip = null;
	var currentTrigger = null;

	$.fn.tooltip = function(options)
	{
		var settings = $.extend(
			{},
			$.fn.tooltip.defaults,
			options
		);

		return this.each(
			function()
			{
				_init(this, settings);
			}
		);
	}

	$.fn.tooltip.defaults = {
		offsetX: 15,
		offsetY: 0,
		toggleEvent: 'hover',
		tooltip: null, // The placeholder div for the tooltip
		showDelay: 600,
		hideDelay: 400,
		autoHide: true
	};

	var _init = function(element, o)
	{
		var t = $(element);
		_bind(t, o);
	}

	var _bind = function(t, o)
	{
		var tooltip = $(o.tooltip);

		// Mouseover over the link triggers the tooltips.
		t.unbind('mouseover').mouseover(function(e)
		{
			if (hideDelayTimer)
			{
				clearTimeout(hideDelayTimer);
			}

			hideDelayTimer = null;

			// If there's already a tooltip active, check if the hover
			// is triggered by a different object. If so, we hide the
			// current and show the new tooltip.
			if (shown)
			{
				if (this != currentTrigger)
				{
					currentTrigger = this;
					_hide(currentTooltip);
					_show(t, tooltip, false);
					return;
				}
			}
			else
			{
				currentTrigger = this;
			}

			if (showDelayTimer)
			{
				return;
			}

			showDelayTimer = setTimeout(
				function()
				{
					_show(t, tooltip, true);
				},
				o.showDelay
			);

			return false;
		});

		// Hide on trigger click if tooltip is currently visible.
		// If it's not visible, we make sure to cancel the current
		// show action.
		t.unbind('click').click(function(e)
		{
			if (shown)
			{
				_hide(currentTooltip);
			}
			else
			{
				if (showDelayTimer)
				{
					clearTimeout(showDelayTimer);
				}

				showDelayTimer = null;
			}
		});

		// Mouseover over the tooltip keeps it visible.
		tooltip.unbind('mouseover').mouseover(function()
		{
			if (hideDelayTimer)
			{
				clearTimeout(hideDelayTimer);
			}

			hideDelayTimer = null;
			return false;
		});

		// Mouseout (for both elements) hides the tooltip.
		t.add(tooltip).unbind('mouseout').mouseout(
			function(e)
			{
				if (showDelayTimer)
				{
					clearTimeout(showDelayTimer);
				}

				showDelayTimer = null;
				if (hideDelayTimer)
				{
					clearTimeout(hideDelayTimer);
				}

				hideDelayTimer = setTimeout(
					function()
					{
						_hide(tooltip);
					},
					o.hideDelay
				);

				return false;
			}
		);
	}

	var _show = function(t, tooltip, animate)
	{
		showDelayTimer = null;
		shown = true;
		currentTooltip = tooltip;

		// Inject the tooltip text and header, if any. We get it from
		// the trigger element attributes.
		var header = t.attr('tooltip-header');
		if (header)
		{
			tooltip.find('.tooltip-header').text(header).show();
		}
		else
		{
			tooltip.find('.tooltip-header').hide();
		}

		var $p = tooltip.find('p');

		var text = t.attr('tooltip-text');
		if (text) {
			var lines =  text.split("\n");
			if (lines.length === 1) {
				$p.text(lines[0]);
			} else {
				$p.text('');
				lines.forEach(function(line) {
					$p.append($('<p>').text(line));
				});
			}
		}

		var html = t.attr('tooltip-html');
		if(html) {
			$p.html(html);
		}

		var width = t.attr('tooltip-width');
		if (!width)
		{
			width = 190;
		}

		let customClass = t.attr('tooltip-class');
		if (customClass) {
			tooltip.addClass(customClass);
		}

		tooltip.css('width', width + 'px');

		// Calculate and set the position for the tooltip including
		// pointer.
		var pos = t.attr('tooltip-position');
		var xy = _getPosition(t, tooltip, pos);

		tooltip.css({
			top: xy.top,
			left: xy.left
		});

		var up = $('.tooltip-pointer-up', tooltip);
		var right = $('.tooltip-pointer-right', tooltip);

		if (pos == 'custom') {
			right.hide();
			up.css({
				'bottom': '-6px',
				'transform': 'rotate(180deg)',
				'left': ($(tooltip).width() / 2) - 3
			}).show();
		} else if (pos == 'custom-top') {
			right.hide();
			if (!t.attr('tooltip-position-center')) {
				// We point the up-pointer to the trigger.
				up.css({
					'transform': 'rotate(180deg)',
					'bottom': '-6px',
					'left': t.offset().left - xy.left +
						(t.outerWidth() > 10 ? 3 : -3) + 7
				}).show();
			} else {
				right.hide();

				// We point the up-pointer to the trigger.
				up.css({
					"transform": "rotate(180deg)",
					"bottom": "-6px",
					"left": t.offset().left - xy.left +
						(t.outerWidth() > 10 ? 3 : -3) + (width / 12)
				}).show();
			}
		} else if (pos == 'left') {
			up.hide();

			// We point the right-pointer to the middle of the trigger
			// height.
			right.css({
				top: Math.floor(t.outerHeight() / 2) + 1,
				left: tooltip.outerWidth()
			}).show();
		} else if (pos == 'top' || pos == 'right') {
			up.hide();
			right.hide();
		} else {
			right.hide();

			// We point the up-pointer to the trigger.
			up.css({
				top: -6,
				left: t.offset().left - xy.left +
					(t.outerWidth() > 10 ? 3 : -3)
			}).show();
		}

		// Show the tooltip (with an animation, if requested).
		if (animate) {
			tooltip.hide().fadeIn(100);
		} else {
			tooltip.show();
		}
	}

	var _getPosition = function(t, tooltip, pos)
	{
		var w = $(window);
		var windowWidth = w.width() + w.scrollLeft();

		var offset = t.offset();
		if (pos == 'custom') {
			return {
				top: offset.top - t.attr('tooltip-position-top'),
				left: offset.left - t.attr('tooltip-position-left')
			};
		} else if (pos == 'custom-top') {
			if (!t.attr('tooltip-position-center')) {
				var left = offset.left + parseInt(t.outerWidth() / 2) -
					parseInt(tooltip.outerWidth() / 2) - parseInt(tooltip.outerWidth() / 3.5);
				var width = tooltip.outerWidth();

				// Limit the left position based on the window width
				return {
					top: offset.top - tooltip.outerHeight() - 12,
					left: Math.max(
						15,
						Math.min(
							left,
							windowWidth - width - 15
						)
					)
				};
			} else {
				var left = offset.left + parseInt(t.outerWidth() / 2) -
				parseInt(tooltip.outerWidth() / 2);
				var width = tooltip.outerWidth();

				// Limit the left position based on the window width
				return {
					top: offset.top - tooltip.outerHeight() - 12,
					left: Math.max(
						15,
						Math.min(
							left,
							windowWidth - width - 15
						)
					)
				};
			}
		} else if (pos == 'left') {
			return {
				top: offset.top - 8,
				left: offset.left - tooltip.outerWidth() - 12
			};
		} else if (pos == 'right') {
			return {
				top: offset.top - 8,
				left: offset.left + t.outerWidth()
			};
		} else if (pos == 'top') {
			var left = offset.left + parseInt(t.outerWidth() / 2) -
				parseInt(tooltip.outerWidth() / 2);
			var width = tooltip.outerWidth();

			// Limit the left position based on the window width
			return {
				top: offset.top - tooltip.outerHeight() - 12,
				left: Math.max(
					15,
					Math.min(
						left,
						windowWidth - width - 15
					)
				)
			};
		} else {
			var left = offset.left - 15;
			var width = tooltip.outerWidth();

			// Limit the left position based on the window width
			return {
				top: offset.top + t.height() + 8,
				left: Math.min(
					left,
					windowWidth - width - 10
				)
			};
		}
	}

	var _hide = function(tooltip)
	{
		hideDelayTimer = null;
		currentTooltip = null;
		currentTrigger = null;
		tooltip.hide();
		shown = false;
	}
})(jQuery);
;

