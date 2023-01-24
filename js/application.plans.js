/*******************************************************************/
/* Plans  */

/* [Permissions checked!] */

App.Plans = new function()
{
	var self = this;

	// The list of available entries for the test plan form etc.
	self.entries = null;
	self.project_id = null;
	self.current_plan_id = null;
	self.runs = null;
	self.filters = null;
	self.dialogDropZone = null;
	self.dialogAttachments = [];
	self._fieldsToUpdate = [
		'description',
		'refs',
		'attachments'
	];
	self.attachmentsCode = {};
	self.attachmentCodeCache = [];
	self.$_editRunAttachments =  $('#addDescriptionAttachments input#attachments');

	self.applyResponsive = function()
	{
		App.Responsive.register(
			'#content',
			750,
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

	//---------------------------------------------------------------
	// FORM: Entries
	//---------------------------------------------------------------

	self.loadEntry = function()
	{
		$('#chooseSuiteForm').unbind('submit');
		$('#chooseSuiteForm').submit(function(e)
		{
			var suite_id = $('#choose_suite_id').val();

			$('#chooseSuiteDialogSubmit').addClass('button-busy');
			self._loadEntryForSuite(
			{
				suite_id: suite_id,
				stop: function()
				{
					$('#chooseSuiteDialogSubmit').removeClass('button-busy');
				}
			});

			return false;
		});

		App.Dialogs.open(
		{
			selector: '#chooseSuiteDialog',
			focusedControl: '#choose_suite_id'
		});
	}

	self._loadEntryForSuite = function(o)
	{
		App.Ajax.call(
		{
			target: '/plans/ajax_render_entry',

			arguments: {
				suite_id: o.suite_id
			},

			stop: function()
			{
				if (o.stop)
				{
					o.stop();
				}
			},

			success: function(data)
			{
				App.Dialogs.closeTop();
				$('#noEntries').hide();
				$('#entries').append(data.code);
				self._addEntry(data.entry_id, o.suite_id);
				self.updateEntriesInput();
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self.loadEntryForSuite = function(suite_id)
	{
		self._loadEntryForSuite({ suite_id: suite_id });
	}

	self._addEntry = function(entry_id, suite_id)
	{
		self.entries[entry_id] = {
			entry_id: entry_id,
			suite_id: suite_id,
			include_all: true,
			case_ids: [],
			assignedto_id: null,
			description: null,
			refs: null,
			attachments: null,
			attachments_files: [],
			config_ids: []
		};
	}

	self.removeEntry = function(entry_id)
	{
		$('#entry-' + entry_id).remove();

		if ($('.plan-entry').length == 0)
		{
			$('#noEntries').show();
		}

		self._removeEntry(entry_id);
		self.updateEntriesInput();
	}

	self._removeEntry = function(entry_id)
	{
		delete self.entries[entry_id];
	}

	self.moveEntryUp = function(entry_id)
	{
		var entry = $('#entry-' + entry_id);
		entry.insertBefore(entry.prev());
		self.updateEntriesInput();
	}

	self.moveEntryDown = function(entry_id)
	{
		var entry = $('#entry-' + entry_id);
		entry.insertAfter(entry.next());
		self.updateEntriesInput();
	}

	self._getEntryValue = function(entry_id, key)
	{
		return self.entries[entry_id][key];
	}

	self._setEntryValue = function(entry_id, key, value)
	{
		self.entries[entry_id][key] = value;
	}

	self._getEntryValueForConfig = function(config_id, key)
	{
		return self.runs[config_id][key];
	}

	self._setEntryValueForConfig = function(config_id, key, value)
	{
        self.runs[config_id][key] = value;
    }

	self.entriesToString = function()
	{
		var t = [];

		$.each(self.entries, function(ix, v)
		{
			var e = $('#entry-' + v.entry_id);
			var entry_clone = $.extend({}, v);
			delete(entry_clone.attachments_files);

			// Add the index based on the position in the form. The
			// order of the arguments ensures that the original entry is
			// not changed.
			var entry = $.extend(
				{
					name: $('.name', e).text(),
					index: e.prevAll().length + 1
				},
				entry_clone,
				{
					runs: self._getEntryRuns(v.entry_id)
				}
			);
			//map to make it conistent with dirty checker
			entry.runs.forEach(function(run){
				run.case_ids = (run.case_ids || []).map(function(id){
					return parseInt(id);
				})
			});

			t.push(entry);
		});

		return JSON.stringify(t);
	}

	self._getEntryRuns = function(entry_id)
	{
		var run_ids = self._getEntryValue(entry_id, 'runs');

		if (!run_ids)
		{
			return [];
		}

		var runs = [];
		$.each(
			run_ids,
			function(ix, run_id)
			{
				var run = self.runs[run_id];
				var row = $('#entryRun-' + run_id);

				runs.push(
				{
					include_dynamic: run.include_dynamic,
					dynamic_filters: run.dynamic_filters,
					config_ids: run.config_ids,
					include_all: run.include_all,
					case_ids: run.case_ids,
					assignedto_id: run.assignedto_id,
					description: run.description,
					refs: run.refs,
					attachments: run.attachments,
					attachments_files: run.attachments_files,
					is_selected:
						$('input.selectionCheckbox', row).is(':checked')
				});
			}
		);

		return runs;
	}

	self._setEntryRuns = function(entry_id, runs)
	{
		var run_ids = [];

		$.each(runs, function(ix, run)
		{
			self.runs[run.uuid] = {
				config_ids: run.config_ids,
				include_all: run.include_all,
				case_ids: run.case_ids,
				assignedto_id: run.assignedto_id,
				description: run.description,
				refs: run.refs,
				attachments: run.attachments,
				attachments_files: run.attachments_files
			};

			run_ids.push(run.uuid);
		});

		self._setEntryValue(entry_id, 'runs', run_ids);
	}

	//---------------------------------------------------------------
	// FORM: Cases
	//---------------------------------------------------------------

	self.selectCases = function(entry_id, suite_id)
	{
		var case_ids = self._getEntryValue(entry_id, 'case_ids');

		var select = new App.Suites.Select(
		{
			project_id: self.project_id,
			suite_id: suite_id,
			case_ids: case_ids,
			columns_custom: false,
			column_area_id: 3, // Area ID for the plan form
			filters: self.filters
		});

		// Bind the form submit event to render the info string and
		// save the test cases/filters afterwards.
		$('#selectCasesSubmit').unbind('click');
		$('#selectCasesSubmit').bind('click',
			function()
			{
				//Need to convert array of string ["1","2","3"] to [1,2,3], to make it consistent with dirty check
				var case_ids = select.getSelection().case_ids.map(
					function (n) {
						return parseInt(n)
					});
				self._selectCasesSubmit(
				{
					entry_id: entry_id,
					suite_id: suite_id,
					case_ids: case_ids,

					success: function(info)
					{
						select.close();
						self.filters = select.filters;
						self._selectCases(
							entry_id,
							case_ids,
							info
						);

						//Unset dynamic filters for whole run to make it consistent with dirty checker
						$.each(self.entries, function(index,entry){
							delete entry.include_dynamic;
							delete entry.dynamic_filters;
						});

						self.updateEntriesInput();
					}
				});

				return false;
			}
		);

		select.open();
	}

	self._selectCasesSubmit = function(o)
	{
		$('#selectCasesSubmit').addClass('button-busy');

		App.Ajax.call(
		{
			target: '/plans/ajax_render_cases_info',
			arguments: {
				entry_id: o.entry_id,
				suite_id: o.suite_id,
				case_ids: o.case_ids,
				project_id: self.project_id,
			},

			stop: function()
			{
				$('#selectCasesSubmit').removeClass('button-busy');
			},

			success: function(html)
			{
				o.success(html);
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self._selectCases = function(entry_id, case_ids, info)
	{
		var entry = $('#entry-' + entry_id);
		$('.suite .includeSpecificLink', entry).html(info);
		$('.suite .includeSpecificLink', entry).show();
		$('.suite .includeAllLink', entry).hide();
		self._setEntryValue(entry_id, 'include_all', false);
		self._setEntryValue(entry_id, 'case_ids', case_ids);
	}

	self.selectCasesAll = function(entry_id)
	{
		var entry = $('#entry-' + entry_id);
		$('.suite .includeAllLink', entry).show();
		$('.suite .includeSpecificLink', entry).hide();
		self._setEntryValue(entry_id, 'include_all', true);
		self.updateEntriesInput();
	}

	self.selectCasesForConfig = function(config_id, suite_id)
	{
		var case_ids = self._getEntryValueForConfig(config_id,
			'case_ids');

		var select = new App.Suites.Select(
		{
			project_id: self.project_id,
			suite_id: suite_id,
			case_ids: case_ids,
			columns_custom: false,
			column_area_id: 3, // Area ID for the plan form
			filters: self.filters
		});

		// Bind the form submit event to render the info string and
		// save the test cases/filters afterwards.
		$('#selectCasesSubmit').unbind('click');
		$('#selectCasesSubmit').bind('click',
			function()
			{
				var case_ids = select.getSelection().case_ids;

				self._selectCasesSubmitForConfig(
				{
					config_id: config_id,
					suite_id: suite_id,
					case_ids: case_ids,

					success: function(info)
					{
						select.close();
						self.filters = select.filters;
						self._selectCasesForConfig(
							config_id,
							case_ids,
							info
						);

						//Set for dirty checker to make hidden input consistent
						self._setEntryValueForConfig(config_id, 'include_dynamic', undefined);
						self._setEntryValueForConfig(config_id, 'dynamic_filters', undefined);
						self.updateEntriesInput();
					}
				});

				return false;
			}
		);

		select.open();
	}

	self._selectCasesSubmitForConfig = function(o)
	{
		$('#selectCasesSubmit').addClass('button-busy');

		App.Ajax.call(
		{
			target: '/plans/ajax_render_cases_info_for_config',
			arguments: {
				config_id: o.config_id,
				suite_id: o.suite_id,
				case_ids: o.case_ids
			},

			stop: function()
			{
				$('#selectCasesSubmit').removeClass('button-busy');
			},

			success: function(html)
			{
				o.success(html);
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self._selectCasesForConfig = function(config_id, case_ids, info)
	{
		var run = $('#entryRun-' + config_id);
		$('span.includeSpecificInfo', run).html(info);
		$('span.includeAll', run).hide();
		$('span.includeDefault', run).hide();
		App.Effects.add($('span.includeSpecific', run));
		self._setEntryValueForConfig(config_id, 'include_all', false);
		self._setEntryValueForConfig(config_id, 'case_ids', case_ids);
	}

	self.selectCasesAllForConfig = function(config_id, suite_id)
	{
		var run = $('#entryRun-' + config_id);
		$('span.includeSpecific', run).hide();
		$('span.includeDefault', run).hide();
		App.Effects.add($('span.includeAll', run));
		self._setEntryValueForConfig(config_id, 'include_all', true);
		self.updateEntriesInput();
	}

	self.clearCasesForConfig = function(config_id, suite_id)
	{
		var run = $('#entryRun-' + config_id);
		$('span.includeSpecific', run).hide();
		$('span.includeAll', run).hide();
		App.Effects.add($('span.includeDefault', run));
		self._setEntryValueForConfig(config_id, 'include_all', null);

		//Clear entry from configs to make it consistent with dirty checker
		self._setEntryValueForConfig(config_id, 'case_ids', []);
		self._setEntryValueForConfig(config_id, 'include_dynamic', undefined);
		self._setEntryValueForConfig(config_id, 'dynamic_filters', undefined);
		self.updateEntriesInput();
	}

	//---------------------------------------------------------------
	// FORM: Name
	//---------------------------------------------------------------

	self.selectName = function(entry_id)
	{
		var entry = $('#entry-' + entry_id);

		self._selectNameDialog(
		{
			name: $('.name', entry).text(),

			submit: function(name)
			{
				App.Dialogs.closeTop();
				$('.name', entry).text(name);
				App.Effects.add($('.name', entry));
				self.updateEntriesInput();
			}
		});
	}

	self._selectNameDialog = function(o)
	{
		// Reset/initialize the dialog
		$('#editNameErrors').hide();
		$('#editName').val(o.name);

		$('#editNameForm').unbind('submit');
		$('#editNameForm').bind('submit', function()
		{
			$('#editNameErrors').hide();
			var name = $.trim($('#editName').val());

			if (!name)
			{
				$('#editNameErrors').show();
			}
			else
			{
				o.submit(name);
			}

			return false;
		});

		App.Dialogs.open({
			focusedControl: '#editName',
			selectedControl: '#editName',
			selector: '#editNameDialog'
		});
	}

	//---------------------------------------------------------------
	// FORM: Assigned To
	//---------------------------------------------------------------

	self.selectAssignedTo = function(entry_id)
	{
		var user_id = self._getEntryValue(entry_id, 'assignedto_id');

		App.Users.selectDialog(
		{
			user_id: user_id,

			submit: function(user)
			{
				App.Dialogs.closeTop();
				self._selectAssignedTo(entry_id, user);
				self.updateEntriesInput();
			}
		});
	}

	self._selectAssignedTo = function(entry_id, user)
	{
		var entry = $('#entry-' + entry_id);
		var assignedto = $('.suite .assignedTo', entry);
		var assignedto_no = $('.suite .assignedToNobody', entry);

		if (user.id)
		{
			assignedto.text(user.name).show();
			assignedto_no.hide();
			App.Effects.add(assignedto);
		}
		else
		{
			App.Effects.replace(assignedto, assignedto_no);
			App.Effects.add(assignedto_no);
		}

		self._setEntryValue(entry_id, 'assignedto_id', parseInt(user.id)); // need to parse it to int, to make it consistent with inital form state for dirtycheck
	}

	self.selectAssignedToForConfig = function(config_id)
	{
		var user_id = self._getEntryValueForConfig(config_id,
			'assignedto_id');

		App.Users.selectDialog(
		{
			user_id: user_id,

			submit: function(user)
			{
				App.Dialogs.closeTop();
				self._selectAssignedToForConfig(config_id, user);
				self.updateEntriesInput();
			}
		});
	}

	self._selectAssignedToForConfig = function(config_id, user)
	{
		if (user.id)
		{
			self._setAssignedToForConfig(config_id, user);
		}
		else
		{
			self._clearAssignedToForConfig(config_id);
		}
	}

	self._setAssignedToForConfig = function(config_id, user)
	{
		var run = $('#entryRun-' + config_id);
		$('span.assignedToDefault', run).hide();
		$('span.assignedToName', run).text(user.name);
		App.Effects.add($('span.assignedTo', run));
		self._setEntryValueForConfig(config_id, 'assignedto_id', user.id);
	}

	self.clearAssignedToForConfig = function(config_id)
	{
		self._clearAssignedToForConfig(config_id);
		self.updateEntriesInput();
	}

	self._clearAssignedToForConfig = function(config_id)
	{
		var run = $('#entryRun-' + config_id);
		$('span.assignedTo', run).hide();
		App.Effects.add($('span.assignedToDefault', run));
		self._setEntryValueForConfig(config_id, 'assignedto_id', null);
	}

	//---------------------------------------------------------------
	// FORM: Description
	//---------------------------------------------------------------

	self._getValueData = function(id, getter)
	{
		var data = {};
		self._fieldsToUpdate.forEach(function (field) {
			data[field] = getter(id, field);
		});
		return data;
	}

	self._getValueFromDialog = function()
	{
		var data = {};
		self._fieldsToUpdate.forEach(function (field) {
			var capitalizedField = field[0].toUpperCase() + field.slice(1);
			if (field !== 'attachments') {
				data[field] = $.trim($('#editRun' + capitalizedField).val());
			}
		});
		return data;
	}

	// deprecated
	self.selectDescription = function(entry_id)
	{
		var description = self._getEntryValue(entry_id, 'description');

		self._selectDescriptionDialog(
		{
			description: description,

			success: function(description)
			{
				self._selectDescription(entry_id, description);
			}
		});
	}

	self.selectRunData = function(entry_id)
	{
		var data = self._getValueData(entry_id, self._getEntryValue);
		var attachments_files = self.dialogAttachments = self._getEntryValue(entry_id, 'attachments_files');

		var request_params = {plan_id: self.current_plan_id, entry_id: entry_id};
		self._initDialogAttachments({
			data: data,
			attachments_files: attachments_files,
			request_params: request_params,
			entity_id: entry_id,
			getter: self._getEntryValue,
			setter: self._setEntryValue
		});

		var editorAttachments = self._initEditorAttachments(
			entry_id,
			self._getEntryValue,
			self._setEntryValue,
			request_params
		);

		if (self.attachmentCodeCache[entry_id]) {
			data.description_display = self.attachmentCodeCache[entry_id];
		}
		self._selectRunDataDialog(
			$.extend({}, data, {
				show: function() {
					self._showDialogAttachments(request_params);
					editorAttachments.enable();
				},
				success: function(data) {
					var values = self.$_editRunAttachments.val();
					if (values) {
						var prevAttachments = self._getEntryValue(entry_id, 'attachments') || [];
						values = JSON.parse(values);
						prevAttachments = prevAttachments.concat(values)
						data['attachments'] = prevAttachments;
					}
					if (data['description']) {
						self.attachmentCodeCache[entry_id] = $('#editRunDescription_display').html();
					}
					self._selectRunData(entry_id, data);
				},
				close: function() {
					editorAttachments.disable();
					self._clearDialogAttachments();
				}
			})
		);
	}

	self._initDialogAttachments = function(config)
	{
		var data = config.data || {},
			attachments_files = config.attachments_files || [],
			request_params = config.request_params || {},
			entity_id = config.entity_id,
			getter = config.getter || function(){},
			setter = config.setter || function(){};

		var dropZoneElement = $('.dialogDropZone');
		var dialogSelector = '#editRunDialog';
		if (dropZoneElement.length) {
			self.dialogDropZone = App.Attachments.init({
				selector: '.dialogDropZone',
				inputParent: dialogSelector,
				itemsParent: dialogSelector,
				inputSelector: 'input#editRunAttachments',
				project_id: self.project_id,
				entity_type: 'entry',
				params: request_params,
				clickable: true,
				success: self._onAttachmentSuccess(entity_id, getter, setter, request_params)
			});
		}

		if (data.attachments && data.attachments.length) {
			self.dialogAttachments = [];
			App.Ajax.call({
				target: '/attachments/ajax_get_entity_list_items',

				arguments: {
					project_id: self.project_id,
					attachment_ids: JSON.stringify(data.attachments)
				},

				success: function success(data) {
					self.dialogAttachments = Object.values(data.data);
					self._showDialogAttachments(request_params);
				},

				error: function error(data) {
					App.Ajax.handleError(data);
				}
			});
		}
	}

	self._onAttachmentSuccess = function(entity_id, getter, setter, request_params)
	{
		return function(file, data) {
			var file_list = getter(entity_id, 'attachments_files');
			file_list.push(data.attachment);
			setter(entity_id, 'attachments_files', file_list);

			self.dialogAttachments = file_list;
			self._showDialogAttachments(request_params);
		}
	}

	self._clearDialogAttachments = function()
	{
		$('#editRunDialog #entityAttachmentList .attachment-list-item').remove();
		$('#editRunDialog #entityAttachmentListAdd').hide();
		$('#editRunDialog #entityAttachmentListEmptyIcon').show();
		this.$_editRunAttachments.val('[]');
	}

	self._showDialogAttachments = function(entry_params)
	{
		if (self.dialogAttachments.length) {
			var attachment_list = $('#editRunDialog #entityAttachmentListAdd');
			$('#editRunDialog #entityAttachmentListEmptyIcon').hide();
			$('#editRunDialog #entityAttachmentListAdd').show();
			self.dialogAttachments.forEach(function (attachment){
				attachment_list.before(attachment);
			});
			App.Attachments.lazyLoad('#editRunDialog #entityAttachmentList', 0.35);
		}
	}

	self.removeAttachment = function (evt)
	{
        if (App.Attachments.dontShowEntityDeleteDialog) {
            App.Attachments.removeFromEntity(
                {
                    'project_id': self.project_id,
                    'entity_type': 'entry',
                    'listParent': '#addDescriptionAttachments .attachment-list-wrapper',
					'success': function success(attachmentIds) {
						Object.keys(self.entries).forEach(function(entry_id){
							self._removeAttachment(self.entries[entry_id], attachmentIds)
						});
						Object.keys(self.runs).forEach(function(run_id){
							self._removeAttachment(self.runs[run_id], attachmentIds)
						});
						self.entriesToString();
					}
                }
            );
        } else {
            App.Dialogs.confirm(
                confirmMessage,
                function() {
                    App.Attachments.removeFromEntity(
                        {
                            'project_id': self.project_id,
                            'entity_type': 'entry',
                            'listParent': '#addDescriptionAttachments .attachment-list-wrapper',
							'success': function success(attachmentIds) {
								Object.keys(self.entries).forEach(function(entry_id){
									self._removeAttachment(self.entries[entry_id], attachmentIds)
								});
								Object.keys(self.runs).forEach(function(run_id){
									self._removeAttachment(self.runs[run_id], attachmentIds)
								});
								self.entriesToString();
							}
                        }
                    );
                },
                null,
                '#deleteEntityAttachmentDialog'
            );
            var dialog = App.Dialogs.getActive();
            dialog.prev().css('background', '#E40046');
            dialog.prev().css('color', '#FFFFFF');
        }

		return false;
	}

	self._removeAttachment = function(entity, attachment_ids)
	{
		if (entity.attachments) {
			entity.attachments = entity.attachments.filter(function(obj) {
				return !attachment_ids.includes(obj.id);
			});
		}
	}

	//deprecated
	self._selectDescriptionDialog = function(o)
	{
		App.Validation.hideErrors();

		// Initialize the dialog
		$('#editRunDescription').val(o.description);
		$('#editRunForm').unbind('submit');
		$('#editRunForm').submit(function(e)
		{
			o.success($.trim($('#editRunDescription').val()));
			App.Dialogs.closeTop();
			return false;
		});

		App.Dialogs.open(
		{
			selector: '#editRunDialog',
			focusedControl: '#editRunDescription',
			selectedControl: '#editRunDescription'
		});
	}

	self._selectRunDataDialog = function(o)
	{
		App.Validation.hideErrors();

		// Initialize the dialog
		App.Editor.projectId = self.project_id;
		App.Editor.entityType = 'entry';
		self._fieldsToUpdate.forEach(function (field) {
			var capitalizedField = field[0].toUpperCase() + field.slice(1);
			if (field === 'description') {
				var html = '';
				if (o[field]) {
					if (o['description_display']) {
						$('#editRun' + capitalizedField + '_display').html(o['description_display']);
						$('#editRun' + capitalizedField + '_display').trigger('keyup');
						return;
					}
					var regex = /\!\[\]\(index.php\?\/attachments\/?get\/?([\w-]+)\)/g;
					var attachmentIds = [];
					match = regex.exec(o[field]);
					while (match != null) {
						attachmentIds.push(match[1]);
						match = regex.exec(o[field]);
					}
					attachmentIds = attachmentIds.map(function (el) { return { id: el, dataId: '' } });
					App.Ajax.call({
						target: '/attachments/ajax_get_entity_list_items',

						arguments: {
							project_id: self.project_id,
							attachment_ids: JSON.stringify(attachmentIds)
						},

						success: function success(data) {
							html = o[field].replace(
								regex,
								function (match, p1) {
									return data.data[p1];
								}
							);
							self.attachmentCodeCache[o[field]] = html;
							$('#editRun' + capitalizedField + '_display').html(html);
							$('#editRun' + capitalizedField + '_display').trigger('keyup');
						},

						error: function error(data) {
							App.Ajax.handleError(data);
						}
					});
				} else {
					$('#editRun' + capitalizedField + '_display').html(html);
					$('#editRun' + capitalizedField + '_display').trigger('keyup');
				}
			} else {
				$.trim($('#editRun' + capitalizedField).val(o[field]));
			}
		});

		$('#editRunForm').unbind('submit');
		$('#editRunForm').submit(function(e)
		{
			o.success(self._getValueFromDialog());
			App.Dialogs.closeTop();
			return false;
		});

		App.Dialogs.open(
		{
			selector: '#editRunDialog',
			focusedControl: '#editRunDescription',
			selectedControl: '#editRunDescription',
			close: o.close,
			show: o.show
		});
	}

	//deprecated
	self._selectDescription = function(entry_id, description)
	{
		var entry = $('#entry-' + entry_id);
		App.Effects.add($('.suite .descriptionLink', entry));
		self._setEntryValue(entry_id, 'description', description);
		self.updateEntriesInput();
	}

	self._selectRunData = function(entry_id, data)
	{
		var entry = $('#entry-' + entry_id);
		App.Effects.add($('.suite .descriptionLink', entry));
		self._fieldsToUpdate.forEach(function(field) {
			self._setEntryValue(entry_id, field, data[field]);
		});
		self.updateEntriesInput();
	}

	//deprecated
	self.selectDescriptionForConfig = function(config_id)
	{
		var description = self._getEntryValueForConfig(config_id,
			'description');

		self._selectDescriptionDialog(
		{
			description: description,

			success: function(description)
			{
				self._selectDescriptionToForConfig(
					config_id,
					description
				);
				self.updateEntriesInput();
			}
		});
	}

	self.selectDataForConfig = function(config_id)
	{
		var runData = self._getValueData(config_id, self._getEntryValueForConfig);
		var attachments_files = self.dialogAttachments = self._getEntryValueForConfig(config_id, 'attachments_files');

		var entry_id = null;
		if (self.entries) {
			Object.keys(self.entries).forEach(function(entry_key){
				var entry = self.entries[entry_key];
				if (entry.runs) {
					entry.runs.forEach(function(run){
						if (run === config_id) {
							entry_id = entry_key;
						}
					})
				}
			});
		}

		var request_params = {
			plan_id: self.current_plan_id,
			entry_id: entry_id,
			config_ids: self._getEntryValueForConfig(config_id, 'config_ids').join(',')
		};
		self._initDialogAttachments({
			data: runData,
			attachments_files: attachments_files,
			request_params: request_params,
			entity_id: config_id,
			getter: self._getEntryValueForConfig,
			setter: self._setEntryValueForConfig
		});

		var editorAttachments = self._initEditorAttachments(
			config_id,
			self._getEntryValueForConfig,
			self._setEntryValueForConfig,
			request_params
		);

		if (self.attachmentCodeCache[config_id]) {
			data.description_display = self.attachmentCodeCache[config_id];
		}
		self._selectRunDataDialog(
			$.extend({}, runData, {
				success: function(data)
				{
					var values = self.$_editRunAttachments.val();
					if (values) {
						var prevAttachments = self._getEntryValueForConfig(config_id, 'attachments') || [];
						values = JSON.parse(values);
						prevAttachments = prevAttachments.concat(values)
						data['attachments'] = prevAttachments;
					}
					if (data['description']) {
						self.attachmentCodeCache[config_id] = $('#editRunDescription_display').html();
					}
					self._selectDataToForConfig(
						config_id,
						data
					);
					self.updateEntriesInput();
				},
				show: function() {
					self._showDialogAttachments(request_params);
					editorAttachments.enable();
				},
				close: function() {
					editorAttachments.disable();
					self._clearDialogAttachments();
				}
			})
		);
	}

	self._initEditorAttachments = function(entity_id, getter, setter, request_params)
	{
		var prevImageDialogUploadSuccess = App.Editor.imageDialogUploadSuccess;
		var prevImageDialogSuccess = App.Editor.imageDialogSuccess;
		var prevRemoveSuccess = App.Attachments.removeSuccess;
		var prevAttachmentContainerParent = App.Editor.attachmentContainerParent;
		var prevInputParent = App.Attachments.inputParent;
		$('#editRunDialog #entityAttachmentListRemove').prop('onclick', null);
		$('#editRunDialog #entityAttachmentListRemoveBottom').prop('onclick', null);
		$('#editRunDialog #entityAttachmentListRemove').on('click', self.removeAttachment);
		$('#editRunDialog #entityAttachmentListRemoveBottom').on('click', self.removeAttachment);

		return {
			enable: function () {
				var selector = '#addDescriptionAttachments';
				App.Attachments.initEditorAttachments(
					App.Tests.attachmentsCode,
					{
						inputParent: selector,
						itemsParent: selector
					}
				);
				App.Editor.entity_id = self.current_plan_id ? self.current_plan_id + '|' : null;
			},
			disable: function() {
				$('#editRunDialog #entityAttachmentListRemove').off('click');
				$('#editRunDialog #entityAttachmentListRemoveBottom').off('click');
				$('#editRunDialog .attachment-list-wrappper').attr('deleteIds', '');
				App.Editor.imageDialogUploadSuccess = prevImageDialogUploadSuccess;
				App.Editor.imageDialogSuccess = prevImageDialogSuccess;
				App.Attachments.removeSuccess = prevRemoveSuccess;
				App.Editor.attachmentContainerParent = prevAttachmentContainerParent;
				App.Attachments.inputParent = prevInputParent;
				App.Editor.entity_id = null;
			}
		}
	}

	//deprecated
	self._selectDescriptionToForConfig = function(config_id,
		description)
	{
		if (description)
		{
			self._setDescriptionForConfig(config_id, description);
		}
		else
		{
			self._clearDescriptionForConfig(config_id);
		}
	}

	self._selectDataToForConfig = function(config_id, data)
	{
		if (data.description || data.refs || data.attachments)
		{
			self._setDataForConfig(config_id, data);
		}
		else
		{
			self._clearDataForConfig(config_id);
		}
	}

	//deprecated
	self._setDescriptionForConfig = function(config_id, description)
	{
		var run = $('#entryRun-' + config_id);
		$('span.descriptionDefault', run).hide();
		$('span.description', run).show();
		App.Effects.add($('span.descriptionChange', run));
		self._setEntryValueForConfig(config_id, 'description',
			description);
	}

	self._setDataForConfig = function(config_id, data)
	{
		var run = $('#entryRun-' + config_id);
		$('span.descriptionDefault', run).hide();
		$('span.description', run).show();
		App.Effects.add($('span.descriptionChange', run));
		self._fieldsToUpdate.forEach(function(field) {
			self._setEntryValueForConfig(config_id, field, data[field]);
		})
	}

	self.clearDescriptionForConfig = function(config_id)
	{
		self._clearDescriptionForConfig(config_id);
		self.updateEntriesInput();
	}

	self.clearDataForConfig = function(config_id)
	{
		self._clearDataForConfig(config_id);
		self.updateEntriesInput();
	}

	//deprecated
	self._clearDescriptionForConfig = function(config_id)
	{
		var run = $('#entryRun-' + config_id);
		$('span.description', run).hide();
		App.Effects.add($('span.descriptionDefault', run));
		self._setEntryValueForConfig(config_id, 'description', null);
	}

	self._clearDataForConfig = function(config_id)
	{
		var run = $('#entryRun-' + config_id);
		$('span.description', run).hide();
		App.Effects.add($('span.descriptionDefault', run));
		self._fieldsToUpdate.forEach(function(field) {
			self._setEntryValueForConfig(config_id, field, null);
		});
	}

	//---------------------------------------------------------------
	// FORM: Configs
	//---------------------------------------------------------------
	self.updateEntriesInput = function()
	{
		$("#entries_str").val(self.entriesToString());
		$("#entries_str").trigger('input');
	}

	self.selectConfigs = function(suite_id, entry_id)
	{
		var selected = self._getEntryValue(entry_id, 'config_ids');

		App.Configs.select(
		{
			selected: selected,
			submit: function(o)
			{
				var success = function()
				{
					$('#selectConfigsSubmit').removeClass('button-busy');
					App.Dialogs.closeTop();
					self.updateEntriesInput();
				};

				var error = function(data)
				{
					$('#selectConfigsSubmit').removeClass('button-busy');
					App.Ajax.handleError(data);
				}

				self._setEntryValue(entry_id, 'config_ids', o.selected);

				// Indicate busy.
				$('#selectConfigsSubmit').addClass('button-busy');

				// In most cases, we only need to update the actual plan
				// entry whose configurations have been edited. But in
				// some cases (a configuration got deleted, e.g.), we
				// need to update all test plan entries.

				if (o.refreshAll)
				{
					self._updateConfigs(
					{
						success: success,
						error: error
					});
				}
				else
				{
					self._updateConfigsForEntry(
					{
						suite_id: suite_id,
						entry_id: entry_id,
						config_ids: o.selected,
						success: success,
						error: error
					});
				}
			},

			cancel: function(o)
			{
				if (o.refreshAll)
				{
					// Even in the cancel case, we need to handle config
					// or group deletes.
					self._updateConfigs(
					{
						error: function(data)
						{
							App.Ajax.handleError(data);
						}
					});
				}
			}
		});
	}

	self._updateConfigs = function(o)
	{
		// We need to update multiple configuration sections, but we
		// only call the success/error events once.
		var completed = false;

		$.each(self.entries, function(ix, v)
		{
			self._updateConfigsForEntry(
			{
				suite_id: v.suite_id,
				entry_id: v.entry_id,
				config_ids: v.config_ids,

				success: function()
				{
					if (!completed)
					{
						completed = true;
						if (o.success)
						{
							o.success();
						}
					}
				},

				error: function(data)
				{
					if (!completed)
					{
						completed = true;
						if (o.error)
						{
							o.error(data);
						}
					}
				}
			});
		});
	}

	self._updateConfigsForEntry = function(o)
	{
		App.Ajax.call(
		{
			target: '/plans/ajax_render_configs',

			arguments:
			{
				suite_id: o.suite_id,
				entry_id: o.entry_id,
				config_ids: o.config_ids,
				runs: JSON.stringify(self._getEntryRuns(o.entry_id))
			},

			success: function(data)
			{
				var entry = $('#entry-' + o.entry_id);

				if (data.runs.length > 0)
				{
					$('.configurations', entry).html(data.code);
					$('.configurations', entry).show();
				}
				else
				{
					$('.configurations', entry).hide();
					$('.configurations', entry).html('');
				}

				self._setEntryRuns(o.entry_id, data.runs);
				o.success();
			},

			error: function(data)
			{
				o.error(data);
			}
		});
	}

	self.confirmEdit = function(plan_id, submit)
	{
		App.Validation.hideErrors();

		// Submit action
		$('#confirmDiffForm').unbind('submit');
		$('#confirmDiffForm').submit(function(e)
		{
			App.Dialogs.closeTop();
			self.disableFormSubmit();
			submit();
			return false;
		});

		// Indicate progress
		$('#accept').addClass('button-busy');

		App.Ajax.call(
		{
			target: '/plans/ajax_render_diff',

			arguments:
			{
				plan_id: plan_id,
				entries_str: self.entriesToString()
			},

			success: function(data)
			{
				$('#accept').removeClass('button-busy');

				if (data.show_diff)
				{
					$('#diff').html(data.code);

					// Show the dialog
					App.Dialogs.open(
					{
						selector: '#confirmDiffDialog'
					});
				}
				else
				{
					// Do not display the diff dialog, submit directly.
					self.disableFormSubmit();
					submit();
				}
			},

			error: function(data)
			{
				$('#accept').removeClass('button-busy');
				App.Ajax.handleError(data);
			}
		});
	}

	self.disableFormSubmit = function()
	{
		$('#accept').hide();
		$('#acceptDisabled').show();
	}

	//---------------------------------------------------------------
	// FORM: Load
	//---------------------------------------------------------------

	self.load = function()
	{
		self._loadDialog(
		{
			submit: function(o)
			{
				self.rerun(o.plan_id);
			}
		});
	}

	self._loadDialog = function(o)
	{
		App.Validation.hideErrors();

		// Initialize the dialog
		$('#loadPlanForm input:radio[name=selectedPlan]').prop('checked', false);

		// Submit action
		$('#loadPlanForm').unbind('submit');
		$('#loadPlanForm').submit(function(e)
		{
			var plan_id = $('#loadPlanForm input:radio[name=selectedPlan]:checked').val();

			if (!plan_id)
			{
				$('#loadPlanErrors').show();
				return false;
			}

			o.submit(
			{
				plan_id: plan_id
			});

			return false;
		});

		// Show the dialog
		App.Dialogs.open(
		{
			selector: '#loadPlanDialog'
		});
	}

	self.loadCompleted = function(project_id)
	{
		$('#showCompleted .showAll').hide();
		$('#showCompleted .busy').show();

		App.Ajax.call(
		{
			target: '/plans/ajax_get_completed',

			arguments:
			{
				project_id: project_id
			},

			success: function(html)
			{
				$('#showCompleted .busy').hide();
				$('#completed').html(html);
			},

			error: function(data)
			{
				$('#showCompleted .busy').hide();
				App.Ajax.handleError(data);
			}
		});
	}

	self.loadActive = function(project_id)
	{
		$('#showActive .showAll').hide();
		$('#showActive .busy').show();

		App.Ajax.call(
		{
			target: '/plans/ajax_get_active',

			arguments:
			{
				project_id: project_id
			},

			success: function(html)
			{
				$('#showActive .busy').hide();
				$('#active').html(html);
			},

			error: function(data)
			{
				$('#showActive .busy').hide();
				App.Ajax.handleError(data);
			}
		});
	}

	//---------------------------------------------------------------
	// EXPORT (CSV/Excel)
	//---------------------------------------------------------------

	self.exportTestsCsv = function(plan_id)
	{
		self._exportTests(plan_id, 'csv');
	}

	self.exportTestsExcel = function(plan_id)
	{
		self._exportTests(plan_id, 'excel');
	}

	self._exportTests = function(plan_id, format)
	{
		var dialog = new App.ExportCsv(
		{
			format: format
		});

		dialog.open();
	}

	//---------------------------------------------------------------
	// RERUN
	//---------------------------------------------------------------

	self.rerun = function(plan_id, return_location)
	{
		App.Runs.rerunDialog(
		{
			submit: function(status_ids, fetch_assignedto)
			{
				App.Page.load(
					'/plans/rerun/{0}/{1}&status_ids={2}&fetch_assignedto={3}',
					plan_id,
					return_location ? return_location : '',
					status_ids.join(','),
					fetch_assignedto ? 1 : 0
				);
			}
		});
	}

	//---------------------------------------------------------------
	// ACTIVITIES
	//---------------------------------------------------------------

	self.loadActivities = function(plan_id, offset)
	{
		let status_id = $('#status_id').val();
		$('#activitiesPaginationBusy').show();

		App.Ajax.call(
		{
			target: '/plans/ajax_render_activities',

			arguments:
			{
				plan_id: plan_id,
				status_id: status_id,
				offset: offset
			},

			success: function(data)
			{
				$('#activities').html(data.activities);
				$('#activitiesPagination').html(data.pagination);
				$('#activitiesPaginationBusy').hide();
			},

			error: function(data)
			{
				$('#activitiesPaginationBusy').hide();
				App.Ajax.handleError(data);
			}
		});
	}

	self.selectActivityDays = function(plan_id)
	{
		App.Charts.selectTimeframe(
		{
			success: function(days)
			{
				self._reloadActivityChart(plan_id, days);
			}
		});
	}

	self._reloadActivityChart = function(plan_id, days)
	{
		App.Ajax.call(
		{
			target: '/plans/ajax_render_activity_chart',

			arguments: {
				plan_id: plan_id,
				days: days
			},

			success: function(html)
			{
				App.Dialogs.closeTop();
				App.Charts.reload(
					App.Charts.activity,
					'#activityContainer',
					html
				);
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	//---------------------------------------------------------------
	// DEFECTS
	//---------------------------------------------------------------

	self.loadDefects = function(plan_id, offset)
	{
		$('#defectsPaginationBusy').show();

		App.Ajax.call(
		{
			target: '/plans/ajax_render_defects',

			arguments:
			{
				plan_id: plan_id,
				offset: offset
			},

			stop: function()
			{
				$('#defectsPaginationBusy').hide();
			},

			success: function(data)
			{
				$('#defects').html(data.defects);
				$('#defectsPagination').html(data.pagination);
				$('#defectsPaginationBusy').hide();
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	//---------------------------------------------------------------
	// DYNAMIC FILTERS
	//---------------------------------------------------------------

	self.dynamicFilters = function(entry_id, suite_id, filters_for_run)
	{
		var case_ids = self._getEntryValue(entry_id, 'case_ids');
		self.suite_id = suite_id;

		if (!filters_for_run)
		{
			self.filters = null;
			self.case_ids = null;
			case_ids = null;
		} else if (filters_for_run === null) {
			self.filters = JSON.parse(filters_for_run);
		}

		var select = new App.Suites.Select(
			{
				project_id: self.project_id,
				suite_id: self.suite_id,
				case_ids: case_ids,
				columns_custom: false,
				column_area_id: 3, // Area ID for the run form
				filters: self.filters,
				is_dynamic: true,
			});

			$('#selectCasesSubmit').unbind('click').bind('click',
			function()
			{
				var case_ids = select.getSelection().case_ids;

				self._selectCasesSubmit(
				{
					entry_id: entry_id,
					suite_id: self.suite_id,
					case_ids: case_ids,

					success: function(data)
					{
						select.close();
						self.filters = select.filters;
						self._selectCases(
							entry_id,
							case_ids,
							data
						);
						self._dynamicFilterApply(entry_id, suite_id, case_ids);
					}
				});

				return false;
}
		);

		select.open();
	}

	self._dynamicFilterApply = function(entry_id, suite_id, case_ids)
	{
		App.Ajax.call(
		{
			target: '/plans/ajax_dynamic_filters_save',
			arguments: {
				project_id: self.project_id,
				entry_id: entry_id,
				suite_id: suite_id,
				filters: self.filters
			},

			start: function()
			{
				$('#filterTestsApply').addClass('button-busy');
			},

			stop: function()
			{
				$('#filterTestsApply').removeClass('button-busy');
			},

			success: function(data)
			{
				$('#entry-' + entry_id + ' .includeAllLink').addClass('hidden');
				$('#entry-' + entry_id + ' .includeSpecificLink').removeClass('hidden');

				$('#entry-' + entry_id + ' .includeSpecificLink').html(
					data.info.replace(
						new RegExp('<strong>[0-9]+</strong>', 'g'),
						'<strong>' + case_ids.length + '</strong>'
					)
				);
				self._setEntryValue(entry_id, 'dynamic_filters', self.filters);
				self._setEntryValue(entry_id, 'include_dynamic', true);
				self._setEntryValue(entry_id, 'include_all', false);
				self._setEntryValue(entry_id, 'case_ids', case_ids);
				self.updateEntriesInput();
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self.dynamicFiltersForConfig = function(config_id, suite_id, filters_for_run)
	{
		if (!filters_for_run)
		{
			self.filters = null;
			self.case_ids = null;
			case_ids = null;
		} else if (filters_for_run === null) {
			self.filters = JSON.parse(filters_for_run);
		}

		var case_ids = self._getEntryValueForConfig(config_id, 'case_ids');
		var select = new App.Suites.Select({
			project_id: self.project_id,
			suite_id: suite_id,
			case_ids: case_ids,
			columns_custom: false,
			column_area_id: 3, // Area ID for the plan form
			filters: self.filters,
			is_dynamic: true,
		});

		// Bind the form submit event to render the info string and
		// save the test cases/filters afterwards.
		$('#selectCasesSubmit').unbind('click').bind('click',
			function()
			{
				var case_ids = select.getSelection().case_ids;
				self._selectCasesSubmitForConfig(
				{
					config_id: config_id,
					suite_id: suite_id,
					case_ids: case_ids,

					success: function(data)
					{
						select.close();
						self.filters = select.filters;
						self._selectCasesForConfig(
							config_id,
							case_ids,
							data
						);
						self._dynamicFilterForConfigApply(config_id, suite_id);
						self.updateEntriesInput();
					},
				});

				return false;
			}
		);
		select.open();
	}

	self._dynamicFilterForConfigApply = function(config_id, suite_id)
	{
		App.Ajax.call(
		{
			target: '/plans/ajax_dynamic_filters_config_save',
			arguments: {
				project_id: self.project_id,
				config_id: config_id,
				suite_id: suite_id,
				filters: self.filters
			},

			start: function()
			{
				$('#filterTestsApply').addClass('button-busy');
			},

			stop: function()
			{
				$('#filterTestsApply').removeClass('button-busy');
			},

			success: function(data)
			{
				var run = $('#entryRun-' + config_id);
				$('span.includeSpecificInfo', run).html(data.info);
				$('span.includeAll', run).hide();
				$('span.includeDefault', run).hide();
				App.Effects.add($('span.includeSpecific', run));
				self._setEntryValueForConfig(config_id, 'dynamic_filters', self.filters);
				self._setEntryValueForConfig(config_id, 'include_dynamic', true);
				self._setEntryValueForConfig(config_id, 'include_all', false);
				self._setEntryValueForConfig(config_id, 'case_ids', data.case_ids);
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self.setPlansPrintViewChange = function(viewType) {

		self._showRunsByPlanId({
			group_id: null,
			format: viewType,
		});
	}

    self.setTestRunsGrouping = function(column, showProgress) {

        App.Tables.setGrouping(column);

        if (showProgress) {
            $('#orderByChange').hide();
            $('#orderBy .busy').show();
        }

        self._showRunsByPlanId({
            group_id: null,
            error: function() {
                $('#orderBy .busy').hide();
                $('#orderByChange').show();
            }
        });
    }

    self._showRunsByPlanId = function(o) {
        var defaults = {
            plan_id: self.plan_id,
            display: self.display,
			group_id: self.group_id,
			format: $('#formatSelection').val(),
        };

        var s = $.extend(defaults, o);
        $('#contentLoading').show();
        $('#groupContainer').hide();
        App.Ajax.call(
        {
            target: '/plans/ajax_render_test_runs',
            arguments: self._getGridArguments(s),
            success: function(html) {
                self._injectRuns(html);
                self._syncToolbar();
                self._setStateUrl();
                $('#contentLoading').hide();
        		$('#groupContainer').show();
            },
            error: function(data) {
                App.Ajax.handleError(data);
            }
        });
    }

	self._getGridArguments = function(o) {
        // Besides the given arguments, we also include the column
        return $.extend({
                group_by: App.Tables.group_by,
                group_order: App.Tables.group_order,
                filters: self.filters
            }, o
        );
    }

	self._injectRuns = function(html) {
        $('#groupContent').remove();
        $('#groupTreeContent').remove();
        $('#ajaxResponse').html(html);
        $('#groupTreeContent').appendTo('#groupTreeContainer');
        $('#groupContent').appendTo('#groupContainer');
    }

	self._syncToolbar = function() {
        // Reset the global order-by link and update the order-by name,
        $('#orderBy .busy').hide();
        $('#orderByChange').removeClass('link link-dashed nolink');

		if (App.Tables.group_by == 'cases:section_id') {
            $('#orderByChange, #orderByEmpty, #addSection').show();
            $('#orderByAsc, #orderByDesc, #orderByReset').hide();
            $('#orderByName, #filterCasesReset, #addSectionDisabled').hide();
			$('#orderByChange').addClass('link link-dashed');

            if (self.filters) {
                $('#filterByReset').removeClass('hidden');
            }
        } else {
            if (App.Tables.group_order !== '') {
                if (App.Tables.group_order == 'desc') {
                    $('#orderByAsc').hide();
                    $('#orderByDesc').show();
                } else {
                    $('#orderByDesc').hide();
                    $('#orderByAsc').show();
                }
			}

            if (App.Tables.group_by !== '') {
                $('#addSection').hide();
                $('#addSectionDisabled').show();
                $('#orderByChange').addClass('nolink');
                $('#orderByName').text(
                    App.Tables.getRunsColumnName(App.Tables.group_by)
                );
                $('#orderByEmpty').hide();
                $('#orderByReset, #orderByChange').show();
                $('#orderByName').show();
			}

            if (self.filters) {
                $('#filterByReset').removeClass('hidden');
            }
        }
    }

    self._getStateOptions = function () {
        // Get the current query string and only override the grouping
        // related options (the remaining options are preserved).

        var options = App.Page.getQueryOptions();

        return App.Page.formatQueryOptions(options);
    }

    self._setStateUrl = function()
	{
		var currentUrl = self._getStateOptions();
		var replacedUrl = currentUrl.replace(
			currentUrl.includes('outline') ? 'outline' : 'details', 
			$('#formatSelection').val()
		);

		App.Page.replaceState(
			'/plans/plot/' + self.plan_id,
			replacedUrl
		);
	}

	self._createFilter = function(e) {
        return new App.Plans.Filter({
            event: e,
            plan_id: self.plan_id,
            filters: self.filters,
            save_filters: true,
            changed: function(filters) {
                self.filters = filters;
            }
        });
    }

	self.filterPlans = function(e) {
        var filter = self._createFilter(e);
        filter.open();
    }

	self.filterPlansReset = function() {
        var filter = self._createFilter();
        filter.reset();
    }
}

//-------------------------------------------------------------------
// FILTERING
//-------------------------------------------------------------------
App.Plans.Filter = function(o) {
	var self = this;

	self.plan_id = o.plan_id;
	self.filters = o.filters;
	self.changed = o.changed;
	self.event = o.event;

	self.open = function(e) {
		var bubble = $('#filterByChange').bubble({
			bubble: '#filterPlansBubble',
			toggleEvent: 'null'
		});

		self._load({
			show: function() {
				self._bind({
					bubble: bubble
				});
				bubble.show(self.event);
			}
		});
	}

	self._load = function(o) {
		var busy = $('#filterBy .busy');

		App.Ajax.call(
		{
			target: '/plans/ajax_render_plans_filter',
			arguments: {
				plan_id: self.plan_id,
				filters: self.filters
			},
			start: function() {
				$('#filterByChange').hide();
				busy.show();
			},
			stop: function() {
				busy.hide();
				$('#filterByChange').show();
			},
			success: function(html) {
				$('#filterPlansContent').html(html);
				o.show();
			},
			error: function(data) {
				App.Ajax.handleError(data);
			}
		});
	}

	self._bind = function(o) {
		$('#filterPlansApply').click(function() {
				self._apply(o);
				return false;
			}
		);

		$('#filterPlansCancel').click(function() {
				self._cancel(o);
				return false;
			}
		);
	}

	self._apply = function(o) {
		var filters = App.Filters.getAll($('#filterPlansContent'));
		App.Ajax.call(
		{
			target: '/plans/ajax_render_plan_filter_info',
			arguments: {
				plan_id: self.plan_id,
				filters: filters,
				save_filters: self.save_filters
			},
			start: function() {
				$('#filterCasesApply').addClass('button-busy');
			},
			stop: function(){
				$('#filterCasesApply').removeClass('button-busy');
			},
			success: function(html) {
				self._sync(filters, html);
				self._changed();
				App.Plans._showRunsByPlanId();
				o.bubble.hide();
			},
			error: function(data) {
				App.Ajax.handleError(data);
			}
		});
	}

	self._sync = function(filters, info) {
		$('#filterByInfo').hide();
		$('#filterByEmpty').hide();
		$('#filterByChange').removeClass('link link-dashed nolink');

		info = $.trim(info);
		if (info) {
			$('#filterByChange').addClass('nolink');
			$('#filterByInfo').html(info);
			$('#filterByInfo, #filterByReset').show();
			$('#filterByReset').removeClass('hidden');
			self.filters = filters;
		} else {
			$('#filterByReset').hide();
			$('#filterByChange').addClass('link link-dashed');
			$('#filterByEmpty').show();
			self.filters = null;
		}
	}

	self._changed = function() {
		self.changed(self.filters);
	}

	self._cancel = function(o) {
		o.bubble.hide();
	}

	self.reset = function() {
		App.Ajax.call(
		{
			target: '/plans/ajax_render_plan_filter_info',
			arguments: {
				plan_id: self.plan_id,
				filters: null,
				save_filters: self.save_filters
			},
			start: function() {
				$('#filterByChange').hide();
				$('#filterBy .busy').show();
			},
			stop: function() {
				$('#filterBy .busy').hide();
				$('#filterByChange').show();
			},
			success: function(html) {
				self._sync(null, '');
				self._changed();
				App.Plans._showRunsByPlanId();
			},
			error: function(data) {
				App.Ajax.handleError(data);
			}
		});
	}
}

App.Plans.changePage = function(offset, plan_id)
{
	App.Ajax.call(
		{
			target: '/plans/ajax_change_page',

			arguments: {
				plan_id: plan_id,
				offset: offset
			},

			success: function(html)
			{
				$('#content-inner-entries').html(html);
				App.Plans.rebuildSidebar();
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
}

App.Plans.rebuildSidebar = function () {
	let stickySidebar = $('#sidebarSticky').find('tbody');
	stickySidebar.html('');
	let contentInnerEntries = $('#content-inner-entries h2');
	contentInnerEntries.each(function(key, item) {
		let href = $(item).attr('id');
		let text = $(item)[0].firstChild.textContent;
		let count = $(item).find('span')[0].textContent;
		let template = '<tr class="dark text-softer">' +
			'<td class="dark"><a id="navigation-' + href + '" class="link-noline" href="#' + href + '">' + text + '</a></td>' +
			'<td class="dark right text-secondary">' + count + '</td>' +
			'</tr>';

			stickySidebar.append(template);
		});
	}

;

