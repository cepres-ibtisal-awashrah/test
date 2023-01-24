/*******************************************************************/
/* Dropzones */

/* [Permissions checked!] */

App.ready(function()
{
	Dropzone.autoDiscover = false;
});

App.Dropzone = new function()
{
	var self = this;

	self.elements = null;
	self.appliedDropElements = [];
	self.dnd_text = false;

	self.init = function()
	{
		self._resetDocumentDrag();
		self.preview = '<div class="dz-preview dz-file-preview">' +
			'<div class="dz-image"><img data-dz-thumbnail /></div>' +
			'<div class="dz-details"><div class="dz-size"><span data-dz-size></span></div><div class="dz-filename"><span data-dz-name></span></div></div>' +
			'<div class="dz-remove"><a class=dz-remove-link" href="javascript:void(0)" data-dz-remove>' + lang('attachments_remove_image') + '</a></div>' +
			'<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>' +
		'</div>';

		// Drag enter and leave for $(document) are complex because the
		// leave events are also fired when a child element is reached,
		// We keep track of all enter/leave elements in a list and only
		// leave the document once the list is empty. Note: the events
		// are not triggered for dropzone elements and this is covered
		// by the enter/leave for the dropzone object (see `apply'). We
		// also make sure to detect drag&drops from input/textareas on
		// the page via the dragstart to avoid the overlay dropzones in
		// this special case.

		$(document).on(
			'dragstart',
			function(e)
			{
				if (!e.target)
				{
					return;
				}

				var t = $(e.target);

				// If we are dealing with a textarea or input, we can
				// ignore this d&d attempt for the dropzones. This can
				// include other elements as well (<p>, text) but
				// textarea/input are the most important.

				if (t.is('textarea') || t.is('input') || t.is('img'))
				{
					self.dnd_text = true;
				}
			}
		);

		$(document).on(
			'dragenter',
			function(e)
			{
				if (self.dnd_text)
				{
					return; // Don't activate for detectable text
				}

				if (self.elements.length == 0)
				{
					$.publish('body.drag_started');
					self.show();
				}

				// Only visible elements are added as some browsers do
				// not fire the leave event for hidden elements (also
				// see _show which can hide elements).

				var t = $(e.target);
				if (t.is(':visible'))
				{
					self._addToDocumentDrag(e.target);
				}

				return false;
			}
		);

		$(document).on(
			'dragleave',
			function(e)
			{
				if (self.dnd_text)
				{
					return;
				}

				self._removeFromDocumentDrag(e.target);

				if (self.elements.length == 0)
				{
					self.hide();
					$.publish('body.drag_stopped');
				}

				return false;
			}
		);

		$(document).on(
			'dragend',
			function(e)
			{
				// Only called for unsuccessful drop attempts that are
				// not handled by dropzone (e.g. text). We make sure to
				// hide the dropzones and reset the d&d state.
				self.hide();
				$.publish('body.drag_stopped');
				self._resetDocumentDrag();
			}
		);
	}

	self._addToDocumentDrag = function(t)
	{
		self.elements = self.elements.add(t);
	}

	self._removeFromDocumentDrag = function(t)
	{
		self.elements = self.elements.not(t);
	}

	self._resetDocumentDrag = function()
	{
		self.elements = $();
		self.dnd_text = false;
	}

	self.applyDrop = function(selector, o)
	{
		if ($(selector).data('has-drop')) {
			return;
		}

		var dropzone = new Dropzone(
			selector,
			{
				url: o.url + '&is_upload=1', // For error handling
				acceptedFiles: o.files || null,
				paramName: 'attachment',
				parallelUploads: 3,
				uploadMultiple: false,
				filesizeBase: 1024,
				thumbnailWidth: 90,
				thumbnailHeight: 75,
				previewTemplate: self.preview,
				dictDefaultMessage: o.dict.drop,
				dictInvalidFileType: o.dict.notype,
				params: o.params,
				clickable: o.clickable === undefined ? true : o.clickable,
				previewsContainer: o.previewsContainer,
				autoProcessQueue: o.autoProcessQueue === undefined ? true : o.autoProcessQueue,

				sending: function(file, xhr, form)
				{
					form.append('_token', Consts.ajaxCsrf);
				}
			}
		);

		$(selector).data('has-drop', 'true');

		// Indicate progress for Ajax (blocks user interactions during
		// upload).

		dropzone.on(
			'addedfile',
			function(file, isPasted)
			{
				if (file.type.match(/image.*/) && !isPasted) {
					dropzone.options.autoProcessQueue = false;
				}

				if (o.addedfile) {
					o.addedfile(file);
				}

				if (!o.doNotStartBlockUI) {
					App.Ajax.start();
				}
			}
		);

		dropzone.on(
			'complete',
			function()
			{
				App.Ajax.stop();
			}
		);

		// Start/stop/success/error event handling for clients.

		var file_count = 0;
		var image_count = 0;
		var processed_images = 0;

		dropzone.on(
			'addedfiles',
			function(files)
			{
				file_count = files ? files.length : 0;
				for (var i = 0; i < files.length; i++) {
					if (files[i].type.match(/image.*/) && files[i].size < (dropzone.options.maxThumbnailFilesize * 1024 * 1024)) {
						image_count++;
					}
				}
				if (o.start)
				{
					o.start(files);
				}
			}
		);

		dropzone.on(
			'success',
			function(file, data)
			{
				if (data && data.result)
				{
					if (o.success)
					{
						o.success(file, data);
					}
				}
				else
				{
					if (file)
					{
						dropzone.removeFile(file);
					}

					self.showError();
				}

				file_count--;
				if (file_count <= 0)
				{
					if (o.stop)
					{
						o.stop();
					}
				}
			}
		);

		dropzone.on(
			'error',
			function(file, error, xhr)
			{
				if (file)
				{
					dropzone.removeFile(file);
				}

				if (error && typeof error === 'string')
				{
					self.showError(error);
				}
				else
				{
					self.showError();
				}

				file_count--;
				if (file_count <= 0)
				{
					if (o.stop)
					{
						o.stop();
					}
				}
			}
		);

		// $(document) drag enter/leave management, also see init().

		dropzone.on(
			'dragenter',
			function(e)
			{
				self._addToDocumentDrag(e.target);
			}
		);

		dropzone.on(
			'drop',
			function(e)
			{
				self._resetDocumentDrag();
			}
		);

		dropzone.on(
			'dragleave',
			function(e)
			{
				self._removeFromDocumentDrag(e.target);
			}
		);

		dropzone.on(
			'thumbnail',
			function(file, thumb, thumb1, thumb2)
			{
				var blob = self.dataURItoBlob(thumb1);
				file.thumbnail1 = blob;
				blob = self.dataURItoBlob(thumb2);
				file.thumbnail2 = blob;
				processed_images++;
				if (processed_images === image_count) {
					var processQueue = o.autoProcessQueue === undefined ? true : o.autoProcessQueue;
					if (processQueue) {
						dropzone.processQueue();
						dropzone.options.autoProcessQueue = processQueue;
					}
					image_count = 0;
					processed_images = 0;
				}
			}
		);

		dropzone.on(
			'sending',
			function(file, xhr, formData)
			{
				if (file.type.match(/image.*/)) {
					formData.append('thumbnail', file.thumbnail1);
					formData.append('thumbnail2', file.thumbnail2);
				}
			}
		);

		return dropzone;
	}

	self.dataURItoBlob = function (dataURI) {
		var byteString;
		if (dataURI.split(',')[0].indexOf('base64') >= 0)
			byteString = atob(dataURI.split(',')[1]);
		else
			byteString = unescape(dataURI.split(',')[1]);
		var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
		var ia = new Uint8Array(byteString.length);
		for (var i = 0; i < byteString.length; i++) {
			ia[i] = byteString.charCodeAt(i);
		}

		return new Blob([ia], {type:mimeString});
	}

	self.show = function()
	{
		$('.dropzone:not(.dz-persistent)').each(self._show);
	}

	self._show = function()
	{
		var d = $(this);
		var rel = d.attr('rel'), control = null;

		// If the dropzone is related to another control (textarea etc.)
		// we use the same height for the dropzone as the control and
		// hide the control.

		if (rel)
		{
			control = $('#' + rel);
			if (control.hasClass('textarea-with-grippie'))
			{
				control = control.parent();
			}

			d.css('min-height', control.outerHeight() + 'px');
		}

		var can_show = true;

		// If there's a dialog active, the allowed/target dialog of the
		// dropzone must match.

		var dialog = App.Dialogs.getActive();
		if (dialog)
		{
			can_show = d.attr('dialog') == dialog.attr('id');
		}

		if (can_show)
		{
			if (control)
			{
				control.hide();
			}
			d.show();
		}
	}

	self.hide = function()
	{
		$('.dropzone:not(.dz-persistent)').each(self._hide);
	}

	self._hide = function()
	{
		var d = $(this);
		var rel = d.attr('rel');

		d.hide();

		// See _show
		if (rel)
		{
			var control = $('#' + rel);
			if (control.hasClass('textarea-with-grippie'))
			{
				control = control.parent();
			}
			control.show();
		}
	}

	self.addAttachment = function(file, attachment_id)
	{
		if (file && file.previewElement)
		{
			$(file.previewElement).attr('rel', attachment_id);
		}
	}

	self.getAttachments = function(selector)
	{
		var ids = [];

		$('.dz-preview', $(selector)).each(
			function(ix, v)
			{
				ids.push($(this).attr('rel'));
			}
		);

		return ids;
	}

	self.showError = function(error)
	{
		error = error || lang('attachments_loading_error_generic');
		App.Dialogs.error(error);
		var dialog = App.Dialogs.getActive();
		dialog.dialog('option', 'title', lang('attachments_loading_error_title'));
		dialog.prev().css('background', '#E40046');
		dialog.prev().css('color', '#FFFFFF');
	}
}

;

