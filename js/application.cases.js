'use strict';

/*******************************************************************/
/* Test Cases  */

	/* [Permissions checked!] */

App.Cases = new function () {
	var self = this;

	// Fields for keeping the current state (drag & drop, etc.)
	self.dragged_ids = null;
	self.droppables = null;
	self.formCopy = null;
	self.drop_data = null;
	self.attachmentsCode = {};
	self.suiteId = null;
	self.restoreCallback = null;
	self.savedSharedSteps = null;
	self.restoringVersionData = null;
	self.restoreItems = [];
	self.commentLimit = null;

	self.applyActions = function () {
		self._applyHover();
	};

	self._applyHover = function () {
		// Late binding for drag & drop for cases. We delay setting up
		// the draggable/droppable until we hover over the drag action.

		$(document).on({
			mouseenter: function mouseenter() {
				if (!App.DragDrop.isDragging()) {
					self._applyDraggable($(this));
				}
			} }, 'td.drag');
	};

	self.applyResponsive = function () {
		App.Responsive.register('#content', 950, function (is_below) {
			var buttons = $('#content-header .button-responsive');
			if (is_below) {
				buttons.addClass('button-notext');
			} else {
				buttons.removeClass('button-notext');
			}
		});
	};

	//---------------------------------------------------------------
	// DRAG & DROP
	//---------------------------------------------------------------

	self._applyDraggable = function (column) {
		$('.caseDraggable', column).draggable({
			addClasses: false,
			cursor: 'move',
			containment: 'document',
			cursorAt: { top: 10, left: 5 },
			scroll: true,
			scrollSensitivity: 50,
			scrollSpeed: 40,
			scope: 'cases',
			start: self._dragStart,
			stop: self._dragStop,
			helper: self._dragHelper
		});
	};

	self._applyDroppable = function () {
		self.droppables = $('tr.caseDroppable, #groupTree a.caseDroppable');

		self.droppables.droppable({
			addClasses: false,
			tolerance: 'pointer',
			scope: 'cases',
			hoverClass: 'jstree-dropping',
			over: self._dropEnter,
			out: self._dropLeave,
			drop: self._drop
		});
	};

	self._destroyDroppable = function () {
		if (self.droppables) {
			self.droppables.droppable('destroy');
		}
	};

	self._dragHelper = function (event) {
		self._dragInit(this, event);
		return self._getDragHelper(this, event);
	};

	self._dragInit = function (el, event) {
		// Get and remember dragged case IDs for later
		self.dragged_ids = self._getDragged(el);
	};

	self._getDragged = function (el) {
		// In case the dragged row is selected (its checkbox is checked)
		// we return all selected rows, otherwise only the dragged case.

		var tr = $(el).closest('tr');
		var checkbox = $('input.selectionCheckbox', tr);

		if (!checkbox.is(':checked')) {
			return [tr.attr('rel')];
		} else {
			return App.Tables.getSelected($('#groups'));
		}
	};

	self._getDragHelper = function (el, event) {
		var tr = $(el).closest('tr');

		var case_ids = self.dragged_ids;
		if (case_ids.length > 1) {
			var title = '<strong>' + case_ids.length + '</strong> test cases';
		} else {
			var title = $('.title', tr).html();
		}

		var dragGrayUrl = Consts.resourceBaseUrl + 'images/icons/dragGray.png';

		var content = '<img src="' + dragGrayUrl + '" /> ' + title;

		// The section helper is hidden by default and will be shown by
		// the _dragStart handler. This is a workaround for a bug/mis-
		// behavior in Google Chrome which changes the column width of
		// the drag handle (not sure why).

		var helper = '<div id="caseHelper" class="hidden dragdrop-helper">' + content + '</div>';

		return $(helper).get(0);
	};

	self._dragStart = function (event, ui) {
		if (self.drop_data) {
			// Cancel any previous open drag & drop operation.
			self._dropCancel();
		}

		App.DragDrop.start();
		$(ui.helper).show(); // See getDragHelper

		// Defer applying droppable until we start dragging.
		self._applyDroppable();
	};

	self._dragStop = function (event, ui) {
		// And destroy droppables again when drag is finished.
		self._destroyDroppable();
		App.DragDrop.stop();
	};

	self._dropShowBorder = function (el) {
		var rows = $('td, th', $(el));
		rows.addClass('row-dragged-show').removeClass('row-dragged-hide');
	};

	self._dropHideBorder = function (el) {
		var row = $(el);
		$('th', row).addClass('row-dragged-hide').removeClass('row-dragged-show');
		$('td', row).addClass('row-dragged-hide').removeClass('row-dragged-show');
	};

	self._dropShowHighlight = function (section_id) {
		var node = $('#node-' + section_id);
		$('> a', node).addClass('jstree-highlighted');
	};

	self._dropHideHighlight = function (section_id) {
		var node = $('#node-' + section_id);
		$('> a', node).removeClass('jstree-highlighted');
	};

	self._dropEnter = function (event, ui) {
		self._dropShowBorder(this);
	};

	self._dropLeave = function (event, ui) {
		self._dropHideBorder(this);
	};

	self._drop = function (event, ui) {
		var target = $(this);

		// Get and remember the drop data (e.g. the droppable, section
		// etc.).
		if (this.tagName == 'A') // Sidebar tree
			{
				var section_id = target.closest('li').attr('rel');

				self.drop_data = {
					drop_to_tree: true,
					droppable: this,
					section_id: section_id,
					case_ids: self.dragged_ids
				};

				// Keep the hover highlight visible/active for the section.
				self._dropShowHighlight(section_id);
			} else {
			var after_id = target.attr('rel'); // Undefined if header row
			var section_id = target.closest('.grid-container').attr('rel');

			self.drop_data = {
				drop_to_tree: false,
				droppable: this,
				after_id: after_id,
				section_id: section_id,
				case_ids: self.dragged_ids
			};
		}

		var e = event.originalEvent;
		var show_menu = false;

		// If the user holds the shift key when dropping the case, we
		// execute the copy directly. The same is true for ctrl/cmd +
		// move. Otherwise, we show a dropdown menu.
		if (e.shiftKey) {
			self.dropCopy();
		} else if (e.ctrlKey || e.metaKey) {
			if (self._dropCanMove(self.drop_data)) {
				self.dropMove();
			} else {
				show_menu = true;
			}
		} else {
			show_menu = true;
		}

		if (show_menu) {
			self._dropShowMenu(e, self.drop_data);
		}
	};

	self._dropShowMenu = function (e, drop_data) {
		if (self._dropCanMove(drop_data)) {
			$('#casesDndMoveDisabled').hide();
			$('#casesDndMove').show();
		} else {
			$('#casesDndMove').hide();
			$('#casesDndMoveDisabled').show();
		}

		App.Dropdowns.show('#casesDndDropdown', e.pageX, e.pageY);
	};

	self._dropCanMove = function (drop_data) {
		var droppable = drop_data.droppable;

		if (droppable.tagName == 'A') {
			// Dropping on a sidebar section is always okay.
			return true;
		}

		var row = $(droppable);
		if (row.hasClass('header')) {
			// Dropping on a grid header is always okay.
			return true;
		}

		// In all other cases, we need to check if the move operation
		// is allowed. Simply said, we do not allow to drop rows into
		// dragged rows.
		var lookup = {};

		var case_ids = self.dragged_ids;
		for (var i = 0; i < case_ids.length; i++) {
			lookup[case_ids[i]] = true;
		}

		var id = row.attr('rel');
		return !lookup[id];
	};

	self._dropHideMenu = function () {
		App.Dropdowns.hide('#casesDndDropdown');
	};

	self._dropStart = function (el) {
		// Add a progress-indicating row to the table right below the
		// actual droppable.
		var progressInlineUrl = Consts.resourceBaseUrl + 'images/animations/progressInline.gif';

		var column_count = $('td, th', el).length;
		var tr = '<tr>' + '<td colspan="' + column_count + '">' + '<img src="' + progressInlineUrl + '" />' + '</td>' + '</tr>';

		$(el).after(tr);
	};

	self._dropStop = function (el) {
		self._dropHideBorder(el);
		self._dropClearCheckboxes();
		$(el).next().remove(); // Remove progress row again
		self.drop_data = null;
	};

	self._dropClearCheckboxes = function () {
		// Disable all possible checkboxes, not just the dragged row(s)
		var grids = $('#groups .grid-container');

		$.each(grids, function (index, value) {
			App.Tables.setCheckboxes($(value), false);
		});

		self._disableMassActions();
	};

	self.dropCancel = function () {
		self._dropCancel();
	};

	self._dropCancel = function () {
		self._dropHideMenu();
		if (self.drop_data.drop_to_tree) {
			self._dropHideHighlight(self.drop_data.section_id);
		} else {
			self._dropHideBorder(self.drop_data.droppable);
		}

		self.drop_data = null;
	};

	self.dropCopy = function () {
		self._dropHideMenu();

		// Call the actual copy action, either copy to section (tree
		// in the sidebar) or after a table row.
		if (self.drop_data.drop_to_tree) {
			self._dropCopyToSection(self.drop_data);
		} else {
			self._dropCopy(self.drop_data);
		}
	};

	self._dropCopy = function (o) {
		self._dropStart(o.droppable);

		App.Ajax.call({
			target: '/cases/ajax_copy',

			arguments: {
				case_ids: o.case_ids,
				section_id: o.section_id,
				after_id: o.after_id,
				columns: App.Tables.columns_for_user
			},

			success: function success(html) {
				self._dropStop(o.droppable);

				var grid = $('#grid-' + o.section_id);

				if (o.after_id) {
					$('#row-' + o.after_id).after(html);
				} else {
					$('tr.header', grid).after(html);
				}

				App.Suites.onCasesAdded();
				App.Suites.refreshGroupCount(o.section_id);
			},

			error: function error(data) {
				self._dropStop(o.droppable);
				App.Ajax.handleError(data);
			}
		});
	};

	self._dropCopyToSection = function (o) {
		var node = $('#node-' + o.section_id);
		var a = node.children('a');

		a.addClass('jstree-loading');

		App.Ajax.call({
			target: '/cases/ajax_copy_to_section_end',

			arguments: {
				case_ids: o.case_ids,
				section_id: o.section_id,
				columns: App.Tables.columns_for_user
			},

			success: function success(html) {
				a.removeClass('jstree-loading jstree-highlighted');

				var grid = $('#grid-' + o.section_id);
				if (grid.length) {
					$(html).appendTo(grid);
				}

				self._dropClearCheckboxes();
				App.Suites.onCasesAdded();
				App.Suites.refreshGroupCount(o.section_id);
			},

			error: function error(data) {
				a.removeClass('jstree-loading');
				App.Ajax.handleError(data);
			}
		});
	};

	self.dropMove = function () {
		self._dropHideMenu();

		// Call the actual move action, either move to section (tree
		// in the sidebar) or after a table row.
		if (self.drop_data.drop_to_tree) {
			self._dropMoveToSection(self.drop_data);
		} else {
			self._dropMove(self.drop_data);
		}
	};

	self._dropMove = function (o) {
		self._dropStart(o.droppable);
		// Show confirmation dialog before moving if run count is greater than 0
		App.Cases.callAjaxConfirmMove(o.case_ids, o.section_id).done(function(resp) {
			resp = JSON.parse(resp);
			if (resp.show_dialog) {
				App.Dialogs.confirm(resp.info, function () {
					App.Cases.callAjaxMove(o);
				}, function () {
					self._dropStop(o.droppable);
				}, '#confirmDialogOkCancel');
			}
			else {
				App.Cases.callAjaxMove(o);
			}
		}).fail(function(resp) {
			App.Ajax.handleError(resp);
		})

	};

	self._dropMoveToSection = function (o) {
		var node = $('#node-' + o.section_id);
		var a = node.children('a');

		a.addClass('jstree-loading');

		App.Ajax.call({
			target: '/cases/ajax_move_to_section_end',

			arguments: {
				case_ids: o.case_ids,
				section_id: o.section_id
			},

			success: function success(data) {
				a.removeClass('jstree-loading jstree-highlighted');
				var grid = $('#grid-' + o.section_id);
				var cases = self._dropGetRows(o.case_ids);

				if (grid.length) {
					cases.appendTo(grid);
				} else {
					cases.remove();
				}

				self._dropClearCheckboxes();
				App.Suites.refreshGroupCounts();
			},

			error: function error(data) {
				a.removeClass('jstree-loading');
				App.Ajax.handleError(data);
			}
		});
	};

	self._dropGetRows = function (case_ids) {
		var cases = false;

		for (var i = 0; i < case_ids.length; i++) {
			var row = $('#row-' + case_ids[i]);

			if (cases) {
				cases = cases.add(row);
			} else {
				cases = row;
			}
		}

		return cases;
	};
}();

//---------------------------------------------------------------------
// ATTACHMENTS
//---------------------------------------------------------------------

App.Cases.Attachments = new function () {
	var self = this;

	self.dropzones = [];

	self.init = function (selector, project_id, case_id) {
		var target = $(selector);

		var dropzone = App.Dropzone.applyDrop(selector, {
			url: App.Page.formatUri('{0}/attachments/ajax_add_for_case/{1}/{2}', Consts.ajaxBaseUrl, project_id, case_id ? case_id : ''),

			dict: {
				drop: lang('attachments_drop')
			},

			start: function start() {
				// Hide volatile dropzones if we are dropping to a
				// persistent dropzone.
				if (target.is('.dz-persistent')) {
					App.Dropzone.hide();
				}
			},

			stop: function stop() {
				App.Dropzone.hide(); // Hide all volatile dropzones
			},

			success: function success(file, data) {
				self._addId(data.id);
				self._addRow(data.code);
				dropzone.removeFile(file);
			}
		});

		self.dropzones.push(dropzone);

		return dropzone;
	};

	self._addRow = function (html) {
		var row = $(html);
		$('#noCaseAttachments').hide();
		row.appendTo($('#caseAttachmentList')).show();
	};

	self._addId = function (id, dataId) {
        var $attachments = $('#attachments');
        var value = $attachments.val();
        if (value) {
            value = JSON.parse($attachments.val());
            value.push({ id: id, dataId: dataId });
        } else {
            value = [];
            value.push({ id: id, dataId: dataId });
        }
        $attachments.val(JSON.stringify(value));
	};

	self.remove = function (attachment_id) {
		App.Ajax.call({
			target: '/attachments/ajax_delete',

			arguments: {
				attachment_id: attachment_id
			},

			success: function success(data) {
				$('#attachment-' + attachment_id).remove();
				if ($('#caseAttachmentList div').length == 0) {
					$('#noCaseAttachments').show();
				}
			},

			error: function error(data) {
				App.Ajax.handleError(data);
			}
		});
	};

	self.clear = function()
	{
		$.each(self.dropzones, function(ix, v)
		{
			v.removeAllFiles();
		});
	};
}();

App.Cases.Edit = new function () {
	var self = this;

	// Fields for keeping the current state (filters, case list, etc.)
	self.suite_id = null;
	self.scope = null;
	self.display = null;
	self.group_only = null;
	self.group_by = null;
	self.group_id = null;
	self.case_ids = null;
	self.filters = null;
	self.columns = null;

	self._createFilter = function (e) {
		return new App.Suites.Filter({
			event: e,
			suite_id: self.suite_id,
			filters: self.filters,
			save_filters: false,

			changed: function changed(filters) {
				self.filters = filters;
				self._filterReload();
			}
		});
	};

	self.filter = function (e) {
		var filter = self._createFilter(e);
		filter.open();
	};

	self.filterReset = function () {
		var filter = self._createFilter();
		filter.reset();
	};

	self._filterReload = function () {
		App.Ajax.call({
			target: '/cases/ajax_render_edit_all_filter_match',
			blockUI: false,

			// Submit all input fields of the form along with the suite
			// ID this is about.
			arguments: {
				suite_id: self.suite_id,
				display: self.display,
				group_only: self.group_only,
				group_by: self.group_by,
				group_id: self.group_id,
				filters: self.filters
			},

			success: function success(html) {
				$('#filterByMatch').html(html);
			},

			error: function error(data) {
				// Ignore error
			}
		});
	};

	self.includeChanged = function () {
		var control_id = $(this).attr('rel');
		var control = $('#' + control_id);

		// We differentiate between standard and special controls
		// (multi/steps). For the standard control, we simply toggle
		// the placeholder attribute. For the special controls, we
		// toggle between the special 'various' message and the actual
		// control container.

		if (control.is('.multi') || control.is('.steps')) {
			var various = $('#' + control_id + '_various');
			if (various.length) {
				var container = $('#' + control_id + '_container');
				if (this.checked) {
					various.hide();
					container.show();
				} else {
					container.hide();
					various.show();
				}
			}
		} else {
			if (this.checked) {
				control.data('placeholder', control.attr('placeholder'));
				control.removeAttr('placeholder');
				control.focus();
			} else {
				control.attr('placeholder', control.data('placeholder'));
			}
		}
	};

	self.controlChanged = function () {
		var control = $(this);
		var checkbox = $('#' + control.attr('id') + '_included');
		if (checkbox.length === 0) {
			checkbox = $('#' + control.attr('source_id') + '_included');
		}
		checkbox.attr('checked', true).change();
	};

	self.confirm = function (suite_id, submit) {
		App.Validation.hideErrors();
		var case_count = 0;

		// Submit action
		$('#confirmDiffForm').unbind('submit');
		$('#confirmDiffForm').submit(function (e) {
			// Depending on the amount of test cases to update, we also
			// display an additional confirmation dialog.
			if (case_count >= 50) {
				if (App.Dialogs.remove('l:cases_edit_many_diff_confirm_dialog', $('#confirmDiffSubmit').html(), null, // No extra
				null, // No init callback
				function () {
					App.Dialogs.closeTop();
					submit();
				})) ;
			} else {
				App.Dialogs.closeTop();
				submit();
			}

			return false;
		});

		$('#accept').addClass('button-busy');

		App.Ajax.call({
			target: '/cases/ajax_render_edit_many_diff',

			// Submit all input fields of the form along with the suite
			// ID this is about.
			arguments: $.extend({
				suite_id: suite_id,
				scope: self.scope,
				case_ids: self.getCases(),
				display: self.display,
				group_only: self.group_only,
				group_by: self.group_by,
				group_id: self.group_id,
				filters: self.filters,
				form_data: App.Cases.serializeForm()
			}, self._getInput()),

			stop: function stop() {
				$('#accept').removeClass('button-busy');
			},

			success: function success(data) {
				case_count = data.case_count; // See top of function

				if (data.show_diff) {
					$('#diff').html(data.code);
					$('#confirmDiffSubmit').text(data.message);
					if (parseInt(data.test_runs_count)) {
						$('#dynamic_filter_warning').show();
						$('#testRunsCount').text(data.test_runs_count);
					} else {
						$('#dynamic_filter_warning').hide();
					}
					App.Dialogs.open({
						selector: '#confirmDiffDialog'
					});
				} else {
					// Do not display the diff dialog, submit directly.
					submit();
				}
			},

			error: function error(data) {
				App.Ajax.handleError(data);
			}
		});
	};

	self._getInput = function () {
		// If there's a step field, make sure to synchronize the steps
		// with the form field. The control would usually do this as
		// well on form submit. But with the new template field, it may
		// be loaded dynamically after the initial form load and confirm
		// may be called before the field can update the data.

		var steps = $('#form .custom.steps');
		if (steps.length) {
			App.Cases.updateSteps(steps.attr('id'));
		}

		var values = {};

		$('#form :input').each(function () {
			var t = $(this);
			if (t.attr('type') == 'checkbox') {
				values[t.attr('name')] = t.prop('checked');
			} else {
				values[this.name] = $(this).val();
			}
		});

		return values;
	};

	self.setCases = function (case_ids) {
		self.case_ids = {};
		if (case_ids) {
			$.each(case_ids, function (ix, v) {
				self.case_ids[v] = true;
			});
		}
	};

	self.getCases = function () {
		return self.case_ids ? Object.keys(self.case_ids) : [];
	};

	self.removeCase = function (case_id) {
		var row = $('#row-' + case_id);
		if (row.next().length == 0) {
			row.prev().find('th, td').addClass('noborder');
		}

		row.remove();
		delete self.case_ids[case_id];
	};

	self.loadCases = function (offset) {
		$('#paginationBusy').show();

		App.Ajax.call({
			target: '/cases/ajax_render_edit_many_cases',

			arguments: {
				suite_id: self.suite_id,
				case_ids: self.getCases(),
				columns: self.columns,
				offset: offset
			},

			stop: function stop() {
				$('#paginationBusy').show();
			},

			success: function success(html) {
				$('#cases').html(html);
			},

			error: function error(data) {
				App.Ajax.handleError(data);
			}
		});
	};

	$('#form #custom_automation_type').each(function(ix, v) {
		if (typeof v.type !== 'undefined' && v.type !== 'hidden') {
			var dropdown = $(v);
			// Apply the chosen control
			dropdown.chosen();
		}
	});
}();

//---------------------------------------------------------------------
// TESTS/RESULTS
//---------------------------------------------------------------------

App.Cases.showTests = function () {
	$('#activitiesLink').removeClass('text-active');
	$('#tests').show();
	$('#testsLink').addClass('text-active');
	$('#activities').hide();
};

App.Cases.loadTests = function (case_id) {
	$('#showTests .showAll').hide();
	$('#showTests .busy').show();

	App.Ajax.call({
		target: '/cases/ajax_get_tests',

		arguments: {
			case_id: case_id
		},

		success: function success(html) {
			$('#showTests .busy').hide();
			$('#tests').html(html);
		},

		error: function error(data) {
			$('#showTests .busy').hide();
			App.Ajax.handleError(data);
		}
	});
};

App.Cases.changePage = function (case_id, offset) {
	var showTests = $('#showTests .busy');
	showTests.show();

	App.Ajax.call({
		target: '/cases/ajax_change_page',

		arguments: {
			case_id: case_id,
			offset: offset
		},

		success: function success(html) {
			showTests.hide();
			$('#tests').html(html);
		},

		error: function error(data) {
			showTests.hide();
			App.Ajax.handleError(data);
		}
	});
};

App.Cases.showActivities = function () {
	$('#testsLink').removeClass('text-active');
	$('#activities').show();
	$('#activitiesLink').addClass('text-active');
	$('#tests').hide();
};

App.Cases.loadActivities = function (case_id) {
	$('#showActivities .showAll').hide();
	$('#showActivities .busy').show();

	App.Ajax.call({
		target: '/cases/ajax_get_activities',

		arguments: {
			case_id: case_id
		},

		success: function success(html) {
			$('#showActivities .busy').hide();
			$('#activities').html(html);
		},

		error: function error(data) {
			$('#showActivities .busy').hide();
			App.Ajax.handleError(data);
		}
	});
};

App.Cases.changeActivitiesPage = function (case_id, offset) {
	var activitiesBusy = $('#showActivities .busy');
	activitiesBusy.show();
	$('#showActivities .showAll').hide();

	App.Ajax.call({
		target: '/cases/ajax_change_activities_page',

		arguments: {
			case_id: case_id,
			offset: offset
		},

		success: function success(html) {
			activitiesBusy.hide();
			$('#activities').html(html);
		},

		error: function error(data) {
			activitiesBusy.hide();
			App.Ajax.handleError(data);
		}
	});
};
//---------------------------------------------------------------------
// HISTORY
//---------------------------------------------------------------------

App.Cases.showPrevious = function (id) {
	$('#previous-' + id).show();
	$('#previousLink-' + id).hide();
};

App.Cases.loadHistory = function (case_id, offset) {
	$('#changesPaginationBusy').show();

	App.Ajax.call({
		target: '/cases/ajax_get_history',

		arguments: {
			case_id: case_id,
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

App.Cases.resizeTables = function ()
{
	var versionLeftTable = $('#compareVersionLeft .history > tbody > tr');
	var versionRightTable = $('#compareVersionRight .history > tbody > tr');
	var columnCount = 0;
	var smallerTable = null;
	var biggerTable = null;
	if (versionLeftTable.size() < versionRightTable.size()) {
		columnCount = versionLeftTable.size();
		smallerTable = versionLeftTable;
		biggerTable = versionRightTable;
	} else {
		columnCount = versionRightTable.size();
		smallerTable = versionRightTable;
		biggerTable = versionLeftTable;
	}
	for (var i = 0; i < columnCount; i++) {
		var leftRow = $(versionLeftTable[i]);
		var rightRow = $(versionRightTable[i]);
		var height = Math.max(leftRow.height(), rightRow.height());
		leftRow.height(height);
		rightRow.height(height);
	}

	var targetHeight = 0;
	$.each(biggerTable, function (_, val) {
		targetHeight += $(val).height();
	});
	var smallerHeight = 0;
	$.each(smallerTable, function (_, val) {
		smallerHeight += $(val).height();
	});

	var lastElement = smallerTable.last();
	lastElement.height(lastElement.height() + (targetHeight - smallerHeight));
};

App.Cases.applyCompareToChosen = function ()
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
			'/cases/compare/{0}/{1}/{2}',
			$(this).attr('data-case-id'),
			isRightVersion ? $(this).find(':selected').val() : $(this).attr('data-change-id'),
			isRightVersion ? $(this).attr('data-change-id') : $(this).find(':selected').val()
		);
	});
};

App.Cases.initRestoreView = function (isTemplateDifferent, templateFields)
{
	var self = this;
	var templateField = 'template_id';
	var templateCheckbox = $('#template_checkbox');

	$('.restore-checkbox').change(function () {
		var field = $(this).attr('data-field');
		if ($(this).is(':checked')) {
			if (field !== templateField
					&& isTemplateDifferent
					&& !templateFields.includes(field)
					&& !self.restoreItems.includes(templateField)) {
				self.restoreItems.push(templateField);
				templateCheckbox.prop('checked', true);
				templateCheckbox.prop('disabled', true);
			}

			self.restoreItems.push(field);
			$('#restoreSelectedButton').show();
		} else {
			self.restoreItems.splice($.inArray(field, self.restoreItems), 1);
			if (isTemplateDifferent && self.restoreItems.includes(templateField)) {
				templateCheckbox.prop('disabled', false);
				$.each(self.restoreItems, function (_, v) {
					if (v !== templateField && !templateFields.includes(v)) {
						templateCheckbox.prop('checked', true);
						templateCheckbox.prop('disabled', true);
						return false;
					}
				});
			}

			if (self.restoreItems.length === 0) {
				$('#restoreSelectedButton').hide();
			}
		}
	});
};

App.Cases.restoreVersion = function (caseId, fullRestore, isTemplateDifferent)
{
	var self = this;

	var title = fullRestore ? lang('cases_history_restore_confirm_title') : lang('cases_history_restore_confirm_title_partial');
	var message = title.replace(/\{0\}/g, self.requestedVersion.version) + lang('cases_history_restore_confirm');
	if (isTemplateDifferent) {
		message += lang('cases_history_restore_template_warning');
	}
	App.Dialogs.confirm(
		message,
		function() {
			App.Ajax.call({
				target: '/cases/ajax_restore_version',

				arguments: {
					case_id: caseId,
					change: JSON.stringify(self.requestedVersion),
					restore_items: JSON.stringify(fullRestore ? self.restoringVersionData : self.restoreItems)
				},

				success: function success() {
					App.Page.load(
						'/cases/history/{0}',
						caseId
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

App.Cases.showCommentsView = function (caseId, changeId)
{
	var self = this;

	App.Ajax.call({
		target: '/cases/ajax_get_comment_view',

		arguments: {
			case_id: caseId,
			change_id: changeId,
			limit: self.commentLimit
		},

		success: function success(data) {
			$('#commentButtonWrapper-' + changeId).hide();
			$('#commentArea-' + changeId)
				.html(data)
				.show();
		},

		error: function error(data) {
			App.Ajax.handleError(data);
		}
	});
};

App.Cases.submitComment = function (caseId, changeId, isForLatest)
{
	App.Ajax.call({
		target: '/cases/ajax_insert_comment',

		arguments: {
			case_id: caseId,
			change_id: changeId,
			comment: $('#commentInput-' + changeId).val(),
			is_for_latest: isForLatest,
			attachments: $('#commentWrapper-' + changeId + ' #attachments').val()
		},

		success: function success() {
			if (isForLatest) {
				App.Cases.loadComments(caseId, 0);
			} else {
				App.Cases.showCommentsView(caseId, changeId);
				App.Cases._updateCommentCount(changeId, 1);
			}
		},

		error: function error(data) {
			App.Ajax.handleError(data);
		}
	});
};

App.Cases.removeComment = function (commentId, caseId, changeId, isForLatest)
{
	App.Dialogs.confirm(
		lang('cases_history_comment_delete'),
		function() {
			App.Ajax.call({
				target: '/cases/ajax_remove_comment',

				arguments: {
					comment_id: commentId
				},

				success: function success() {
					if (isForLatest) {
						App.Cases.loadComments(caseId, 0);
					} else {
						App.Cases.showCommentsView(caseId, changeId);
						App.Cases._updateCommentCount(changeId, -1);
					}
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

App.Cases.loadComments = function (caseId, offset)
{
	$('#commentPaginationBusy').show();

	App.Ajax.call({
		target: '/cases/ajax_get_comment_view',

		arguments: {
			case_id: caseId,
			change_id: 0,
			is_all_comments: true,
			offset: offset
		},

		success: function success(data) {
			$('#commentPaginationBusy').hide();
			$('.case-comment-container').html(data);
		},

		error: function error(data) {
			$('#commentPaginationBusy').hide();
			App.Ajax.handleError(data);
		}
	});
};

App.Cases.loadMoreComments = function (button, caseId, changeId)
{
	var offset = parseInt($(button).attr('data-offset'));
	var totalCount = parseInt($(button).attr('data-total-count'));
	var self = this;

	App.Ajax.call({
		target: '/cases/ajax_get_comments',

		arguments: {
			case_id: caseId,
			change_id: changeId,
			limit: self.commentLimit,
			offset: offset
		},

		success: function success(data) {
			data.comments.forEach(function(comment) {
				$('#caseComments-' + changeId).append(comment);
			});

			var newOffset = offset + data.comments.length;
			if (newOffset >= totalCount) {
				$(button).hide();
			} else {
				$(button).text(
					lang('cases_history_comments_show_more')
						.replace(/\{0\}/g, totalCount - newOffset < self.commentLimit ? totalCount - newOffset : self.commentLimit)
				);
			}
			$(button).attr('data-offset', newOffset);
			$('#commentsHeader-' + changeId).text(
				lang('cases_history_comments_header')
					.replace(/\{0\}/g, newOffset)
					.replace(/\{1\}/g, totalCount)
			);
		},

		error: function error(data) {
			App.Ajax.handleError(data);
		}
	});
};

App.Cases.closeCommentsView = function (changeId)
{
	$('#commentButtonWrapper-' + changeId).show();
	$('#commentArea-' + changeId).hide();
};

App.Cases.editComment = function (commentId)
{
	var selector = '#commentContent-' + commentId;

	if ($(selector + ' #commentContentEdit').is(':hidden')) {
		$('#commentEdit-' + commentId).val($('#commentEdit-' + commentId).attr('data-comment'));
	}

	$('#commentHeader-' + commentId + ' .case-comment-edit').toggle();
	$('#commentHeader-' + commentId + ' .case-comment-delete').toggle();
	$(selector + ' #commentContentDisplay').toggle();
	$(selector + ' #commentContentEdit').toggle();
};

App.Cases.editCommentSubmit = function (commentId, caseId, changeId, isForLatest)
{
	App.Ajax.call({
		target: '/cases/ajax_edit_comment',

		arguments: {
			comment_id: commentId,
			comment: $('#commentEdit-' + commentId).val(),
			attachments: $('#commentContent-' + commentId + ' #attachments').val()
		},

		success: function success() {
			if (isForLatest) {
				App.Cases.loadComments(caseId, 0);
			} else {
				App.Cases.showCommentsView(caseId, changeId);
				App.Cases._updateCommentCount(changeId, 1);
			}
		},

		error: function error(data) {
			App.Ajax.handleError(data);
		}
	});
};

App.Cases._updateCommentCount = function (changeId, count)
{
	var selector = '#commentButtonWrapper-' + changeId + ' .history-comment-button';
	$(selector).text(parseInt($(selector).text()) + count);

	var allCommentCount = parseInt($('#allCommentsButton').attr('data-count')) + count;
	$('#allCommentsButton')
		.attr('data-count', allCommentCount)
		.text(
			lang('cases_history_all_comments').replace(/\{0\}/g, allCommentCount)
		);
};

//---------------------------------------------------------------------
// DEFECTS
//---------------------------------------------------------------------

App.Cases.loadDefects = function (case_id) {
	$('#showDefects .showAll').hide();
	$('#showDefects .busy').show();

	App.Ajax.call({
		target: '/cases/ajax_render_defects',

		arguments: {
			case_id: case_id
		},

		stop: function stop() {
			$('#showDefects .busy').hide();
		},

		success: function success(html) {
			$('#defects').html(html);
		},

		error: function error(data) {
			App.Ajax.handleError(data);
		}
	});
};

//---------------------------------------------------------------------
// ADD/EDIT/DELETE
//---------------------------------------------------------------------

App.Cases.editTitleDialog = function (o) {
	App.Validation.hideErrors();

	// Initialize the dialog
	$('#editCaseTitle').val(o.title);
	$('#editCaseForm').unbind('submit');
	$('#editCaseSubmit').removeClass('button-busy');

	$('#editCaseForm').submit(function (e) {
		App.Validation.hideErrors();
		var title = $.trim($('#editCaseTitle').val());

		// Signal busy
		$('#editCaseSubmit').addClass('button-busy');

		o.submit(title);
		return false;
	});

	// Also make sure to accept Enter for submitting the form
	$('#editCaseTitle').unbind('keydown').bind('keydown', function (e) {
		if (e.keyCode == App.keyEnter) {
			$('#editCaseForm').submit();
			return false;
		}
	});

	App.Dialogs.open({
		selector: '#editCaseDialog',
		focusedControl: '#editCaseTitle',
		selectedControl: '#editCaseTitle',
		titleSelector: o.titleSelector
	});
	App.DirtyChecker.init("editCaseSubmit", "editCaseForm");
};

App.Cases.editTitle = function (case_id) {
	// Get the related case title
	var selector = '#row-' + case_id + ' .title';
	var title = $(selector).text();

	$('.editCaseEdit').show();
	$('.editCaseAdd').hide();

	// Show the dialog
	App.Cases.editTitleDialog({
		title: title,
		titleSelector: '.dialogTitleEdit',
		submit: function submit(title) {
			// Rename the section on the server
			App.Ajax.call({
				target: '/cases/ajax_edit_title',

				arguments: {
					case_id: case_id,
					title: title
				},

				success: function success(data) {
					$(selector).text(title);
					App.Effects.add(selector);
					App.Dialogs.close('#editCaseDialog');
				},

				error: function error(data) {
					$('#editCaseSubmit').removeClass('button-busy');
					App.Ajax.handleError(data, '#editCaseErrors');
				}
			});
		}
	});
};

App.Cases.callEditCase = function (case_id) {
	App.Ajax.call({
		target: '/cases/ajax_edit',
		arguments: App.Cases.serializeForm({case_id: case_id}),
		success: function success(data) {
			App.Cases.renderQpaneAgain(case_id);
			self.qpane.removeClass("edit-mode");
		},
		error: function error(data) {
			App.Ajax.handleError(data);
		}
	})
}

App.Cases.updateFromQpane = function (case_id) {

	var formData = App.Cases.serializeForm({case_id: case_id});

	App.Cases.callAjaxCheckCaseInDynamicFilters(case_id, formData).done(function(resp) {
		resp = JSON.parse(resp);
			if (resp.is_added) {
				App.Dialogs.confirm(resp.info, function() {
					App.Cases.callEditCase(case_id)
				}, function() {}, '#confirmDialogOkCancel');
			} else {
				App.Cases.callEditCase(case_id)
			}
	}).fail(function(resp) {
		App.Ajax.handleError(resp);
	})
};

App.Cases.renderQpaneAgain = function (test_id) {
	App.Ajax.call({
		target: '/cases/ajax_render_qpane',
		reflow: true, // For responsive qpane
		arguments: {
			case_id: test_id
		},
		success: function success(html) {
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
		error: function error(data) {
			App.Ajax.handleError(data);
		}
	});
};

App.Cases.resetFormBody = function () {
	if (self.formCopy != null) {
		$("#qpane form").html(self.formCopy);
	}
};

App.Cases.editMode = function (test_id) {
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
		App.Cases.updateSteps($('.fast_track').first().attr('name'));
		App.Cases.updateFromQpane(test_id);

		return;
	}

	self.qpane.addClass("edit-mode");
	if ($("#qpane-body .form-control").length > 0) {
		$('#qpane_first_control').focus();
	}

	$('#cancelButton').show();
	$('#closeButton').hide();
};

App.Cases.cancelEditMode = function(case_id)
{
	App.Hotkeys.isForm(false);
	self.qpane = $("#qpane");
	self.formCopy = self.qpane.find('form').html();
	App.Cases.renderQpaneAgain(case_id);

	App.Editor.imageDialogUploadSuccess = self.prevImageDialogUploadSuccess;
	App.Editor.imageDialogSuccess = self.prevImageDialogSuccess;
	App.Attachments.removeSuccess = self.prevRemoveSuccess;
	App.Editor.attachmentContainerParent = self.prevAttachmentContainerParent;
	App.Attachments.inputParent = self.prevInputParent;

	if (self.qpane.hasClass("edit-mode")) {
		self.qpane.removeClass("edit-mode");
		$('#cancelButton').hide();
		$('#closeButton').show();
		App.Cases.resetFormBody();

		return;
	}
}

App.Cases.add = function (section_id) {
	App.Validation.hideErrors();

	// Make sure that all other inline forms are hidden
	$('.inlineSectionActions').show();
	$('.inlineSectionAddCase').hide();

	// Get the element names
	var actionsElement = '#inlineSectionActions-' + section_id;
	var addElement = '#inlineSectionAddCase-' + section_id;

	// Prepare the form
	$(addElement + ' .addForm').unbind('submit');
	$(addElement + ' .cancel').unbind('click');
	$(addElement + ' .title').unbind('keydown');
	$(addElement + ' .title').val('');

	// Prepare the functionality to hide/cancel the form
	var hideForm = function hideForm() {
		$(actionsElement).show();
		$(addElement).hide();
	};

	// Mark the form as busy / none-busy
	var signalBusy = function signalBusy(busy) {
		if (busy) {
			$(addElement + ' .buttons').hide();
			$(addElement + ' .busy').show();
		} else {
			$(addElement + ' .buttons').show();
			$(addElement + ' .busy').hide();
		}
	};

	// Make sure that the user can cancel the inline form with escape
	$(addElement + ' .title').keydown(function (e) {
		if (e.keyCode == App.keyEscape) {
			hideForm();
		}
	});

	// Assign the cancel functionality to the cancel image link
	$(addElement + ' .cancel').click(hideForm);

	var form = $(addElement + ' .addForm');

	// Specify what should happen when the user submits the case
	$(addElement + ' .addForm').submit(function () {
		$(addElement + ' .submit').blur();
		App.Validation.hideErrors();

		// Get and validate the case title
		var caseTitle = $.trim($(addElement + ' .title').val());

		if (!caseTitle) {
			$(addElement + ' .errorPanel').show();
			$(addElement + ' .requiredMessage').show();
			return false;
		}

		signalBusy(true);

		App.Ajax.call({
			target: 'cases/ajax_add',

			arguments: {
				section_id: section_id,
				title: caseTitle,
				columns: App.Tables.columns_for_user
			},

			success: function success(html) {
				$(addElement + ' .title').val('');
				$(addElement + ' .title').focus();
				signalBusy(false);

				var grid = $('#grid-' + section_id);
				var row = $(html);
				row.appendTo(grid);
				App.Effects.add(row);

				App.Suites.onCasesAdded();
				App.Suites.refreshGroupCount(section_id);

				if (App.Users.hasGoals()) {
					App.Users.reloadGoals();
				}
			},

			error: function error(data) {
				signalBusy(false);
				App.Ajax.handleError(data);
			}
		});

		return false;
	});

	$(actionsElement).hide();
	$(addElement).show();
	$(addElement + ' .title').focus();
};

App.Cases.restore = function restore(case_id) {
	var $button = $('#restoreLink');
	$button.addClass('button-busy');

	App.Ajax.call({
		target: 'cases/ajax_restore',

		arguments: {
			case_id: case_id,
		},

		stop: function stop() {
			$button.removeClass('button-busy');
		},

		success: function success(data) {
			window.location.reload();
		},

		error: function error(data) {
			App.Ajax.handleError(data);
		},
	});
}

App.Cases.restore = function restore(caseId) {
	var $button = $('#restoreLink');
	$button.addClass('button-busy');

	App.Ajax.call({
		target: 'cases/ajax_restore',

		arguments: {
			case_id: caseId,
		},

		stop: function stop() {
			$button.removeClass('button-busy');
		},

		success: function success(_data) {
			window.location.reload();
		},

		error: function error(data) {
			App.Ajax.handleError(data);
		},
	});
}

App.Cases.restoreAll = function restoreAll(suiteId, casesIds) {
	var $button = $('#restoreLink');
	$button.addClass('button-busy');

	App.Ajax.call({
		target: 'cases/ajax_restore_many',
		arguments: {
			suite_id: suiteId,
			case_ids: casesIds
		},

		stop: function stop() {
			$button.removeClass('button-busy');
		},

		success: function success(_data) {
			if (App.Cases.restoreCallback) {
				var cb = App.Cases.restoreCallback;
				App.Cases.restoreCallback = null;
				cb();
			} else {
				window.location.reload();
			}
		},

		error: function error(data) {
			App.Ajax.handleError(data);
		},
	});
}

App.Cases.remove = function (caseId, permanently, refreshSidebar) {
	var row = $('#row-' + caseId);
	$('.deleteLink', row).hide();
	$('.deleteBusy', row).show();

	var section_id = row.closest('.grid-container').attr('rel');

	App.Ajax.call({
		target: 'cases/ajax_delete',

		arguments: {
			case_id: caseId,
			permanently: permanently,
			inline: refreshSidebar
		},

		stop: function stop() {
			$('.deleteBusy', row).hide();
			$('.deleteLink', row).show();
		},

		success: function success(_data) {
			App.Cases._removeRow(caseId, permanently);
			if (permanently) {
				App.Suites.refreshGroupCount(section_id);
			}

			if (refreshSidebar) {
				App.Suites.onCasesDeleted();
			} else if (permanently && App.Cases.suiteId !== null) {
				App.Page.load(
					'suites/view/{0}',
					App.Cases.suiteId
				);
			} else {
				App.Page.load(
					'cases/view/{0}',
					caseId
				);
			}

			App.Cases._updateMassActions(); // May be needed as well
			App.Dialogs.closeTop();
		},

		error: function error(data) {
			App.Ajax.handleError(data);
		}
	});
};

App.Cases.removeMany = function (suite_id, permanently) {
	var case_ids = App.Tables.getSelected($('#groups'));
	$('#deleteCases').addClass('button-busy');

	App.Ajax.call({
		target: 'cases/ajax_delete_many',

		arguments: {
			suite_id: suite_id,
			case_ids: case_ids,
			permanently: permanently,
		},

		success: function success(data) {
			$('#deleteCases').removeClass('button-busy');
			App.Cases._removeMany(case_ids, permanently);
			App.Suites.onCasesDeleted();
			App.Suites.refreshGroupCounts();
			App.Cases._disableMassActions();
		},

		error: function error(data) {
			$('#deleteCases').removeClass('button-busy');
			App.Ajax.handleError(data);
		}
	});
};

App.Cases._removeMany = function (case_ids, permanently) {
	$.each(case_ids, function (_ix, case_id) {
		App.Cases._removeRow(case_id, permanently);
	});
};

App.Cases._removeRow = function (case_id, permanently)
{
	var $row = $('#row-' + case_id);
	if (permanently || !App.Tables.displayDeletedCases) {
		$row.remove();

		return;
	}

	$row.find('.selectionCheckbox').prop('checked', false);
	$row.find('span.case-deleted').removeClass('case-deleted-hidden');
	$row.find('.editLink').remove();
	$row.find('.deleteLink').remove();
	$row.find('.icon-small-edit').remove();
	$row.addClass('semi-transparent deleted-case').css('opacity', 0.5);
}

App.Cases.onRowClick = function (e) {
	App.Tables.onRowClick(e);
	App.Cases._updateMassActions();
};

App.Cases.onToggleAllClick = function (e) {
	App.Tables.onToggleAllClick(e);
	App.Cases._updateMassActions();
};

App.Cases._updateMassActions = function () {
	var checkboxes = $('tr.row input.selectionCheckbox');

	// Iterate all rows and check if at least one test is selected.
	var checked = false;
	$.each(checkboxes, function (checkboxIndex, checkboxValue) {
		if (checkboxValue.checked) {
			checked = true;
			return;
		}
	});

	if (checked) {
		App.Cases._enableMassActions();
	} else {
		App.Cases._disableMassActions();
	}
};

App.Cases._enableMassActions = function () {
	// Show the enabled mass actions
	$('#deleteCasesDisabled').hide();
	$('#deleteCases').show();
	$('#editCasesSelectedDisabled').hide();
	$('#editCasesSelected').show();
	$('#massAssignSelectedDisabled').hide();
	$('#massAssignSelected').show();
};

App.Cases._disableMassActions = function () {
	// Show the disabled mass actions
	$('#deleteCases').hide();
	$('#deleteCasesDisabled').show();
	$('#editCasesSelected').hide();
	$('#editCasesSelectedDisabled').show();
	$('#massAssignSelected').hide();
	$('#massAssignSelectedDisabled').show();
};

App.Cases.editSelected = function (suiteId) {
	var caseIds = App.Tables.getSelected($('#groups'));
	App.Cases._checkDeletedCases(suiteId, caseIds, function() {
		var action = Consts.ajaxBaseUrl + '/cases/edit_many/' + suiteId + // The endpoint
		'/1&' + // Initial load
		App.Suites.getStateOptions(); // The state parameters

		$('#case_ids').val(caseIds.join(','));
		$('#editCasesForm').attr('action', action).submit();
	});
};

App.Cases.editView = function (suiteId) {
	if (App.Cases.hasDeletedCase()) {
		App.Cases._checkDeletedCases(suiteId, null, function() {
			App.Page.load(
				'/cases/edit_all/{0}/1/{1}&{2}',
				suiteId,
				App.Suites.display,
				App.Suites.getStateOptions()
			);
		});
	} else {
		App.Page.load(
			'/cases/edit_all/{0}/1/{1}&{2}',
			suiteId,
			App.Suites.display,
			App.Suites.getStateOptions() // The state parameters
		);
	}
};

App.Cases.editAllInFilter = function (suiteId)
{
	if (App.Cases.hasDeletedCase()) {
		App.Cases._checkDeletedCases(suiteId, null, function() {
			App.Page.load(
				'cases/edit_all/{0}',
				suiteId
			);
		});
	} else {
		App.Page.load(
			'cases/edit_all/{0}',
			suiteId
		);
	}
}

App.Cases._checkDeletedCases = function _checkDeletedCases(suiteId, caseIds, callback)
{
	var args = {};
	if (caseIds) {
		args.case_ids = caseIds;
	}

	App.Ajax.call({
		target: '/cases/ajax_check_deleted_cases/' + suiteId,

		arguments: args,

		success: function(data)
		{
			if (data.length === 0 || data.result === true) {
				callback();

				return;
			}

			App.Cases.restoreCallback = callback;
			$('body').append(data);
			App.Dialogs.open({
				selector: '#deletedCasesDialog',
				titleColor: '#E40046'
			});
		}
	});
}

App.Cases.restoreMany = function(suiteId)
{
	$('#restoreCasesButton').addClass('button-busy');
	App.Ajax.call({
		target: '/cases/ajax_restore_many/' + suiteId,

		success: function(data)
		{
			$('#restoreCasesButton').removeClass('button-busy');
			if (data.result) {
				App.Page.load(
					'cases/edit_all/{0}',
					suiteId
				);

				return;
			}
		},

		error: function(data)
		{
			$('#restoreCasesButton').removeClass('button-busy');
			App.Ajax.handleError(data);
		}
	});
}

App.Cases.hasDeletedCase = function()
{
	return $('#groups table tr').hasClass('deleted-case');
}

//---------------------------------------------------------------------
// STEPS
//---------------------------------------------------------------------

App.Cases.stepsToString = function (field_name, inlineShared, inlineStepIds) {
	inlineShared = inlineShared || false;
	inlineStepIds = inlineStepIds || false;
	var temp = [];

	$('tr.step-container', $('#' + field_name + '_table')).each(function (ix, e) {
		var tr = $(e);

		var o = {};

		if (tr.attr('sharedstepsetid') && inlineShared === false) {
			if (tr.hasClass('step-shared-last')) {
				o.shared_step_id = tr.attr('sharedstepsetid');
				if (inlineStepIds) {
					o.step_id = tr.attr('id');
				}
				temp.push(o);
			}
		} else {
			var attachments = [];

			o.content = App.Editor.formatValueForDB($('div.content', tr));
			$('div.content .attachment-list-item', tr).each(function (idx, el) {
				attachments.push({ 'id': $(el).data('attachment-id'), 'dataId': $(el).data('attachment-data-id') });
			})

			var expected = $('div.expected', tr);
			if (expected.length > 0) {
				o.expected = App.Editor.formatValueForDB(expected);

				$('div.expected .attachment-list-item', tr).each(function (idx, el) {
					attachments.push({ 'id': $(el).data('attachment-id'), 'dataId': $(el).data('attachment-data-id') });
				});
			}

			var additional_info = $('div.additional_info', tr);
			if (additional_info.length > 0) {
				o.additional_info = App.Editor.formatValueForDB(additional_info);

				$('div.additional_info .attachment-list-item', tr).each(function (idx, el) {
					attachments.push({ 'id': $(el).data('attachment-id'), 'dataId': $(el).data('attachment-data-id') });
				});
			}

			var refs = $('input.refs', tr);
			if (refs.length > 0) {
				o.refs = refs.val();
			}

			if (inlineShared) {
				o.shared = tr.attr('sharedstepsetid') ? 1 : 0;
			}

			if (inlineStepIds) {
				o.step_id = tr.attr('id');
			}

			o.attachments = attachments;

			temp.push(o);
		}
	});

	if (temp.length > 0) {
		return JSON.stringify(temp);
	} else {
		return '';
	}
};

App.Cases.addStep = function (project_id, field_name, step_id) {
	var container = $('#' + field_name + '_container');
	$('.addStepBusy', container).show();
	$('.addStep', container).hide();

	var steps = $('#' + field_name + '_table');
	var index = $('tr.step-container', steps).length + 1;

	App.Ajax.call({
		target: '/cases/ajax_render_step',

		arguments: {
			index: index,
			project_id: project_id,
			field_name: field_name
		},

		success: function success(html) {
			$('.noSteps', container).hide();
			var step = $(html);
			if (step_id) {
				var sharedStepId = steps.find('tr.step-' + step_id).attr('sharedStepSetId');
				step.insertAfter(
					sharedStepId
						? $('tr.step-last-shared.shared-step-set-' + sharedStepId)
						: steps.find('tr.step-' + step_id),
					steps
				);
			} else {
				step.appendTo(steps);
			}

			$('.addStepBusy', container).hide();
			$('.addStep', container).show();
			step.find('textarea:first').focus();

			App.Cases.indexSteps(field_name);
			App.Cases.changeSteps(field_name);
		},

		error: function error(data) {
			$('.addStepBusy', container).hide();
			$('.addStep', container).show();
			App.Ajax.handleError(data);
		}
	});
};

App.Cases.addStepToCurrent = function (project_id, field_name) {
	var step_id = App.Cases.getCurrentStep(field_name);
	if (step_id) {
		App.Cases.addStep(project_id, field_name, step_id);
	}
};

App.Cases.updateSteps = function (field_name) {
	var input = $('#' + field_name);
	input.val(App.Cases.stepsToString(field_name));
};

App.Cases.changeSteps = function (field_name) {
	App.Cases.updateSteps(field_name);
	// Not fired otherwise because it's a hidden field
	$('#' + field_name).trigger('change');
	$('#' + field_name).trigger('input');
};

App.Cases.indexSteps = function (field_name) {
	var steps = $('#' + field_name + '_table');

	var current_index = 0;
	$('tr', steps).each(function (ix, e) {
		if ($('.step-no-inner', $(e)).length > 0) {
			++current_index;
			$('.step-no-inner', $(e)).html(current_index);
		}
	});
};

App.Cases.removeStep = function (field_name, step_id) {
	var steps = $('#' + field_name + '_table');
	var step = steps.find('tr.step-' + step_id);
	var sharedStepSetId = step.attr('sharedStepSetId');
	if (sharedStepSetId) {
		step.next().remove();
		const $prevSteps = step.prevAll('tr');
		let stillTheSame = true;
		$prevSteps.each(function() {
			if (stillTheSame && $(this).hasClass('step-container') && $(this).attr('sharedStepSetId') === sharedStepSetId)
				$(this).remove();
			else {
				stillTheSame = false;
			}
		});
		step.remove();
	} else {
		step.remove();
	}
	$(step_id).trigger('input');

	if ($('tr', steps).length == 0) {
		$('#' + field_name + '_container').find('.noSteps').show();
	} else {
		App.Cases.indexSteps(field_name);
	}

	App.Cases.changeSteps(field_name);
};

App.Cases.moveStepUp = function (field_name, step_id) {
	var step = $('#' + field_name + '_table').find('tr.step-' + step_id);
	var sharedStepSetId = step.attr('sharedStepSetId');
	if (sharedStepSetId) {
		var firstOfGroup = step.prev();
		while (firstOfGroup.prevAll().length > 0 &&
					!(firstOfGroup.prev().hasClass('shared-step-name-row') || firstOfGroup.prev().attr('sharedStepSetId') === undefined) )
		{
				firstOfGroup = firstOfGroup.prev();
		}

		if (firstOfGroup.prevAll().length === 0) {
			return; //this group is first in list
		}

		var prevStep = firstOfGroup.prev();
		while (prevStep.prevAll().length > 0 &&
					!(prevStep.prev().hasClass('shared-step-name-row') || prevStep.prev().attr('sharedStepSetId') === undefined) )
		{
			prevStep = prevStep.prev();
		}

		var stillInGroup = true;
		var allNextSteps = firstOfGroup.nextAll();
		firstOfGroup.insertBefore(prevStep);

		allNextSteps.each(function() {
			if (stillInGroup) {
				$(this).insertBefore(prevStep);
				if ($(this).hasClass('shared-step-name-row')) {
					stillInGroup = false;
				}
			}
		});
	} else {
		var prevStep = step.prevAll('tr').first();
		do {
			step.insertBefore(prevStep);
			prevStep = step.prevAll('tr').first();
		} while (prevStep.attr('sharedStepSetId') && prevStep.hasClass('step-container'));
	}
	step.find('textarea').first().focus();
	App.Cases.indexSteps(field_name);
	App.Cases.changeSteps(field_name);
};

App.Cases.moveCurrentStepUp = function (field_name) {
	var step_id = App.Cases.getCurrentStep(field_name);
	if (step_id) {
		App.Cases.moveStepUp(field_name, step_id);
	}
};

App.Cases.getCurrentStep = function (field_name) {
	var focused = $(':focus');
	var step = focused.closest('tr.step-container');
	return step.length > 0 ? step.attr('rel') : null;
};

App.Cases.moveStepDown = function (field_name, step_id) {
	var step = $('#' + field_name + '_table').find('tr.step-' + step_id);
	var sharedStepSetId = step.attr('sharedStepSetId');
	if (sharedStepSetId) {
		if (step.next().nextAll().length === 0) {
			return;
		}
		var groupFooter = step.next();

		var nextStep = groupFooter.next();
		if (nextStep.attr('sharedStepSetId') !== undefined) { //another group, search for group footer
			do {
				nextStep = nextStep.next();
			}
			while (!nextStep.hasClass('shared-step-name-row'));
		}

		groupFooter.insertAfter(nextStep);
		let allPrevs = step.prevAll('tr');
		step.insertAfter(nextStep);
		let stillTheSame = true;
		allPrevs.each(function() {
			if (stillTheSame && $(this).hasClass('step-container') && $(this).attr('sharedStepSetId') === sharedStepSetId) {
				$(this).insertAfter(nextStep);
			} else {
				stillTheSame = false;
			}
		});
	} else {
		var nextStep = step.nextAll('tr').first();
		do {
			step.insertAfter(nextStep);
			nextStep = step.nextAll('tr').first();
		} while (nextStep.attr('sharedStepSetId') && nextStep.hasClass('step-container'));
		if (nextStep.hasClass('shared-step-name-row'))
			step.insertAfter(nextStep);
	}
	step.find('textarea').first().focus();
	App.Cases.indexSteps(field_name);
	App.Cases.changeSteps(field_name);
};

App.Cases.moveCurrentStepDown = function (field_name) {
	var step_id = App.Cases.getCurrentStep(field_name);
	if (step_id) {
		App.Cases.moveStepDown(field_name, step_id);
	}
};

//---------------------------------------------------------------------
// FORM
//---------------------------------------------------------------------

App.Cases.reloadForm = function (suite_id, template_id) {
	$('#templateBusy').show();

	App.Ajax.call({
		target: '/cases/ajax_render_form',

		arguments: $.extend({
			suite_id: suite_id
		}, App.Cases._getFormValues()),

		stop: function stop() {
			$('#templateBusy').hide();
		},

		success: function success(html) {
			$('#form-controls').html(html);
			if (window.location.search.indexOf('/cases/edit/') > -1) {
				$.each($('.textarea-resizable textarea'), function(index, element){
					$(element).addClass('form-fields');
				});
			}

			$.each($('.editor-bindable'), function(_idx, el) {
				App.Editor.bind($(el).data('attribute'));
			});
			$('#template_id').trigger('input');
			$('#milestone_id').parent().removeClass('dropdown-size');
			$('#form .searchable').each(function(ix, v) {
				var dropdown = $(v);
				// Apply the chosen control
				dropdown.chosen();
			});
		},

		error: function error(data) {
			App.Ajax.handleError(data);
		}
	});
};

App.Cases.reloadFormMany = function (suite_id, template_id, various) {
	$('#templateBusy').show();

	App.Ajax.call({
		target: '/cases/ajax_render_form_many',

		arguments: $.extend({
			suite_id: suite_id,
			various: various
		}, App.Cases._getFormValues()),

		stop: function stop() {
			$('#templateBusy').hide();
		},

		success: function success(html) {
			$('#form-controls').html(html);
			$('#milestone_id').parent().removeClass('dropdown-size');
			$('#form .searchable').each(function(ix, v) {
				var dropdown = $(v);
				// Apply the chosen control
				dropdown.chosen();
			});
		},

		error: function error(data) {
			App.Ajax.handleError(data);
		}
	});
};

App.Cases._getFormValues = function () {
	// Read the standard input fields from the form.
	var values = {
		title: $('#title').val(),
		section_id: $('#section_id').val(),
		template_id: $('#template_id').val(),
		type_id: $('#type_id').val(),
		priority_id: $('#priority_id').val(),
		estimate: $('#estimate').val(),
		milestone_id: $('#milestone_id').val(),
		status_id: $('#status_id').val(),
		refs: $('#refs').val()
	};

	// If there's a step field, make sure to synchronize the steps with
	// the form field.
	var steps = $('#form .custom.steps');
	if (steps.length) {
		App.Cases.updateSteps(steps.attr('id'));
	}

	// And handle and append the custom fields. All custom field
	// controls have a 'custom' class in order to to identify them as
	// custom fields.
	$('#form .custom').each(function (ix, e) {
		var t = $(this);
		if (t.attr('type') == 'checkbox') {
			values[t.attr('name')] = t.prop('checked');
		} else {
			var k = t.attr('name');
			values[k] = t.val();
		}
	});

	// Also inject the included fields for the bulk-edit form, if any.
	// They are not used in single-edit mode.
	$.each(values, function (ix, v) {
		var key = ix + '_included';
		var included = $('#' + key);

		// The included field can either be a checkbox, or a hidden
		// input.
		if (included.is('input[type=checkbox]')) {
			values[key] = included.is(':checked');
		} else {
			values[key] = included.val();
		}
	});

	values['template_id_included'] = true; // Always on after change
	return values;
};

//---------------------------------------------------------------------
// NEXT/PREVIOUS
//---------------------------------------------------------------------

App.Cases.loadPrev = function (case_id, location) {
	App.Ajax.call({
		target: '/cases/ajax_get_prev',

		arguments: {
			case_id: case_id
		},

		success: function success(data) {
			if (data.case_id) {
				document.location = Consts.ajaxBaseUrl + '/cases/' + location + '/' + data.case_id;
			} else {
				$('#directionPrev').hide();
				$('#directionPrevDisabled').show();
			}
		},

		error: function error(data) {
			App.Ajax.handleError(data);
		}
	});
};

App.Cases.loadNext = function (case_id, location) {
	App.Ajax.call({
		target: '/cases/ajax_get_next',

		arguments: {
			case_id: case_id
		},

		success: function success(data) {
			if (data.case_id) {
				document.location = Consts.ajaxBaseUrl + '/cases/' + location + '/' + data.case_id;
			} else {
				$('#directionNext').hide();
				$('#directionNextDisabled').show();
			}
		},

		error: function error(data) {
			App.Ajax.handleError(data);
		}
	});
};

App.Cases.hideStepsHint = function () {
	App.Ajax.call({
		target: '/cases/ajax_hide_steps_hint',
		blockUI: false,

		success: function success(data) {
			App.Effects.hide('#stepsHint');
		},

		error: function error(data) {
			// Non-critical error, can be safely ignored.
		}
	});
};

//---------------------------------------------------------------------
// Dynamic Filters
//---------------------------------------------------------------------

App.Cases.serializeForm = function(data) {
	data = data || {};
	$.each($('#form').serializeArray(), function (_, field) {
		data[field.name] = field.value;
	});
	$('#form input:checkbox').each(function() {
		data[this.name] = this.checked;
	});
	return data;
}

App.Cases.isDynamicFilters = function(case_id, success_function){
	var form = App.Cases.serializeForm();
	App.Cases.callAjaxCheckCaseInDynamicFilters(case_id, form).done(function(resp) {
		resp = JSON.parse(resp);
		if (resp.is_added) {
			App.Dialogs.confirm(resp.info, success_function, function() {}, '#confirmDialogOkCancel');
		} else {
			success_function();
		}
	}).fail(function(resp) {
		App.Ajax.handleError(resp);
	})
};

App.Cases.callAjaxCheckCaseInDynamicFilters = function(case_id, form) {
	return App.Ajax.call({
		target: '/cases/ajax_check_case_in_run_dynamic',
		arguments: {
			case_id: case_id,
			form: JSON.stringify(form)
		},
	});

};

App.Cases.callAjaxConfirmMove = function(case_ids, target_section_id) {
	return App.Ajax.call({
		target: '/cases/ajax_move_confirmation',
		arguments: {
			case_ids: case_ids,
			target_section_id: target_section_id
		},
	});
};

App.Cases.callAjaxMove = function(o) {
	return App.Ajax.call({
		target: '/cases/ajax_move',

		arguments: {
			case_ids: o.case_ids,
			section_id: o.section_id,
			after_id: o.after_id
		},

		success: function success(data) {
			App.Cases._dropStop(o.droppable);

			var section = '#grid-' + o.section_id;
			var cases = App.Cases._dropGetRows(o.case_ids);

			if (o.after_id) {
				cases.insertAfter($('#row-' + o.after_id));
			} else {
				cases.insertAfter($('tr.header', section));
			}

			App.Suites.refreshGroupCounts();
		},

		error: function error(data) {
			App.Cases._dropStop(o.droppable);
			App.Ajax.handleError(data);
		}
	});
};

App.Cases.openDeletionDialog = function (entityID, permanentlyDelete, refreshSidebar, normalDelete = false)
{
	var dialogSelector = null;
	dialogSelector = (!normalDelete && permanentlyDelete) ? '#casesDeletionConfirmationDialog' : '#casesDeletionDialog';
	var caseIds = App.Tables.getSelected($('#groups'));
	var isBulk = caseIds.length > 1;
	$('#deletionCaseID').val(entityID);
	$('#refreshSidebar').val(refreshSidebar.toString());

	if (normalDelete) {
		dialogSelector = '#normalCasesDeletionDialog'
		$('#normaldeletionCaseID').val(entityID);
		$('#normalrefreshSidebar').val(refreshSidebar.toString());
	}

	if (!permanentlyDelete) {
		var activeCaseIds = [];
		if (caseIds.length === 0) {
			activeCaseIds.push(entityID);
		} else {
			for (var i = 0; i < caseIds.length; i++) {
				if ($('tr#row-' + caseIds[i] + '.deleted-case').length === 0) {
					activeCaseIds.push(caseIds[i]);
				}
			}
		}

		if (activeCaseIds.length === 0) {
			App.Dialogs.closeTop();
			App.Cases.confirmDeletion(true, true);

			return;
		}
	}

	var hiddenSelector, visibleSelector;
	if (isBulk) {
		hiddenSelector = '.singular';
		visibleSelector = '.plural';
	} else {
		hiddenSelector = '.plural';
		visibleSelector = '.singular';
	}

	$(dialogSelector + ' ' + hiddenSelector).hide();
	$(dialogSelector + ' ' + visibleSelector).show();

	App.Dialogs.closeTop();
	App.Dialogs.open({
		selector: dialogSelector,
		titleColor: '#E40046'
	});
}

App.Cases.confirmDeletion = function(permanentlyDelete, showConfirmation, normalDeletion = false)
{
	var caseIds = App.Tables.getSelected($('#groups'));
	var isBulk = caseIds.length > 1;
	var entityID = normalDeletion ? $('#normaldeletionCaseID').val() : $('#deletionCaseID').val();
	var refreshSidebar = normalDeletion ? $('#normalrefreshSidebar').val() === 'true' : $('#refreshSidebar').val() === 'true';

	if (showConfirmation) {
		if (permanentlyDelete) {
			App.Cases.openDeletionDialog(
				entityID,
				true,
				refreshSidebar
			);
		}

		return;
	}

	if (isBulk) {
		App.Cases.removeMany(
			entityID,
			permanentlyDelete,
			refreshSidebar
		);
	} else {
		App.Cases.remove(
			caseIds[0] || entityID,
			permanentlyDelete,
			refreshSidebar
		);
	}

	App.Dialogs.closeTop();
}

App.Cases.predictive = function (fieldName, step_id, project_id) {
	if (!App.Cases.savedSharedSteps) {
		return;
	}

	const text = $('#stepContent-' + step_id).html().toLocaleLowerCase();
	let similarSets = [];
	if ($.trim(text.length) >= 3) {
		App.Cases.savedSharedSteps.forEach(function(sharedStep) {
			if (sharedStep.title.toLocaleLowerCase().indexOf(text) > -1) {
				$('#want-to-import-' + step_id).addClass('show-it');
				similarSets.push(sharedStep);
			}
		});

		if (similarSets.length > 0) {
			let list = '<select class="form-control form-control-full form-select searchable" onChange="App.Cases.closeImportAndAdd(event, \'' + fieldName + "', '" + step_id + "', " + project_id + ');">';
			list += '<option value="">select</option>';
			similarSets.forEach(function(set) {
				list += '<option value="' + set.id + '">' + set.title + '</option>';
			});
			list += '</select>';
			$('#want-to-import-list-' + step_id).html(list);
		}
		else {
			$('#want-to-import-' + step_id).removeClass('show-it');
			$('#want-to-import-list-' + step_id).html('');
		}
	} else {
		$('#want-to-import-' + step_id).removeClass('show-it');
	}
}

App.Cases.closeImportAndAdd = function (event, fieldName, step_id, project_id) {
	const selectSharedStepsSet = $(event.target).val();
	const sharedStepsSetName = $('option:selected', event.target).text();
	if (selectSharedStepsSet === '') {
		return;
	}

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
			const prev = steps.find('tr.step-' + step_id);
			step.insertAfter(prev);
			prev.remove();

			App.Cases.indexSteps(fieldName);
			App.Cases.changeSteps(fieldName);
		},

		error: function error(data) {
			App.Ajax.handleError(data);
		}
	});
}

App.Cases.expectedInputHandler = function (event, step_id) {
	if (event.keyCode === 13) {
		$('#want-to-share-' + step_id).addClass('show-it');
		return false;
	}

	const text = $('#stepExpected-' + step_id).html();
	if (text.indexOf("\n") === -1 && text.indexOf("\r") === -1) {
		$('#want-to-share-' + step_id).removeClass('show-it');
	}

	return true;
}

//---------------------------------------------------------------------
// COMMENTS & ASSIGN TO
//---------------------------------------------------------------------

App.Cases.prepareCommentDialog = function(config)
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

App.Cases.setCommentType = function(type)
{
	$('#addCommentDialog .addComment, #addCommentDialog .editComment, #addCommentDialog .assignTo, #addCommentDialog .editAssignTo').hide();
	$('#addCommentDialog .' + type).show();
}

App.Cases.assignToAndStatus = function(caseId, action)
{
	var selector = action === 'assignTo' ? '#addCommentAssignTo' : '#addCommentStatus';

	App.Cases.setCommentType(action);

	App.Cases.commentDialog(
		false,
		{ titleSelector: '.' + action },
		{
			show: function()
			{
				$(selector).focus();
			},

			submit: function(change)
			{
				change.case_id = caseId;
				App.Cases.addChangeInline(
					change,
					{
						success: App.Cases.commentSuccess,
						error: App.Cases.commentError
					}
				);
			}
		}
	);
}

App.Cases.commentDialogReset = function(change, options)
{
	App.Validation.hideErrors();

	$('#addCommentErrors, #addCommentComment_display').empty();
	$('#addCommentDialog #attachments, #addCommentComment').val('');

	// Initialize the busy actions
	$('#addCommentSubmit').removeClass('button-busy');
}

// Shows the case comment dialog and invokes a custom action on submit.
App.Cases.commentDialog = function(change, options, callbacks)
{
	change = change || {};
	options = options || {};
	App.Cases.commentDialogReset(change, options);

	$('#addCommentForm').unbind('submit');
	$('#addCommentForm').submit(function(_evt)
	{
		App.Validation.hideErrors();
		$('#addCommentErrors').empty();

		// Read the values from the input fields.
		var values = {
			status: $('#addCommentStatus').val(),
			assignedto: $('#addCommentAssignTo').val(),
			comment: $.trim($('#addCommentComment').val()),
			attachments: $('#addCommentDialog #attachments').val()
		};

		$('#addCommentSubmit').addClass('button-busy');

		// Call the submit action and pass the dialog's input fields.
		callbacks.submit(values);
		return false;
	});

	App.Cases.Attachments.clear();

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
		titleSelector: options.titleSelector || '.addComment',
		focusedControl: '#addCommentComment',
		show: function() {
			if (App.Cases.canAddEditAttachments) {
				var selector = '#addCommentAttachments';
				App.Attachments.initEditorAttachments(
					App.Cases.attachmentsCode,
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

// Callback action. Called when a user has successfully added a change.
App.Cases.commentSuccess = function(data)
{
	if (data.hasOwnProperty('assignedto')) {
		if (data.assignedto) {
			$('#assignedToCaption').text('Assigned to ');
			$('#assignedToName').text(data.assignedto).show();
		} else {
			$('#assignedToCaption').text('Unassigned');
			$('#assignedToName').hide();
		}
	}

	if (data.status) {
		$('#statusName').text(data.status);
	}

	App.Dialogs.close('#addCommentDialog');
}

// Callback action. Called when an error occurred while trying to add
// a new test comment. Shows an AJAX error.
App.Cases.commentError = function(data)
{
	$('#addCommentSubmit').removeClass('button-busy');
	App.Ajax.handleError(data, '#addCommentErrors');
}

// Adds a new comment to a test.
App.Cases.addComment = function(caseId, projectId)
{
	App.Cases.setCommentType('addComment');

	App.Cases.prepareCommentDialog(
		{
			titleSelector: '.editComment',
			case_id: caseId,
			project_id: projectId
		}
	);
}

// Adds a change to a test and updates the corresponding html row on
// the view run page.
App.Cases.addChangeInline = function(change, callbacks)
{
	App.Ajax.call(
	{
		target: '/cases/ajax_add_change_inline',
		arguments: change,

		success: function(data)
		{
			callbacks.success(data);
		},

		error: function(data)
		{
			callbacks.error(data);
		}
	});
}

// Opens the Assign dialog and then assigns the currently selected
// cases to the selected user.
App.Cases.massAssignTo = function()
{
	var caseIds = App.Tables.getSelected($('#groups'));
	if (caseIds.length === 0) {
		return;
	}

	App.Cases.setCommentType('assignTo');
	App.Cases.prepareCommentDialog(
		{
			titleSelector: '.editComment',
			method: function(o) {
				App.Cases.commentDialog(
					false,
					{ titleSelector: '.assignTo' },
					{
						show: o.show,

						submit: function(change)
						{
							change.case_ids = caseIds;
							App.Cases.massAssign(
								change,
								{
									success: App.Cases.commentSuccess,
									error: App.Cases.commentError
								}
							);
						}
					}
				);
			}
		}
	);
}

// Assigns multiple cases and updates the corresponding html rows
// in the case grid.
App.Cases.massAssign = function(change, callbacks)
{
	change.columns = JSON.stringify(App.Tables.columns_for_user);
	change.group_by = App.Tables.group_by;
	change.group_order = App.Tables.group_order;

	App.Ajax.call(
	{
		target: '/cases/ajax_mass_assign',
		arguments: change,

		success: function(data)
		{
			callbacks.success(data);
			var cases = false;

			// Add and replace the individual case rows.
			for (var i = 0, len = data.rows.length; i < len; i++) {
				var testCase = data.rows[i];
				var selector = '#row-' + testCase.id;
				var element = $(selector);
				var style = element.hasClass('oddSelected') ? 'odd' : 'even';

				// Replace the test row and refresh the jQuery object (so
				// that we deal with the row).
				element.replaceWith(testCase.code);
				element = $(selector);

				element.removeClass('oddSelected evenSelected').addClass(style);

				if (cases) {
					cases = cases.add(element);
				} else {
					cases = element;
				}
			}

			App.Effects.add(cases);

			// And then uncheck all header checkboxes and update the
			// mass action buttons.
			$('tr.header input.selectionCheckbox').prop('checked', false);
			App.Cases._updateMassActions();
		},

		error: function(data)
		{
			callbacks.error(data);
		}
	});
}

;

