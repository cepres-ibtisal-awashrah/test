/*******************************************************************/
/* Global application namespace */

/* [Permissions checked!] */

var App = new function()
{
	var self = this;

	self.keyEscape = 27;
	self.keyEnter = 13;

	self.ready = function(callback)
	{
		$(document).ready(callback);
	}

	self.escapeId = function(id)
	{
		// IDs in TestRail can contain ':' characters which need to
		// be escaped for jQuery.
		return id.replace(/(:)/g, '\\$1');
	}

	self.escapeHTML = function(html)
	{
		return $('<div />').text(html).html();
	}

	self.applyDatepicker = function(ctx)
	{
		$('input.datepicker', ctx || $(document)).datepicker(
		{
			duration: 0,
			showAnim: ''
		})
	}

	self.applyFancyBox = function(ctx)
	{
		// Enable fancy box for markdown images
		if ($.fn.fancybox)
		{
			$('a.fancy', ctx || $(document)).fancybox(
			{
				zoomOpacity: false,
				overlayShow: false,
				centerOnScroll: false // Don't mess with resize/scroll events
			});
		}
	}

	self.applyTextAreaResizer = function()
	{
		// Make text areas resizable
		var texts = $('textarea.form-control:not(.processed)');
		if (texts.length > 0)
		{
			texts.textarearesizer();
		}
	}

	self.applyPopups = function()
	{
		var windowHeight = $(window).height();
		var height = Math.max(600, windowHeight * 0.7);

		var parameters = "location=0,menubar=1,height=" + height +
			",width=700,toolbar=0,scrollbars=1,status=0,resizable=1";

		$(document).on({
			click: function()
			{
				window.open(this.href, 'popup', parameters).focus();
				return false;
			}},
			'a.popupLink'
		);
	}

	self.applyKeepGet = function()
	{
		$(document).on({
			click: function(e) {
				$.publish('page.set_get', {
					link: this
				});

				var query = App.Page.getQuery();
				if (query)
				{
					var a = $(this);
					a.attr('href', a.attr('href') + '&' + query);
				}
			}},
			'a[rel="keep-get"]'
		);
	}

	/** Begin of notification bars */
	self.applyNotificationBar = function () {
		let notificationItemClass = '.notificationbar-decoration';
		let $notificationBar = $('#notificationbar');
		let notificationsArray = (Cookies.get('notificationbar') || '').split('-');
		let notifications = $notificationBar.find(notificationItemClass);
		let isNotificationBarEmpty = function () {
			return $notificationBar.find(notificationItemClass).length === 0;
		};

		if (notificationsArray[0] === '') {
			notificationsArray.shift();
		}

		if (notifications.length > 0) {
			let notificationHiddenClassName = 'notificationbar-hidden';

			$notificationBar.removeClass(notificationHiddenClassName);
			notifications.each( function () {
				let $this = $(this);
				let notificationId = $this.attr('id').toString();

				if ($.inArray(notificationId, notificationsArray) === -1) {
					$this.removeClass(notificationHiddenClassName);
				} else {
					$this.remove();
				}
			});
		}

		if (isNotificationBarEmpty()) {
			 $notificationBar.remove();
		}

		$notificationBar.find('.notificationbar-content-dismiss').on('click', function (event) {
			let notificationId = $(this).closest('.notificationbar-decoration').attr('id').toString();
			if ($.inArray(notificationId, notificationsArray) === -1) {
				$('#' + notificationId).slideUp('slow', function () {
					$(this).remove();
					if (isNotificationBarEmpty()) {
						$notificationBar.remove();
					}
				});
				notificationsArray.push(notificationId);
				let slashSeparator = '/';
				let $location = $(location);
				let path = $location[0]['pathname'] === undefined ? slashSeparator : $location[0]['pathname'];
				if (path !== slashSeparator) {
					path = slashSeparator + path.split('.php')[0].split(slashSeparator).slice(1, -1).join(slashSeparator);
				}
				Cookies.set(
					'notificationbar',
					notificationsArray.join('-'),
					{
						expires: 32,
						path: path
					}
				);
			}

			event.stopPropagation();
			event.preventDefault();

			return false;
		});

		$('#form .searchable').each(function(ix, v) {
			var dropdown = $(v);
			// Apply the chosen control
			dropdown.chosen();
		});
	} /** End of notification bar */

	self.showLocalNotification = function (notificationId) {
		let notificationHiddenClassName = 'notificationbar-hidden';
		let notification = $(notificationId);
		notification.removeClass(notificationHiddenClassName);
	}

	self.hideLocalNotification = function (notificationId) {
		let notificationHiddenClassName = 'notificationbar-hidden';
		let notification = $(notificationId);
		notification.addClass(notificationHiddenClassName);
	}

	self.getPath = function () {
		let slashSeparator = '/';
		let $location = $(location);
		let path = $location[0]['pathname'] === undefined ? slashSeparator : $location[0]['pathname'];
		if (path !== slashSeparator) {
			path = slashSeparator + path.split('.php')[0].split(slashSeparator).slice(1, -1).join(slashSeparator);
		}
		return path;
	}

	self.applyLocalNotificationsBar = function () {
		let storageLimitsNotificationCookieAge = 7;
		let storageLimitsNotificationCookieName = 'notificationbar-local';
		let notificationItemClass = '.notificationbar-local';
		let notificationBar = $(notificationItemClass);
		let path = self.getPath();

		if ($('.notificationbar-decoration').length === 0) {
			notificationBar.remove();
		}

		let recentClosedNotification = Cookies.get(storageLimitsNotificationCookieName);
		notificationBar.find(notificationItemClass).each(function () {
			let bannerId = $(this).attr('id');

			if (bannerId === recentClosedNotification) {
				notificationBar.remove();
				return false;
			} else {
				Cookies.remove(storageLimitsNotificationCookieName, {path: path});
			}
			self.showLocalNotification('#' + bannerId);
		});

		notificationBar.find('.notification-local-dismiss').on('click', function () {
			let notification = $(this).closest(notificationItemClass);
			let notificationId = notification.attr('id');

			$('#' + notificationId).slideUp('slow', function () {
				$(this).remove();
				if (notificationBar.find(notificationItemClass).length === 0) {
					notificationBar.remove();
				}
			});

			Cookies.set(
				storageLimitsNotificationCookieName,
				notificationId,
				{
					expires: storageLimitsNotificationCookieAge,
					path: path
				}
			);
		})
	}
  /** End of local notifications bar */

	if ($.blockUI)
	{
		$.blockUI.defaults.message = '';
		$.blockUI.defaults.fadeOut = 0;
		$.blockUI.defaults.fadeIn = 0;
		$.blockUI.defaults.baseZ = 10000;
		$.blockUI.defaults.overlayCSS = {};
	}

	// Initialize the environment for the page and apply any dynamic
	// actions or layouts.
	self.ready(function()
	{
		self.applyTextAreaResizer();
		self.applyFancyBox();
		self.applyPopups();
		self.applyKeepGet();
		self.applyNotificationBar();
		self.applyLocalNotificationsBar();
	});
};

/*******************************************************************/
/* Various helper methods */

// TODO: move all functions to 'fields' module where they are used

App.callFunction = function(namespace, name, o)
{
	if (namespace)
	{
		var fn = namespace[name];
	}
	else
	{
		var fn = window[name];
	}

	if (typeof fn === 'function')
	{
		return fn(o);
	}
	else
	{
		return false;
	}
}

App.getCount = function(collection)
{
	var size = 0;

	$.each(collection, function(ix, v)
	{
		size++;
	});

	return size;
}

;

