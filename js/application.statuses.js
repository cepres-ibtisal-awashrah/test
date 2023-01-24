/**********************************************************************************************/
/* Statuses  */

/* [Permissions checked!] */

App.Statuses = new function()
{
	var self = this;

	//---------------------------------------------------------------
	// MOVE (on overview)
	//---------------------------------------------------------------

	self.moveUp = function(id)
	{
		var status = $('#status-' + id);
		$('.moveUp', status).hide();
		$('.moveUpBusy', status).show();

		App.Ajax.call(
		{
			target: '/admin/statuses/ajax_move_up',
			
			arguments: 
			{
				status_id: id
			},
			
			success: function(data)
			{
				$('.moveUp', status).show();
				$('.moveUpBusy', status).hide();
				
				var prev = status.prev();
				status.insertBefore(prev);			
				self._syncMoveButtons(status, prev);
			},
			
			error: function(data)
			{
				$('.moveUp', status).show();
				$('.moveUpBusy', status).hide();
				App.Ajax.handleError(data);
			}
		});
	}

	self.moveDown = function(id)
	{
		var status = $('#status-' + id);
		$('.moveDown', status).hide();
		$('.moveDownBusy', status).show();

		App.Ajax.call(
		{
			target: '/admin/statuses/ajax_move_down',
			
			arguments: 
			{
				status_id: id
			},
			
			success: function(data)
			{
				$('.moveDown', status).show();
				$('.moveDownBusy', status).hide();
				
				var next = status.next();	
				status.insertAfter(next);
				self._syncMoveButtons(status, next);
			},
			
			error: function(data)
			{
				$('.moveDown', status).show();
				$('.moveDownBusy', status).hide();
				App.Ajax.handleError(data);
			}
		});
	}

	self._syncMoveButtons = function(s, t)
	{
		var sUp = $('.moveUp', s).is(':visible');
		var sDown = $('.moveDown', s).is(':visible');
		var tUp = $('.moveUp', t).is(':visible');
		var tDown = $('.moveDown', t).is(':visible');
		App.Effects.setVisible($('.moveUp', s), tUp);
		App.Effects.setVisible($('.moveDown', s), tDown);
		App.Effects.setVisible($('.moveUp', t), sUp);
		App.Effects.setVisible($('.moveDown', t), sDown);
	}

	//---------------------------------------------------------------
	// FORM
	//---------------------------------------------------------------

	self.updateTestBox = function(color, box, set_label)
	{
		var hex = $('#' + color).val();

		if (hex.match(/^([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i))
		{
			$(box).css('background', '#' + hex);
			$(box).show();

			if ($(box).attr('toggle-parent'))
			{
				$(box).parent().show();
			}
		}
		else
		{
			$(box).hide();
			$(box).css('background', '#000000');

			if ($(box).attr('toggle-parent'))
			{
				$(box).parent().hide();
			}
		}

		if (set_label)
		{
			$(box).text($('#label').val());
		}
	}

	self.updateTestBoxes = function()
	{
		self.updateTestBox('color_dark', '#statusBoxDark', true);
		self.updateTestBox('color_bright', '#statusBoxBright', true);
	}

	self.onColorKeypressed = function(e, event)
	{
		var key = event.which ? event.which : event.keyCode;

		if (event.ctrlKey || event.altKey)
		{
			return true;
		}

		if (key == 8 || key == 9 || (key > 34 && key < 40) || 
			key == 46) 
		{
			return true;
		}

		// 0-9
		if (key > 47 && key < 58)
		{
			if (!event.shiftKey)
			{
				return true;
			}
		}

		// a-fA-F
		if ((key >= 97 && key <= 102) || (key >= 65 && key <= 70))
		{
			return true;
		}

		return false;
	}
}

;

