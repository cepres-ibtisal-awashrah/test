/*******************************************************************/
/* Standard Dialogs */

/* [Permissions checked!] */

App.Dialogs = {};
App.Dialogs.dialogs = new Array();

// Initializes a dialog. The dialog must be given as selector
// (e.g. '#confirmDialog'). Is automatically applied when calling
// open, so there's usually no need to call this function manually
// yourself.
App.Dialogs.init = function(dialog)
{
	$(dialog).dialog(
	{
		autoOpen: false,
		modal: true,
		resizable: false,
		draggable: true,
		position: 'center',
		dialogClass: 'dialog',
		closeOnEscape: false,
		height: 'auto',
		minHeight: 0
	});
}

App.ready(function()
{
	// Bind the Enter and ESC keys for dialogs
	// TODO: do not bind to the entire document, bind to the
	// dialogs itself, if possible
	$(document).bind('keydown.messageDialog', function(e)
	{
		if (App.Dialogs.dialogs.length == 0)
		{
			return;
		}

		if (App.Ajax.inAction)
		{
			return; // Do not process enter/esc during Ajax request
		}

		// Get the top dialog
		var dialog = App.Dialogs.dialogs[App.Dialogs.dialogs.length - 1];

		// Handle Enter key / default button
		if (e.keyCode == App.keyEnter)
		{
			var focused = $('*:focus', dialog);

			// We ignore the enter in case the focused element is a
			// (non-readonly) textarea control.
			if (focused.is('textarea'))
			{
				if (!focused.prop('readonly'))
				{
					return;
				}
			}

			// Ignore new inline attachments fields
			if (focused.attr('contenteditable'))
			{
				return;
			}

			var enter = dialog.data('enter');
			if (enter)
			{
				enter(dialog);
			}

			return false;
		}

		// Handle ESC key and close the dialog
		if (e.keyCode == App.keyEscape)
		{
			App.Dialogs.close(dialog);
			return false; // Prevent default action
		}
	});

	// Add id attribute to wrapped dialog content
	$('.dialog').on(
    	    'dialogopen',
    	    function() {
        	let $wrappedDialog = $(this).parent();
        	let idSelector = 'id';
        	if ($wrappedDialog.attr(idSelector) === undefined) {
            	    $wrappedDialog.attr(idSelector, 'dialog-ident-' + $(this).attr(idSelector));
        	}
    	    }
	);
});

App.Dialogs.getActive = function()
{
	if (App.Dialogs.dialogs.length == 0)
	{
		return null;
	}
	else
	{
		return App.Dialogs.dialogs[App.Dialogs.dialogs.length - 1];
	}
}

App.Dialogs.isActive = function(id)
{
	var dialog = App.Dialogs.getActive();
	return dialog && dialog.attr('id') == id;
}

// Asks the user to confirm an action and executes the given
// callback in case the user confirms it. Note: allows and supports
// HTML.
App.Dialogs.confirm = function(message, success, cancel, selector)
{
	selector = selector || '#confirmDialog';
	$(selector + ' .dialog-message').html(message);
	$(selector + ' .dialog-action-default')
    .unbind('click')
    .bind( 'click', function() {
			if (success) {
				success();
			}

			App.Dialogs.closeTop();
		}
	);

	$(selector + ' .dialog-action-close')
    .unbind('click.confirm')
    .bind( 'click.confirm', function() {
			if (cancel) {
				cancel();
			}
		}
	);

	App.Dialogs.open( {
		selector: selector
	});
}

// Asks the user to confirm a delete action and executes the given
// callback in case the user confirms it. Note: allows and supports
// HTML.
App.Dialogs.remove = function(message, confirm, extra, init, success,
	cancel)
{
	var d = $('#deleteDialog');

	// Reset the OK button (disable) and register for the button/dialog
	// events.
	var ok = $('.dialog-action-default', d);

	ok.addClass('button-ok-disabled button-disabled');
	ok.unbind('click').bind(
		'click',
		function(e)
		{
			if ($(this).hasClass('button-disabled'))
			{
				return;
			}

			if (success)
			{
				success();
			}

			App.Dialogs.closeTop();
		}
	);

	// Cancel button
	$('.dialog-action-close', d).unbind('click.confirm').bind(
		'click.confirm',
		function()
		{
			if (cancel)
			{
				cancel();
			}
		}
	);

	// Reset checkbox (uncheck) and register for change events (to
	// toggle the disabled state of OK).
	var checkbox = $('.checkbox', d);

	if (confirm)
	{
		var confirm_msg = '<strong>' + langc(confirm) + '</strong>';

		checkbox.find('.dialog-confirm-busy').hide();
		checkbox.find('.dialog-confirm').html(confirm_msg);
		checkbox.find('input').prop('disabled', false);
		checkbox.find('input').prop('checked', false);
		checkbox.find('input').change(
			function()
			{
				if ($(this).is(':checked'))
				{
					ok.removeClass('button-ok-disabled button-disabled');
				}
				else
				{
					ok.addClass('button-ok-disabled button-disabled');
				}
			}
		);

		$('.delete-confirm-container', d).show();
	}
	else
	{
		$('.delete-confirm-container', d).hide();
		ok.removeClass('button-ok-disabled button-disabled');
	}

	$('.dialog-message', d).html(langc(message));

	if (extra)
	{
		$('.dialog-extra', d).html(langc(extra)).show();
	}
	else
	{
		$('.dialog-extra', d).hide();
	}

	// Open the dialog and execute init callback from the caller, if any.
	// Can be used to add an extra
	App.Dialogs.open(
	{
		selector: '#deleteDialog',
		titleColor: '#D04437',
		init: function()
		{
			if (init)
			{
				checkbox.addClass('checkbox-disabled');
				checkbox.find('input').prop('disabled', true)
				checkbox.find('.dialog-confirm-busy').show();
				init();
			}
		}
	});
}

// Asks the user to accept the DPA agreement
App.Dialogs.dataProcessingAgreement = function(message, confirm, title)
{
    var d = $('#dpaDialog');

    // Reset the OK button (disable) and register for the button/dialog
    // events.
    var ok = $('.dialog-action-default', d);

    ok.addClass('button-ok-disabled button-disabled');
    ok.unbind('click').bind('click', function() {
    	if ($(this).hasClass('button-disabled'))
    	{
    		return;
    	}

    	$('#dpa_form').submit();

    	App.Dialogs.closeTop();
    });

    // Reset checkbox (uncheck) and register for change events (to
    // toggle the disabled state of OK).
    var checkbox = $('.checkbox', d);

    if (confirm)
    {
        var confirm_msg = '<strong>' + langc(confirm) + '</strong>';
        var country = $('#country');
        var full_name = $('#full_name');
        var checkbox_input = checkbox.find('input');

        checkbox.find('.dialog-confirm-busy').hide();
        checkbox.find('.dialog-confirm').html(confirm_msg);
        checkbox_input.prop('disabled', false);
        checkbox_input.prop('checked', false);

        // Check all fields for validity to proceed
        var changeFunction = function () {
            if (full_name.val() != '' && checkbox_input.is(':checked') && country.val() != '')
            {
                ok.removeClass('button-ok-disabled button-disabled');
            }
            else
            {
                ok.addClass('button-ok-disabled button-disabled');

            }
        };

        country.change(changeFunction);
        full_name.keyup(changeFunction);
        checkbox_input.change(changeFunction);

        $('.delete-confirm-container', d).show();
    }
    else
    {
        $('.delete-confirm-container', d).hide();
        ok.removeClass('button-ok-disabled button-disabled');
    }

    $('.dialog-message', d).html(langc(message));

    // Open the dialog and execute init callback from the caller, if any.
    App.Dialogs.open(
        {
            selector: '#dpaDialog',
            title: title,
            titleColor: '#D04437',
						width: '750px',
            init: function() {}
        });
};

App.Dialogs.removeLoaded = function(extra)
{
	var d = $('#deleteDialog');
	var checkbox = $('.checkbox', d);
	checkbox.removeClass('checkbox-disabled');
	checkbox.find('input').prop('disabled', false);
	checkbox.find('.dialog-confirm-busy').hide();
	$('.dialog-extra', d).html(extra).show();
}

// Shows a message dialog to the user.
App.Dialogs.message = function(message, title, callback)
{
	$('#messageDialog .dialog-message').html(message);

	$('#messageDialog .dialog-action-default').unbind('click');
	$('#messageDialog .dialog-action-default').bind(
		'click',
		function()
		{
			App.Dialogs.closeTop();
		}
	);

	App.Dialogs.open(
	{
		selector: '#messageDialog',
		title: title
	});
}

// Shows an error dialog to the user (message dialog with error
// title).
App.Dialogs.error = function(message)
{
	if (typeof message === 'string' || message instanceof String) {
		App.Dialogs.message(message, Consts.dialogTitleError);
	} else {
		App.Ajax.errorDialog();
	}
}

// Closes a dialog.
App.Dialogs.close = function(selector)
{
	$(selector).dialog('close');

	// Reset the overflow attribute to the body to enable scrolling again
	$('body').css('overflow', 'auto');
}

App.Dialogs.closeTop = function()
{
	if (App.Dialogs.dialogs.length == 0)
	{
		return;
	}

	var dialog = App.Dialogs.dialogs[App.Dialogs.dialogs.length - 1];
	dialog.dialog('close');

	// Reset the overflow attribute to the body to enable scrolling again
	$('body').css('overflow', 'auto');
}

// Opens and displays a dialog.
App.Dialogs.open = function(o)
{
	var d = $(o.selector);

	// Adds an overflow hidden attribute to the body to prevent scrolling
	$('body').css('overflow','hidden');

	// Get the dialog width (and height with resizable)
	var height = 0;
	if (o.resizable)
	{
		var height = parseInt(d.css('height'));
	}
	else
	{
		var height = 0;
	}

	var resized = false; // Set in the resizeStop event
	var width = parseInt(d.css('width'));

	App.Dialogs.init(o.selector);

	// Set the dialog width (and height with resizable). For
	// resizable dialogs, we limit the height and width to the window
	// size (minus some margin), so that the dialog is always fully
	// visible. We also support min height and width parameters from
	// the caller.
	if (o.minHeight)
	{
		d.dialog('option', 'minHeight', o.minHeight);
	}

	if (o.minWidth)
	{
		d.dialog('option', 'minWidth', o.minWidth);
	}

	if (height)
	{
		if (o.resizable)
		{
			var max_height = $(window).height();
			height = Math.min(height, Math.round(max_height * 0.9));
		}

		d.dialog('option', 'height', height);
		d.data('height', height);
	}

	if (width)
	{
		if (o.resizable)
		{
			var max_width = $(window).width();
			width = Math.min(width, Math.round(max_width * 0.9));
		}

		d.dialog('option', 'width', width);
		d.data('width', width);
	}

	// Register for the click event on the close action and close
	// the dialog in the event handler.
	$('.dialog-action-close', d).unbind('click.dialog');
	$('.dialog-action-close', d).bind('click.dialog',
		function()
		{
			$(this).closest('.dialog').dialog('close');

			// Reset the overflow attribute to the body to enable scrolling again
			$('body').css('overflow', 'auto');

			if (o.cancel) {
				o.cancel();
			}
		}
	);

	$('.ui-dialog-titlebar-close').click(function() {
			// Reset the overflow attribute to the body to enable scrolling again
			$('body').css('overflow', 'auto');
	});

	// Set the dialog title
	if (o.title)
	{
		d.dialog('option', 'title', o.title);
	}
	else if (o.titleSelector)
	{
		d.dialog('option', 'title',
			$('.dialog-title ' + o.titleSelector, o.selector).text());
	}
	else
	{
		d.dialog('option', 'title',
			$('.dialog-title', o.selector).text());
	}

	if (o.titleColor)
	{
		d.prev().css('background', o.titleColor);
	}

	// Setup open and close events
	d.dialog('option', 'open', function(event, ui)
	{
		if (o.resizable)
		{
			var buttons = $('.dialog-buttons-pane-container', $(this));
			if (buttons.length)
			{
				buttons.insertAfter($(this));
			}
			else
			{
				buttons = $(this).next('.dialog-buttons-pane-container');
			}

			$('.dialog-body', $(this)).css(
				'height',
				$(this).outerHeight() - buttons.outerHeight()
			);
		}

		var target = $(event.target);
		var autoFocus = o.autoFocus === undefined || o.autoFocus;

		if (autoFocus)
		{
			if (o.focusedControl)
			{
				$(o.focusedControl).focus();
				if (o.selectedControl)
				{
					$(o.selectedControl).select();
				}
			}
			else
			{
				// Try to select the first control (i.e. input, select or
				// textarea) in the dialog (not applicable when the content
				// of the dialog is loaded dynamically in o.show(), e.g.).
				$(':input:visible:first', target).focus();
			}
		}

		App.Dialogs.dialogs.push(target);

		if (o.show)
		{
			o.show();
		}
	});

	d.dialog('option', 'close', function(event, ui)
	{
		if (o.close)
		{
			o.close();
		}

		App.Dialogs.dialogs.pop();

		if (!resized)
		{
			// If we are not in resize mode, we simply restore the saved
			// width/height so that the dialog has the correct size the
			// next time we open it.
			d.css('width', d.data('width'));
			d.css('height', d.data('height'));
		}
		else
		{
			var parent = d.closest('.ui-dialog');
			d.css('width', parent.css('width'));
			d.css('height', parent.css('height'));
		}

		if (jQuery.browser.webkit)
		{
			if (document.activeElement)
			{
				$(document.activeElement).blur();
			}
		}
	});

	if (o.resizable)
	{
		d.dialog('option', 'resizable', true);

		d.dialog('option', 'resize', function(event, ui)
		{
			var t = $(this);

			// Resize the body of the dialog according to the size of
			// the dialog.
			var buttons = t.next('.dialog-buttons-pane-container');

			$('.dialog-body', t).css(
				'height',
				t.outerHeight() - buttons.outerHeight()
			);
		});

		d.dialog('option', 'resizeStop', function(event, ui)
		{
			resized = true;
			if (o.resizeStop)
			{
				o.resizeStop(event, ui);
			}
		});
	}

	if (o.init)
	{
		o.init();
	}

	// Does the dialog has a custom enter/submit callback?
	if (o.enter)
	{
		d.data('enter', o.enter);
	}
	else
	{
		d.data('enter', function(dialog)
		{
			// Trigger the default button / link of the dialog.
			$('a.dialog-action-default', dialog).click();
			$('button.dialog-action-default', dialog).submit();
		});
	}
	if (o.additionalCss) {
		$(o.selector).parent().css(o.additionalCss);
	}
	d.dialog('open');
}

App.Dialogs.setOption = function(selector, name, value)
{
	$(selector).dialog('option', name, value);
}

App.Dialogs.setWidth = function(selector, width)
{
	$(selector).dialog('option', 'width', width).
		dialog('option', 'position', 'center');
}

App.Dialogs.ranorexBannerConfirm = function(title)
{
    App.Dialogs.open(
        {
            selector: '#ranorexDialog',
            title: title,
            titleColor: '#D04437',
            init: function() {}
        });
};

App.Dialogs.trEnterpriseBannerConfirm = function(title)
{
    App.Dialogs.open(
        {
            selector: '#trEnterpriseDialog',
            title: title,
            titleColor: '#D04437',
            init: function() {}
        });
};

App.Dialogs.trEnterpriseBannerConfirmNew = function(pos) {
	App.Ajax.call({
		target: '/enterprise/ajax_close_banner',
		success: function(data) {
			if (pos === 'sidebar') {
				$('#sidebar_confirm').html(data);
				$('#sidebar_banner_desc').css('display', 'none');
			} else {
				$('#logo_confirm').html(data);
				$('#logo_banner_desc').css('display', 'none');
			}
			$('#popupBannerConfirmSidebar').css('display', 'block');
		},
		error: function(data) {
			App.Ajax.handleError(data);
		}
	});
}

App.Dialogs.closeOverlay = function() {
	$('.banner_overlay').css('display', 'none');
	$('#sidebar_banner_desc').css('display', 'block');
	$('#logo_banner_desc').css('display', 'block');
}

App.Dialogs.BulkDeleteDialog = function() {
	App.Dialogs.open({
		selector: '#bulkDeleteDialog',
		titleColor: 'red'
	});

	$('input[name="deleteCheckbox"]').on('change', function() {
		if (this.checked) {
			$('.dialog-action-default').removeClass('button-disabled button-black-disabled');
		} else {
			$('.dialog-action-default').addClass('button-disabled button-black-disabled');
		}
	});
}


;

