/**********************************************************************************************/
/* Priorities  */

/* [Permissions checked!] */

App.Priorities = {};

App.Priorities.moveUp = function(id)
{
	var priority = $('#priority-' + id);
	$('.moveUp', priority).hide();
	$('.moveUpBusy', priority).show();

	App.Ajax.call(
	{
		target: '/admin/priorities/ajax_move_up',
		
		arguments: 
		{
			priority_id: id
		},
		
		success: function(data)
		{
			$('.moveUp', priority).show();
			$('.moveUpBusy', priority).hide();
			
			var prev = priority.prev();
			priority.insertBefore(prev);
			
			App.Priorities.syncMoveButtons(priority, prev);			
			if ($('td', priority).hasClass('separator'))
			{
				$('td', priority).removeClass('separator');
				$('td', prev).addClass('separator');
			}
		},
		
		error: function(data)
		{
			$('.moveUp', priority).show();
			$('.moveUpBusy', priority).hide();
			App.Ajax.handleError(data);
		}
	});
}

App.Priorities.moveDown = function(id)
{
	var priority = $('#priority-' + id);
	$('.moveDown', priority).hide();
	$('.moveDownBusy', priority).show();

	App.Ajax.call(
	{
		target: '/admin/priorities/ajax_move_down',
		
		arguments: 
		{
			priority_id: id
		},
		
		success: function(data)
		{
			$('.moveDown', priority).show();
			$('.moveDownBusy', priority).hide();
			
			var next = priority.next();	
			priority.insertAfter(next);
			
			App.Priorities.syncMoveButtons(priority, next);
			if ($('td', next).hasClass('separator'))
			{
				$('td', next).removeClass('separator');
				$('td', priority).addClass('separator');
			}
		},
		
		error: function(data)
		{
			$('.moveDown', priority).show();
			$('.moveDownBusy', priority).hide();
			App.Ajax.handleError(data);
		}
	});
}

App.Priorities.syncMoveButtons = function(s, t)
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

;

