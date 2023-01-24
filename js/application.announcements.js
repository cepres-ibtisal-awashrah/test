/*******************************************************************/
/* Announcements  */

/* [Permissions checked!] */

App.Announcements = new function()
{
	var self = this;

	self.showDialog = function()
	{
		self._showDialog(
		{
			submit: function(is_closing)
			{
				self._hideAnnouncement();
				if (!is_closing)
				{
					App.Dialogs.closeTop();
				}
			}
		});
	}

	self._showDialog = function(o)
	{
		var is_hiding = false;

		$('#announcementForm').unbind('submit');
		$('#announcementForm').submit(
			function()
			{
				is_hiding = true;
				o.submit(false);
				return false;
			}
		);

		App.Dialogs.open(
		{
			selector: '#announcementDialog',
			close: function() 
			{
				if (!is_hiding)
				{
					o.submit(true);
				}
			}
		});
	}

	self._hideAnnouncement = function()
	{
		App.Ajax.call(
		{
			target: '/projects/ajax_hide_announcement',
				
			arguments:
			{
			},			
			success: function(data)
			{				
			},			
			error: function(data)
			{				
			}
		});		
	}
}

;

