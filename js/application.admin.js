/*******************************************************************/
/* Admin Area  */

/* [Permissions checked!] */

App.Admin = {};

// Switches to the license edit mode
App.Admin.editLicense = function()
{
	App.Hotkeys.unregister('e');
	App.Hotkeys.isForm(true);
	App.Effects.replace('#license', '#form');
	$('#license_key').focus();
}

// A generic function to show the email test dialog.
App.Admin.emailTestDialog = function(o)
{
	App.Validation.hideErrors();

	// Initialize the dialog
	$('#emailAddress').val('');
	$('#emailTestForm').unbind('submit');
	$('#emailTestSubmit').removeClass('button-busy');
	$('#emailTestErrors').css('height', '');
	$('#emailTestSuccess').hide();

	// Submit action
	$('#emailTestForm').submit(function(e)
	{
		$('#emailTestSuccess').hide();
		App.Validation.hideErrors();

		var emailAddress = $.trim($('#emailAddress').val());

		// Signal busy
		$('#emailTestSubmit').addClass('button-busy');

		o.submit(
		{
			emailAddress: emailAddress
		});

		return false;
	});

	// Show the dialog
	App.Dialogs.open(
	{
		selector: '#emailTestDialog',
		focusedControl: '#emailAddress'
	});
}

App.Admin.emailTest = function()
{
	App.Admin.emailTestDialog(
	{
		submit: function(o)
		{
			App.Ajax.call(
			{
				target: '/admin/site_settings/ajax_send_test_email',

				arguments:
				{
					email: o.emailAddress
				},

				success: function(data)
				{
					$('#emailTestSubmit').removeClass('button-busy');
					$('#emailTestSuccess').show();
				},

				error: function(data)
				{
					$('#emailTestSubmit').removeClass('button-busy');
					App.Ajax.handleError(data, '#emailTestErrors');
				}
			});
		}
	});
}

App.Admin.onActionChange = function(o)
{
	var t = $(o.element);
	var action = parseInt(t.val());
	var perm = parseInt($('#permissions').val());

	if (!t.is(':checked'))
	{
		$('#permissions').val(perm & ~action);

		if (o.childId)
		{
			// Also uncheck the child action.
			for (var k in o.childId){
				var child = $('#' + o.childId[k]);

				if (child.is(':checked'))
				{
					child.prop('checked', false);
					child.trigger('input');
					App.Admin.onActionChange({element: child.get(0)});
				}
			}

		}
	}
	else
	{
		$('#permissions').val(perm | action);

		if (o.parentId)
		{
			// Also check the parent action.
			var parent = $('#' + o.parentId);
			if (!parent.is(':checked'))
			{
				parent.prop('checked', true);
				parent.trigger('input');
				App.Admin.onActionChange({element: parent.get(0)});
			}
		}
	}
}

App.Admin.setActive = function(isActive)
{
	var userId = App.Dropdowns.getTag('#activeDropdown');

	App.Ajax.call(
	{
		target: '/admin/users/ajax_set_active',

		arguments:
		{
			user_id: userId,
			is_active: isActive
		},

		success: function(data)
		{
			var userActive = $('.active', $('#user-' + userId));
			if (isActive)
			{
				userActive.html($('#active').html());
			}
			else
			{
				userActive.html($('#inactive').html());
			}
			App.Effects.add(userActive);
		},

		error: function(data)
		{
			App.Ajax.handleError(data);
		}
	});
}

App.Admin.setRole = function(roleId)
{
	var userId = App.Dropdowns.getTag('#roleDropdown');

	App.Ajax.call(
	{
		target: '/admin/users/ajax_set_role',

		arguments:
		{
			user_id: userId,
			role_id: roleId
		},

		success: function(data)
		{
			var userRole = $('.role', $('#user-' + userId));
			userRole.html($('.name', $('#role-' + roleId )).html());
			App.Effects.add(userRole);
		},

		error: function(data)
		{
			App.Ajax.handleError(data);
		}
	});
}

App.Admin.setUserAccess = function(accessId)
{
	var userId = App.Dropdowns.getTag('#userAccessDropdown');

	if (!accessId)
	{
		var display = '-';
		var value = '';
	}
	else
	{
		var display = $('#access-' + accessId).html();
		var value = accessId;
	}

	$('#useraccess-' + userId).val(value).trigger('input'); // The hidden input
	$('.access', $('#user-' + userId)).html(display);
}

App.Admin.setGroupAccess = function(accessId)
{
	var groupId = App.Dropdowns.getTag('#groupAccessDropdown');

	if (!accessId)
	{
		var display = '-';
		var value = '';
	}
	else
	{
		var display = $('#access-' + accessId).html();
		var value = accessId;
	}

	$('#groupaccess-' + groupId).val(value).trigger('input'); // The hidden input
	$('.access', $('#group-' + groupId)).html(display);
}

App.Admin._updateUserTimer = null;

App.Admin.updateUserPreview = function()
{
	if (App.Admin._updateUserTimer !== null)
	{
		clearTimeout(App.Admin._updateUserTimer);
		App.Admin._updateUserTimer = null;
	}

	App.Admin._updateUserTimer = setTimeout(
		App.Admin._updateUserPreview,
		1000
	);
}

App.Admin._updateUserPreview = function()
{
	App.Ajax.call(
	{
		target: '/admin/users/ajax_render_users_preview',
		blockUI: false,

		arguments:
		{
			users: $('#users').val()
		},

		success: function(html)
		{
			$('#preview').html(html);
			App.Admin._updateUserTimer = null;
		},

		error: function(data)
		{
			App.Ajax.handleError(data);
			App.Admin._updateUserTimer = null;
		}
	});
}

App.Admin.addUsers = function()
{
	$('#usersSubmit').addClass('button-busy');

	App.Ajax.call(
	{
		target: '/admin/users/ajax_render_users_dialog',
		blockUI: false,

		arguments:
		{
			users: $('#users').val()
		},

		success: function(data)
		{
			$('#usersSubmit').removeClass('button-busy');

			$('#addUsersTable').html(data.code);
			$('#addUsersReturn').hide();
			$('#addUsersReturnDisabled').show();
			$('#addUsersClose').hide();
			$('#addUsersCloseDisabled').show();

			App.Dialogs.open(
			{
				selector: '#addUsersDialog'
			});

			if (data.users && data.users.length > 0)
			{
				App.Admin._addUsers(
					data.users,
					function()
					{
						$('#addUsersReturnDisabled').hide();
						$('#addUsersReturn').show();
						$('#addUsersCloseDisabled').hide();
						$('#addUsersClose').show();
					}
				);
			}
		},

		error: function(data)
		{
			$('#usersSubmit').removeClass('button-busy');
			App.Ajax.handleError(data);
		}
	});
}

App.Admin._addUsers = function(users, finish)
{
	App.Admin._addUser(users, 1, finish);
}

App.Admin._addUser = function(users, index, finish)
{
	App.Validation.hideErrors();

	var user = users[index - 1];
	var row = $('#userDialog-' + index);
	$('.busy', row).show();

	var rowHeight = row.outerHeight();
	var scrollTop = (index - 1) * rowHeight;
	if (scrollTop == 0 ||
		scrollTop >= $('#addUsersTable').innerHeight() - 10)
	{
		$('#addUsersTable').scrollTop(scrollTop - 75);
	}

	App.Ajax.call(
	{
		target: '/admin/users/ajax_add',

		arguments:
		{
			name: user.name,
			email: user.email,
			language: $('#language').val(),
			locale: $('#locale').val(),
			timezone: $('#timezone').val(),
			role_id: $('#role_id').val(),
			group_ids: App.Controls.Checkboxes.getValues('group_ids'),
			project_ids: App.Controls.Checkboxes.getValues('project_ids'),
			invite: $('#invite').is(':checked'),
			is_mfa_enabled: $('#is_mfa_enabled').is(':checked')
		},

		success: function(data)
		{
			$('.busy', row).hide();
			$('.success', row).show();

			if (index == 1)
			{
				// Make sure to reload the goals for the current user
				// for trial onboarding, if necessary.
				if (App.Users.hasGoals())
				{
					App.Users.reloadGoals();
				}
			}

			if (index < users.length)
			{
				App.Admin._addUser(users, index + 1, finish);
			}
			else
			{
				$('#addUsersSuccess').show();
				if (finish)
				{
					finish();
				}
			}
		},

		error: function(data)
		{
			$('.busy', row).hide();
			$('.error', row).show();
			App.Ajax.handleError(data, '#addUsersErrors');

			if (finish)
			{
				finish();
			}
		}
	});
}

App.Admin.showUserExtras = function()
{
	$('#extrasBox').hide();
	$('#extras').show();
}

App.Admin.onInviteClicked = function(invite, radio)
{
	var showPassword = false;
	if (invite)
	{
		if (!radio.checked)
		{
			showPassword = true;
		}
	}
	else
	{
		if (radio.checked)
		{
			showPassword = true;
		}
	}

	if (showPassword)
	{
		App.Effects.show('#passwordContainer');
	}
	else
	{
		App.Effects.hide('#passwordContainer');
	}
}

App.Admin.editUiscript = function(uiscript_id)
{
	$('#uiscriptEdit').addClass('button-busy');

	App.Ajax.call(
	{
		target: '/admin/uiscripts/ajax_edit',

		arguments:
		{
			uiscript_id: uiscript_id,
			config: $('#config').val(),
			is_active: $('#is_active').is(':checked')
		},

		success: function(data)
		{
			$('#uiscriptEdit').removeClass('button-busy');
			$('#config').focus();
		},

		error: function(data)
		{
			$('#uiscriptEdit').removeClass('button-busy');
			App.Ajax.handleError(data);
		}
	});
}

App.Admin.loadExports = function()
{
	$('#showExports .showAll').hide();
	$('#showExports .busy').show();

	App.Ajax.call(
	{
		target: '/admin/subscription/ajax_get_exports',

		success: function(html)
		{
			$('#showExports .busy').hide();
			$('#trExports').html(html);
		},

		error: function(data)
		{
			$('#showExports .busy').hide();
			App.Ajax.handleError(data);
		}
	});
}

App.Admin.passwordPolicyChanged = function()
{
	if ($('#password_policy').val() == 'custom')
	{
		$('#passwordPolicyCustom').show();
		$('#passwordPolicyDescription').show();
	}
	else
	{
		$('#passwordPolicyCustom').hide();
		$('#passwordPolicyDescription').hide();
	}
}

App.Admin.ipAdd = function(ip)
{
	var list = $.trim($('#ip_policy').val());
	$('#ip_policy').val(list + "\n" + ip);
	$('#ip_policy').focus();
}

App.Admin.onProjectsClicked = function(all, radio)
{
	var showProjects = false;
	if (all)
	{
		if (!radio.checked)
		{
			showProjects = true;
		}
	}
	else
	{
		if (radio.checked)
		{
			showProjects = true;
		}
	}

	if (showProjects)
	{
		App.Effects.show('#includeSpecificContainer');
	}
	else
	{
		App.Effects.hide('#includeSpecificContainer');
	}
}

App.Admin.showTemplateFields = function()
{
	$('#showFields').hide();
	$('#fields').show();
}

App.Admin.Integration  = new function()
{
	var self = this;

	self.showDefectTemplate = function()
	{
		$('#defectTemplateLink').hide();
		$('#defectTemplateContainer').show();
		$('#defect_template').val('%tests:comment%\n\n%tests:details%');
		$('#defect_template').focus();
		$('#defect_template').trigger("input");
	}

	self.addDefectField = function()
	{
		App.Validation.hideErrors();
		$("#addDefectFieldItems").val(
			$("#addDefectFieldItems option:first").val()
		);

		// Submit action
		$('#addDefectFieldForm').unbind('submit');
		$('#addDefectFieldForm').submit(function(e)
		{
			App.Dialogs.closeTop();
			var field = $('#addDefectFieldItems').val();
			$('#defect_template').insertAtCaret('%' + field + '%');
			$('#defect_template').trigger("input");
			return false;
		});

		App.Dialogs.open(
		{
			selector: '#addDefectFieldDialog'
		});
	}

	self.onDefectPluginChange = function()
	{
		var plugin = $('#defect_plugin').val();
		$('#defect_config').val('');

		if (plugin)
		{
			$('#defectBusy').show();

			App.Ajax.call(
			{
				target: '/admin/integration/ajax_get_defect_config',

				arguments:
				{
					plugin: plugin
				},

				stop: function()
				{
					$('#defectBusy').hide();
				},

				success: function(data)
				{
					$('#defect_config').val(data.config);
					if (plugin == 'Jira_REST' || plugin == 'Jira')
					{
						$('#defectJiraBanner').show();
					}
					else
					{
						$('#defectJiraBanner').hide();
					}
				},

				error: function(data)
				{
					App.Ajax.handleError(data);
				}
			});
		}
		else
		{
			$('#defectJiraBanner').hide();
		}
	}

	self.onReferencePluginChange = function()
	{
		var plugin = $('#reference_plugin').val();
		$('#reference_config').val('');

		if (plugin)
		{
			$('#referenceBusy').show();

			App.Ajax.call(
			{
				target: '/admin/integration/ajax_get_reference_config',

				arguments:
				{
					plugin: plugin
				},

				stop: function()
				{
					$('#referenceBusy').hide();
				},

				success: function(data)
				{
					$('#reference_config').val(data.config);
					if (plugin == 'Jira_REST' || plugin == 'Jira')
					{
						$('#referenceJiraBanner').show();
					}
					else
					{
						$('#referenceJiraBanner').hide();
					}
				},

				error: function(data)
				{
					App.Ajax.handleError(data);
				}
			});
		}
		else
		{
			$('#referenceJiraBanner').hide();
		}
	}

	self.hideJiraConfig = function()
	{
		App.Ajax.call(
		{
			target: '/admin/integration/ajax_hide_jira_config',
			blockUI: false,

			success: function(data)
			{
				$('#jiraConfig').hide();
			},

			error: function(data)
			{
				// Non-critical error, can be safely ignored.
			}
		});
	}

	self.configureJira = function()
	{
		App.Validation.hideErrors();

		// Change version action
		$('#jiraIntegrationVersion').change(function () {
			var version = $(this).val(),
					jiraServer = $('.jira-server'),
					jiraCloud = $('.jira-cloud');

			if (version === '6') {
				jiraCloud.removeClass('hidden');
				jiraServer.addClass('hidden');
			} else {
				jiraCloud.addClass('hidden');
				jiraServer.removeClass('hidden');
			}
		});

		// Submit action
		$('#jiraIntegrationForm').unbind('submit');
		$('#jiraIntegrationForm').submit(function(e)
		{
			App.Validation.hideErrors();
			self._configureJira();
			return false;
		});

		// Reset dialog
		$('#jiraIntegrationAddress').val('');
		$('#jiraIntegrationVersion').val('6').change();
		$('#jiraIntegrationUser').val('');
		$('#jiraIntegrationPassword').val('');
		$('#jiraIntegrationDefects').prop('checked', true);
		$('#jiraIntegrationRefs').prop('checked', true);

		App.Dialogs.open(
		{
			selector: '#jiraIntegrationDialog'
		});
	}

	self._configureJira = function()
	{
		$('#jiraIntegrationSubmit').addClass('button-busy');

		App.Ajax.call(
		{
			target: '/admin/integration/ajax_get_jira_options',

			arguments:
			{
				address: $('#jiraIntegrationAddress').val(),
				version: $('#jiraIntegrationVersion').val(),
				user: $('#jiraIntegrationUser').val(),
				secret: $('#jiraIntegrationPassword').val(),
				enable_defects: $('#jiraIntegrationDefects').is(':checked'),
				enable_refs: $('#jiraIntegrationRefs').is(':checked')
			},

			stop: function()
			{
				$('#jiraIntegrationSubmit').removeClass('button-busy');
			},

			success: function(data)
			{
				if ($('#jiraIntegrationDefects').is(':checked'))
				{
					$('#defect_id_url').val(data.defect_id_url);
					$('#defect_add_url').val(data.defect_add_url);
					$('#defect_plugin').val(data.defect_plugin).trigger('liszt:updated');
					$('#defect_config').val(data.defect_config);
					$('#defectJiraBanner').show();
				}

				if ($('#jiraIntegrationRefs').is(':checked'))
				{
					$('#reference_id_url').val(data.reference_id_url);
					$('#reference_add_url').val(data.reference_add_url);
					$('#reference_plugin').val(data.reference_plugin).trigger('liszt:updated');
					$('#reference_config').val(data.reference_config);
					$('#referenceJiraBanner').show();
				}

				$.each(data.user_variables, function(ix, field)
				{
					// If the field already exists, we need to update
					// the fallback. Otherwise, we need to add it.
					if (App.Users.hasField(field.name))
					{
						App.Users.editFieldNoDialog(field);
					}
					else
					{
						App.Users.addFieldNoDialog(field);
					}
				});

				App.Dialogs.closeTop();
			},

			error: function(data)
			{
				App.Ajax.handleError(data, '#jiraIntegrationErrors');
			}
		});
	}

    self.connectAssembla = function() {
		self._findAssemblaCluster(function(clusterName) {
			Cookies.set('asmclustername', clusterName);
			$('#asmOauthConnected').val('1');
			let $button = $('.asm-connect-btn');
			let asmAppUrl = $button.data('authurl')
					.replace('%s', $button.data(clusterName + 'apisubdomain'))
					.replace('%s', $button.data(clusterName + 'clientid'))
					+ '&redirect_uri='
					+ $button.data('redirect-url');
			window.open(
				asmAppUrl,
				'',
				"width=980,height=800"
			);
			$('#asmIntegrationForm .button-cancel').addClass('disabled');
			$('#asmIntegrationForm').submit();

			setTimeout(function() {
				$('#asmIntegrationForm .button-cancel').removeClass('disabled');
				},
				5000
			);

			return false;
		});
	}

	self._findAssemblaCluster = function(cb) {
		let assemblaPortfolio = $('#asmAppUrl').val();
		let $assembleIntegrationSubmit = $('#asmIntegrationSubmit');
		$assembleIntegrationSubmit.addClass('button-busy');
		App.Ajax.call({
			target: '/admin/integration/ajax_get_assembla_cluster_name',
			arguments: {
				address: assemblaPortfolio,
				space: $('#asmSpace').val(),
			},
			success: function(data) {
				if (data.result === true) {
					let lowerCaseClusterName = data['x-cluster-name'].toLowerCase();
					let urlProperties = $('<a>', { href: assemblaPortfolio });
					let dotSeparatorSign = '.';
					let slashSeparatorSign = '/';
					$('#asmApiEndpoint').val(
						urlProperties.prop('protocol')
						+ slashSeparatorSign
						+ slashSeparatorSign
						+ (lowerCaseClusterName === 'us' ? 'api' : 'eu-api')
						+ dotSeparatorSign
						+ urlProperties
							.prop('hostname')
							.split(dotSeparatorSign)
							.slice(1)
							.join(dotSeparatorSign)
						+ slashSeparatorSign
					);
					App.Validation.hideErrors();
					$assembleIntegrationSubmit.removeClass('button-busy');
					cb && cb(lowerCaseClusterName);

					App.Ajax.call({
						target: '/mysettings/ajax_set_oauth_organization_url',
						arguments: {
							oauth_organization_url: assemblaPortfolio
						},
					});
				}
			},
			error: function(data) {
				App.Validation.hideErrors();
				$assembleIntegrationSubmit.removeClass('button-busy');
				App.Ajax.handleError(data, '#asmIntegrationErrors');
			},
		});

		return false;
	}

/* Assembla configuration Starts */
    self.configureAssembla = function() {

		App.Validation.hideErrors();

		App.Dialogs.open(
		{
			selector: '#assemblaIntegrationDialog'
		});

		// Submit action
		let $asmIntegrationForm = $('#asmIntegrationForm');
		$asmIntegrationForm.unbind('submit').submit(function(e) {
			e.preventDefault();
			e.stopPropagation();

			self._findAssemblaCluster(self._configureAssembla);
		});

		$('#asmToken, #asmSecretKey').val('');
		$('#asmIntegrationDefects, #asmIntegrationRefs').prop('checked', true);

        App.Dialogs.open({
            selector: '#assemblaIntegrationDialog'
        });
    }

	self._configureAssembla = function() {
		$('#asmIntegrationSubmit').addClass('button-busy');
		var oauthConnected = parseInt($('#asmOauthConnected').val());
		var asmOptionsUrl = oauthConnected > 0 ? 'oauth' : 'api_key';
		App.Ajax.call(
		{
			target: '/admin/integration/ajax_get_assembla_options_'+asmOptionsUrl,
			arguments:
			{
				address: $('#asmAppUrl').val(),
				user: $('#asmToken').val(),
				secret: $('#asmSecretKey').val(),
				enable_defects: $('#asmIntegrationDefects').is(':checked'),
				enable_refs: $('#asmIntegrationRefs').is(':checked'),
				asm_space: $('#asmSpace').val(),
				asm_api_endpoint: $('#asmApiEndpoint').val()
			},

			stop: function() {
				$('#asmIntegrationSubmit').removeClass('button-busy');
			},

			success: function(data)
			{
				if ($('#asmIntegrationDefects').is(':checked'))
				{
					$('#defect_id_url').val(data.defect_id_url);
					$('#defect_add_url').val(data.defect_add_url);
					$('#defect_plugin').val(data.defect_plugin).trigger('liszt:updated');
					$('#defect_config').val(data.defect_config);
				}

				if ($('#asmIntegrationRefs').is(':checked'))
				{
					$('#reference_id_url').val(data.reference_id_url);
					$('#reference_add_url').val(data.reference_add_url);
					$('#reference_plugin').val(data.reference_plugin).trigger('liszt:updated');
					$('#reference_config').val(data.reference_config);
				}

				App.Users.removeField('jira_email');
				App.Users.removeField('jira_token');
				$('#userField-jira_email, #userField-jira_token').remove();

				var asmTokenVal = $('#asmToken').val();

				if (asmTokenVal == '') {
					App.Users.removeField('key');
					App.Users.removeField('secret');
					$('#userField-key, #userField-secret').remove();
				} else {
					App.Users.removeField('user_access_token');
					$('#userField-user_access_token').remove();
				}

				$.each(data.user_variables, function(ix, field) {
					// If the field already exists, we need to update
					// the fallback. Otherwise, we need to add it.
					if (App.Users.hasField(field.name))
					{
						App.Users.editFieldNoDialog(field);
					}
					else
					{
						App.Users.addFieldNoDialog(field);
					}
				});

				App.Dialogs.closeTop();
			},
			error: function(data) {
			    App.Ajax.handleError(data, '#asmIntegrationErrors');
			}
		});
	}
}

App.Admin.hideUIScriptNote = function()
{
	App.Effects.hide('#uiscriptsDisabled');

	App.Ajax.call(
	{
		target: '/admin/custom/ajax_hide_uiscript_note',
		blockUI: false,

		error: function(data)
		{
			// Ignore possible errors
		}
	});
}

App.Admin.setSuiteMode = function(el)
{
	$(el).prop('checked', true);
}

App.Admin.addExampleProject = function()
{
	App.Admin.addExampleProjectDialog(
	{
		submit: function(name)
		{
			$('#addProjectSubmit').addClass('button-busy');

			App.Ajax.call(
			{
				target: '/admin/projects/ajax_add_example',

				arguments:
				{
					name: name
				},

				stop: function()
				{
					$('#addProjectSubmit').removeClass('button-busy');
				},

				success: function(data)
				{
					App.Dialogs.closeTop();
					App.Page.load('projects/overview/' + data.id);
				},

				error: function(data)
				{
					App.Ajax.handleError(data, '#addProjectErrors');
				}
			});
		}
	});
}

App.Admin.addExampleProjectDialog = function(o)
{
	App.Validation.hideErrors();

	// Initialize the dialog
	$('#addProjectName').val('');
	$('#addProjectForm').unbind('submit');
	$('#addProjectSubmit').removeClass('button-busy');

	$('#addProjectForm').submit(function(e)
	{
		App.Validation.hideErrors();
		var name = $.trim($('#addProjectName').val());
		o.submit(name);
		return false;
	});

	App.Dialogs.open(
	{
		selector: '#addProjectDialog'
	});
}

App.Admin.cancelRestoration = function() {
  App.Ajax.call(
      {
        target: '/admin/site_settings/ajax_cancel_backup_restoration',

        success: function(data) {
          App.Effects.hide('#restoreBackup');
          $('.restore_button').attr("disabled", false);
        },

        error: function(data) {
          App.Ajax.handleError(data);
        },
      });
};

App.Admin.showCancelRestoration = function(){
  $('#content-inner').prepend($('#restoreBackup'));
  App.Effects.show('#restoreBackup');
};

App.Admin.requestRestoration = function(restoreDate) {
  App.Ajax.call(
      {
        target: '/admin/site_settings/ajax_request_backup_restoration',
        arguments: {
		restoredate: restoreDate,
	},
        success: function(data) {
          if (data.result) {
            App.Dialogs.closeTop();
            App.Admin.showCancelRestoration();
              $('.restore_button').attr('disabled','disabled');
          }
        },

        error: function(data) {
          App.Ajax.handleError(data);
        },
      });
};

App.Admin.requestBackupDialog = function(message, confirm, extra, extra2, restoreDate) {
  let d = $('#backupDialog');
  // Reset the OK button (disable) and register for the button/dialog
  // events.

  let checkboxDiv = $('.checkbox', d);
  let ok = $('.dialog-action-default', d);
  let confirmText = $(':text', d).val('');
  ok.addClass('button-ok-disabled button-disabled');
  ok.unbind('click').bind('click', function(e) {
    if ($(this).hasClass('button-disabled')) {
      return;
    }
    App.Admin.requestRestoration(restoreDate);
  });

  let confirm_msg = '<strong>' + langc(confirm) + '</strong>';

  checkboxDiv.find('.dialog-confirm').html(confirm_msg);
  checkboxDiv.find('input').prop('disabled', false);
  checkboxDiv.find('input').prop('checked', false);
  let checkbox = checkboxDiv.find(':checkbox');

  $('.dialog-message', d).html(message);
  $('.dialog-extra', d).html(extra);
  $('.dialog-extra2', d).html(extra2);

  // Open the dialog and execute init callback from the caller, if any.
  // Can be used to add an extra
  App.Dialogs.open({
    selector: '#backupDialog',
    titleColor: '#D04437'
  });

  function checkConfirm() {
    if (checkbox.is(':checked') && confirmText.val() === 'restore backup') {
      ok.removeClass('button-ok-disabled button-disabled');
    } else {
      ok.addClass('button-ok-disabled button-disabled');
    }
  }

  checkbox.click(checkConfirm);
  confirmText.keyup(checkConfirm);
};

App.Admin.enableBySelector = function (selector) {
	$(selector).removeClass('disabled');
}

App.Dialogs.enterpriseDialog = function() {
	App.Validation.hideErrors();

	// Initialize the dialog
	$('#emailSendError').hide().find('div').val('');
	$('#emailSendErrordiv').removeClass('message-error-div');

	App.Dialogs.open({
		selector : '#enterpriseDialog',
		title : 'Get TestRail Enterprise'
	});
}

App.Admin.sendEmailToTR = function() {
	$('#enterpriseCallToAction').removeClass('button-arrow');
	$('#enterpriseCallToAction').addClass('button-busy');
	App.Ajax.call({
		target: 'enterprise/ajax_send_request_quote',
		success: function(data) {
			App.Dialogs.close('#enterpriseDialog');
			document.location = Consts.ajaxBaseUrl + 'enterprise/confirm';
		},
		error: function(data) {
			$('#enterpriseCallToAction').removeClass('button-busy');
			$('#enterpriseCallToAction').addClass('button-ok');
			$('#emailSendError').addClass('message-error');
			$('#emailSendErrordiv').addClass('message-error-div');
			App.Ajax.handleError(data, '#emailSendError');
		},
	});
}

App.Admin.manageProjectAdmin = function () {
	$('#enable_project_admin input').prop(
		'disabled',
		$('#is_project_admin').prop('checked') === false
	);
}

App.Admin.setUserProjectAccess = function(accessId) {
	var projectId = App.Dropdowns.getTag('#userProjectAccessDropdown');
	if (!accessId) {
		var display = '-';
		var value = '';
	} else {
		var display = $('#access-' + accessId).html();
		var value = accessId;
	}
	$('#userprojectaccess-' + projectId).val(value).trigger('input');
	$('.access', $('#userproject-' + projectId)).html(display);
}
App.Admin.Ok = function() {
	if ($('#dialog_brand_logo_flag').val() === 'custom') {
		let canvas = document.querySelector('#uploaded_image');
		let blank = document.querySelector('#blank_image');

		if (canvas.toDataURL() != blank.toDataURL()) {
			$('#custom_logo').val(canvas.toDataURL());
			$('#brand_logo').val('custom');
		}
	} else {
		$('#custom_logo').val('');
		$('#brand_logo').val('testrail');
	}
	$('.ui-dialog-titlebar-close').trigger('click');
}

App.Admin.brandLogo = function() {
	$('#brandLogoDialog div.dialogFormDefault').hide();

	if ($('#brand_logo').val() === 'custom') {
		$('#brandLogoDialog div#updateBrandLogo').show();
	} else {
		$('#brandLogoDialog div#brandLogo').show();
	}
	App.Dialogs.open({
		selector: '#brandLogoDialog'
	});
}

App.Admin.BrandLogoFailed = function() {
	$('.inputfile').val('');
	$('#brandLogoDialog div.dialogFormDefault').hide();
	$('#brandLogoDialog div#failureBrandLogo').show();
}

App.Admin.RestoreTestRailLogo = function() {
	$('.image-preview').attr('src', $('#default_testrail_logo').val());
	$('#dialog_brand_logo_flag').val('testrail');
}

App.Admin.TryAgain = function() {
	$('#brandLogoDialog div.dialogFormDefault').hide();
	if ($('#brand_logo').val() === 'custom') {
		$('#brandLogoDialog div#updateBrandLogo').show();
	} else {
		$('#brandLogoDialog div#brandLogo').show();
	}
}

App.Admin.ReadImage = function(input) {
	const ctx = document.getElementById('uploaded_image').getContext('2d');
	let target_height = parseInt($('#blank_image').attr('height'));
	let target_width = parseInt($('#blank_image').attr('width'));
	let logo_size = parseInt($('#brand_logo_size').val());

	if (!input.files || !input.files[0]) return;

	let allowed_types = ['image/png','image/gif','image/jpeg','image/jpg'];
	if(allowed_types.indexOf(input.files[0].type) < 0){
		App.Admin.BrandLogoFailed();

		return false;
	}

	if(parseInt(input.files[0].size) > logo_size || !parseInt(input.files[0].size)){
		App.Admin.BrandLogoFailed();

		return false;
	}

	const FR = new FileReader();
	FR.addEventListener("load", function(evt) {
		const img = new Image();
		let old_src = $('.image-preview').attr('src');

		img.addEventListener("load", function() {

			if(parseInt(img.height) < target_height || parseInt(img.width) < target_width){
				$('.image-preview').attr('src', old_src);
				App.Admin.BrandLogoFailed();

				return false;
			}
			var ratio = Math.min(target_width / img.width, target_height / img.height);
			ctx.canvas.width = Math.floor(ratio * img.width);
			ctx.canvas.height = Math.floor(ratio * img.height);
			ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
			ctx.drawImage(img, 0, 0, Math.floor(ratio * img.width), Math.floor(ratio * img.height));
		});
		img.src = evt.target.result;
		$('.image-preview').attr('src', evt.target.result);
		$('#dialog_brand_logo_flag').val('custom');
	});
	FR.readAsDataURL(input.files[0]);
}

App.Admin.addCaseFieldsToTemplate = function() {
	App.Dialogs.open({
		selector: '#addCaseFieldsToTemplateDialog'
	});
}

App.Admin.saveCaseFieldsToTemplate = function() {
	App.Ajax.call({
			target: '/admin/templates/ajax_save_fields_to_template',
			arguments: {
					template_id: $('#addCaseFieldstoTemplateSubmit').data('templateid'),
					field_ids: 	App.Controls.Checkboxes.getValues('case_field_ids')
				},
			success: function(data) {
				App.Dialogs.closeTop();
				App.Page.load('admin/templates/field_add_success/' + this.arguments.template_id);
			},
			error: function(data) {
				App.Ajax.handleError(data);
			}
		});
}

App.Admin.addResultFieldsToTemplate = function() {
	App.Dialogs.open({
		selector: '#addResultFieldsToTemplateDialog'
	});
}

App.Admin.saveResultFieldsToTemplate = function() {
	App.Ajax.call({
			target: '/admin/templates/ajax_save_fields_to_template',
			arguments: {
					template_id: $('#addResultFieldstoTemplateSubmit').data('templateid'),
					field_ids: 	App.Controls.Checkboxes.getValues('result_field_ids')
				},
			success: function(data) {
				App.Dialogs.closeTop();
				App.Page.load('admin/templates/field_add_success/' + this.arguments.template_id);
			},
			error: function(data) {
				App.Ajax.handleError(data);
			}
		});
}

jQuery(function()
{
	$('#mq_enabled').bind('change', function(evt)
	{
		var $target = $(evt.target);
		var $div = $('#mq');
		$target.is(':checked')
			? $div.show()
			: $div.hide();
	});
});

;

