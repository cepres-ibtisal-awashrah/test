/*******************************************************************/
/* JIRA Integration  */

App.Jira = new function()
{
	var self = this;

	self.dispatch = function(message)
	{
		// Not all browsers we support also support auto-encoding/
		// decoding of objects (e.g. IE9), so we need to handle this
		// ourselves. Newer browser directly support sending/receiving
		// objects.

		if (parent && parent.postMessage)
		{
			parent.postMessage(JSON.stringify(message), '*');
		}
	}
}

App.Jira.Frame = new function()
{
	var self = this;

	self.height = null;

	self.init = function(frame)
	{
		self._resize(frame);
		self._resizeWatch(frame);
	}

	self.resize = function(frame)
	{
		self._resize(frame);
	}

	self._resize = function(frame)
	{
		App.Jira.dispatch(
			{
				frame: frame,
				action: 'frame:resize',
				height: $('body').outerHeight()
			}
		);
	}

	self._resizeWatch = function(frame)
	{
		// We watch for changes in the body height of the frame due to
		// window resizing. In case of height changes, we trigger a new
		// resize event for the frame. This only applies to window
		// changes and document changes

		self.height = $('body').outerHeight();

		$(window).resize(
			function()
			{
				var height = $('body').outerHeight();
				if (height != self.height)
				{
					self.height = height;
					self._resize(frame);
				}
			}
		);
	}

	self.resized = function()
	{
		$(window).trigger('resize');
	}
}

App.Jira.Dialogs = new function()
{
	var self = this;

	self.open = function(dialog, width, height)
	{
		App.Jira.dispatch(
			{
				action: 'dialog:open',
				dialog: dialog,
				width: width,
				height: height
			}
		);
	}

	self.close = function()
	{
		App.Jira.dispatch(
			{
				action: 'dialog:close'
			}
		);
	}
}

App.Jira.Issues = new function()
{
	var self = this;

	self.display = null; // The different display modes for results

	self.showResult = function(change_id)
	{
		var change = $('#change-' + change_id);
		var details = change.next();

		if ($('.js-result-details', details).length > 0)
		{
			self._showResult(change_id);
		}
		else 
		{
			self._loadResult(change_id);
		}
	}

	self._getResultError = function(data)
	{
		if (data && data.error)
		{
			return data.error;
		}
		else 
		{
			return Consts.ajaxErrorMessage;
		}
	}

	self._loadResult = function(change_id)
	{
		var change = $('#change-' + change_id);
		$('.js-expand', change).hide();
		$('.js-expandBusy', change).show();

		App.Ajax.call(
		{
			target: 'ext/jira/ajax_render_panel_result_details',
			
			arguments:
			{
				test_change_id: change_id
			},

			stop: function()
			{
				$('.js-expandBusy', change).hide();
				$('.js-expand', change).show();
			},
			
			success: function(html)
			{
				change.next().find('.js-result-id').after(html);
				self._showResult(change_id);
			},
			
			error: function(data)
			{
				var error = self._getResultError(data);
				change.find('.js-error').text(error).show();
				App.Jira.Frame.resized();
			}
		});
	}

	self._showResult = function(change_id)
	{
		var change = $('#change-' + change_id);
		change.next().show();
		$('.js-error', change).hide();
		$('.js-expand', change).hide();
		$('.js-collapse', change).show();
		App.Jira.Frame.resized();

		// We also need to resize again after potential images have been
		// loaded (this may change the height again). Inline-images may
		// be included as part of the markdown-enabled comment or steps
		// fields, for example.

		change.next().find('img').load(
			function()
			{
				App.Jira.Frame.resized();				
			}
		);
	}

	self.hideResult = function(change_id)
	{
		var change = $('#change-' + change_id);
		change.next().hide();
		$('.js-expand', change).show();
		$('.js-expandBusy', change).hide();
		$('.js-collapse', change).hide();
		App.Jira.Frame.resized();
	}

	self.loadResults = function(issue, offset)
	{
		$('#paginationBusy').show();
		self._loadResults(issue, offset);
	}
	
	self._loadResults = function(issue, offset)
	{
		App.Ajax.call(
		{
			target: 'ext/jira/ajax_render_panel_results',
			
			arguments:
			{
				issue: issue,
				offset: offset,
				display: self.display
			},
			
			stop: function()
			{
				$('#paginationBusy').hide();
				$('#resultModeBusy').hide();
			},

			success: function(html)
			{
				$('#content').html(html);
				App.Jira.Frame.resized();
			},
			
			error: function(data)
			{
				var error = self._getResultError(data);
				$('#content').addClass('text-error').text(error);
				App.Jira.Frame.resized();
			}
		});
	}

	self.initResults = function(display)
	{
		self.display = display;
	}

	self.setResultMode = function(issue, display)
	{
		self.display = display;
		$('#resultModeBusy').show();
		self._loadResults(issue, 0);
	}
};

App.Jira.RunsIssues = new function() {
	var b = this;
	b.display = null;
	b.showResult = function(f) {
		var e = $("#change-" + f);
		var a = e.next();
		if ($("#statusChart-" + f, a).length > 0) {
			b._showResult(f)
		} else {
			b._loadResult(f)
		}
	};
	b._getResultError = function(a) {
		if (a && a.error) {
			return a.error
		} else {
			return Consts.ajaxErrorMessage
		}
	};
	b._loadResult = function(a) {
		var e = $("#change-" + a);
		$(".js-expand", e).hide();
		$(".js-expandBusy", e).show();
		var d = e.width();
		App.Ajax.call({
			target: "ext/jira/ajax_render_panel_result_runs_details",
			blockUI: false,
			arguments: {
				test_change_id: a,
			},
			stop: function() {
				$(".js-expandBusy", e).hide();
				$(".js-expand", e).show()
			},
			success: function(c) {
				e.next().find(".js-result-id").after(c);
				b._showResult(a)
			},
			error: function(c) {
				var f = b._getResultError(c);
				e.find(".js-error").text(f).show();
				App.Jira.Frame.resized()
			}
		})
	};
	b._showResult = function(a) {
		var d = $("#change-" + a);
		d.next().show();
		$(".js-expand", d).hide();
		$(".js-collapse", d).show();
		App.Jira.Frame.resized();
		d.next().find("section").load(function() {
			App.Jira.Frame.resized();
		})
	};
	b.hideResult = function(a) {
		var d = $("#change-" + a);
		d.next().hide();
		$(".js-expand", d).show();
		$(".js-expandBusy", d).hide();
		$(".js-collapse", d).hide();
		App.Jira.Frame.resized()
	};
	b.loadResult = function(a, d) {
		$("#paginationBusy").show();
		b._loadResults(a, d)
	};
	b._loadResults = function(a, d) {
		App.Ajax.call({
			target: "ext/jira/ajax_render_panel_results",
			arguments: {
				issue: a,
				offset: d,
				display: b.display
			},
			stop: function() {
				$("#paginationBusy").hide();
				$("#resultModeBusy").hide()
			},
			success: function(c) {
				$("#content").html(c);
				App.Jira.Frame.resized()
			},
			error: function(c) {
				var f = b._getResultError(c);
				$("#content").addClass("text-error").text(f);
				App.Jira.Frame.resized()
			}
		})
	};
	b.initResults = function(a) {
		b.display = a
	};
	b.setResultMode = function(a, d) {
		b.display = d;
		$("#resultModeBusy").show();
		b._loadResults(a, 0)
	}
};

App.Jira.RunsDetails = new function() {
	var b = this;
	b.display = null;
	b.showResult = function(f) {
		var e = $("#changes-" + f);
		var a = e.next();
		if ($("#detail-" + f, a).length > 0) {
			b._showResult(f)
		} else {
			b._loadResult(f)
		}
	};
	b._getResultError = function(a) {
		if (a && a.error) {
			return a.error
		} else {
			return Consts.ajaxErrorMessage
		}
	};
	b._loadResult = function(a) {
		var d = $("#changes-" + a);
		$(".js-expand", d).hide();
		$(".js-expandBusy", d).show();
		App.Ajax.call({
			target: "ext/jira/ajax_render_panel_result_cases_details",
			blockUI: false,
			arguments: {
				test_change_id: a
			},
			stop: function() {
				$(".js-expandBusy", d).hide();
				$(".js-expand", d).show()
			},
			success: function(c) {
				d.next().find(".js-result-id").after(c);
				b._showResult(a)
			},
			error: function(c) {
				var f = b._getResultError(c);
				d.find(".js-error").text(f).show();
				App.Jira.Frame.resized()
			}
		})
	};
	b._showResult = function(a) {
		var d = $("#changes-" + a);
		d.next().show();
		$(".js-expand", d).hide();
		$(".js-collapse", d).show();
		App.Jira.Frame.resized();
		d.next().find("section").load(function() {
			App.Jira.Frame.resized()
		})
	};
	b.hideResult = function(a) {
		var d = $("#changes-" + a);
		d.next().hide();
		$(".js-expand", d).show();
		$(".js-expandBusy", d).hide();
		$(".js-collapse", d).hide();
		App.Jira.Frame.resized()
	};
	b.loadResults = function(a, d) {
		$("#paginationBusy").show();
		b._loadResults(a, d)
	};
	b._loadResults = function(a, d) {
		var id = a;
		App.Ajax.call({
			target: "ext/jira/ajax_render_panel_result_runs_details",
			arguments: {
				test_change_id: a,
				offset: d,
			},
			stop: function() {
				$("#paginationBusy").hide();
				$("#resultModeBusy").hide()
			},
			success: function(c) {
				$("#chart-"+id).html(c);
				App.Jira.Frame.resized()
			},
			error: function(c) {
				var f = b._getResultError(c);
				$("#content").addClass("text-error").text(f);
				App.Jira.Frame.resized()
			}
		})
	};
	b.initResults = function(a) {
		b.display = a
	};
	b.setResultMode = function(a, d) {
		b.display = d;
		$("#resultModeBusy").show();
		b._loadResults(a, 0)
	}
};

App.Jira.Projects = new function()
{
	var self = this;

	self.saveMapping = function(project_key, project_id)
	{
		App.Ajax.call(
		{
			target: 'ext/jira/ajax_save_project_mapping',
			blockUI: false,
			
			arguments:
			{
				project_key: project_key,
				project_id: project_id
			}
		});
	}
}

;

