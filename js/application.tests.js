/*******************************************************************/
/* Tests  */

App.Tests = {
	attachmentsCode: {}
};

// Sets the dialog title color for the given selector based on the
// passed test status ID.
App.Tests.setDialogColor = function(dialog, status_id)
{
	var background = null;
	if (statuses !== undefined) // Included directly in the page
	{
		background = statuses[status_id]['color_gradient_a'];
	}

	var bar = $(dialog).prev();
	if (background)
	{
		bar.css('background', '#' + background);
		bar.css('color', '#ffffff');
	}
	else
	{
		bar.css('background', '');
		bar.css('color', '');
	}
}

App.Tests.setDialogColorDefault = function(dialog)
{
	var status_id = Consts.statusPassed;

	if (status_default_id !== undefined) // Included directly in the page
	{
		status_id = status_default_id;
	}

	App.Tests.setDialogColor(dialog, status_id);
}

App.Tests.applyResponsive = function()
{
	App.Responsive.register(
		'#content',
		950,
		function(is_below)
		{
			var buttons = $('#content-header .button-responsive');
			if (is_below)
			{
				buttons.addClass('button-notext');
			}
			else
			{
				buttons.removeClass('button-notext');
			}
		}
	);
}

App.Tests.showInProgress = function()
{
	var showDropdown = function()
	{
		var link = $('#inProgressLink');
		if (link.length > 0)
		{
			var a = link[0];
			a.href = '#inProgressDropdown';
			App.Dropdowns.open(a);
		}
	}

	// Remove the previous progress dropdown, if any
	var dropdown = $('#inProgressDropdown');
	if (dropdown.is(':visible'))
	{
		return; // Is hidden via the click
	}
	if (dropdown.length != 0)
	{
		dropdown.remove();
	}

	App.Ajax.call(
	{
		target: '/tests/ajax_render_in_progress_dropdown',

		success: function(html)
		{
			$('body').append(html);
			showDropdown();
		},

		error: function(data)
		{
			App.Ajax.handleError(data);
		}
	});
}

App.Tests.showInProgressAll = function()
{
	var showDialog = function()
	{
		App.Dialogs.open(
		{
			selector: '#inProgressDialog'
		});
	}

	// Remove the previous progress dropdown, if any
	var dialog = $('#inProgressDialog');
	if (dialog.length != 0)
	{
		dialog.remove();
	}

	App.Ajax.call(
	{
		target: '/tests/ajax_render_in_progress_dialog',

		success: function(html)
		{
			$('body').append(html);
			showDialog();
		},

		error: function(data)
		{
			App.Ajax.handleError(data);
		}
	});
}

//---------------------------------------------------------------------
// RESULTS
//---------------------------------------------------------------------

App.Tests.loadResultDialog = function(o)
{
	$('#addResultSubmit').hide();
	$('#addResultSubmitDisabled').show();
	var dialog = $('#addResultDialog');
	var busy = dialog.find('.resultBusy');
	var container = dialog.find('.resultContainer');
	var height = dialog.find('.dialog-body').outerHeight();

	// Adjust the height of the progress div and show it
	busy.css('padding-top', Math.round((height / 2) - 25) + 'px');
	busy.show();

	container.hide();

	App.Ajax.call(
	{
		target: '/tests/ajax_render_result_dialog',
		arguments: o,

		success: function(html)
		{
			busy.hide();
			container.html(html);
			container.show();

			if ($('#addResultDialog').dialog('isOpen') == true) {
				$('.searchable').each(function(ix, v) {
					var dropdown = $(v);
					// Apply the chosen control
					dropdown.chosen();
				});
			}

			$('#addResultSubmit').show();
			$('#addResultSubmitDisabled').hide();
			o.success();
			$.publish('result_dialog.loaded');
		},

		error: function(data)
		{
			busy.hide();
			App.Ajax.handleError(data);
		}
	});
}

App.Tests.resultDialog = function(o)
{
	$('#addResultSubmit').removeClass('button-busy');

	// Show the dialog and call the show event afterwards to let the
	// caller focus the appropriate controls.
	App.Dialogs.open(
	{
		init: o.init,
		selector: '#addResultDialog',
		titleSelector: o.titleSelector ? o.titleSelector : '.addResult',
		minWidth: 650,
		minHeight: 425,
		resizable: true,
		resizeStop: App.Tests.resultDialogResized,
		autoFocus: false,
		enter: function() {
			if (!$('input[tabindex=0]').is(":focus") || $(":input.form-control").is(":focus")) {
				$('#addResultSubmit').click();
			}
		}
	});

	o.show();
}

App.Tests.resultDialogValues = function()
{
	// Read the standard input fields from the form.
	var values = {
		status_id: $('#addResultStatus').val(),
		assignedto: $('#addResultAssignTo').val(),
		comment: $('#addResultComment').val(),
		version: $('#addResultVersion').val(),
		elapsed: $('#addResultElapsed').val(),
		defects: $('#addResultDefects').val(),
		attachments: $('#result_content input#attachments').val()
	};

	// And handle and append the custom fields. All custom field
	// controls have a 'custom' class in order to to identify
	// them as custom fields.
	$('#addResultDialog .custom').each(function(ix, e)
	{
		var t = $(this);
		if (t.attr('type') == 'checkbox')
		{
			values[t.attr('name')] = t.prop('checked');
		}
		else
		{
			var k = t.attr('name');
			values[k] = t.val();
			if (t.is('select'))
			{
				values[k + '_string'] = $('option:selected', t).text();
			}
		}
	});

	return values;
}

App.Tests.resultDialogBind = function(o)
{
	App.applyTextAreaResizer();

	// Register for the change status event to switch the dialog bar
	// colors.
	$('#addResultStatus').unbind('change');
	$('#addResultStatus').change(function()
	{
		var status_id = Number($(this).val());
		App.Tests.setDialogColor('#addResultDialog', status_id);
	});

	$('#addResultSubmit').unbind('click');
	$('#addResultSubmit').bind('click', function(e)
	{
		App.Validation.hideErrors();
		$('#addResultErrors').empty();

		// Read the standard input fields from the form.
		var values = App.Tests.resultDialogValues();

		// Issue a validation event and check the event status after
		// that. This can be used to do custom-validate the form and
		// deny the submit.
		$.publish('result_dialog.validate', {
			event: e,
			values: values
		});

		if (e.isPropagationStopped())
		{
			return false;
		}

		$('#addResultSubmit').addClass('button-busy');

		// Call the submit action and pass our arguments.
		o.submit(values);
		return false;
	});

	$('#addResultClose').unbind('click');
	$('#addResultClose').bind('click', function(e)
	{
		App.Dialogs.close('#addResultDialog');
	});
}

App.Tests.resultDialogResized = function(event, ui)
{
	// Update the size preferences for the user on the server.
	App.Ajax.call(
	{
		target: '/tests/ajax_save_result_dialog_size',
		blockUI: false,

		arguments: {
			width: Math.round(ui.size.width),
			height: Math.round(ui.size.height)
		}
	});
}

App.Tests.setResultType = function(type)
{
	// On subsequent invokes, the buttons are not part of the actual
	// dialog anymore, so we need to handle both cases here.
	if (type == 'addResult')
	{
		$('#addResultDialog .addResult').show();
		$('#addResultDialog .editResult').hide();
		$('#addResultButtons .addResult').show();
		$('#addResultButtons .editResult').hide();
	}
	else
	{
		$('#addResultDialog .editResult').show();
		$('#addResultDialog .addResult').hide();
		$('#addResultButtons .editResult').show();
		$('#addResultButtons .addResult').hide();
	}
}

// Lets the user add a result on the view test page with the generic
// result dialog and updates the corresponding html sections (headline,
// changes and sidebar) on success.
App.Tests.addResult = function(project_id, test_id, elapsed)
{
	App.Tests.hideResultNext();
	App.Tests.setResultNext(false);
	App.Tests.setResultType('addResult');

	App.Tests.resultDialog(
	{
		show: function()
		{
			App.Tests.loadResultDialog(
			{
				type: 'add',
				project_id: project_id,
				test_id: test_id,
				elapsed: elapsed,

				success: function()
				{
					$('#addResultStatus').focus();
					App.Tests.resultDialogBind(
					{
						submit: function(change)
						{
							change.test_id = test_id;
							change.is_result = true;
							App.Tests.addChange(
								change,
								{
									success: App.Tests.resultSuccess,
									error: App.Tests.resultError
								}
							);
						}
					});
				}
			});
		},

		init: function()
		{
			App.Tests.setDialogColorDefault('#addResultDialog');
		}
	});
}

App.Tests.changePage = function(offset, test_id)
{
	App.Tests._loadResults(null, test_id, offset);
}

App.Tests.setResultNext = function(next)
{
	if (next)
	{
		$('#addResultNextNo').hide();
		$('#addResultNextYes').show();
		$('#addResultNext').attr('rel', '1');
	}
	else
	{
		$('#addResultNext').attr('rel', '0');
		$('#addResultNextYes').hide();
		$('#addResultNextNo').show();
	}
}

App.Tests.getResultNext = function()
{
	return $('#addResultNext').attr('rel') == '1';
}

App.Tests.hideResultNext = function()
{
	$('#addResultNext').hide();
}

App.Tests.showResultNext = function()
{
	$('#addResultNext').show();
}

// Lets the user add a test result on the standard test list with
// the generic result dialog and updates the corresponding html
// row on success.
App.Tests.addResultInline = function(project_id, status_id)
{
	var test_id = App.Dropdowns.getTag('#statusDropdown');
	App.Tests.hideResultNext();
	App.Tests.setResultNext(false);
	App.Tests._addResultInline(project_id, test_id, status_id, false);
}

App.Tests._addResultInline = function(
	project_id,
	test_id,
	status_id,
	set_next,
	elapsed,
	isAddedFromQpane
) {
	App.Tests.setResultType('addResult');

	App.Tests.resultDialog(
	{
		show: function()
		{
			App.Tests.loadResultDialog(
			{
				type: 'add',
				project_id: project_id,
				test_id: test_id,
				elapsed: elapsed,
				status_id: status_id,
				isAddedFromQPane: isAddedFromQpane,
				success: function()
				{
					$('#addResultStatus').focus();
					App.Tests.resultDialogBind(
					{
						submit: function(change)
						{
							change.test_id = test_id;
							change.is_result = true;
							change.set_next = set_next;
							change.next = App.Tests.getResultNext();

							App.Tests.addChangeInline(
								change,
								{
									success: function()
									{
										App.Tests.resultSuccess();

										if (App.Tests.getResultNext())
										{
											App.Runs.nextRow(true);
										}
									},
									error: App.Tests.resultError
								}
							);
						}
					});
				}
			});
		},

		init: function()
		{
			App.Tests.setDialogColor('#addResultDialog', status_id);
		}
	});
}

App.Tests.addResultQPane = function(project_id, test_id, elapsed, isAddedFromQpane)
{
	App.Tests.showResultNext();
	App.Tests.setResultNext(App.Runs.goto_next);
	App.Tests._addResultInline(
		project_id,
		test_id,
		Consts.statusPassed,
		true,
		elapsed,
		isAddedFromQpane
	);
}

App.Tests.addResultAndNext = function(project_id, test_id, status_id,
	skip_dialog)
{
	if (skip_dialog)
	{
		App.Tests._addResultAndNext(project_id, test_id, status_id);
	}
	else
	{
		App.Tests.showResultNext();
		App.Tests.setResultNext(true);
		App.Tests._addResultInline(project_id, test_id, status_id, true);
	}
}

App.Tests._addResultAndNext = function(project_id, test_id, status_id)
{
	$('#addResultAndNext').addClass('button-busy');

	App.Tests.addChangeInline(
		{
			test_id: test_id,
			status_id: status_id,
			set_timer: true,
			is_result: true
		},
		{
			success: function()
			{
				$('#addResultAndNext').removeClass('button-busy');
				App.Runs.nextRow(true);
			},

			error: function(data)
			{
				$('#addResultAndNext').removeClass('button-busy');
				App.Ajax.handleError(data);
			}
		}
	);
}

App.Tests.stepsToString = function(field_name)
{
	var temp = Array();

	var table = $('#' + field_name + '_table');
	table.find('tr.step-row').each(function(ix, e)
	{
		var tr = $(e);
		var o = {
			content: $('td.content input.step', tr).val(),
			status_id: $('td.result select', tr).val()
		};

		var expected = $('td.content input.expected', tr);
		if (expected.length > 0) {
			o.expected = expected.val();
		}

		var actual = $('td.content input.actual', tr);
		if (actual.length > 0) {
			var actual_str = $.trim(actual.val());
			if (actual_str) {
				o.actual = actual_str;
			}
		}

		var additionalInfo = $('td.content input.additional', tr);
		if (additionalInfo.length > 0) {
			var additionalInfoStr = $.trim(additionalInfo.val());
			if (additionalInfoStr.length > 0) {
				o.additional_info = additionalInfoStr;
			}
		}

		var reference = $('td.content input.reference', tr);
		if (reference.length > 0) {
			var referenceStr = $.trim(reference.val());
			if (referenceStr.length > 0) {
				o.refs = referenceStr;
			}
		}

		temp.push(o);
	});

	if (temp.length > 0)
	{
		return JSON.stringify(temp);
	}
	else
	{
		return '';
	}
}

App.Tests.showSteps = function(change_id)
{
	$('#steps-' + change_id).show();
	$('#results-' + change_id).hide();
}

App.Tests.showStepsActual = function(step_id)
{
	var $actualContainer = $('#actualContainer-' + step_id);
	$('#actualLink-' + step_id).hide();
	$actualContainer.show();
	$actualContainer.find('textarea').focus();
	$actualContainer.find('.field-editor').focus();
}

// Lets the user edit a passed/failed result on the view test page
// with the generic result dialog.
App.Tests.editResult = function(project_id, test_change_id, status_id)
{
	App.Tests.hideResultNext();
	App.Tests.setResultNext(false);
	App.Tests.setResultType('editResult');

	App.Tests.resultDialog(
	{
		titleSelector: '.editResult',

		show: function()
		{
			App.Tests.loadResultDialog(
			{
				type: 'edit',
				project_id: project_id,
				test_change_id: test_change_id,

				success: function()
				{
					App.Tests.resultDialogBind(
					{
						submit: function(change)
						{
							change.test_change_id = test_change_id;
							change.is_result = true;
							App.Tests.editChange(
								change,
								{
									success: App.Tests.resultSuccess,
									error: App.Tests.resultError
								}
							);
						}
					});

					$('#addResultComment').focus();
				}
			});
		},

		init: function()
		{
			App.Tests.setDialogColor('#addResultDialog', status_id);
		}
	});
}

App.Tests._initEditorAttachments = function(test_change_id, config)
{
	var prevImageDialogUploadSuccess = App.Editor.imageDialogUploadSuccess;
	var prevImageDialogSuccess = App.Editor.imageDialogSuccess;
	var prevRemoveSuccess = App.Attachments.removeSuccess;
	var _config = $.extend(
		{},
		{
			inputSelector: '#result_content input#attachments',
			listSelector: '#entityAttachmentList'
		},
		config || {}
	);
	var separator = ',';
	var $listSelector = $(_config.listSelector);
	var $noEntityAttachments = $listSelector.next('#noEntityAttachments');

	return {
		enable: function () {
			App.Editor.entity_id = '';
			App.Editor.imageDialogUploadSuccess = function(file, data) {
				App.Tests.attachmentsCode[data.id] = data.code;
			}
			App.Editor.imageDialogSuccess = function(control, attachment_ids) {
				var $dialogAttachmentsInput = $(_config.inputSelector);
				$dialogAttachmentsInput.length && $dialogAttachmentsInput.val(
					$dialogAttachmentsInput.val()
						.split(separator)
						.filter(Boolean)
						.concat(attachment_ids)
						.join(separator)
				);
				attachment_ids.forEach(function(attachment_id){
					$listSelector.append(App.Tests.attachmentsCode[attachment_id]);
					delete(App.Tests.attachmentsCode[attachment_id]);
				});
				$noEntityAttachments.toggle(!Boolean($listSelector.html()));
			}
		},
		disable: function() {
			App.Editor.imageDialogUploadSuccess = prevImageDialogUploadSuccess;
			App.Editor.imageDialogSuccess = prevImageDialogSuccess;
			App.Attachments.removeSuccess = prevRemoveSuccess;
			App.Editor.entity_id = null;
		}
	}
}

// Opens the Add Result dialog and then sets the currently selected
// tests to the selected status.
App.Tests.massAddResult = function(project_id)
{
	var test_ids = App.Tests.getSelected();

	if (test_ids == '')
	{
		return;
	}

	App.Tests.hideResultNext();
	App.Tests.setResultNext(false);
	App.Tests.setResultType('addResult');

	App.Tests.resultDialog(
	{
		show: function()
		{
			App.Tests.loadResultDialog(
			{
				type: 'massadd',
				project_id: project_id,
				test_ids: test_ids,

				success: function()
				{
					$('#addResultStatus').focus();
					App.Tests.resultDialogBind(
					{
						submit: function(change)
						{
							change.test_ids = test_ids;
							change.is_result = true;
							App.Tests.massAddChange(
								change,
								{
									success: App.Tests.resultSuccess,
									error: App.Tests.resultError
								}
							);
						}
					});
				}
			});
		},

		init: function()
		{
			App.Tests.setDialogColorDefault('#addResultDialog');
		}
	});
}

// Callback action. Called when a user has successfully added a test
// result. Just hides the add result dialog.
App.Tests.resultSuccess = function(data)
{
	App.Dialogs.close('#addResultDialog');
}

// Callback action. Called when an error occurred while trying to add
// a new test result. Shows an AJAX error.
App.Tests.resultError = function(data)
{
	$('#addResultSubmit').removeClass('button-busy');
	App.Ajax.handleError(data, '#addResultErrors');
}

//---------------------------------------------------------------------
// COMMENTS & ASSIGN TO
//---------------------------------------------------------------------

App.Tests.setCommentType = function(type)
{
	$('#addCommentDialog .addComment').hide();
	$('#addCommentDialog .editComment').hide();
	$('#addCommentDialog .assignTo').hide();
	$('#addCommentDialog .editAssignTo').hide();
	$('#addCommentDialog .' + type).show();
}

App.Tests.commentDialogReset = function(change, options)
{
	App.Validation.hideErrors();

	$('#addCommentErrors').empty();

	$('#addCommentAttachments .dropzone').toggle(!Boolean(options.hide_attachments));

	// Enable/disable assign to combobox.
	if (options.disable_assignedto)
	{
		App.Controls.disableCombobox('#addCommentAssignTo');
	}
	else
	{
		App.Controls.enableCombobox('#addCommentAssignTo');
	}

	// Reset the input fields
	if (!change.assignedto)
	{
		App.Controls.resetCombobox('#addCommentAssignTo');
	}
	else
	{
		$('#addCommentAssignTo').val(change.assignedto);
	}

	$('#addCommentComment_display').html(change.comment ? change.comment : "");
	$('#addCommentComment_display').trigger('keyup');

	if (change.attachments && change.attachments.length) {
		change.attachments = change.attachments.map(function (el) {
			return { id: el.id, data_id: el.data_id };
		});
		App.Ajax.call({
			target: '/attachments/ajax_get_entity_list_items',

			arguments: {
				project_id: change.project_id,
				attachment_ids: JSON.stringify(change.attachments)
			},

			success: function success(data) {
				$.each(data.data, function (_, el) {
					App.Attachments._addRow(el, '#addCommentAttachments');
				});
			},

			error: function error(data) {
				App.Ajax.handleError(data);
			}
		});
	}

	// Initialize the busy actions
	$('#addCommentSubmit').removeClass('button-busy');
}

// Shows the test comment dialog and invokes a custom action on submit.
App.Tests.commentDialog = function(change, options, callbacks)
{
	change = change || {};
	options = options || {};
	App.Tests.commentDialogReset(change, options);

	$('#addCommentForm').unbind('submit');
	$('#addCommentForm').submit(function(e)
	{
		App.Validation.hideErrors();
		$('#addCommentErrors').empty();

		// Read the values from the input fields.
		var values = {
			assignedto: $('#addCommentAssignTo').val(),
			comment: $.trim($('#addCommentComment').val()),
			attachments: $('#addCommentAttachments #attachments').val()
		};

		$('#addCommentSubmit').addClass('button-busy');

		// Call the submit action and pass the dialog's input fields.
		callbacks.submit(values);
		return false;
	});

	App.Tests.Attachments.clear();

	// Show the dialog and call the show event afterwards to let the
	// caller focus the appropriate controls.
	var imageDialogUploadSuccess = App.Editor.imageDialogUploadSuccess;
	var imageDialogSuccess = App.Editor.imageDialogSuccess;
	var attachmentContainerParent = App.Editor.attachmentContainerParent;
	var inputParent = App.Attachments.inputParent;
	var removeSuccess = App.Attachments.removeSuccess;
	App.Dialogs.open(
	{
		selector: '#addCommentDialog',
		titleSelector:
			options.titleSelector ? options.titleSelector : '.addComment',
		focusedControl: '#addCommentComment',
		show: function() {
			if (App.Tests.canAddEditAttachments) {
				var selector = '#addCommentAttachments';
				App.Attachments.initEditorAttachments(
					App.Tests.attachmentsCode,
					{
						inputParent: selector,
						itemsParent: selector
					}
				);
			}
			if (callbacks.show) {
				callbacks.show(change);
			}
		},
		close: function() {
			App.Editor.imageDialogUploadSuccess = imageDialogUploadSuccess;
			App.Editor.imageDialogSuccess = imageDialogSuccess;
			App.Editor.attachmentContainerParent = attachmentContainerParent;
			App.Attachments.inputParent = inputParent;
			App.Attachments.removeSuccess = removeSuccess;
			$('#addCommentAttachments #attachments').val('[]');
			$('#addCommentAttachments .attachment-list-item').remove();
			$('#addCommentDialog .attachment-list-wrappper').attr('deleteIds', '');
			if (callbacks.close) {
				callbacks.close(change);
			}
		}
	});
}

// Callback action. Called when a user has successfully added a test
// result. Just hides the add result dialog.
App.Tests.commentSuccess = function(data)
{
	App.Dialogs.close('#addCommentDialog');
}

// Callback action. Called when an error occurred while trying to add
// a new test comment. Shows an AJAX error.
App.Tests.commentError = function(data)
{
	$('#addCommentSubmit').removeClass('button-busy');
	App.Ajax.handleError(data, '#addCommentErrors');
}

// Adds a new comment to a test.
App.Tests.addComment = function(test_id, project_id)
{
	App.Tests.setCommentType('addComment');

	prepareCommentDialog(
		{
			titleSelector: '.editComment',
			test_id: test_id,
			project_id: project_id
		}
	);
}

App.Tests.implAddComment = function(o)
{
	App.Tests.commentDialog(
		false,
		{ titleSelector: o.titleSelector },
		{
			validate: o.validate,
			show: o.show,
			submit: function(change)
			{
				change.test_id = o.test_id;
				App.Tests.addChange(
					change,
					{
						success: App.Tests.commentSuccess,
						error: App.Tests.commentError
					}
				);
			}
		}
	);
}

// Lets the user edit a general comment on the view test page with the
// standard comment dialog.
App.Tests.editComment = function(test_change_id, project_id)
{
	App.Tests.setCommentType('editComment');
	prepareCommentDialog(
		{
			test_change_id: test_change_id,
			titleSelector: '.editComment',
			method: App.Tests.implEditComment,
			project_id: project_id
		}
	);
}

App.Tests.removeAttachment = function(attachment_id, project_id)
{
	App.Attachments.remove(
		attachment_id,
		{
			entity_type: 'test_change',
			project_id: project_id || 0
		}
	);
}

// Opens the Assign dialog and then assigns the currently selected
// tests to the selected user.
App.Tests.massAssignTo = function()
{
	var test_ids = App.Tests.getSelected();

	if (test_ids == '')
	{
		return;
	}

	App.Tests.setCommentType('assignTo');

	prepareCommentDialog(
		{
			titleSelector: '.editComment',
			method: function(o) {
				App.Tests.commentDialog(
					false,
					{ titleSelector: '.assignTo' },
					{
						show: o.show,

						submit: function(change)
						{
							change.test_ids = test_ids;
							App.Tests.massAddChange(
								change,
								{
									success: App.Tests.commentSuccess,
									error: App.Tests.commentError
								}
							);
						}
					}
				);
			}
		}
	);
}

App.Tests.assignTo = function(test_id, project_id)
{
	App.Tests.setCommentType('assignTo');

	prepareCommentDialog(
		{
			test_id: test_id,
			titleSelector: '.assignTo',
			project_id: project_id
		}
	);
}

function prepareCommentDialog(config)
{
	var listSelector = '#addCommentForm #entityAttachmentList';
	var inputSelector = '#addCommentForm input#attachments';
	var $attachmentList = $(listSelector);
	var $noAttachments = $('#addCommentForm #noEntityAttachments');
	var attachments = App.Tests._initEditorAttachments(
		config.test_change_id,
		{
			listSelector: listSelector,
			inputSelector: inputSelector
		}
	);
	var $attachmentInput = $(inputSelector);
	var method = config.method || App.Tests.implAddComment;

	method(
		$.extend(
			{},
			{
				show: function(change)
				{
					$('#addCommentComment').focus();
				},
				close: function(change)
				{
				    var dropzone = App.Editor.editor_dropzone['#addCommentComment_display_drop'];
					dropzone && $(dropzone.element).data('has-drop', false);
					dropzone && dropzone.destroy();
					delete App.Editor.editor_dropzone['#addCommentComment_display_drop'];
				}
			},
			config || {}
		)
	);
}

App.Tests.assignToInline = function(test_id)
{
	App.Tests._assignToInline(test_id);
}

App.Tests._assignToInline = function(test_id)
{
	App.Tests.setCommentType('assignTo');

	App.Tests.commentDialog(
		false,
		{ titleSelector: '.assignTo' },
		{
			show: function()
			{
				$('#addCommentAssignTo').focus();
			},

			submit: function(change)
			{
				change.test_id = test_id;
				App.Tests.addChangeInline(
					change,
					{
						success: App.Tests.commentSuccess,
						error: App.Tests.commentError
					}
				);
			}
		}
	);
}

App.Tests.assignToQPane = function(test_id)
{
	App.Tests._assignToInline(test_id);
}

App.Tests.addCommentNoDialogActivate = function(test_id)
{
	var box = $('#addCommentInline');
	box.height(80);
	box.unbind('keydown').bind('keydown',
		function(e)
		{
			if ((e.ctrlKey || e.metaKey) && e.keyCode == App.keyEnter)
			{
				App.Tests.addCommentNoDialog(test_id);
				return false;
			}
		}
	);

	if (!box.next().is('.textarea-grippie'))
	{
		box.removeClass('processed');
		App.applyTextAreaResizer(); // Make comment box resizable
	}

	setTimeout(
		function()
		{
			box.focus();
			$('#addCommentInlineAttachments').show();
			$('#addCommentInlineButtons').show();
		},
		0
	);
}

App.Tests.addCommentNoDialog = function(test_id)
{
	var comment = $.trim($('#addCommentInline').val());
	if (!comment)
	{
		$('#addCommentInlineEmpty').show();
		return;
	}

	$('#addCommentInlineEmpty').hide();
	$('#addCommentInlineSubmit').addClass('button-busy');

	App.Ajax.call(
	{
		target: '/tests/ajax_add_change',
		reflow: true, // For the responsive results

		arguments: {
			test_id: test_id,
			comment: $('#addCommentInline').val(),
			attachments: $('#addCommentInlineAttachments #attachments').val(),
			direction_mode: 'run'
		},

		stop: function()
		{
			$('#addCommentInlineSubmit').removeClass('button-busy');
		},

		success: function(data)
		{
			$('#resultsContainer').html(data.changes);
			App.Effects.add('#testChange-' + data.change_id);
			App.Tests.addCommentNoDialogActivate(test_id);
		},

		error: function(data)
		{
			App.Ajax.handleError(data);
		}
	});
}

// Lets the user edit a assignto result on the view test page with the
// assign to dialog.
App.Tests.editAssignTo = function(test_change_id, project_id)
{
	App.Tests.setCommentType('editAssignTo');

	prepareCommentDialog(
		{
			test_change_id: test_change_id,
			titleSelector: '.editAssignTo',
			method: App.Tests.implEditComment,
			project_id: project_id
		}
	);
}

App.Tests.implEditComment = function(o)
{
	App.Tests.loadChange(
	{
		test_change_id: o.test_change_id,
		error: App.Ajax.handleError,

		success: function(data)
		{
			App.Tests.commentDialog(
				data.change,
				{
					disable_assignedto: true,
					hide_attachments: true,
					titleSelector: o.titleSelector
				},
				{
					show: o.show,
					close: o.close,
					validate: o.validate,
					submit: function(change)
					{
						change.test_change_id = o.test_change_id;
						App.Tests.editChange(
							change,
							{
								success: App.Tests.commentSuccess,
								error: App.Tests.commentError
							}
						);
					}
				}
			);
		}
	});
}

//---------------------------------------------------------------------
// CHANGES
//---------------------------------------------------------------------

// Adds a change to a test and updates the corresponding html sections
// on the view test page.
App.Tests.addChange = function(change, callbacks)
{
	var direction_mode = $('#directionNext').attr('rel');
	change.direction_mode = direction_mode;

	App.Ajax.call(
	{
		target: '/tests/ajax_add_change',
		arguments: change,

		success: function(data)
		{
			callbacks.success(data);
			$('#content-header').replaceWith(data.headline);
			$('#sidebar').html(data.sidebar);
			$('#resultsContainer').html(data.changes);
			App.Effects.add('#testChange-' + data.change_id);
			App.Tabs.activate('#resultsTab');

			if (change.status_id)
			{
				$.publish('results.added', {
					test_id: change.test_id,
					status_id: change.status_id
				});

				App.Tests.countTimerStop();
			}

			// Make sure to reload the goals for the current user
			// for trial onboarding, if necessary.
			if (change.status_id)
			{
				if (App.Users.hasGoals())
				{
					App.Users.reloadGoals();
				}
			}
		},

		error: function(data)
		{
			callbacks.error(data);
		}
	});
}

// Adds a change to a test and updates the corresponding html row on
// the view run page.
App.Tests.addChangeInline = function(change, callbacks)
{
	change.columns = JSON.stringify(App.Tables.columns_for_user);
	change.group_by = App.Tables.group_by;
	change.group_order = App.Tables.group_order;

	if (App.QPane.isVisible())
	{
		change.qpane_id = App.QPane.getCurrentRowID();
	}

	App.Ajax.call(
	{
		target: '/tests/ajax_add_change_inline',
		arguments: change,

		success: function(data)
		{
			var selector = '#row-' + change.test_id;
			var e = $(selector);

			// Determine the odd/even alternator for the updated row.
			var style;
			if (e.hasClass('odd'))
			{
				style = 'odd';
			}
			else if (e.hasClass('oddSelected'))
			{
				style = 'oddSelected';
			}
			else if (e.hasClass('evenSelected'))
			{
				style = 'evenSelected';
			}
			else
			{
				style = 'even';
			}

			// Check if a checkbox is available and checked.
			var checkbox = $('input.selectionCheckbox', e);
			var checked = checkbox.length == 1 && checkbox.get(0).checked;

			// Replace the row and refresh the jQuery object with this
			// new row.
			e.replaceWith(data.row);
			e = $(selector);

			e.removeClass('odd even').addClass(style);

			if (checked)
			{
				checkbox = $('input.selectionCheckbox', e);
				if (checkbox.length == 1)
				{
					checkbox.get(0).checked = true;
				}
			}

			if (change.status_id)
			{
				App.Tests.countTimerStop();
			}

			// And fade it in.
			App.Effects.add(selector);

			// Also update the qpane if it's part of the response.
			if (data.qpane)
			{
				App.QPane.update(data.qpane);
			}

			$.publish({
				'body.changed': null,
				'tests.changed': {
					project_id: data.project_id,
					run_id: data.run_id,
					test_id: change.test_id
				}
			});

			// Make sure to reload the goals for the current user
			// for trial onboarding, if necessary.
			if (change.status_id)
			{
				if (App.Users.hasGoals())
				{
					App.Users.reloadGoals();
				}
			}

			callbacks.success(data);
		},

		error: function(data)
		{
			callbacks.error(data);
		}
	});
}

// Adds a change to multiple tests and updates the corresponding html rows
// in the test grid.
App.Tests.massAddChange = function(change, callbacks)
{
	change.columns = JSON.stringify(App.Tables.columns_for_user);
	change.group_by = App.Tables.group_by;
	change.group_order = App.Tables.group_order;

	if (App.QPane.isVisible())
	{
		change.qpane_id = App.QPane.getCurrentRowID();
	}

	App.Ajax.call(
	{
		target: '/tests/ajax_mass_add_change',
		arguments: change,

		success: function(data)
		{
			callbacks.success(data);
			var tests = false;

			// Add and replace the individual test rows.
			for (var i = 0, len = data.rows.length; i < len; i++)
			{
				var test = data.rows[i];
				var selector = '#row-' + test.id;

				var e = $(selector);
				if (e.hasClass('oddSelected'))
				{
					var style = 'odd';
				}
				else
				{
					var style = 'even';
				}

				// Replace the test row and refresh the jQuery object (so
				// that we deal with the row).
				e.replaceWith(test.code);
				e = $(selector);

				e.removeClass('oddSelected evenSelected').addClass(style);

				if (tests)
				{
					tests = tests.add(e);
				}
				else
				{
					tests = e;
				}
			}

			$.publish({
				'body.changed': null,
				'tests.changed': {
					project_id: data.project_id,
					run_id: data.run_id
				}
			});

			App.Effects.add(tests);

			// Also update the qpane if it's part of the response.
			if (data.qpane)
			{
				App.QPane.update(data.qpane);
			}

			// And then uncheck all header checkboxes and update the
			// mass action buttons.
			$('tr.header input.selectionCheckbox').prop('checked', false);
			App.Tests.updateMassActions();

			// Make sure to reload the goals for the current user
			// for trial onboarding, if necessary.
			if (change.status_id)
			{
				if (App.Users.hasGoals())
				{
					App.Users.reloadGoals();
				}
			}
		},

		error: function(data)
		{
			callbacks.error(data);
		}
	});
}

// Edits an existing test change and updates the corresponding html
// sections on the view test page.
App.Tests.editChange = function(change, callbacks)
{
	if(App.Tables.group_by && App.Tables.group_order && JSON.stringify(App.Tables.columns_for_user)){
		change.columns = JSON.stringify(App.Tables.columns_for_user);
		change.group_by = App.Tables.group_by;
		change.group_order = App.Tables.group_order;
	}
    if (App.QPane.isVisible())
    {
        change.qpane_id = App.QPane.getCurrentRowID();
    }
    change.direction_mode = 'run';
	App.Ajax.call(
	{
		target: '/tests/ajax_edit_change',
		arguments: change,
		reflow: true, // For responsive results

		success: function(data)
		{
            callbacks.success(data);
            if (data.headline !== undefined) {
		$('#content-header').replaceWith(data.headline);
	      }
            $('#sidebar').html(data.sidebar);
            $('#resultsContainer').html(data.changes);

			App.Effects.add('#testChange-' + change.test_change_id);

			var selector = '#row-' + data.test_id;
			var e = $(selector);
			e.replaceWith(data.row);
// Also update the qpane if it's part of the response.
            if (data.qpane) {
                App.QPane.update(data.qpane);
            }

			App.Tests.removeDeletedImageSrc();
			App.Tests.removeDeletedImage();

			$.publish({
				'body.changed': null,
				'tests.changed': {
					project_id: data.project_id,
					run_id: data.run_id,
					test_id: change.test_id ? change.test_id : data.test_id
				}
			});
		},

		error: function(data)
		{
			callbacks.error(data);
		}
	});
}

// Loads the test change identified by the given id from the server
// and invokes custom actions on success/error.
App.Tests.loadChange = function(o)
{
	var selector = '#editChange-' + o.test_change_id;

	$(selector + ' .link').hide();
	$(selector + ' .busy').show();

	App.Ajax.call(
	{
		target: '/tests/ajax_get_change',

		arguments:
		{
			test_change_id: o.test_change_id
		},

		success: function(data)
		{
			$(selector + ' .link').show();
			$(selector + ' .busy').hide();
			o.success(data);
		},

		error: function(data)
		{
			$(selector + ' .link').show();
			$(selector + ' .busy').hide();
			o.error(data);
		}
	});
}

App.Tests.removeDeletedImageSrc = function()
{
	var all_image_ids = [];
	$('a.fancy[href*="/attachments/get/"]').each(function() {
		if ($(this).closest('div').hasClass('content markdown')) {
			all_image_ids.push(parseInt($(this).attr('href').split('/').reverse()[0]));
		}
	})

	var only_attachment_ids = [];
	$('.attachment-title').find('a').each(function() {
		only_attachment_ids.push(parseInt($(this).attr('href').split('/').reverse()[0]));
	})

	all_image_ids.forEach(function(image_id) {
		if (only_attachment_ids.indexOf(image_id) === -1) {
			$('a[href$="/attachments/get/'+image_id+'"]').remove();
		}
	})
}

App.Tests.setStepResults = function(field_name, status_id)
{
	var table = $('#' + field_name + '_table');
	table.find('select').val(status_id);
	$('#' + field_name).val(App.Tests.stepsToString(field_name));
}

App.Tests.removeDeletedImage = function()
{
	var all_images = [];
	$('img[src*="/attachments/get/"]').each(function() {
		if ($(this).closest('span').hasClass('markdown-img-container')) {
			all_images.push($(this).attr('src').split('/').reverse()[0]);
		}
	})

	var only_attachments = [];
	$('.attachment-list-item').each(function() {
	    let attachmentId = $(this).attr('data-attachment-id');
	    let attachmentDataId = $(this).attr('data-attachment-data-id');
	    only_attachments.push(
	        attachmentId.length && attachmentId.substr(0, 2) === 'E_' && attachmentDataId.length
	            ? attachmentDataId
	            : attachmentId
	    );
	})

	all_images.forEach(function(image_id) {
		if (only_attachments.indexOf(image_id) === -1) {
			$('img[src$="/attachments/get/'+image_id+'"]').remove();
		}
	})
}

//---------------------------------------------------------------------
// ATTACHMENTS
//---------------------------------------------------------------------

App.Tests.Attachments = new function()
{
	var self = this;

	self.dropzones = [];

	self.init = function(selector, project_id, test_change_id)
	{
		var dropzone = App.Dropzone.applyDrop(
			selector,
			{
				url: App.Page.formatUri(
					'{0}/attachments/ajax_add_for_test_change/{1}/{2}',
					Consts.ajaxBaseUrl,
					project_id,
					test_change_id
				),

				dict: {
					drop: lang('attachments_drop')
				},

				start: function()
				{
					App.Dropzone.hide(); // Hide volatile dropzones
				},

				success: function(file, data)
				{
					App.Dropzone.addAttachment(file, data.id);
				}
			}
		);

		self.dropzones.push(dropzone);
		return dropzone;
	}

	self.clear = function()
	{
		$.each(self.dropzones, function(ix, v)
		{
			v.removeAllFiles();
		});
	}
}



//---------------------------------------------------------------------
// TIMERS
//---------------------------------------------------------------------

App.Tests.elapsed = null;
App.Tests.elapsed_timer = null;

// Generic function to issue a timer related AJAX request. Used by all
// timer related functions in this file.
App.Tests.callTimer = function(o)
{
	App.Ajax.call(
	{
		target: o.target,
		blockUI: o.blockUI,

		arguments: {
			test_id: o.test_id
		},

		success: function(data)
		{
			if (data && data.timer)
			{
				$('#testTimer').html(data.timer);
			}

			if (o.success)
			{
				o.success(data);
			}
		},

		error: function(data)
		{
			if (!o.hideErrors)
			{
				App.Ajax.handleError(data);
			}
		}
	});
}

App.Tests.callTimerInline = function(o)
{
	$('#addResultElapsedBusy').show();

	App.Ajax.call(
	{
		target: o.target,

		arguments: {
			test_id: o.test_id
		},

		stop: function()
		{
			$('#addResultElapsedBusy').hide();
		},

		success: function(data)
		{
			if (data && data.timer)
			{
				$('#testTimer').html(data.timer);
			}

			if (o.success)
			{
				o.success(data);
			}
		},

		error: function(data)
		{
			App.Ajax.handleError(data);
		}
	});
}

App.Tests.callTimerQPane = function(o)
{
	$(o.button).addClass('button-busy');

	App.Ajax.call(
	{
		target: o.target,

		arguments: {
			test_id: o.test_id
		},

		stop: function()
		{
			$(o.button).removeClass('button-busy');
		},

		success: function(data)
		{
			if (o.success)
			{
				o.success(data);
			}
		},

		error: function(data)
		{
			App.Ajax.handleError(data);
		}
	});
}

// Issues an AJAX request to start the timer for a given test and then
// updates the timer related html section.
App.Tests.startTimer = function(test_id)
{
	App.Tests.callTimer(
	{
		target: '/tests/ajax_start_timer',
		test_id: test_id
	});
}

App.Tests.startTimerInline = function(test_id)
{
	App.Tests.callTimerInline(
	{
		target: '/tests/ajax_start_timer',
		test_id: test_id,

		success: function()
		{
			$('#addResultElapsedStart').hide();
			$('#addResultElapsedPause').show();
			$('#addResultElapsedStop').show();
			$('#startTimer').hide(); // For QPane
			$('#pauseTimer').show(); // For QPane
			$('#stopTimer').show();  // For QPane
			App.Tests.elapsed = 0;
			App.Tests.countTimerStart();
		}
	});
}

App.Tests.startTimerQPane = function(test_id)
{
	App.Tests.callTimerQPane(
	{
		target: '/tests/ajax_start_timer',
		button: '#startTimer',
		test_id: test_id,

		success: function()
		{
			$('#startTimer').hide();
			$('#pauseTimer').show();
			$('#stopTimer').show();
			App.Tests.elapsed = 0;
			App.Tests.countTimerStart();
		}
	});
}

App.Tests.countTimerStart = function()
{
	App.Tests.countTimerStop();

	$('#testTimerQPane').show();
	$('#addResultElapsed').prop('readonly', true);

	App.Tests.countTimerUpdate();
	App.Tests.elapsed_timer = setInterval(
		function()
		{
			App.Tests.elapsed++;
			App.Tests.countTimerUpdate();
		},
		1000
	);
}

App.Tests.countTimerUpdate = function()
{
	// Timer may be shown both on result dialog as well as QPane.
	var elapsed = App.Tests.formatTimer(App.Tests.elapsed);
	$('#addResultElapsed').val(elapsed);
	$('#testTimerQPane').text(elapsed);
}

App.Tests.formatTimer = function(elapsed)
{
	var h = 0, m = 0, s = 0;

	if (elapsed >= 3600)
	{
		h = parseInt(elapsed / 3600);
		elapsed -= h * 3600;
	}

	if (elapsed >= 60)
	{
		m = parseInt(elapsed / 60);
		elapsed -= m * 60;
	}

	s = elapsed;

	var t = '';

	if (h > 0)
	{
		t += h + lang('timespans_hour_short') + ' ';
	}

	if (m > 0)
	{
		t += m + lang('timespans_minute_short') + ' ';
	}

	if (s > 0)
	{
		t += s + lang('timespans_second_short');
	}

	return t;
}

App.Tests.countTimerStop = function()
{
	$('#addResultElapsed').prop('readonly', false);

	if (App.Tests.elapsed_timer)
	{
		clearInterval(App.Tests.elapsed_timer);
		App.Tests.elapsed_timer = null;
	}
}

// Issues an AJAX request to reload the timer for a given test and then
// updates the timer related html section. Called periodically to update
// the minute counter.
App.Tests.reloadTimer = function(test_id)
{
	App.Tests.callTimer(
	{
		target: '/tests/ajax_reload_timer',
		test_id: test_id,
		hideErrors: true,
		blockUI: false
	});
}

// Issues an AJAX request to resume the timer for a given test and then
// updates the timer related html section.
App.Tests.resumeTimer = function(test_id)
{
	App.Tests.callTimer(
	{
		target: '/tests/ajax_resume_timer',
		test_id: test_id
	});
}

App.Tests.resumeTimerInline = function(test_id)
{
	App.Tests.callTimerInline(
	{
		target: '/tests/ajax_resume_timer',
		test_id: test_id,

		success: function()
		{
			$('#addResultElapsedResume').hide();
			$('#addResultElapsedPause').show();
			$('#resumeTimer').hide(); // For QPane
			$('#pauseTimer').show();  // For QPane
			App.Tests.countTimerStart();
		}
	});
}

App.Tests.resumeTimerQPane = function(test_id)
{
	App.Tests.callTimerQPane(
	{
		target: '/tests/ajax_resume_timer',
		button: '#resumeTimer',
		test_id: test_id,

		success: function()
		{
			$('#resumeTimer').hide();
			$('#pauseTimer').show();
			App.Tests.countTimerStart();
		}
	});
}

// Issues an AJAX request to pause the timer for a given test and then
// updates the timer related html section.
App.Tests.pauseTimer = function(test_id)
{
	App.Tests.callTimer(
	{
		target: '/tests/ajax_pause_timer',
		test_id: test_id
	});
}

App.Tests.pauseTimerInline = function(test_id)
{
	App.Tests.callTimerInline(
	{
		target: '/tests/ajax_pause_timer',
		test_id: test_id,

		success: function()
		{
			$('#addResultElapsedPause').hide();
			$('#addResultElapsedResume').show();
			$('#pauseTimer').hide();  // For QPane
			$('#resumeTimer').show(); // For QPane
			App.Tests.countTimerStop();
		}
	});
}

App.Tests.pauseTimerQPane = function(test_id)
{
	App.Tests.callTimerQPane(
	{
		target: '/tests/ajax_pause_timer',
		button: '#pauseTimer',
		test_id: test_id,

		success: function()
		{
			$('#pauseTimer').hide();
			$('#resumeTimer').show();
			App.Tests.countTimerStop();
		}
	});
}

// Issues an AJAX request to stop the timer for a given test and then
// updates the timer related html section. After that, it spawns the
// add result dialog for letting the user enter a test result. It also
// pre-fills the 'elapsed' field which was returned by the server.
App.Tests.stopTimer = function(test_id)
{
	App.Tests.callTimer(
	{
		target: '/tests/ajax_stop_timer',
		test_id: test_id,
		success: function(data)
		{
			App.Tests.addResult(data.project_id, test_id, data.elapsed);
		}
	});
}

App.Tests.stopTimerInline = function(test_id)
{
	App.Tests.callTimerInline(
	{
		target: '/tests/ajax_stop_timer',
		test_id: test_id,

		success: function(data)
		{
			$('#addResultElapsedPause').hide();
			$('#addResultElapsedResume').hide();
			$('#addResultElapsedStop').hide();
			$('#addResultElapsedStart').show();
			$('#pauseTimer').hide();     // For QPane
			$('#resumeTimer').hide();    // For QPane
			$('#stopTimer').hide();      // For QPane
			$('#startTimer').show();     // For QPane
			$('#testTimerQPane').hide(); // For QPane
			App.Tests.countTimerStop();
		}
	});
}

App.Tests.stopTimerQPane = function(test_id)
{
	App.Tests.callTimerQPane(
	{
		target: '/tests/ajax_stop_timer',
		button: '#stopTimer',
		test_id: test_id,

		success: function(data)
		{
			$('#pauseTimer').hide();
			$('#resumeTimer').hide();
			$('#stopTimer').hide();
			$('#startTimer').show();
			$('#testTimerQPane').hide();
			App.Tests.countTimerStop();
			App.Tests.addResultQPane(data.project_id, test_id,
				App.Tests.elapsed);
		}
	});
}

//---------------------------------------------------------------------
// SUBSCRIPTIONS
//---------------------------------------------------------------------

// Subscribes a user to email notifications for the given test.
App.Tests.subscribe = function(test_id)
{
	$('#unsubscribed .subscribe').hide();
	$('#unsubscribed .busy').show();

	App.Ajax.call(
	{
		target: '/tests/ajax_subscribe',

		arguments:
		{
			test_id: test_id
		},

		success: function(data)
		{
			App.Effects.replace('#unsubscribed', '#subscribed');
			$('#unsubscribed .subscribe').show(); // Restore link
			$('#unsubscribed .busy').hide();
		},

		error: function(data)
		{
			$('#unsubscribed .subscribe').show();
			$('#unsubscribed .busy').hide();
			App.Ajax.handleError(data);
		}
	});
}

// Unsubscribes a user from email notifications for the given test.
App.Tests.unsubscribe = function(test_id)
{
	$('#subscribed .unsubscribe').hide();
	$('#subscribed .busy').show();

	App.Ajax.call(
	{
		target: '/tests/ajax_unsubscribe',

		arguments:
		{
			test_id: test_id
		},

		success: function(data)
		{
			App.Effects.replace('#subscribed', '#unsubscribed');
			$('#subscribed .unsubscribe').show(); // Restore link
			$('#subscribed .busy').hide();
		},

		error: function(data)
		{
			$('#subscribed .unsubscribe').show();
			$('#subscribed .busy').hide();
			App.Ajax.handleError(data);
		}
	});
}

//---------------------------------------------------------------------
// NEXT/PREVIOUS
//---------------------------------------------------------------------

App.Tests.loadPrev = function(testId)
{
	var mode = $('#directionPrev').attr('rel');

	App.Ajax.call(
	{
		target: '/tests/ajax_get_prev',

		arguments:
		{
			test_id: testId,
			direction_mode: mode
		},

		success: function(data)
		{
			if (data.test_id)
			{
				var location = Consts.ajaxBaseUrl + '/tests/view/' +
					data.test_id;

				if (data.return_location)
				{
					location += '/' + data.return_location;
				}

				document.location = location;
			}
			else
			{
				$('#directionPrev').hide();
				$('#directionPrevDisabled').show();
			}
		},

		error: function(data)
		{
			App.Ajax.handleError(data);
		}
	});
}

App.Tests.loadNext = function(testId)
{
	var mode = $('#directionNext').attr('rel');

	App.Ajax.call(
	{
		target: '/tests/ajax_get_next',

		arguments:
		{
			test_id: testId,
			direction_mode: mode
		},

		success: function(data)
		{
			if (data.test_id)
			{
				var location = Consts.ajaxBaseUrl + '/tests/view/' +
					data.test_id;

				if (data.return_location)
				{
					location += '/' + data.return_location;
				}

				document.location = location;
			}
			else
			{
				$('#directionNext').hide();
				$('#directionNextDisabled').show();
			}
		},

		error: function(data)
		{
			App.Ajax.handleError(data);
		}
	});
}

App.Tests.setDirectionMode = function(mode)
{
	var current = $('#directionNext').attr('rel');

	if (current == mode)
	{
		// No need to update it and activate the buttons again when
		// the mode hasn't actually changed.
		return;
	}

	if (mode == 'run')
	{
		$('#directionRun').show();
		$('#directionRunAssigned').hide();
		$('#directionTodo').hide();
	}
	else if (mode == 'run_assigned')
	{
		$('#directionRun').hide();
		$('#directionRunAssigned').show();
		$('#directionTodo').hide();
	}
	else
	{
		$('#directionRun').hide();
		$('#directionRunAssigned').hide();
		$('#directionTodo').show();
	}

	$('#directionNext').attr('rel', mode);
	$('#directionNext').show();
	$('#directionNextDisabled').hide();

	$('#directionPrev').attr('rel', mode);
	$('#directionPrev').show();
	$('#directionPrevDisabled').hide();
}

//---------------------------------------------------------------------
// GRIDS
//---------------------------------------------------------------------

// Returns a comma-separated list of selected test IDs (selected in
// the current context of a test grid).
App.Tests.getSelected = function()
{
	var checkboxes = $('tr.row input.selectionCheckbox');
	var ids = '';

	// Iterate all rows and add the IDs of the selected rows
	// to the return value.
	$.each(checkboxes, function(checkboxIndex, checkboxValue)
	{
		if (checkboxValue.checked)
		{
			if (ids != '')
			{
				ids = ids + ',';
			}

			ids = ids + checkboxValue.value;
		}
	});

	return ids;
}

// Is called by a data table selection checkbox on click. Changes the
// row selection color and updates the mass actions.
App.Tests.onRowClick = function(e)
{
	App.Tables.onRowClick(e);
	App.Tests.updateMassActions();
}

// Called when the toggle all checkbox is clicked. Selects or unselects
// all row checkboxes of the parent data table and updates the mass
// actions.
App.Tests.onToggleAllClick = function(e)
{
	App.Tables.onToggleAllClick(e);
	App.Tests.updateMassActions();
}

// Hides or shows the mass actions for assigning multiple tests or
// adding multiple test results. Called after a row/toggleAll checkbox
// has been clicked.
App.Tests.updateMassActions = function()
{
	var checkboxes = $('tr.row input.selectionCheckbox');

	// Iterate all rows and check if at least one test is selected.
	var checked = false;
	$.each(checkboxes, function(checkboxIndex, checkboxValue)
	{
		if (checkboxValue.checked)
		{
			checked = true;
			return;
		}
	});

	if (checked)
	{
		// Show the enabled mass actions
		$('#massAssignSelectedDisabled').hide();
		$('#massAssignSelected').show();
		$('#massAddResultDisabled').hide();
		$('#massAddResult').show();
	}
	else
	{
		// Show the disabled mass actions
		$('#massAssignSelected').hide();
		$('#massAssignSelectedDisabled').show();
		$('#massAddResult').hide();
		$('#massAddResultDisabled').show();
	}
}

App.Tests.onResultsClick = function(tab, test_id)
{
	if (!App.Tabs.isActive(tab))
	{
		App.Tests._loadResults(tab, test_id);
	}
}

App.Tests._loadResults = function(tab, test_id, offset)
{
	$('#resultsBusy').show();
	$('#resultsTab .link-tooltip').hide();

	if(tab && !offset){
		offset = -1;
	}

	App.Ajax.call(
	{
		target: '/tests/ajax_render_results',
		reflow: true,

		arguments: {
			test_id: test_id,
			offset: offset
		},

		stop: function()
		{
			$('#resultsBusy').hide();
			$('#resultsTab .link-tooltip').show();
		},

		success: function(html)
		{
			$('#resultsContainer').html(html);
			App.Tests.removeDeletedImageSrc();

			if (tab) {
				App.Tabs.activate(tab);
			}

		},

		error: function(data)
		{
			App.Ajax.handleError(data);
		}
	});
}

App.Tests.onHistoryClick = function(tab, test_id)
{
	if (!App.Tabs.isActive(tab))
	{
		App.Tests._onHistoryClick(tab, test_id);
	}
}

App.Tests._onHistoryClick = function(tab, test_id)
{
	$('#historyContainer').html('');
	$('#historyBusy').show();
	$('#historyTab .link-tooltip').hide();

	App.Ajax.call(
	{
		target: '/tests/ajax_render_history',
		reflow: true,

		arguments: {
			test_id: test_id,
			offset: -1
		},

		stop: function()
		{
			$('#historyBusy').hide();
            $('#historyTab .link-tooltip').show();
		},

		success: function(html)
		{
			$('#historyContainer').html(html);
			App.Tabs.activate(tab);
		},

		error: function(data)
		{
			App.Ajax.handleError(data);
		}
	});
}

App.Tests.loadHistory = function(test_id, offset, show_all)
{
	$('#showHistory .showAll').hide();
	$('#showHistory .busy').show();

	App.Ajax.call(
	{
		target: '/tests/ajax_render_history',
		reflow: true,

		arguments: {
			test_id: test_id,
			offset: offset,
			show_all: show_all
		},

		success: function(html)
		{
			$('#historyContainer').html(html);
		},

		error: function(data)
		{
			$('#showHistory .busy').hide();
			App.Ajax.handleError(data);
		}
	});
}

App.Tests.onDefectsClick = function(tab, test_id)
{
	if (!App.Tabs.isActive(tab))
	{
		App.Tests._onDefectsClick(tab, test_id);
	}
}

App.Tests._onDefectsClick = function(tab, test_id)
{
	$('#defectsContainer').html('');
	$('#defectsBusy').show();
	$('#defectsTab .link-tooltip').hide();

	App.Ajax.call(
	{
		target: '/tests/ajax_render_defects',
		reflow: true,

		arguments: {
			test_id: test_id,
			limit: 25
		},

		stop: function()
		{
			$('#defectsBusy').hide();
			$('#defectsTab .link-tooltip').show();
		},

		success: function(html)
		{
			$('#defectsContainer').html(html);
			App.Tabs.activate(tab);
		},

		error: function(data)
		{
			App.Ajax.handleError(data);
		}
	});
}

App.Tests.loadDefects = function(test_id)
{
	$('#showDefects .showAll').hide();
	$('#showDefects .busy').show();

	App.Ajax.call(
	{
		target: '/tests/ajax_render_defects',
		reflow: true,

		arguments: {
			test_id: test_id
		},

		success: function(html)
		{
			$('#defectsContainer').html(html);
		},

		error: function(data)
		{
			$('#showDefects .busy').hide();
			App.Ajax.handleError(data);
		}
	});
}

App.Tests.callEditCase = function (case_id) {
    return App.Ajax.call({
      target: '/cases/ajax_edit',
      arguments: App.Cases.serializeForm({case_id: case_id}),
    }).fail(function error(data) {
        App.Ajax.handleError(data);
    })
}

App.Tests.updateFromQpane = function (test_id, case_id) {
	var formData = App.Cases.serializeForm({case_id: case_id});
	App.Cases.callAjaxCheckCaseInDynamicFilters(case_id, formData).done(function(resp) {
		resp = JSON.parse(resp);
		if (resp.is_added) {
			App.Dialogs.confirm(resp.info, function() {
				App.Tests.callEditCase(case_id).done(function(resps) {
					resps = JSON.parse(resps);
					if (resps.result === true) {
						window.location.reload();
					}
					else {
						App.Ajax.handleError(resps);
					}
				})
			}, function() {}, '#confirmDialogOkCancel');
		} else {
			App.Tests.callEditCase(case_id).done(function(resp){
				resp = JSON.parse(resp);
				if (resp.result === false) {
					App.Ajax.handleError(resp);
				} else {
					App.Tests.renderQpaneAgain(test_id);
					self.qpane.removeClass("edit-mode");
				}
			});
		}
	}).fail(function(resp) {
		App.Ajax.handleError(resp);
	})
};

App.Tests.renderQpaneAgain = function(test_id)
{
	App.Ajax.call({
		target: '/tests/ajax_render_qpane',
		reflow: true,
		arguments: {
			test_id: test_id
		},
		success: function(html) {
			$('#qpane-content').html(html);
			$('#form .searchable').each(function(ix, v) {
				var dropdown = $(v);
				// Apply the chosen control
				dropdown.chosen();
			});
			$.each($('.editor-bindable'), function(_idx, el) {
				App.Editor.bind($(el).data('attribute'));
			});
		},
		error: function(data) {
			App.Ajax.handleError(data);
		}
	});
}

App.Tests.resetFormBody = function()
{
  if (self.formCopy != null) {
    $("#qpane form").html(self.formCopy);
  }
}

App.Tests.editMode = function(test_id, case_id)
{
  App.Hotkeys.isForm(true);
  self.qpane = $("#qpane");
  self.formCopy = self.qpane.find('form').html();
  self.prevImageDialogUploadSuccess = App.Editor.imageDialogUploadSuccess;
  self.prevImageDialogSuccess = App.Editor.imageDialogSuccess;
  self.prevRemoveSuccess = App.Attachments.removeSuccess;
  self.prevAttachmentContainerParent = App.Editor.attachmentContainerParent;
  self.prevInputParent = App.Attachments.inputParent;
  App.Attachments.inputParent = '#form';
  App.Editor.attachmentContainerParent = '#form';
  App.Attachments.initEditorAttachments(App.Cases.attachmentsCode);

  if (self.qpane.hasClass("edit-mode")) {
  	App.Cases.updateSteps($('.fast_track').attr('name'));
    App.Tests.updateFromQpane(test_id, case_id);

    return;
  }

  self.qpane.addClass("edit-mode");
  if ($("#qpane-body .form-control").length > 0) {
  	$('#qpane_first_control').focus();
  }
  $('#cancelButton').show();
  $('#closeButton').hide();
}

App.Tests.cancelEditMode = function(test_id)
{
  App.Hotkeys.isForm(false);
  self.qpane = $("#qpane");
  self.formCopy = self.qpane.find('form').html();
  App.Tests.renderQpaneAgain(test_id);

  App.Editor.imageDialogUploadSuccess = self.prevImageDialogUploadSuccess;
  App.Editor.imageDialogSuccess = self.prevImageDialogSuccess;
  App.Attachments.removeSuccess = self.prevRemoveSuccess;
  App.Editor.attachmentContainerParent = self.prevAttachmentContainerParent;
  App.Attachments.inputParent = self.prevInputParent;

  if (self.qpane.hasClass("edit-mode")) {
    self.qpane.removeClass("edit-mode");
    $('#cancelButton').hide();
    $('#closeButton').show();
    App.Tests.resetFormBody();

    return;
  }
}

;

