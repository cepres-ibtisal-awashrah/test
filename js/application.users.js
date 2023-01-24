/*******************************************************************/
/* Users  */

/* [Permissions checked!] */

App.Users = new function () {
	var self = this;

	self.email = null;
	self.fields = null;
	self.field_type_previous = null;
	self.tokens = null;
	self.current_token = null;
	self.filters = null;
	secretKey = null,
	auth_app_connected = false

	self.loadAjaxData = function (offset, o) {
		var busy = $('#usersPaginationBusy');
		busy.show();

		var defaults = {
			offset: offset,
			search: $('#search_txt').val()
		};
		var param = $.extend(defaults, o);

		App.Ajax.call(
			{
				target: 'admin/users/ajax_render_users',
				arguments: self._getGridArguments(param),
				success: function (data) {
					$('#usersTable').html(data.users);
					$('#usersPagination').html(data.pagination);
					busy.hide();
				},
				error: function (data) {
					busy.hide();
					App.Ajax.handleError(data);
				}
			});
	}

	self.setUserGrouping = function (column) {
		App.Tables.setGrouping(column);

		self._showUsersList({
			error: function () {
				$('#orderBy .busy').hide();
				$('#orderByChange').show();
			}
		});
	}

	self.seSearchGrouping = function () {
		self._showUsersList({
			error: function () {
				$('#orderBy .busy').hide();
				$('#orderByChange').show();
			}
		});
	}

	//---------------------------------------------------------------
	// CONTENT & STATE
	//---------------------------------------------------------------
	self._showUsersList = function (o) {
		var defaults = {
			user_id: self.user_id,
			search: $('#search_txt').val(),
			offset: 0,
			display: self.display, // Does not change
		};
		var s = $.extend(defaults, o);
		App.Ajax.call(
			{
				target: 'admin/users/ajax_render_users',
				arguments: self._getGridArguments(s),
				success: function (data) {
					$('#usersTable').html(data.users);
					$('#usersPagination').html(data.pagination);
					$('#usersPaginationBusy').hide();
				},
				error: function (data) {
					if (o.error) {
						o.error();
					}
					App.Ajax.handleError(data);
				}
			});
	}

	self._getGridArguments = function (event) {
		// Besides the given arguments, we also include the column
		// definition for the grids, the grouping options and the
		// property filters.
		return $.extend({
			columns: App.Tables.columns_for_user,
			order_by_column: App.Tables.group_by,
			order_by: App.Tables.group_order,
			filters: self.filters
		},
			event
		);
	}

	self.filterUsers = function (e) {
		var filter = self._createFilter(e);
		filter.open();
	}


	self.filterUsersReset = function () {
		var filter = self._createFilter();
		filter.reset();
	}

	//---------------------------------------------------------------
	// FILTERING
	//---------------------------------------------------------------

	self._createFilter = function (e) {
		return new App.Users.Filter(
			{
				event: e,
				filters: self.filters,
				save_filters: true,

				changed: function (filters) {
					self.filters = filters;
					self._reloadUsers();
				}
			});
	}

	self._reloadUsers = function (group_id) {
		self.group_id = group_id || null; // Reset the group, if none
		$('#groupContent').remove();
		$('#groupTreeContent').remove();
		self.showInitial();
	}

	self.selectDialog = function (o) {
		if (o.user_id) {
			$('#selectUser').val(o.user_id);
		}
		else {
			$('#selectUser').val('');
		}

		$('#selectUserForm').unbind('submit');
		$('#selectUserForm').bind('submit', function () {
			o.submit({
				id: $('#selectUser').val(),
				name: $('#selectUser option:selected').text()
			});

			return false;
		});

		App.Dialogs.open({
			focusedControl: '#selectUser',
			selectedControl: '#selectUser',
			selector: '#selectUserDialog'
		});
	}

	self.showInitial = function () {
		// Calculate the height of the visible area for the test cases.
		var height =
			$(window).height() - $('#contentToolbar').offset().top;
		// Divide by number of height
		var spinnerWidth = 125;
		var heightDivider = 2;
		var offsetHeight = 50;

		// Calculate and set a suitable top padding for the loading
		// spinner
		var top = Math.max(Math.round(height / heightDivider - spinnerWidth), offsetHeight);
		$('#contentLoading').css('padding-top', top);
		$('#contentLoading').show();

		self._showUsersList(
			{
				include_sidebar: true,
				group_expands: self._getExpandState(),

				success: function (data) {
					$('#contentLoading').hide();
					if (self.display !== 'tree' && self.group_id) {
						self._openParents(self.group_id);
					}
				}
			});
	}

	self._getExpandState = function () {
		return App.Storage.getObject('suites.groups.expands',
			self.suite_id);
	}

	//---------------------------------------------------------------
	// FIELDS
	//---------------------------------------------------------------

	self.hasField = function (name) {
		return self.fields && self.fields.hasOwnProperty(name);
	}

	self.addField = function () {
		self._fieldDialog(
			{
				submit: function (o) {
					self._loadConfig(
						{
							label: o.label,
							description: o.description,
							name: o.name,
							type_id: o.type_id,
							fallback: o.fallback,

							success: function (html) {
								App.Dialogs.closeTop();
								$('#userFields').append(html);
								self._addFieldToArray(o);
							}
						});
				}
			});
	}

	self.addFieldNoDialog = function (o) {
		self._loadConfig(
			{
				label: o.label,
				description: o.description,
				name: o.name,
				type_id: o.type_id,
				fallback: o.fallback,

				success: function (html) {
					$('#userFields').append(html);
					self._addFieldToArray(o);
				}
			});
	}

	self._addFieldToArray = function (o) {
		self.fields[o.name] = {
			label: o.label,
			description: o.description,
			name: o.name,
			type_id: o.type_id,
			fallback: o.fallback
		};
	}

	self._fieldDialog = function (o) {
		if (o.field) {
			field = self.fields[o.field];
			$('#userFieldLabel').val(field.label);
			$('#userFieldDesc').val(field.description);
			$('#userFieldName').val(field.name);
			$('#userFieldName').attr('disabled', 'disabled');
			$('#userFieldType').attr('disabled', 'disabled');
			$('#userFieldType').val(field.type_id);
			$('#userFieldFallback').val(field.fallback);
			$('#userFieldPassword').val(field.fallback);
		}
		else {
			$('#userFieldLabel').val('');
			$('#userFieldDesc').val('');
			$('#userFieldName').val('');
			$('#userFieldName').removeAttr('disabled');
			$('#userFieldType').removeAttr('disabled');
			$('#userFieldType').val('');
			$('#userFieldFallback').val('');
			$('#userFieldPassword').val('');
		}

		self._fieldTypeInit();

		App.Validation.hideErrors();
		$('#userFieldErrors').empty();

		$('#userFieldForm').unbind('submit');
		$('#userFieldForm').submit(function (e) {
			App.Validation.hideErrors();
			$('#userFieldErrors').empty();

			var type_id = $('#userFieldType').val();
			var fallback = type_id == 2 ?
				$.trim($('#userFieldPassword').val()) :
				$.trim($('#userFieldFallback').val());

			o.submit(
				{
					label: $.trim($('#userFieldLabel').val()),
					description: $.trim($('#userFieldDesc').val()),
					name: $.trim($('#userFieldName').val()),
					type_id: type_id,
					fallback: fallback
				});

			return false;
		});

		App.Dialogs.open(
			{
				selector: '#userFieldDialog'
			});
	}

	self._fieldTypeInit = function () {
		var type_id = $('#userFieldType').val();

		if (type_id == 2) {
			$('#userFieldPassword').val($('#userFieldFallback').val());
			$('#userFieldFallback').hide();
			$('#userFieldPassword').show();
			$('#userFieldFallback').val('');
		}
		else {
			if (self.field_type_previous == 2) {
				$('#userFieldFallback').val($('#userFieldPassword').val());
			}

			$('#userFieldPassword').hide();
			$('#userFieldFallback').show('');
			$('#userFieldPassword').val('');
		}

		self.field_type_previous = type_id;
	}

	self.fieldTypeChanged = function () {
		self._fieldTypeInit();
	}

	self._loadConfig = function (o) {
		$('#userFieldSubmit').addClass('button-busy');

		App.Ajax.call(
			{
				target: '/admin/integration/ajax_render_user_field',

				arguments:
				{
					label: o.label,
					description: o.description,
					name: o.name,
					type_id: o.type_id,
					fallback: o.fallback
				},

				success: function (data) {
					$('#userFieldSubmit').removeClass('button-busy');
					o.success(data);
					$('#accept').prop('disabled', false);
				},

				error: function (data) {
					$('#userFieldSubmit').removeClass('button-busy');
					App.Ajax.handleError(data, '#userFieldErrors');
				}
			});
	}

	self.editField = function (name) {
		self._fieldDialog(
			{
				field: name,
				submit: function (o) {
					self._loadConfig(
						{
							label: o.label,
							description: o.description,
							name: o.name,
							type_id: o.type_id,
							fallback: o.fallback,

							success: function (html) {
								App.Dialogs.closeTop();
								$('#userField-' + name).replaceWith(html);
								self._addFieldToArray(o);
							}
						});
				}
			});
	}

	self.removeField = function (name) {
		$('#userField-' + name).remove();
		App.Users._removeFieldFromArray(name);
		$('#accept').prop('disabled', false);
	}

	self.loadBulkUsers = function(off, selected) {
		let pagination_selected = [];
		let busy = $("#paginationBulkBusy")
		busy.show();
		$('input[name="user_ids[]"]:checked').each(function() {
			pagination_selected.push(parseInt(this.value));
		})
		let all_selected = $.merge(pagination_selected, selected);

		App.Ajax.call({
		    target: "/admin/users/ajax_render_users_for_grouping",
		    arguments: {
		        search_text: $('#group_search_txt').val(),
		        offset: off,
		        selected_ids: all_selected,
		    },
		    stop: function() {
		        busy.show()
		    },
		    success: function(result) {
		        busy.hide();
		        $("#results").html(result.users);
		        $('#usersPage').html(result.pagination);
		        $(all_selected).each(function(index, value) {
		        	if ($('.existing_id_' + value).length <= 0) {
		        		$('#form').append('<input type="hidden" name="user_ids[]" class="existing_id_' + value + '" value="' + value + '"/>');
		        	}
		        })
		    },
		    error: function(err) {
		        App.Ajax.handleError(err)
		    }
		})
    }

	self._removeFieldFromArray = function(name)
	{
		delete self.fields[name];
	}

	self.fieldsToString = function () {
		var fields = [];

		$.each(self.fields, function (ix, v) {
			fields.push(v);
		});

		return JSON.stringify(fields);
	}

	self.editFieldNoDialog = function (o) {
		if (!self.hasField(o.name)) {
			return;
		}

		var field = self.fields[o.name];
		field.fallback = o.fallback; // The only field to update

		self._loadConfig(
			{
				label: field.label,
				description: field.description,
				name: field.name,
				type_id: field.type_id,
				fallback: field.fallback,

				success: function (html) {
					$('#userField-' + o.name).replaceWith(html);
					self._addFieldToArray(field);
				}
			});
	}

	//---------------------------------------------------------------
	// TOKENS
	//---------------------------------------------------------------

	self.addToken = function () {
		self.current_token = null;

		self._tokenDialog(
			{
				submit: function (o) {
					if (!self.current_token) {
						self._getToken(o);
					}
					else {
						self._addToken(o);
					}
				}
			});
	}

	self._getToken = function (o) {
		$('#userTokenGenerate').addClass('button-busy');

		App.Ajax.call(
			{
				target: '/mysettings/ajax_get_api_token',

				arguments:
				{
					name: o.name
				},

				success: function (data) {
					$('#userTokenGenerate').removeClass('button-busy');
					$('#userTokenCode').html(data.html).show();
					$('#userTokenGenerate').hide();
					$('#userTokenAdd').show();
					$('#userTokenName').prop('disabled', true);
					self.current_token = data.token;
				},

				error: function (data) {
					$('#userTokenGenerate').removeClass('button-busy');
					App.Ajax.handleError(data, '#userTokenErrors');
				}
			});
	}

	self._addToken = function (o) {
		$('#userTokenAdd').addClass('button-busy');

		App.Ajax.call(
			{
				target: '/mysettings/ajax_render_api_token',

				arguments:
				{
					name: o.name
				},

				success: function (data) {
					$('#userTokenAdd').removeClass('button-busy');
					$('#tokensGrid').append(data.html);
					$('#noTokens').hide();
					App.Dialogs.closeTop();
					$('#accept').prop('disabled', false);

					self._addTokenToArray(
						{
							token: self.current_token,
							name: data.token.name,
							id: data.token.id
						});
				},

				error: function (data) {
					$('#userTokenAdd').removeClass('button-busy');
					App.Ajax.handleError(data, '#userTokenErrors');
				}
			});
	}

	self._addTokenToArray = function (o) {
		self.tokens[o.id] = {
			name: o.name,
			token: o.token
		};
	}

	self._tokenDialog = function (o) {
		App.Validation.hideErrors();
		$('#userTokenName').prop('disabled', false);
		$('#userTokenName').val('');
		$('#userTokenCode').hide();
		$('#userTokenAdd').hide();
		$('#userTokenGenerate').show();

		$('#userTokenForm').unbind('submit');
		$('#userTokenForm').submit(function (e) {
			App.Validation.hideErrors();

			o.submit(
				{
					name: $.trim($('#userTokenName').val())
				});

			return false;
		});

		App.Dialogs.open(
			{
				selector: '#userTokenDialog'
			});
	}

	self.removeToken = function (id) {
		$('#userToken-' + id).remove();
		self._removeTokenFromArray(id);
		if ($('#tokensGrid tr.token').length == 0) {
			$('#noTokens').show();
		}
		$('#accept').prop('disabled', false);
	}

	self._removeTokenFromArray = function (id) {
		delete self.tokens[id];
	}

	self.tokensToString = function () {
		var tokens = [];

		$.each(self.tokens, function (ix, v) {
			tokens.push({
				id: ix,
				name: v.name,
				token: v.token
			});
		});

		return JSON.stringify(tokens);
	}

	//---------------------------------------------------------------
	// TOKENS
	//---------------------------------------------------------------

	self.verifyPassword = function () {
		self._passwordDialog(
			{
				submit: function (o) {
					self._verifyPassword(o);
				}
			});
	}

	self._verifyPassword = function (o) {
		$('#userPasswordSubmit').addClass('button-busy');

		App.Ajax.call(
			{
				target: '/mysettings/ajax_verify_password',

				arguments:
				{
					login: o.login,
					password: o.password
				},

				success: function (data) {
					$('#userPasswordSubmit').removeClass('button-busy');
					$('#verify_login').val(o.login);
					$('#verify_password').val(o.password);
					App.Dialogs.closeTop();
					$('#form').submit();
				},

				error: function (data) {
					$('#userPasswordSubmit').removeClass('button-busy');
					App.Ajax.handleError(data, '#userPasswordErrors');
				}
			});
	}

	self._passwordDialog = function (o) {
		App.Validation.hideErrors();
		$('#userPassword').val('');

		$('#userPasswordForm').unbind('submit');
		$('#userPasswordForm').submit(function (e) {
			App.Validation.hideErrors();

			var login = null;
			var name = $('#userPasswordName');

			if (name.length) {
				login = name.val();
			}
			else {
				login = self.email;
			}

			o.submit(
				{
					login: login,
					password: $.trim($('#userPassword').val())
				});

			return false;
		});

		App.Dialogs.open(
			{
				selector: '#userPasswordDialog'
			});
	}

	//---------------------------------------------------------------
	// GOALS
	//---------------------------------------------------------------

	self.hasGoals = function () {
		return $('#goals').length > 0;
	}

	self.reloadGoals = function () {
		App.Ajax.call(
			{
				target: '/mysettings/ajax_render_goals',
				blockUI: false,

				success: function (html) {
					$('#goals').replaceWith(html);
				},

				error: function (data) {
					// Ignored, not critical
				}
			});
	}

	self.setGoal = function (step, checked) {
		App.Ajax.call(
			{
				target: '/mysettings/ajax_set_goal',

				arguments: {
					step: step,
					checked: checked
				},

				success: function (html) {
					$('#goals').replaceWith(html);
				},

				error: function (data) {
					App.Ajax.handleError(data);
				}
			});
	}

	self.hideGoals = function (finished) {
		App.Ajax.call(
			{
				target: '/mysettings/ajax_hide_goals',
				blockUI: false,

				success: function (html) {
					$('#goals-start').remove();
					$('#goals-finish').remove();
					$('#goals-banner').slideUp(
						250,
						function () {
							$(this).remove();
							App.Page.reflow();

							if (finished) {
								$('#goals-next').show();
							}
							else {
								$('#goals').remove();
							}
						}
					);
				},

				error: function (data) {
					// Ignored, not critical
				}
			});
	}

	self.hideGoalsNext = function () {
		$('#goals').remove();
	}

	$('.searchable').each(function (ix, v) {
		var dropdown = $(v);
		// Apply the chosen control
		dropdown.chosen();
	});

	self.connectAssembla = function () {
		let $asmAppUrlSelector = $('#asmAppUrl');
		let assemblaPortfolio = $asmAppUrlSelector.val() || $asmAppUrlSelector.data('portfolio-url');
		App.Ajax.call({
			target: '/mysettings/ajax_get_assembla_cluster_name',
			arguments: {
				address: assemblaPortfolio
			},
			success: function (data) {
				if (data.result === true) {
					let clusterName = data['x-cluster-name'].toLowerCase();
					Cookies.set('asmclustername', clusterName);
					var $button = $('.asm-connect-btn');
					App.Validation.hideErrors();
					var asmClientId = $button.data(clusterName + 'clientid');
					var apiSubdomain = $button.data(clusterName + 'apisubdomain');
					var authorizationUrl = $button.data('authurl').replace('%s', apiSubdomain).replace('%s', asmClientId)
						+ '&redirect_uri=' + $button.data('redirect-url');

					window.open(authorizationUrl, '', "width=980,height=800");
				}
			},
			error: function (data) {
				App.Validation.hideErrors();
				App.Ajax.handleError(data, '#asmIntegrationErrors');
			},
		});

		return false;
	}

	self.removeAsmClientId = function (removeFromAdmin) {
		var confirm = $('#asmRemoveConfrmMsg').html();
		App.Dialogs.confirm(confirm, function () {
			self.ajaxRemoveAsmClientId(removeFromAdmin);
		});
	}

	self.ajaxRemoveAsmClientId = function (removeFromAdmin) {
		var removeFromAdmin = removeFromAdmin || false;
		App.Ajax.call(
			{
				target: '/mysettings/ajax_remove_client_details',
				arguments: {
					oauth_server: $('.asm-disconnect-btn').data('oauthname'),
				},
				success: function (c) {
					$('.asm-disconnect-btn').hide();
					$('.asm-connect-btn').show();
					$('.user-connected').hide();
					$('.user-notconnected').show();
					$('.asm-oauth-box input').prop('disabled', false);
					$('#asmOauthConnected').val('0');
					$('#asmAppUrl, #asmSpace').val('');
					if (removeFromAdmin) {
						App.Ajax.call({
							target: '/mysettings/ajax_remove_oauth_organization_url',
						});
					}
				},
				error: function (c) {
					App.Ajax.handleError(c, '#asmClientIdErrors');
				}
			});
	}

	//-------------------------------------------------------------------
	// MFA
	//-------------------------------------------------------------------

	self.removeMfaClient = function (removeFromAdmin) {
		var confirm = $('#asmRemoveConfrmMsg').html();
		App.Dialogs.confirm(confirm, function () {
			self.ajaxRemoveAsmClientId(removeFromAdmin);
		});
	}

	self.validateMfaCode = function () {
		let valid = false;
		let codeLength = 6;
		let validateBtn = $('#qrCodeSubmitButton')
		const value = $('#userQrCode').val().trim();
		if (value.length < codeLength) {
			valid = false;
		} else {
			if (value.match(/^[0-9]+$/)) {
				valid = true;
			} else {
				valid = false;
			}
		}
		if (valid) {
			validateBtn.removeAttr('disabled');
			validateBtn.removeClass('disabled');
		} else {
			validateBtn.attr('disabled', 'disabled');
			validateBtn.addClass('disabled');

		}
	}

	self.mfaDialog = function () {
		$.ajax({
				type: 'GET',
				url: Consts.ajaxBaseUrl + '/mysettings/ajaxGenerateQrCode',
				success: function(data)
				{
					self.secretKey =  data['secret_key'];
					$('#qrCode').attr('src',data['qr_code']) ;
					$('#userQrCode').val('');
					const keys = (data['secret_key'].split('-'));
					$('.secretCode-container').html('');
					$.each( keys, function( i ,value ){
						$('.secretCode-container').append("<span style ='margin-right:12px'>" + value + "<span>");
					});
					$('.authentication-code-heading').show();
					$('.mfa-error-msg-logo').hide();
					$('.mfa-error-msg').hide();
					App.Dialogs.open({selector: '#mfaDialog'});
				},
				error: function(data)
				{
					App.Ajax.handleError(data, '#asmClientIdErrors');
				}
			});
	}

	
	self.connectAuthApp = function () { 
		App.Ajax.call(
			{
				target: '/mysettings/ajax_validate_qr_code',
				arguments: {
					secret_key : self.secretKey,
					code : $('#userQrCode').val().trim()
				},
				success: function (data) {
					if(data['is_code_valid']) {
						$('#mfa_notConnected').hide();
						$('#mfa_Connected').show();
						$('.mfa-connect-btn').hide();
						$('.mfa-disconnect-btn').show();
				$('#auth_app_connected').val(1);
				if($('#accept').attr('disabled') === 'disabled') {
					$('#accept').removeAttr('disabled');
				} else {
					$('#accept').attr('disabled', 'disabled');
				}
			
						App.Dialogs.close('#mfaDialog');
					} else {
						$('.authentication-code-heading').hide();
						$('.mfa-error-msg-logo').show();
						$('.mfa-error-msg').show();
					}
				},
				error: function (data) {
					App.Ajax.handleError(data, '#asmClientIdErrors');
				}
			});
	}

	self.disConnectAuthApp = function () { 
		$('#mfa_notConnected').show();
		$('#mfa_Connected').hide();
		$('.mfa-connect-btn').show();
		$('.mfa-disconnect-btn').hide();
		$('#auth_app_connected').val(0);
		if($('#accept').attr('disabled') === 'disabled') {
			$('#accept').removeAttr('disabled');
		} else {
			$('#accept').attr('disabled', 'disabled');
		}
		App.Dialogs.close('#mfaDisconnectConfirmationDialog');
	}

	self.closeMfaDialog = function () { 
		App.Dialogs.close('#mfaDialog');
	}

  //-------------------------------------------------------------------
	// WEBHOOKS
	//-------------------------------------------------------------------

	self.addWebhook = function () {
		let _arguments = {};
		_arguments["webhook_name"] = $('[name="webhook_name"]').val();
		_arguments["payload_url"] = $('[name="payload_url"]').val();
		_arguments["method"] = $('[name="method"]').val();
		_arguments["content_type"] = $('[name="content_type"]').val();
		_arguments["request_headers"] = $('[name="request_headers"]').val();
		_arguments["request_payload"] = $('[name="request_payload"]').val();
		_arguments["secret"] = $('[name="secret"]').val();
		_arguments["projects"] = $('[name="projects[]"]').val();

		if ($('[name="active"]').attr("checked")) {
			_arguments["active"] = 1;
		} else {
			_arguments["active"] = 0;
		}

		_arguments["events"] = [];

		$('[name="events[]"]').each(i => {
			if ($('[name="events[]"]')[i].checked) {
				_arguments["events"] = [..._arguments["events"], $('[name="events[]"]')[i].value];
			}
		});

		if ($('[name="events[]"]').length == _arguments["events"].length) {
			_arguments["events"] = ["All events"]
		}
		_arguments["projects"] = [];

		$('[name="projects[]"]').each(i => {
			if ($('[name="projects[]"]')[i].checked) {
				_arguments["projects"] = [..._arguments["projects"], $('[name="projects[]"]')[i].value];
			}
		});

		if ($(".error:visible").length) {
			return;
		}

		$('.button-ok').addClass('button-loading').removeClass('button-ok');

		App.Validation.hideErrors();
		App.Ajax.call({
			target: '/admin/integration/ajax_add_webhook',
			arguments: _arguments,

			success: function (data) {
				$('#webhook_form').fadeIn(100);
				$('#webhook_form').html(data);
				$('.webhook-list').hide();
				self.showRecentWebhookDeliveryList($('[name="hook_id"]').val());
				$('#button-test-webhook').show();
				$('.button-loading').addClass('button-ok').removeClass('button-loading');
				$('#accept').prop('disabled', false);
			},

			error: function (data) {
				App.Ajax.handleError(data, '#webhookErrors');
				$('.button-loading').addClass('button-ok').removeClass('button-loading');
			}
		});
	}

	self.editWebhook = function (id, project_id) {
		let _arguments = {};
		_arguments["id"] = id;
		_arguments["hook_id"] = $('[name="hook_id"]').val();
		_arguments["webhook_name"] = $('[name="webhook_name"]').val();
		_arguments["payload_url"] = $('[name="payload_url"]').val();
		_arguments["method"] = $('[name="method"]').val();
		_arguments["content_type"] = $('[name="content_type"]').val();
		_arguments["request_headers"] = $('[name="request_headers"]').val();
		_arguments["request_payload"] = $('[name="request_payload"]').val();
		_arguments["secret"] = $('[name="secret"]').val();
		_arguments["projects"] = $('[name="projects[]"]').val();

		if ($('[name="active"]').attr("checked")) {
			_arguments["active"] = 1;
		} else {
			_arguments["active"] = 0;
		}

		_arguments["events"] = [];

		$('[name="events[]"]').each(i => {
			if ($('[name="events[]"]')[i].checked) {
				_arguments["events"] = [..._arguments["events"], $('[name="events[]"]')[i].value];
			}
		});

		if ($('[name="events[]"]').length == _arguments["events"].length) {
			_arguments["events"] = ["All events"]
		}
		_arguments["projects"] = [];

		$('[name="projects[]"]').each(i => {
			if ($('[name="projects[]"]')[i].checked) {
				_arguments["projects"] = [..._arguments["projects"], $('[name="projects[]"]')[i].value];
			}
		});

		if ($(".error:visible").length) {
			return;
		}

		$(".button-ok").addClass("button-loading").removeClass("button-ok");

		App.Validation.hideErrors();
		App.Ajax.call({
			target: '/admin/integration/ajax_edit_webhook/' + project_id,
			arguments: _arguments,

			success: function (data) {
				$('#webhook_form').fadeOut(0);
				$('#usersTable').html(data);
				$('.webhook-list').fadeIn(100);
				$(".button-loading").addClass("button-ok").removeClass("button-loading");
				$('#accept').prop('disabled', true);
			},

			error: function (data) {
				App.Ajax.handleError(data, '#webhookErrors');
				$(".button-loading").addClass("button-ok").removeClass("button-loading");
			}
		});
	}

	self.deleteWebhookByIds = function (project_id = -1) {
		let ids = $('input[name="delete_ids"]').val();
		let _arguments = {};
		_arguments['ids'] = ids.split(',');
		_arguments['project_id'] = project_id;

		App.Ajax.call({
			target: '/admin/integration/ajax_delete_webhooks',
			arguments: _arguments,

			success: function (data) {
				$('.modal-box, .modal-overlay').fadeOut(100, function () {
					$('.ui-widget-overlay').remove();
				});
				$('#webhook_form').fadeOut(0);
				$('#usersTable').html(data);
				$('.webhook-list').fadeIn(100);
				$('#accept').prop('disabled', true);
			},

			error: function (data) {
			}
		});
	}

	self.showWebhookList = function (project_id = -1) {
		let _arguments = {};
		App.Ajax.call({
			target: '/admin/integration/ajax_render_webhook_list/' + project_id,
			arguments: _arguments,

			success: function (data) {
				$('#webhook_form').fadeOut(0);
				$('#usersTable').html(data);
				$('.webhook-list').fadeIn(100);
				$('#accept').prop('disabled', true);
			},

			error: function (data) {
			}
		});
	}

	self.selectAllWebhooks = function (element) {
		$('[name="selected_hooks[]"]').attr("checked", element.checked);
		self.selectedDeleteButtonToggle();
	}

	self.selectWebhook = function (event) {
		event.preventDefault();

		let $result = true;
		let $webhooks = $('[name="selected_hooks[]"]');
		let $checked = $('[name="selected_hooks[]"]').filter(function (i) {
			return $('[name="selected_hooks[]"]')[i].checked;
		})

		if ($webhooks.length == $checked.length) {
			$('[name="selected_all_hooks"]').attr('checked', 'checked');
		} else {
			$('[name="selected_all_hooks"]').removeAttr('checked');
		}
	}

	self.selectedDeleteButtonToggle = function () {
		$('#delete-selected-webhooks').hide();

		$('[name="selected_hooks[]"]').map(function (index) {
			if ($('[name="selected_hooks[]"]')[index].checked) {
				$('#delete-selected-webhooks').show();
			}
		});
	}

	self.addWebhookForm = function () {
		let _arguments = {};
		App.Ajax.call({
			target: '/admin/integration/ajax_render_add_webhook_form',
			arguments: _arguments,

			success: function (data) {
				$('#webhook_form').fadeIn(100);
				$('#webhook_form').html(data);
				$('.webhook-list').fadeOut(0);
				$('#accept').prop('disabled', false);
			},

			error: function (data) {
			}
		});
	}

	self.editWebhookForm = function (id, hookId) {
		let _arguments = {};
		_arguments['id'] = id;

		App.Ajax.call({
			target: '/admin/integration/ajax_render_edit_webhook_form',
			arguments: _arguments,

			success: function (data) {
				self.showRecentWebhookDeliveryList(hookId);
				$('#webhook_form').fadeIn(100);
				$('#webhook_form').html(data);
				$('.webhook-list').fadeOut(0);
				$('#accept').prop('disabled', false);
			},

			error: function (data) {
			}
		});
	}

	self.onFormSubmit = function (project_id = -1) {
		$('#tab').val($('div.tab-header .current').attr('rel'));

		if($("#tab").val() == 6) {
			self.confirmProjectsPanel(project_id);
			return false;
		}

		return true;
	}

	self.confirmProjectsPanel = function (project_id = -1) {
		let project_labels = [];
		let projectIds = [];

		$('[name="projects[]"]').each(i => {
			if ($('[name="projects[]"]')[i].checked)
				project_labels = [...project_labels, $($('[name="projects[]"]')[i]).attr('project-name')];
			if ($('[name="projects[]"]')[i].checked)
				projectIds = [...projectIds, $('[name="projects[]"]')[i].value];
		});

		let _arguments = {};
		_arguments["projects"] = projectIds;

		if (projectIds.length) {

			$(".button-ok").addClass("button-loading").removeClass("button-ok");
			let id = $('input[name="id"]').val() || -1;
			App.Ajax.call({
				target: '/admin/integration/ajax_check_project_access/' + id,
				arguments: _arguments,

				success: function (data) {
					if ($('[name="projects[]"]').length == project_labels.length) {
						project_labels = ["All projects"]
					}

					if (project_labels.length > 0) {
						const appendthis = ("<div class='ui-widget-overlay'></div>");
						$("body").append(appendthis);
						$(".ui-widget-overlay").fadeTo(100, 0.4);
						$("#dialog-projects-confirmation").fadeIn($(this).data());
						$("#warning_content").html('[' + project_labels.join("], [") + ']');
					} else {
						if ($('input[name="id"]').length) {
							self.editWebhook($('input[name="id"]').val(), project_id);
						} else {
							self.addWebhook();
						}
					}

					$(".button-loading").addClass("button-ok").removeClass("button-loading");
				},

				error: function (data) {
					const appendthis = ("<div class='ui-widget-overlay'></div>");
					$("body").append(appendthis);
					$(".ui-widget-overlay").fadeTo(100, 0.4);
					$("#dialog-projects-error").fadeIn($(this).data());
					$(".button-loading").addClass("button-ok").removeClass("button-loading");
				}
			});
		} else {
			if ($('input[name="id"]').length) {
				self.editWebhook($('input[name="id"]').val(), project_id);
			} else {
				self.addWebhook();
			}
		}
	}

	self.closeConfirmProjectsPanel = function () {
		$(".modal-box, .modal-overlay").fadeOut(100, function () {
			$(".ui-widget-overlay").remove();
		});
	}

	self.confirmProjectsAllowChanges = function (project_id = -1) {
		$(".modal-box, .modal-overlay").fadeOut(1, function () {
			$(".ui-widget-overlay").remove();
		});

		if ($('input[name="id"]').length) {
			self.editWebhook($('input[name="id"]').val(), project_id);
		} else {
			self.addWebhook();
		}
	}

	self.confirmDeleteWebhookPanel = function (id = false, name = false) {
		if (id == false && name == false) {
			let ids = [];
			let names = [];

			$("#webhook_table input").each(function (i) {
				let element = $("#webhook_table input")[i];

				if (element.checked) {
					let values = element.value.replace('[', '').replace(']', '');
					const [id, value] = values.split(",");

					if (id && id != "on") {
						ids = [...ids, id];
					}

					if (value) {
						names = [...names, value];
					}
				}
			});

			let _arguments = {};
			_arguments["projects"] = ids;
			$(".button-ok").addClass("button-loading").removeClass("button-ok");
			App.Ajax.call({
				target: '/admin/integration/ajax_check_delete_project_access',
				arguments: _arguments,

				success: function (data) {
					const appendthis = ("<div class='ui-widget-overlay'></div>");
					$("body").append(appendthis);
					$(".ui-widget-overlay").fadeTo(100, 0.4);
					$("#dialog-ident-deleteDialog").fadeIn($(this).data());
					let element = $("#dialog-ident-deleteDialog").clone().html();
					$("#delete_contents").html('[' + names.join("], [") + ']');
					$('input[name="delete_ids"]').val(ids);
					$('.d-hooks').hide();
					$('.ds-hooks').show();
					$(".button-loading").addClass("button-ok").removeClass("button-loading");
				},

				error: function (data) {
					const appendthis = ("<div class='ui-widget-overlay'></div>");
					$("body").append(appendthis);
					$(".ui-widget-overlay").fadeTo(100, 0.4);
					$("#dialog-projects-error").fadeIn($(this).data());
					$(".button-loading").addClass("button-ok").removeClass("button-loading");
				}
			});

		} else {

			let _arguments = {};
			_arguments["projects"] = id;
			$(".button-ok").addClass("button-loading").removeClass("button-ok");
			App.Ajax.call({
				target: '/admin/integration/ajax_check_delete_project_access',
				arguments: _arguments,

				success: function (data) {
					const appendthis = ("<div class='ui-widget-overlay'></div>");
					$("body").append(appendthis);
					$(".ui-widget-overlay").fadeTo(100, 0.4);
					$("#dialog-ident-deleteDialog").fadeIn($(this).data());
					let element = $("#dialog-ident-deleteDialog").clone().html();
					$("#delete_content").html('[' + name + ']');
					$('input[name="delete_ids"]').val([id]);
					$('.d-hooks').show();
					$('.ds-hooks').hide();
					$(".button-loading").addClass("button-ok").removeClass("button-loading");
				},

				error: function (data) {
					const appendthis = ("<div class='ui-widget-overlay'></div>");
					$("body").append(appendthis);
					$(".ui-widget-overlay").fadeTo(100, 0.4);
					$("#dialog-projects-error").fadeIn($(this).data());
					$(".button-loading").addClass("button-ok").removeClass("button-loading");
				}
			});
		}
	}

	self.onValidateJson = function (string) {
		if ($('select[name=content_type]').val() === 'application/json' && string != '') {
			if (!self.checkValidJSON(string)) {
				$('.payload_json_error').show();
			} else {
				$('.payload_json_error').hide();
			}
		} else {
			$('.payload_json_error').hide();
		}
	}

	self.checkValidJSON = function (string) {
		try {
			if (!string.match(/(\{|\})/gi)) throw false;
			JSON.parse(string);
		} catch (e) {
			return false;
		}

		return true;
	}

	self.cancelWebhook = function () {
		$('#webhook_form').fadeOut(0);
		$('.webhook-list').fadeIn(100);
		$('#accept').prop('disabled', true);
	}

	self.closeDeleteWebhookPanel = function () {
		$(".modal-box, .modal-overlay").fadeOut(100, function () {
			$(".ui-widget-overlay").remove();
		});
	}

	self.toggleSecretKey = function () {
		$('.secret-show-button').get(0).checked = !$('.secret-show-button').get(0).checked;
		$('[name="secret"]').get(0).type = $('.secret-show-button').get(0).checked ? "text" : "password";
	}

	self.toggleAllEvents = function (event) {
		event.preventDefault();
		if (event.target.checked) {
			$('[name="events[]"]').attr("checked", "checked");
		} else {
			$('[name="events[]"]').removeAttr("checked");
		}
	}

	self.toggleEvent = function (event) {
		event.preventDefault();

		let $result = true;
		let $events = $('[name="events[]"]');
		let $checked = $('[name="events[]"]').filter(function (i) {
			return $('[name="events[]"]')[i].checked;
		})

		if ($events.length == $checked.length) {
			$('#all').attr('checked', 'checked');
		} else {
			$('#all').removeAttr('checked');
		}
	}

	self.checkHttpsUrl = function (value) {
		let pattern = /^(https):\/\/.*$/gim;

		if (value.match(pattern) && value.match(pattern).length) {
			$('.payload_url_error').hide();
		} else {
			$('.payload_url_error').show();
		}
	}

	self.onChangeSecret = function (replace_string) {
		let defaultHeaderTemplate = JSON.stringify($('#default_request_headers').html());
		defaultHeaderTemplate = defaultHeaderTemplate.replace(/\"/img, '');
		defaultHeaderTemplate = defaultHeaderTemplate.replace('<br>Authorization: %secret%', '');

		if (replace_string != "") {
			defaultHeaderTemplate = defaultHeaderTemplate + '<br>Authorization: %secret%';
		}

		defaultHeaderTemplate = '"' + defaultHeaderTemplate + '"';
		$("#default_request_headers").html(JSON.parse(defaultHeaderTemplate));
	}

	self.onTextareaFocusIn = function (element) {
		$(element).closest(".textarea-wrap").addClass("focus");
		$(element).css("height", "");
		$(element).css("height", element.scrollHeight + "px");
	}

	self.onTextareaFocusOut = function (element) {
		$(element).closest(".textarea-wrap").removeClass("focus");
	}

	self.onCancelPage = function (url) {
		let tabName = $(".tab:visible").find('#tab_name').val();

		if (tabName == "Webhooks" && $('#webhook_form:visible').length) {
			self.cancelWebhook();
			return;
		}

		window.location.href = url;
	}

	self.populateDataIntoTemplate = function (template, data) {
		if (template != null && template.match(/%([^\s]+)%/igm) != null) {
			for (key in data) {
				let pattern = new RegExp('("?%' + key + '%"?)', 'igm');
				template = template.replace(pattern, '"' + data[key] + '"');
			}
			let pattern = new RegExp('("?%([^%]+)%"?)', 'igm');
			template = template.replace(pattern, '"NULL"');
		}
		return template;
	}

	self.headersToJSON = function (data) {
		let jsonString = '{';

		for (line of data.split(/\\n/)) {
			let string = line.replace(/([^\:]+):\s?(.*)\n?/igm, '"$1":$2,');
			jsonString += string.replace(/\"\"/, "\"");
		}

		jsonString = jsonString.replace(/\,$/, '');
		jsonString += '}';

		return JSON.parse(jsonString);
	}

	self.payloadToJSON = function (data) {

		return JSON.parse(data);
	}

	self.onClickTestButton = function (data) {
		let hookId = data.hook_id;
		let _arguments = {};
		App.Validation.hideErrors();
		App.Ajax.call({
			target: '/admin/integration/ajax_generate_and_send_webhook/' + hookId,
			arguments: _arguments,

			success: function (data) {
				$('#recent_deliveries').html(data);
			},

			error: function (data) {
				App.Ajax.handleError(data, '#webhookErrors');
			}
		});
	}

	self.showRecentWebhookDeliveryList = function (hookId) {
		let _arguments = {};
		_arguments["hook_id"] = hookId;
		App.Ajax.call({
			target: '/admin/integration/ajax_render_recent_webhook_delivery_list/' + hookId,
			arguments: _arguments,

			success: function (data) {
				$('#recent_deliveries').html(data);
			},

			error: function (data) {
			}
		});
	}

	self.tab = function (element, name) {
        let $parentElement = $(element).parent().parent();
        let $tab = $parentElement.next('.tab');
        let currentClassName = 'current';

        $parentElement.find('.' + currentClassName).removeClass(currentClassName);
        $(element).parent().toggleClass(currentClassName);
        $tab.find('.tab-content').hide();
        $tab.find('#' + name).show();
    }
}

//-------------------------------------------------------------------
// FILTERING
//-------------------------------------------------------------------

App.Users.Filter = function (event) {
	var self = this;
	self.filters = event.filters;
	self.save_filters = event.save_filters;
	self.changed = event.changed;
	self.event = event.event;

	self.open = function (event) {
		var bubble = $('#filterByChange').bubble({
			bubble: '#filterUsersBubble',
			toggleEvent: 'null'
		});

		self._load(
			{
				show: function () {
					self._bind(
						{
							bubble: bubble
						});

					bubble.show(self.event);
				}
			});
	}

	self._load = function (event) {
		var busy = $('#filterBy .busy');
		var filterByChange = $('#filterByChange');
		App.Ajax.call({
			target: '/admin/users/ajax_render_user_filter',
			arguments: {
				suite_id: self.suite_id,
				filters: self.filters
			},
			start: function () {
				filterByChange.hide();
				busy.show();
			},
			stop: function () {
				busy.hide();
				filterByChange.show();
			},
			success: function (html) {
				$('#filterUsersContent').html(html);
				event.show();
			},
			error: function (data) {
				App.Ajax.handleError(data);
			}
		});
	}

	$('#filterUsersCancel').click(
		function () {
			self._cancel(event);
			return false;
		}
	);

	self._bind = function (event) {
		$('#filterUsersApply').click(
			function () {
				self._apply(event);
				return false;
			}
		);

		$('#filterUsersCancel').click(
			function () {
				self._cancel(event);
				return false;
			}
		);
	}

	self._changed = function () {
		self.changed(self.filters);
	}

	self._cancel = function (event) {
		event.bubble.hide();
	}

	self.reset = function () {
		var filterByChange = $('#filterByChange');
		var busy = $('#filterBy .busy');
		App.Ajax.call({
			target: '/admin/users/ajax_render_user_filter_info',

			arguments: {
				filters: null,
				save_filters: self.save_filters
			},
			start: function () {
				filterByChange.hide();
				busy.show();
			},
			stop: function () {
				busy.hide();
				filterByChange.show();
			},
			success: function (html) {
				self._sync(null, '');
				self._changed();
			},
			error: function (data) {
				App.Ajax.handleError(data);
			}
		});
	}

	self._bind = function (event) {
		$('#filterCasesApply').click(
			function () {
				self._apply(event);
				return false;
			}
		);

		$('#filterCasesCancel').click(
			function () {
				self._cancel(event);
				return false;
			}
		);
	}

	self._apply = function (event) {
		var filters = App.Filters.getAll($('#filterUsersContent'));
		var filterCasesApply = $('#filterCasesApply');
		App.Ajax.call({
			target: '/admin/users/ajax_render_user_filter_info',
			arguments: {
				suite_id: self.suite_id,
				filters: filters,
				save_filters: self.save_filters
			},
			start: function () {
				filterCasesApply.addClass('button-busy');
			},
			stop: function () {
				filterCasesApply.removeClass('button-busy');
			},
			success: function (html) {
				self._sync(filters, html);
				self._changed();
				event.bubble.hide();
			},
			error: function (data) {
				App.Ajax.handleError(data);
			}
		});
	}

	self._sync = function (filters, info) {
		var filterByInfo = $('#filterByInfo');
		var filterByEmpty = $('#filterByEmpty');
		var filterByChange = $('#filterByChange');
		var filterByReset = $('#filterByReset');

		filterByInfo.hide();
		filterByEmpty.hide();
		filterByChange.removeClass('link link-dashed nolink');

		info = $.trim(info);
		if (info) {
			filterByChange.addClass('nolink');
			filterByInfo.html(info);
			filterByInfo.show();
			filterByReset.show();
			self.filters = filters; // Save for later
		} else {
			filterByReset.hide();
			filterByChange.addClass('link link-dashed');
			filterByEmpty.show();
			self.filters = null; // Reset filter
		}
	}

	self._changed = function () {
		self.changed(self.filters);
	}

	self._cancel = function (event) {
		event.bubble.hide();
	}

	self._init = function () {
		self._bind();
		self._applyTree();
		if (self.case_ids) {
			self._applySelection();
		}
	}
}

;

