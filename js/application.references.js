/*******************************************************************/
/* References */

/* [Permissions checked!] */

App.References = {};

App.ready(function()
{
	// Whenever tests or cases are modified or (re-)loaded, we need
	// to re-apply the reference lookup.
	$.subscribe(
		'tests.loaded, tests.changed, cases.loaded',
		'references',
		function(o)
		{
			if (o.project_id)
			{
				App.References.applyLookup(o.project_id);
			}
		}
	);
});

App.References.applyLookup = function(project_id, ctx)
{
	var request = null;

	$('a.referenceLink, span.referenceLink', ctx || $(document)).bubble(
	{
		bubble: '#referenceBubble',

		onShow: function(e)
		{
			var id = $(e).attr('rel');
			request = App.References.lookup(project_id, id);
		},

		onHide: function(e)
		{
			var content = $('.content', $('#referenceBubble'));
			content.html('');

			if (request)
			{
				App.Ajax.abort(request);
			}
		}
	});
}

App.References.lookup = function(project_id, reference_id)
{
	var bubble = $('#referenceBubble');
	var busy = $('.busy', bubble);
	var content = $('.content', bubble);
	var errors = $('.error', bubble);

	errors.hide();
	content.hide();
	content.html('');
	busy.show();

	return App.Ajax.call(
	{
		target: '/references/ajax_lookup',
		blockUI: false,

		arguments: {
			project_id: project_id,
			reference_id: reference_id
		},

		success: function(html)
		{
			content.html(html);
			content.show();
			$('.container', content).css(
				'height',
				bubble.height() -
				$('.header', content).outerHeight() -
				$('.attributes', content).outerHeight() -
				$('.footer', content).outerHeight()
			);

			busy.hide();
		},

		error: function(data)
		{
			busy.hide();

			if (data && data.error)
			{
				$('#referenceBubbleError').text(data.error);
				errors.show();
			}
			else
			{
				bubble.hide();
			}
		}
	});
}

;

