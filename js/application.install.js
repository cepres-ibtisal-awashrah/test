/*******************************************************************/
/* Installer  */

/* [Permissions checked!] */

App.Install = new function()
{
	var self = this;

	self.runFileCheck = function()
	{
		var row = $('#filecheck');
		row.find('.busy').show();

		App.Ajax.call(
		{
			target: '/installer/ajax_check_files',

			success: function(data)
			{
				row.find('.busy').hide();
				row.find('.success').show();
				$('#next-disabled').hide();
				$('#next').show();
			},

			error: function(data)
			{
				row.find('.busy').hide();
				row.find('.error').show();
				var error = $('#filecheck-error');
				error.find('.message').text(data.error);
				error.show();
			}
		});
	}

	self.runConfigCheck = function()
	{
		$('#login').addClass('button-busy');

		App.Ajax.call(
		{
			target: '/installer/ajax_check_config',

			stop: function() {
				$('#login').removeClass('button-busy');
			},

			success: function()
			{
				App.Page.load('/auth/login');
			},

			error: function(data)
			{
				if (data && data.error)
				{
					App.Dialogs.message(
						data.error,
						'Config.php not found'
					);
				}
				else
				{
					App.Ajax.handleError();
				}
			}
		});
	}

	App.ready(function() {
		$('#rabbitmq_use_ssl').on('change', function(evt) {
			var $settings = $('#rabbitmq_ssl_settings');
			$(evt.target).is(':checked')
				? $settings.show()
				: $settings.hide();
		});
	});
}


;

