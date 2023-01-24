App.SharedSteps = new function () {
	var self = this;

	self.attachmentsCode = {};
	self.project_id = null;
	self.casesBySuite = null;
	self.restoreItems = [];

	self.applyActions = function()
	{
		$(document).on({
			change: function()
			{
				$('#deleteFullSharedStepsDialog .button-ok').prop('disabled', false);
			} },
			'#deleteFullSharedStepsDialog input:radio'
		);
	}

	self.applyResponsive = function()
	{
		App.Responsive.register(
			'#content',
			750,
			function(isBelow)
			{
				self._applyResponsiveContentStage1(isBelow);
			}
		);
	}

	self._applyResponsiveContentStage1 = function(isBelow)
	{
		// This stage operates on the content area and hides the button
		// texts (e.g. toolbar).

		var buttons = $('#contentToolbar, #content-header').find(
			'.button-responsive'
		);

		if (isBelow) {
			buttons.addClass('button-notext');
		} else {
			buttons.removeClass('button-notext');
		}
	}

	self.remove = function (sharedstep_id, permanently) {
		var row = $('#row-' + sharedstep_id);
		$('.deleteLink', row).hide();
		$('.deleteBusy', row).show();

		App.Ajax.call({
			target: 'shared_steps/ajax_delete',

			arguments: {
				shared_step_id: sharedstep_id,
				permanently: permanently,
			},

			stop: function stop() {
				$('.deleteBusy', row).hide();
				$('.deleteLink', row).show();
			},

			success: function success(data) {
				row.remove();
			},

			error: function error(data) {
				App.Ajax.handleError(data);
			}
		});
	};

	self.openImportSharedStepsDialog = function (invokingStep, invokingStepId) {
		$('#invokingStep').html(invokingStep);
		$('#invokingStepId').val(invokingStepId);
		  App.Dialogs.open({
		  selector: '#importSharedStepsDialog'
		});
	}

	self.closeImportSharedStepsDialogAndAdd = function(fieldName, project_id) {
		App.Admin.Ok();
		const selectInsertWhere = $('#selectInsertWhere').val();
		const selectSharedStepsSet = $('#selectSharedStepsSet').val();
		const invokingStepId = $('#invokingStepId').val();
		const sharedStepsSetName = $('#selectSharedStepsSet option:selected').text();

		App.Ajax.call({
			target: '/cases/ajax_render_steps_set',

			arguments: {
				index: 0,
				project_id: project_id,
				field_name: fieldName,
				shared_steps_set_id: selectSharedStepsSet,
				shared_steps_set_name: sharedStepsSetName,
			},

			success: function success(html) {
				const step = $(html);
				const steps = $('#' + fieldName + '_table');
				const prev = steps.find('tr.step-' + invokingStepId);
				if (selectInsertWhere === 'after') {
					step.insertAfter(prev);
				} else {
					step.insertBefore(prev);
				}

				App.Cases.indexSteps(fieldName);
				App.Cases.changeSteps(fieldName);
			},

			error: function error(data) {
				App.Ajax.handleError(data);
			}
		});
	}

	self.openCreateSharedStepsDialog = function (fieldName, invokingStep, invokingStepId, projectId) {
		$('#invokingStep').html(invokingStep);
		$('#invokingStepId').val(invokingStepId);

		const steps = App.Cases.stepsToString(fieldName, true, true);

		App.Ajax.call(
			{
				target: '/shared_steps/ajax_render_steps',
				blockUI: false,

				arguments:
				{
					project_id: projectId,
					index: invokingStep,
					steps: steps
				},

				success: function(data)
				{
					$('#createSharedStepsDialog #steps-selection').html(data);
					App.Dialogs.open(
						{
							selector: '#createSharedStepsDialog'
						});
				}
			});

		$('#createSharedStepsDialog #shared_steps_set_title').val('');
	};

	self.updateSteps = function (field_name, additional_selector) {
		additional_selector = additional_selector || '';
		var input = $((additional_selector != '' ? additional_selector + ' ' : '') + '#' + field_name);
		input.val(self.stepsToString(field_name, additional_selector));
	};

	self.stepsToString = function (field_name, additional_selector) {
		additional_selector = additional_selector || '';
		var temp = Array();
		$('tr', $((additional_selector != '' ? additional_selector + ' ': '') + '#' + field_name + '_table')).each(function (ix, e) {
			var tr = $(e);

			if ($('input.checker', tr).prop('checked')) {
				var o = {
					content: $('input.content', tr).val()
				};

				var expected = $('input.expected', tr);
				if (expected.length > 0) {
					o.expected = expected.val();
				}

				var additional_info = $('input.additional_info', tr);
				if (additional_info.length > 0) {
					o.additional_info = additional_info.val();
				}

				o.attachments = $('input.attachments', tr).val();

				var refs = $('input.refs', tr);
				if (refs.length > 0) {
					o.refs = refs.val();
				}

				temp.push(o);
			}
		});

		if (temp.length > 0) {
			return JSON.stringify(temp);
		} else {
			return '';
		}
	};

	self.createSharedSteps = function(projectId, fieldName, title, custom_steps_separated, callback) {
		var steps = JSON.parse(custom_steps_separated);
		var attachments = [];
		steps.forEach(function (el) {
			attachments = attachments.concat(JSON.parse(el.attachments));
		})
		App.Ajax.call(
			{
				target: '/shared_steps/ajax_add/' + projectId,
				blockUI: false,

				arguments:
				{
					title: title,
					[fieldName]: custom_steps_separated, // key dynamically set from fieldName value in runtime. Default key is 'custom_steps_separated', but can vary from custom customers' settings
					attachments: JSON.stringify(attachments),
					custom_steps_separated: custom_steps_separated
				},

				success: function(data)
				{
					callback(data);
				}
			});
	};


	self.openDeleteSharedStepsDialog = function (sharedStepId, caseIdsCount) {
		$('#caseIdsCount').html(caseIdsCount);

		if (caseIdsCount === 0) {
			$('#simplified_shared_steps_set_id').val(sharedStepId);
			App.Dialogs.open({
				selector: '#deleteSimplifiedSharedStepsDialog'
			});
		} else {
			$('#full_shared_steps_set_id').val(sharedStepId);
			App.Dialogs.open({
				selector: '#deleteFullSharedStepsDialog'
			});
		}
	};

	self.deleteFullSharedStepsSet = function () {
		const sharedStepAction = $('#deleteFullSharedStepsDialog input[name="shared_steps_delete_action"]').filter(':checked').val();
		const sharedStepSetId = $('#full_shared_steps_set_id').val();
		App.Ajax.call(
			{
				target: '/shared_steps/ajax_delete/' + sharedStepSetId,
				blockUI: true,

				arguments:
				{
					action: sharedStepAction
				},

				success: function(data)
				{
					App.Page.load('shared_steps/overview/' + self.project_id);
				},

				error: function(data)
				{
					App.Ajax.handleError(data);
				}
			});
	};

	self.deleteSimplifiedSharedStepsSet = function () {
		const sharedStepSetId = $('#simplified_shared_steps_set_id').val();
		App.Ajax.call(
			{
				target: '/shared_steps/ajax_delete/' + sharedStepSetId,
				blockUI: true,

				success: function(data)
				{
					App.Page.load('shared_steps/overview/' + self.project_id);
				},

				error: function(data)
				{
					App.Ajax.handleError(data);
				}
			});
	};

	self.filterSharedSteps = function(e)
	{
		self._createFilter(e).open();
	}

	self.filterSharedStepsReset = function()
	{
		self._createFilter().reset();
	}

	self._createFilter = function(e)
	{
		return new App.SharedSteps.Filter(
		{
			event: e,
			project_id: self.project_id,
			filters: self.filters,
			save_filters: true,

			changed: function(filters)
			{
				self.filters = filters;
				self._reloadSharedSteps();
			}
		});
	}

	self._reloadSharedSteps = function()
	{
		$('#groupContent').remove();
		$('#groupTreeContent').remove();
		self.showInitial();
	}

	self.showInitial = function(offset)
	{
		offset = offset || 0;
		// Calculate the height of the visible area for the test cases.
		var height = $(window).height() - $('#contentToolbar').offset().top;

		// Calculate and set a suitable top padding for the loading
		// spinner
		var top = Math.max(Math.round(height / 2 - 125), 50);
		$('#contentLoading').css('padding-top', top).show();

		self._showSharedSteps({
			offset: offset,
			success: function(data)
			{
				$('#contentLoading').hide();
			}
		});
	}

	self._showSharedSteps = function(o)
	{
		var defaults = {
			project_id: self.project_id
		};

		var s = $.extend(defaults, o);

		App.Ajax.call(
		{
			target: '/shared_steps/ajax_render_shared_steps',
			arguments: self._getGridArguments(s),

			success: function(data)
			{
				$('#groupContainer').html(data.sharedSteps);

				var $pagination = $('#groupPagination');
				if (data.pagination && data.pagination.length > 0) {
					$pagination.html(data.pagination).show();
				} else {
					$pagination.hide();
				}

				self._onSharedStepsLoaded(s);
			},

			error: function(data)
			{
				if (o.error) {
					o.error();
				}

				App.Ajax.handleError(data);
			}
		});
	}

	self._getGridArguments = function(o)
	{
		// Besides the given arguments, we also include the
		// property filters.
		return $.extend(
			{
				filters: self.filters
			},
			o
		);
	}

	self._onSharedStepsLoaded = function(o)
	{
		// Should not be required but actually is by IE9, for example
		// (in some rare cases). May be needed to reposition the sticky
		// elements.
		$(window).trigger('scroll');

		// Fire the relevant events for external modules (e.g. sidebar,
		// or reference lookup)
		$.publish({
			'body.changed': null
		});

		self._setStateUrl();
	}

	self._setStateUrl = function()
	{
		App.Page.replaceState(
			'/shared_steps/overview/' + self.project_id,
			self.getStateOptions()
		);
	}

	self.getStateOptions = function()
	{
		// Get the current query string and only override the grouping
		// related options (the remaining options are preserved).
		return App.Page.formatQueryOptions(
			App.Page.getQueryOptions()
		);
	}

	self.filterBySuite = function(event)
	{
		if (!App.SharedSteps.casesBySuite) {
			return;
		}

		var value = parseInt($(event.target).val());
		var cases = App.SharedSteps.casesBySuite[value] || [];
		$('#checkboxList').text(cases.join(', '));
	}

	self.applyCompareToChosen = function ()
	{
		$('.case-compare-select').each(function(ix, v) {
			var dropdown = $(v);
			// Apply the chosen control
			dropdown.chosen();
		});
		$('.case-compare-wrapper input').on('focus', function () {
			$('.case-compare-wrapper .chzn-drop').css({width: '350px', left: '-230px'});
		});
		$('.case-compare-wrapper .chzn-search input').attr('placeholder', lang('cases_history_compare_placeholder'));

		$('.case-compare-select').on('change', function(e) {
			var isRightVersion = !!parseInt($(this).attr('data-is-right'));

			App.Page.load(
				'/shared_steps/compare/{0}/{1}/{2}',
				$(this).attr('data-shared-step-id'),
				isRightVersion ? $(this).find(':selected').val() : $(this).attr('data-change-id'),
				isRightVersion ? $(this).attr('data-change-id') : $(this).find(':selected').val()
			);
		});
	}

	self.loadHistory = function (sharedStepId, offset) {
		$('#changesPaginationBusy').show();

		App.Ajax.call({
			target: '/shared_steps/ajax_get_history/' + sharedStepId,

			arguments: {
				offset: offset
			},

			success: function success(data) {
				$('#changesPaginationBusy').hide();
				$('#history').html(data.changes);
				$('#historyPagination').html(data.pagination);
			},

			error: function error(data) {
				$('#changesPaginationBusy').hide();
				App.Ajax.handleError(data);
			}
		});
	};

	self.restoreVersion = function (sharedStepId, versionId, versionNum)
	{
		var message = lang('restore_shared_steps_dialog').replace(/\{0\}/g, versionNum);
		App.Dialogs.confirm(
			message,
			function() {
				App.Ajax.call({
					target: '/shared_steps/ajax_restore_version',

					arguments: {
						id: sharedStepId,
						change_id: versionId,
					},

					success: function success() {
						App.Page.load(
							'/shared_steps/history/{0}',
							sharedStepId
						);
					},

					error: function error(data) {
						App.Ajax.handleError(data);
					}
				});
			}
		);
		var dialog = App.Dialogs.getActive();
		dialog.prev()
			.css('background', '#E40046')
			.css('color', '#FFFFFF');
	};
}

App.SharedSteps.Filter = function(o)
{
	var self = this;

	self.project_id = o.project_id;
	self.filters = o.filters;
	self.save_filters = o.save_filters;
	self.changed = o.changed;
	self.event = o.event;

	self.open = function(e)
	{
		var bubble = $('#filterByChange').bubble({
			bubble: '#filterSharedStepsBubble',
			toggleEvent: 'null'
		});

		self._load({
			show: function()
			{
				self._bind({
					bubble: bubble
				});

				bubble.show(self.event);
			}
		});
	}

	self._load = function(o)
	{
		var busy = $('#filterBy .busy');

		App.Ajax.call(
		{
			target: '/shared_steps/ajax_render_filter',

			arguments: {
				project_id: self.project_id,
				filters: self.filters
			},

			start: function()
			{
				$('#filterByChange').hide();
				busy.show();
			},

			stop: function()
			{
				busy.hide();
				$('#filterByChange').show();
			},

			success: function(html)
			{
				$('#filterSharedStepsContent').html(html);
				o.show();
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self._bind = function(o)
	{
		$('#filterSharedStepsApply').click(
			function()
			{
				self._apply(o);
				return false; // Important for confirm-leave behavior
				              // with IE, e.g. on bulk-edit for cases
			}
		);

		$('#filterSharedStepsCancel').click(
			function()
			{
				self._cancel(o);
				return false; // Important for confirm-leave behavior
				              // with IE, e.g. on bulk-edit for cases
			}
		);
	}

	self._apply = function(o)
	{
		var filters = App.Filters.getAll($('#filterSharedStepsContent'));

		App.Ajax.call(
		{
			target: '/shared_steps/ajax_render_filter_info',

			arguments: {
				project_id: self.project_id,
				filters: filters,
				save_filters: self.save_filters
			},

			start: function()
			{
				$('#filterSharedStepsApply').addClass('button-busy');
			},

			stop: function()
			{
				$('#filterSharedStepsApply').removeClass('button-busy');
			},

			success: function(html)
			{
				self._sync(filters, html);
				self._changed();
				o.bubble.hide();
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self._sync = function(filters, info)
	{
		$('#filterByInfo').hide();
		$('#filterByEmpty').hide();
		$('#filterByChange').removeClass('link link-dashed nolink');

		info = $.trim(info);
		if (info) {
			$('#filterByChange').addClass('nolink');
			$('#filterByInfo').html(info);
			$('#filterByInfo').show();
			$('#filterByReset').show();
			self.filters = filters; // Save for later
		} else {
			$('#filterByReset').hide();
			$('#filterByChange').addClass('link link-dashed');
			$('#filterByEmpty').show();
			self.filters = null; // Reset filter
		}
	}

	self._changed = function()
	{
		self.changed(self.filters);
	}

	self._cancel = function(o)
	{
		o.bubble.hide();
	}

	self.reset = function()
	{
		App.Ajax.call(
		{
			target: '/shared_steps/ajax_render_filter_info',

			arguments: {
				project_id: self.project_id,
				filters: null,
				save_filters: self.save_filters
			},

			start: function()
			{
				$('#filterByChange').hide();
				$('#filterBy .busy').show();
			},

			stop: function()
			{
				$('#filterBy .busy').hide();
				$('#filterByChange').show();
			},

			success: function(html)
			{
				self._sync(null, '');
				self._changed();
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}
}

;

