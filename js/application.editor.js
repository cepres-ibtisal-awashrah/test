/*******************************************************************/
/* Textarea editor */

/* [Permissions checked!] */

App.Editor = new function()
{
	var self = this;

	self.dropzone = null;
	self.editor_dropzone = {};
	self.entity_id = null;
	self.entityType = null;
	self.projectId = null;
	self.imageDialogUploadSuccess = null;
	self.imageDialogSuccess = null;
	self.selectionRange = [];
	self.lastEnterKey = '';
	self.isImageDroped = false;
	self.contentEditableHistory = [];
	self.contentEditablePrevHistory = [];
	self.isMultiple = null;
	self.addedFileCounts = 0;
	self.currentFocussedElement = null;
	self.imageDraged = false;
	self.imagePasted = false;
	self.pastedImages = [];
	self.pastedImageStatus = false;

	self.init = function(project_id)
	{
		// We also support pasting images via the FileReader API (for
		// some browsers) and this is the place to set it up. In the
		// paste event, we open the regular Add Image dialog for the
		// active textarea and add the file to the dropzone.

		$(document.body).clipboard(
			{
				paste: function(e, file, isMultiple, index)
				{
					self.isMultiple = isMultiple;
					imagePasted = true;
					self.pastedImages.push(index);
					self.pastedImageStatus = true;

					if (document.activeElement.id != "defect_description") {
						self._pasteImage(
							document.activeElement,
							project_id,
							file
						);
					} else {
						var pushDropZone = Dropzone.forElement("#pushdropzone");
						pushDropZone.addFile(file);
					}
				}
			}
		);

		$(document).delegate('.field-editor .attachment', 'mousedown', function(evt) {
			var listParent = '#' + $(evt.target).parent()[0].id;
			$(listParent).attr('start', new Date().getTime());
			$(listParent).attr('timeout', setTimeout(function() {
				App.Attachments.toggleSelectionInline(evt.target, $(evt.target).data('attachment-id'), listParent);
			}, 500));
		});

		$(document).delegate('.field-editor .attachment', 'mouseleave', function(evt) {
			var listParent = '#' + $(evt.target).parent()[0].id;
			$(listParent).attr('start', 0);
		});

		$(document).delegate('.field-editor .attachment', 'mouseup', function(evt) {
			var listParent = '#' + $(evt.target).parent()[0].id;
			if (new Date().getTime() < (parseInt($(listParent).attr('start')) + 500)) {
				clearTimeout($(listParent).attr('timeout'));
				if ($(listParent).prop('deleteMode')) {
					App.Attachments.toggleSelectionInline(evt.target, $(evt.target).data('attachment-id'), listParent);
				} else {
					App.Attachments.showInfoDialog($(evt.target).data('attachment-data-id'));
				}
			}
		});

		$(document).ready(function() {
			$.each($('.editor-bindable'), function(_idx, el) {
				if ($(el).data('attribute') !== 'editSectionDescription') {
                    App.Editor.bind($(el).data('attribute'));
                }
			});
		});
	}

	self._pasteImage = function(control, project_id, file)
	{
		// If the Add Image dialog is not currently active, we open it.
		// This also requires a valid textarea control. In case the
		// dialog is already open, we can use the current textarea and
		// also add the file to the dropzone.

		if (!App.Dialogs.isActive('attachmentDialog'))
		{
			if (!control || !$(control).hasClass('field-editor')) {
				return;
			}
			self.addImage(control, project_id, undefined, undefined, undefined, true);
		}
		self.dropzone.addFile(file, true);

	}

	self._triggerEvent = function(fieldName, _element, evt) {
		if (
			$(_element).find('.attachment-list-delete-inline').length === 0 &&
			$(_element).find('.attachment-list-item').length > 0
		) {
			
			$(_element + ' .attachment-block:last').after(
				'<div contenteditable="false"' +
					'class="inlineAttachmentListRemove attachment-list-delete-inline" ' +
					'style="display: none;" ' +
					'href="javascript:void(0)" ' +
					'onclick="' +
						'App.Attachments.entityRemoveAttachmentsDialog(' +
							'\'' + lang('attachments_confirm_delete') + '\',' +
							'\'' + self.projectId + '\',' +
							'\'' + self.entityType + '\',' +
							'\'#' + fieldName + '_attachments_wrapper\'' +
						');' +
						'$(\'' + _element + ' .inlineAttachmentListRemove\')' +
						'.hide(); ' +
						'return false;' +
					'">' +
					'<div class="attachment-list-delete-icon">' +
					'</div>' +
					'<span>' +
						lang('attachments_delete') +
					'</span>' +
				'</div>' +
				'<span ' +
					'contenteditable="false" ' +
					'class="inline-attachment-list-whitespace" ' +
				'>' +
				'</span>'
			);
		}

		$('#' + fieldName).val(
			self.formatValueForDB($(_element))
		);

		if (evt.type === 'paste') {
			if (
				(!App.Env.isWindows()
				&& !App.Env.isChrome())
				|| (!App.Env.isSafari()
				&& !App.Env.isMac())) {
				evt.preventDefault();
			}
			let items = (evt.clipboardData  || evt.originalEvent.clipboardData).items;
			let blob = null;

			for (let i = 0; i < items.length; i++) {
				let items_val = items[i];
				if (blob === null && items_val.type.indexOf('image') === 0 ) {
					blob = items_val.getAsFile();
				}

			}

			if (blob === null) {
				let pastedText = null;
				let xhtmltext = (evt.originalEvent || evt).clipboardData.getData('text/plain');

				if (xhtmltext) {
					pastedText = xhtmltext;
				}

				if (
					(!App.Env.isWindows()
					&& !App.Env.isChrome())
					|| (!App.Env.isSafari()
					&& !App.Env.isMac())) {
					document.execCommand(
						self._isHTML(pastedText)
						&& !pastedText.startsWith('<?xml')
						&& !self._hasScriptTrigger(pastedText)
							? 'insertHTML'
							: 'insertText',
						false,
						pastedText
					);
				} else {
					document.execCommand(
						self._isHTML(pastedText),
						false,
						$.trim(pastedText)
					);
				}

			}
		}

		if (evt.keyCode === 8) {
			if (!App.Env.isChrome()) {
				evt.preventDefault();
				evt.stopPropagation();
				var select = window.getSelection();
				let string = JSON.stringify(select.focusNode.data ?? '').substring(0, select.focusOffset + 1);

				if (string.match(/.*(\\r\\?|\\r\\?\\n\\?)$/gmi)) {
					document.execCommand('delete', false, null);
				}

				return false;
			}
		}

		if (evt.keyCode === App.keyEnter) {
			evt.preventDefault();
			evt.stopImmediatePropagation();
			document.execCommand('insertLineBreak');

			if (!App.Env.isChrome()) {
				if (evt.target.innerHTML.match(/\r<br>\n/g)) {
					$(_element).find('br').before(document.createTextNode('\n\r')).remove();
					document.execCommand('delete', false, null);
				} else if (fieldName !== 'addCommentComment') {
					$(_element).find('br').before(document.createTextNode('\r\n')).remove();
				}
			}
		}
	}

	self.bind = function(fieldName, suffixParam)
	{
		let suffix = suffixParam ?? '_display';
		let _element = '#' + fieldName + suffix;
		let _events = 'blur keyup paste copy cut delete';
		let comment_fields = [
			'addCommentInline',
			'addCommentComment',
			'editRunDescription',
			'editSectionDescription',
		];

		$(document).on('keydown', _element, function (evt) {
			if (evt.keyCode === App.keyEnter) {
				evt.preventDefault();
				evt.stopPropagation();
			}

			if (evt.keyCode === App.keyEnter 
				&& (App.Env.isMac() && !App.Env.isChrome() && !App.Env.isFirefox())) {
				document.execCommand('insertLineBreak');
			}

			if (evt?.keyCode === 90 && (evt.ctrlKey || evt.metaKey)) {
				evt.preventDefault();
				evt.stopPropagation();
				evt.stopImmediatePropagation();
				let index = '#' + evt.target.getAttribute('id');

				self.contentEditableHistory[index] = self.contentEditableHistory[index]?.filter(function (e) {
					if (e === undefined) {
						return false;
					}

					return true;
				});

				let removeElement = self.contentEditableHistory[index]?.pop();

				if (removeElement?.textContent === '\n'
					|| removeElement?.textContent === '\n\r'
					|| (_element?.textContent !== undefined
					&& removeElement?.textContent === undefined)
					&& !removeElement?.textContent.match(/(\n|\t)/) === false
					|| removeElement?.textContent === ''
					|| removeElement?.textContent === 'Delete') {
					let _event = $.Event("keydown", {keyCode: 90, ctrlKey: true, metaKey: true});
					$(_element).trigger(_event);
				}

				removeElement?.remove();

				if (self.contentEditableHistory[index]?.length > -1) {
					let id = $(_element)?.attr('id');
					let attid = $(removeElement)?.attr('data-attachment-id');

					let wrapper = (id === 'addResultComment_display' || id.match('custom_')) && $('#result_content').length ? '#result_content' : '#form';

					if (id === 'addCommentInline_display') {
						wrapper = '#addCommentInlineAttachments';
					}

					if (id === 'addCommentComment_display') {
						wrapper = '#addCommentAttachments';
					}

					if (id.match('stepContent-') || id.match('stepExpected-')) {
						if ($('#create_shared_steps_form').length) {
							wrapper = '#create_shared_steps_form';
						} else {
							wrapper = '#form';
						}
					}

					if($(wrapper).length) {
						let data = $(wrapper + ' > #attachments').val();
						let newData = [];

						if (data) {
							for (let item of JSON.parse(data)) {
								if (item?.id !== attid) {
									newData = [...newData, item];
								}
							}
						}

						$(wrapper + ' > #attachments').val(JSON.stringify(newData));
					}
				}
			}
		});

		if (comment_fields.includes(fieldName) || fieldName.startsWith('custom_')) {
			$(document).on(_events, _element, function (evt) {
				evt.stopImmediatePropagation();
				self._triggerEvent(fieldName, _element, evt);
			});
		} else {
			$(_element).on(_events, function (evt) {
				self._triggerEvent(fieldName, _element, evt);
			});
		}

		$(_element).on("keydown", function (evt) {
			if (evt.keyCode === App.keyEnter) {
				if (fieldName !== 'addCommentComment' && fieldName !== 'editRunDescription') {
					evt.preventDefault();
					return;
				}

				let customStepsFastTrack = $('#' + fieldName).parents().find('.custom.steps.fast_track').not('#create_shared_steps');
				if (self._isSharedStepBox(evt.target.id)
					&& customStepsFastTrack.length === 1
					&& evt.type === 'keydown') {
					evt.preventDefault();
					let fieldSystemName = customStepsFastTrack[0].id;

					if (evt.ctrlKey || evt.metaKey) {
						if (evt.key === 'ArrowUp') {
							App.Cases.moveCurrentStepUp(fieldSystemName);
							evt.currentTarget.focus();
						} else if (evt.key === 'ArrowDown') {
							App.Cases.moveCurrentStepDown(fieldSystemName);
							evt.currentTarget.focus();
						} else if (evt.key === '.' && self.projectId) {
							App.Cases.addStepToCurrent(self.projectId, fieldSystemName);
						}
					} else if (evt.altKey && evt.key === '.' && self.projectId) {
						App.Cases.addStep(self.projectId, fieldSystemName);
					}
				}
			}
		});

		$(_element).on("focus", function (event) {
			event.preventDefault();

			if (!self.entityType || !self.projectId) {
				var currentHtml = $(this).html();
				var arr = currentHtml.substring(currentHtml.indexOf('App.Editor.addImage')).split(',');
				if (arr.length >= 3) {
					self.projectId = arr[1].trim().replace("'", "").replace("'", "");
					self.entityType = arr[2].trim().replace("'", "").replace("'", "");
				}
			}
		});
	}

	self._setElementRange = function(element, browser) {
		if (element) {
			if (!App.Env.isChrome()) {
				setTimeout(function() {
					let selection = window.getSelection();
					let range = document.createRange();
					range.setStartAfter(element);
					range.collapse(true);
					selection.removeAllRanges();
					selection.addRange(range);
				}, 200);
			}
		}
	}

	self._setElementCursorRange = function(callback = false) {
		setTimeout(function() {
			let selection = window.getSelection();
			let range = document.createRange();
			range.setStartAfter(selection.anchorNode);
			range.insertNode(document.createTextNode(' '));
			range.collapse(true);
			selection.removeAllRanges();
			selection.addRange(range);

			if (callback) {
				callback();
			}
		}, 1000);
	}

	self._hasScriptTrigger = function(pastedText) {
		if (pastedText) {
			let parsedString = new DOMParser().parseFromString(pastedText, 'text/html');
			let allTags = parsedString.getElementsByTagName('*');

			for (let attributeKey = 0; attributeKey < allTags.length; attributeKey++) {
				let elementAttributes = allTags[attributeKey].attributes;
				let attributesLength = elementAttributes.length

				if (attributesLength) {
					for (let elementKey = attributesLength - 1; elementKey >= 0; elementKey--) {
						if (elementAttributes[elementKey].name.toLowerCase().startsWith('on')) {

							return true;
						}
					}
				}
			}
		}

		return false;
	}

	self._isHTML = function(xhtml) {
        let htmlTags = ['a',
						'body',
						'br',
						'button',
						'div',
						'form',
						'head',
						'html',
						'i',
						'input',
						'meta',
						'nav',
						'noscript',
						'object',
						'p',
						'script',
						'select',
						'span',
						'strong',
						'table',
						'textarea'
        ];

        let parsedString = new DOMParser().parseFromString(xhtml, 'text/html').body;
        let all = parsedString.getElementsByTagName('*');
        let isHtml = false;
        let tags = [];

		for (let i = 0, max = all.length; i < max; i++) {
            let tagName = all[i].tagName;

			if (tags.indexOf(tagName) == -1) {
                tags.push(tagName);
            }
        }

        if (!xhtml.match(/((<(?:"[^"]*"['"]*|'[^']*'['"]*|[^'">])+>)|(https?:\/\/[\w\.\S]+))/g)) {
			isHtml = true;
        }

        return isHtml;
    }

	self._isSharedStepBox = function(id)
	{
		let $parentParent = $('#' + id).parent().parent();

		return $parentParent.length > 0 && $parentParent[0].className.indexOf('step-text-box') > -1;
	}

	self.formatValueForDB = function(element)
	{
		var tmp = element.clone(true);
		tmp.find('.attachment-list-add-inline').remove();
		tmp.find('.attachment-list-delete-inline').remove();
		tmp.find('.inline-attachment-list-whitespace').remove();
		$.each(tmp.find('div.attachment-list-item'), function(_idx, attachment) {
			var div = $(attachment);
			div.replaceWith(
				self._formatMarkdownAttachment(
					div.data('attachment-id')
				)
			);
		});

		$.each(tmp.find('br'), function(_idx, br) {
			$(br).replaceWith('\n');
		});
		$.each(tmp.find('div'), function(_idx, el) {
			$(el).prepend("\n");
		});

		var div = document.createElement("div");
		div.innerHTML = tmp.html();
		var txt = div.innerHTML.startsWith('<?xml') ? div.innerHTML : (div.textContent || div.innerText || "");
		txt = txt.split('<').join('&lt;');
		txt = txt.split('>').join('&gt;');

		return txt;
	}

	self.setSelectionRange = function(control, fromInlineButton, event)
	{
		let idIndex = '#' + $(control).attr('id');

		if (!self.contentEditableHistory[idIndex]) {
			self.contentEditableHistory[idIndex] = [];
		}

		if (fromInlineButton) {
			var range = document.createRange();
			var index = 0;
			var displayElement = $(control)[0].tagName.toLowerCase() === 'input' ? $(control + '_display')[0] : $(control)[0];
			$.each(displayElement.childNodes, function(idx, el) {
				if ($(el).hasClass('inlineAttachmentListRemove') || $(el).has('.inlineAttachmentListRemove').length) {
					index = idx;
					return false;
				}
			});
			range.setStart(displayElement, index);
			range.collapse(true);
			self.selectionRange[idIndex] = range.cloneRange();
		} else {
			let selection = window.getSelection();
			let currentRange = null;

			if (selection.focusNode) currentRange = selection.getRangeAt(0);

			let displayElement = $(control)[0].tagName.toLowerCase() === 'input' ? $(control + '_display')[0] : $(control)[0];
			let parentNode = currentRange ? currentRange.startContainer.parentNode : null;

			if (parentNode?.id !== displayElement?.id && self._hasScriptTrigger($(control).text())) {
				if (currentRange?.startContainer?.id !== displayElement?.id) {
					let range = document.createRange();

					if (displayElement?.childNodes?.length) {
						if (displayElement?.lastElementChild) {
							range.setStartAfter(displayElement?.lastElementChild, 0);
						} else {
							range.setStart(displayElement, displayElement?.childNodes?.length, 0);
						}
					} else {
						range.setStart(displayElement, 0);
					}

					range.collapse(true);
					self.selectionRange[idIndex] = range?.cloneRange();
				} else {
					self.selectionRange[idIndex] = currentRange?.cloneRange();
				}
			} else {
				self.selectionRange[idIndex] = currentRange?.cloneRange();
			}

			if (event?.keyCode !== 90 && (!event?.ctrlKey && !event?.metaKey)) {
				if (control.tagName !== 'DIV' && control.tagName !== 'SPAN' && [...document.querySelector(control).childNodes].indexOf(self.selectionRange[idIndex]?.startContainer) !== -1) {
					self.setHistory(idIndex, document.querySelector(control).childNodes, self.selectionRange[idIndex]?.startContainer);
				}
			}
		}
	}

	self.setHistory = function(idIndex, childNodes, element) {
		let current = [...childNodes].filter(function(item) {
			if (self.contentEditablePrevHistory[idIndex]?.indexOf(item) === -1) {
				return true;
			}

			return false;
		});

		for (let item of current) {
			if (!self.contentEditableHistory[idIndex]) {
				self.contentEditableHistory[idIndex] = [childNodes[0]];
			}

			self.contentEditableHistory[idIndex] = [...self.contentEditableHistory[idIndex], item];
		}

		if (self.contentEditableHistory[idIndex]?.indexOf([...childNodes][[...childNodes]?.length]) === -1) {
			self.contentEditableHistory[idIndex] = [...self.contentEditableHistory[idIndex], [...childNodes][[...childNodes]?.length]];
		}

		self.contentEditablePrevHistory[idIndex] = [...childNodes];

		self.contentEditableHistory[idIndex].push([...childNodes].indexOf(element));
	}

	self.addImage = function(control, project_id, entity_type, entity_id, fromInlineButton, isPasted)
	{
		self.currentFocussedElement = control;
		isPasted = isPasted || false;

		if (!self.dropzone)
		{
			self.dropzone = self._createImageDialogDropzone({
					project_id: project_id,
					params: {
						entity_type: entity_type,
						entity_id: entity_id || self.entity_id || ''
					}
				},
				isPasted
			);
		}

		self.setSelectionRange(control, fromInlineButton);
		self.lastEnterKey  = '';

		if (isPasted) {
			if (!$('#' + control.id + '_loader').length) {
				$('#' + control.id)
				.parent()
				.before(
					'<span id="' + control.id + '_loader" class="action-expanding">' +
						'<div class="icon-progress-inline"></div>' +
					'</span>'
				);
			}
		}

		if (!self.isMultiple) {
			self._addImageDialog(project_id, entity_type, entity_id,
				{
					success: async function(attachments)
					{
						self.projectId = project_id;
						self.entityType = entity_type;
						await self._addAttachments(control, attachments);

						self._setElementCursorRange();

						setTimeout(function() {
							let selection = window.getSelection();
							let range = document.createRange();
							range.setStartAfter(selection.anchorNode);
							range.insertNode(document.createTextNode(' '));
							range.collapse(true);
							selection.removeAllRanges();
							selection.addRange(range);
						}, 1000);
					},
					cancel: function()
					{
						self._deleteAttachments(App.Dropzone.getAttachments('#attachmentDropzone'))
					},
					close: function()
					{
						$(self.dropzone.element).data('has-drop', false);
						self.dropzone.destroy();
						self.dropzone = null;
					}
				},
				isPasted
			);
		}
	}

	self._formatAttachment = function(attachment)
	{
		return App.Page.formatUri(
			"<img src='{0}/attachments/get/{1}' data-attachment-id='{2}' data-attachment-data-id='{3}' class='attachment'>",
			Consts.ajaxBaseUrl,
			attachment.dataId || attachment.data_id,
			attachment.id,
			attachment.dataId || attachment.data_id
		);
	}

	self._formatMarkdownAttachment = function(attachment_id)
	{
		return App.Page.formatUri(
			'![]({0}/attachments/get/{1})',
			Consts.ajaxBaseUrl,
			attachment_id
		);
	}

	self._addAttachments = async function(control, attachments, fromDropzone)
	{
		if (jQuery.type(control) === 'object') {
			var controlId = $(control).prop('id');
			control = '#' + controlId.replace('_display', '');
		}

		if (fromDropzone === undefined) {
			fromDropzone = false;
		}

		let text = [];
		let index = control;

		$.each(attachments, function(_ix, v) {
			text.push($((typeof v === 'string') ? v : self._formatAttachment(v)));
		});

		if ((!index.match('_display') && (index.match('custom_') || index.match('addCommentInline')))) index = index + '_display';

		if ((index.match('description') || index.match('addCommentComment') || index.match('addResultComment')) && !index.match('_display')) index = index + '_display';

		if (self.selectionRange[index] && !fromDropzone && !self.isMultiple) {
			self.selectionRange[index] = await $(control + '_display, ' + control).eachDivInsertAtCaret(
				self.selectionRange[index],
				text,
				{
					imagePasted: self.imagePasted,
					imageDraged: self.imageDraged
				}
			);
		} else if (self.selectionRange[index]?.startOffset === 0 || self.isMultiple) {
			self.selectionRange[index] = await $(control + '_display, ' + control).eachDivInsertAtCaret(
				self.selectionRange[index],
				text,
				{
					imagePasted: self.imagePasted,
					imageDraged: self.imageDraged
				}
			);
		} else {
			self.selectionRange[index] = await $(control + '_display, ' + control).eachDivInsertAtCaret(
				self.selectionRange[index],
				text,
				{
					imagePasted: self.imagePasted,
					imageDraged: self.imageDraged
				}
			);
		}

		self.imagePasted = false;
		self.imageDraged = false;
		self.pastedImages?.pop();

		if (!self.pastedImages.length && self.pastedImageStatus) {
			self._setElementCursorRange(function() {
				self.pastedImageStatus = false;
			});

			setTimeout(function() {
				let selection = window.getSelection();
				let range = document.createRange();
				range.setStartAfter(selection.anchorNode);
				range.insertNode(document.createTextNode(' '));
				range.collapse(true);
				selection.removeAllRanges();
				selection.addRange(range);
				self.pastedImageStatus = false;
			}, 1000);
		}
		$(control + '_display, ' + control).trigger('keyup');
	}

	self._deleteAttachments = function(attachment_ids)
	{
		attachment_ids.forEach(function(attachment_id) {
			App.Attachments.remove(attachment_id)
		})
	}

	self._addAttachment = async function(control, attachment, fromDropzone)
	{
		await self._addAttachments(control, [attachment], fromDropzone);
	}

	self._createImageDialogDropzone = function(config, isPasted)
	{
		isPasted = isPasted || false;
		var dropzone = App.Dropzone.applyDrop(
			'#attachmentDropzone',
			{
				files: 'image/*',

				url: App.Page.formatUri(
					'{0}/attachments/ajax_add_for_project/{1}',
					Consts.ajaxBaseUrl,
					config.project_id || 0
				),

				params: config.params || {},

				dict: {
					drop: lang('attachments_drop_image'),
					notype: lang('attachments_drop_notype')
				},

				success: async function(file, data)
				{
					if (self.isMultiple && self.currentFocussedElement) {
						await self._addAttachments(self.currentFocussedElement, [data.code]);
						self.imageDialogSuccess(self.currentFocussedElement || '', [{ id: data.id, dataId: data.data_id }]);
						self.addedFileCounts++;

						if (self.isMultiple === self.addedFileCounts && $('#' + self.currentFocussedElement?.id + '_loader').length) {
							$('#' + self.currentFocussedElement?.id + '_loader')[0].remove();
							self.isMultiple = null;
							self.addedFileCounts = 0;
						}
					} else {
						dropzone.removeFile(file);
						App.Dropzone.addAttachment(file, data.id);

						if (self.imageDialogUploadSuccess) {
							self.imageDialogUploadSuccess(file, data);
							setTimeout(
								function() {
									App.Attachments.toggleSelection(data.attachment.data_id, '', config.project_id || 0);
									if (isPasted) {
										$('#attachmentNewSubmit').click();
									}
								},
								1000
							);
						}
					}
				}
			}
		);
		return dropzone;
	}

	self._addImageDialog = function(project_id, entity_type, entity_id, o, isPasted)
	{
		isPasted = isPasted || false;
		App.Validation.hideErrors();
		$('#attachmentForm').unbind('submit');
		$('#attachmentDialog .addAttachment').hide();
		$('#attachmentDialog .addImage').show();

		$('#attachmentForm').submit(function(e)
		{
			App.Validation.hideErrors();
			o.success(App.Dropzone.getAttachments('#attachmentDropzone'));
			App.Dialogs.closeTop();
			return false;
		});

		$('#attachmentScreenshotMac').hide();
		$('#attachmentScreenshotWin').hide();
		$('#attachmentButtons').addClass('dialog-buttons-highlighted');

		if (App.Env.isChrome())
		{
			if (App.Env.isMac())
			{
				$('#attachmentScreenshotMac').show();
			}
			else if (App.Env.isWindows())
			{
				$('#attachmentScreenshotWin').show();
			}
		}

		self.dropzone.removeAllFiles();

		var attachmentContainer = self.attachmentContainerParent;

		App.Attachments.showDialog(attachmentContainer, project_id, entity_id, entity_type, {
				success: function () {
					App.Attachments.linkNewAttachments(attachmentContainer, '', {
						success: function (attachments) {
							o.success(attachments);
							$('.action-expanding').remove();
						}
					});
				}
			},
			isPasted
		);
	}

	self.addTable = function(control)
	{
		var dialog = new App.Editor.Table(
		{
			control: control
		});

		dialog.open();
	}

	self.applyDrop = function(config) {
		var selector = config.selector || '';
		self.projectId = config.project_id;
		self.entityType = config.entity_type;

        var countEnter = 0;
        $(config.control).on('paste keyup click copy cut delete', function (evt) {
            if (evt.keyCode === 13) {
                evt.stopImmediatePropagation();
                document.execCommand('insertLineBreak');

                if (!App.Env.isChrome()) {
                    $(config.control).find('br').before(document.createTextNode('\n\r')).remove();
                    document.execCommand('delete', false, null);
                }
            }

			self.setSelectionRange(config.control, null, evt);
        });

		self._applyDrop(
			$.extend({}, config, {
				success: async function (file, data) {
					await self._addAttachment(config.control || '', data.code, true);
					self.editor_dropzone[selector] && self.editor_dropzone[selector].removeFile(file);
					if (self.imageDialogUploadSuccess && self.imageDialogSuccess) {
						self.imageDialogUploadSuccess(file, data);
						self.imageDialogSuccess(config.control || '', [{ id: data.id, dataId: data.data_id }]);
					}
				}
			})
		);
	}

	self.applyDropDefectAttachments = function(config)
	{
		var selector = config.selector || '';
		self._applyDrop(
			$.extend({}, config, {
				defect: true,
				success: function (file, data) {
					self.editor_dropzone[selector] && self.editor_dropzone[selector].removeFile(file);
					Dropzone.forElement("#pushdropzone").addFile(file);
				}
			})
		);
		App.Dropzone.appliedDropElements.push(config.selector || '');
	}

	self._applyDrop = function(config)
	{
		var selector = config.selector || '';
		var project_id = config.project_id || $(selector).data('projectId') || '';
		var can_attach = config.can_attach || '';
		var entity_type = config.entity_type || '';
		var entity_id = config.entity_id || '';
		/*It is throwing error(Dropzone already attached) when chaning order of steps in edit test case window
		causing dirty checker not work */
		try{
			var dropzone = App.Dropzone.applyDrop(
				selector,
				{
					files: 'image/*',
					url: App.Page.formatUri(
						'{0}/attachments/ajax_add_for_project/{1}' + (config.defect ? '/1' : ''),
						Consts.ajaxBaseUrl,
						project_id
					),
					params: {
						'entity_type': entity_type,
						'entity_id': entity_id || self.entity_id || ''
					},
					dict: {
						drop: lang('attachments_drop_image_nobrowse'),
						notype: can_attach ?
							lang('attachments_drop_notype_canattach') :
							lang('attachments_drop_notype')
					},
					success: async function(file, data)
					{
						self.setSelectionRange(selector.replace('_drop', ''));
						await self._addAttachment(config.control || '', data.code);
						self.editor_dropzone[selector] && self.editor_dropzone[selector].removeFile(file);
						if (self.imageDialogUploadSuccess && self.imageDialogSuccess) {
							self.imageDialogUploadSuccess(file, data);
							self.imageDialogSuccess(config.control || '', [{ id: data.id, dataId: data.data_id }]);
						}
					},
					stop: function()
					{
						App.Dropzone.hide();
						self._setElementCursorRange();

						setTimeout(function() {
							let selection = window.getSelection();
							let range = document.createRange();
							range.setStartAfter(selection.anchorNode);
							range.insertNode(document.createTextNode(' '));
							range.collapse(true);
							selection.removeAllRanges();
							selection.addRange(range);
						}, 1000);
					}
				}
			);

			dropzone.on('dragenter',function(){
				self.imageDraged = true;

				if (App.Env.isChrome()) {
					self.isImageDroped = true;
				}
			});

			self.editor_dropzone[selector] = dropzone;
		}
		catch(e){
			//temporary suppressed unhandled error
		}
	}
}

App.Editor.Table = function(o)
{
	var self = this;

	self.control = o.control;

	self.open = function()
	{
		if ($('#addTableDialog').length == 0)
		{
			self._load(
			{
				success: function()
				{
					self._open(self.control);
				}
			});
		}
		else
		{
			self._open(self.control);
		}
	}

	self._load = function(o)
	{
		App.Ajax.call(
		{
			target: '/editor/ajax_render_table_dialog',

			success: function(html)
			{
				$('body').append(html);
				o.success();
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self._open = function(control)
	{
		self.matrix = $('#addTableMatrix');

		if (window.getSelection().baseNode) {
			self.range = window.getSelection().getRangeAt(0);
		}
		self._dialog(
		{
			submit: function()
			{
				self._add(control);
			}
		});
	}

	self._add = function(control)
	{
		var table = self._getMatrix();
		var $control = $(control);
		if ($control.prop('tagName') === 'DIV') {
			if (self.range && self.range.startContainer && '#' + self.range.startContainer.id === $control.selector) {
				$control.divInsertAtCaret(
					table,
					self.range
				);
			} else {
				$control.append(table);
			}
		} else {
			$control.insertAtCaret(table);
			$control.trigger('input');
		}

		$($control.selector.replace('_display', '')).val(
			App.Editor.formatValueForDB($control)
		);

		App.Dialogs.closeTop();
	}

	self._getMatrix = function()
	{
		var alignments = {};
		var alignment_ix = 0;
		self.matrix.find('select').each(
			function()
			{
				alignments[alignment_ix++] = $(this).val();
			}
		);

		var table = '';
		var row_no = 0;
		var columns = self.matrix.find('tr.header th').length;

		self.matrix.find('tr.row').each(
			function()
			{
				if (row_no == 0)
				{
					table = '\n||';

					for (var i = 0; i < columns; i++)
					{
						table += '|';
						var h = 'Header ' + ( i + 1);

						alignment = alignments[i];

						if (alignment == 'center')
						{
							table += ':' + h + ':';
						}
						else if (alignment == 'right')
						{
							table += h + ':';
						}
						else
						{
							table += ':' + h;
						}
					}

					table += '\n';
				}

				table += '|';
				for (var i = 0; i < columns; i++)
				{
					table += '|';
					if (i == 0)
					{
						table += ' Row ' + (row_no + 1) + ' .. ';
					}
					else
					{
						table += '  '
					}
				}

				table+= '\n';
				row_no++;
			}
		);

		return table;
	}

	self._dialog = function(o)
	{
		self._bind();

		$('#addTableForm').unbind('submit');
		$('#addTableForm').submit(function(e)
		{
			o.submit(
			);

			return false;
		});

		App.Dialogs.open(
		{
			selector: '#addTableDialog'
		});

		self._setWidth();
		self._setInfo();
		self._setAddColumnHeight();
	}

	self._bind = function()
	{
		$('#addTableAddColumn').unbind('click').bind(
			'click',
			function()
			{
				self._addColumn();
				return false;
			}
		);

		$('#addTableAddRow').unbind('click').bind(
			'click',
			function()
			{
				self._addRow();
				return false;
			}
		);

		self.matrix.on(
			'mouseenter',
			'tr.row',
			function()
			{
				self._tryToggleRow($(this), true);
			}
		);

		self.matrix.on(
			'mouseleave',
			'tr.row',
			function()
			{
				self._tryToggleRow($(this), false);
			}
		);

		self.matrix.on(
			'mouseenter',
			'tr.row td',
			function()
			{
				self._tryToggleColumn($(this), true);
			}
		);

		self.matrix.on(
			'mouseleave',
			'tr.row td',
			function()
			{
				self._tryToggleColumn($(this), false);
			}
		);
	}

	self._setWidth = function()
	{
		var columns = self.matrix.find('tr.header th').length;
		var width = Math.max(columns * 60, 500);
		App.Dialogs.setWidth('#addTableDialog', width);
	}

	self._setInfo = function()
	{
		var columns = self.matrix.find('tr.header th').length;
		var rows = self.matrix.find('tr.row').length;
		$('#addTableInfo').text(columns + ' x ' + rows);
	}

	self._setAddColumnHeight = function()
	{
		var add = $('#addTableAddColumn');

		add.css(
			'height',
			(self.matrix.outerHeight() -
				(add.outerHeight() - add.height())
			) + 'px'
		);
	}

	self._tryToggleRow = function(row, on)
	{
		if (row.next().length > 0) // Not last row?
		{
			return;
		}

		if (self.matrix.find('tr.row').length <= 1)
		{
			return;
		}

		if (on)
		{
			row.find('td').addClass('to-remove to-remove-row');
			row.bind(
				'click',
				function()
				{
					self._removeRow(row);
				}
			);
		}
		else
		{
			row.find('td').removeClass('to-remove to-remove-row');
			row.unbind('click');
		}
	}

	self._tryToggleColumn = function(cell, on)
	{
		var row = cell.closest('tr');
		if (row.next().length == 0 && // Last row?
			self.matrix.find('tr.row').length > 1)
		{
			return;
		}

		if (self.matrix.find('tr.header th').length <= 1)
		{
			return;
		}

		var ix = cell.prevAll().length + 1;
		var cells = self.matrix.find(
			'tr td:nth-child(' + ix + '), tr th:nth-child(' + ix + ')'
		);

		if (on)
		{
			cells.addClass('to-remove to-remove-column');
			cells.bind(
				'click',
				function()
				{
					if ($(this).is('td'))
					{
						self._removeColumn(cells);
					}
				}
			);
		}
		else
		{
			cells.removeClass('to-remove to-remove-column');
			cells.unbind('click');
		}
	}

	self._addColumn = function()
	{
		self.matrix.find('tr').each(
			function()
			{
				var row = $(this);
				if (row.hasClass('header'))
				{
					var cell = row.find('th:last').clone();
					row.append(cell);
				}
				else
				{
					row.append('<td>&nbsp;</td>')
				}
			}
		);

		self._setWidth();
		self._setInfo();
	}

	self._removeColumn = function(cells)
	{
		cells.remove();
		self._setWidth();
		self._setInfo();
	}

	self._addRow = function()
	{
		var row = self.matrix.find('tr.row:last').clone();
		self.matrix.append(row);
		self._setInfo();
		self._setAddColumnHeight();
	}

	self._removeRow = function(row)
	{
		row.remove();
		self._setInfo();
		self._setAddColumnHeight();
	}
}

App.Editor_Text = new function() {
    var a = this;
    var f;
    a.dropzone = null;
    a.init = function(b) {
        $(document.body).clipboard({
            paste: function(d, c) {
                a._pasteImage(document.activeElement, b, c)
            }
        })
    };
    a._pasteImage = function(d, c, b) {
        if (!App.Dialogs.isActive("attachmentDialogFile")) {
            if (!d || d.tagName != "TEXTAREA") {
                return
            }
            a.addImage(d, c)
        }
        a.dropzone.addFile(b)
    };
    a.addImage = function(c, b) {
        if (!a.dropzone) {
            a.dropzone = a._createImageDialogDropzone(b);
        }

        a._addImageDialog({
            success: function(d) {
                a._addAttachments(c, d)
            }
        })
        document.getElementById("attachmentDropzone").classList.remove("disabled");
        document.getElementById("attachmentSubmit").classList.add("cursor-not-allowed");
        document.getElementById("attachmentSubmit").setAttribute("disabled","");
    };
    a._formatAttachment = function(b) {
		var reader = new FileReader;
        reader.readAsText(f);
        reader.onload = function(evt) {
            document.getElementById(b).value = evt.target.result.trim() ;
        };
    };
    a._addAttachments = function(c, b) {
        document.getElementById(c).value = "";
        a._formatAttachment(c);
    };
    a._addAttachment = function(c, b) {
        a._addAttachments(c, [b])
    };

    function readFileContent(file, callback) {
        var reader = new FileReader;
        reader.readAsText(file);

        var text;

        return new Promise(function(resolve, reject) {
            reader.onload = function() {
                resolve(reader.result);
            };
        });
    }

    a._createImageDialogDropzone = function(b) {

        return App.Dropzone.applyDrop("#attachmentDropzone", {
            files: "*",
            url: App.Page.formatUri("{0}/attachments/ajax_add_for_certificate", Consts.ajaxBaseUrl),
            dict: {
                drop: lang("attachments_file_here"),
                notype: lang("attachments_drop_filee_nobrowse")
            },
            success: function(c, d) {
                document.getElementById("attachmentDropzone").classList.add("disabled");
                document.getElementById("attachmentSubmit").removeAttribute("disabled");
                document.getElementById("attachmentSubmit").classList.remove("cursor-not-allowed");
                f = c;
                App.Dropzone.addAttachment(c, d.id)

            }
        })
    };
    a._addImageDialog = function(b) {
        App.Validation.hideErrors();
        $("#attachmentForm").unbind("submit");
        $("#attachmentDialogFile .addAttachment").hide();
        $("#attachmentDialogFile .addAttachment").show();
        $("#attachmentForm").submit(function(c) {
            App.Validation.hideErrors();
            App.Dialogs.closeTop();
            b.success(App.Dropzone.getAttachments("#attachmentDropzone"));
            return false
        });
        $("#attachmentScreenshotMac").hide();
        $("#attachmentScreenshotWin").hide();
        $("#attachmentButtons").addClass("dialog-buttons-highlighted");
        if (App.Env.isChrome()) {
            if (App.Env.isMac()) {
                $("#attachmentScreenshotMac").show();
            } else {
                if (App.Env.isWindows()) {
                    $("#attachmentScreenshotWin").show();
                }
            }
        }
        a.dropzone.removeAllFiles();
        App.Dialogs.open({
            titleSelector: ".addImage",
            selector: "#attachmentDialogFile",
            focusedControl: "#attachment"
        })
    };
    a.addTable = function(c) {
        var b = new App.Editor.Table({
            control: c
        });
        b.open()
    };
    a.applyDrop = function(b, f, e, d) {
        var c = App.Dropzone.applyDrop(b, {
            files: "image/*",
            url: App.Page.formatUri("{0}/attachments/ajax_add_for_project/{1}", Consts.ajaxBaseUrl, e),
            dict: {
                drop: lang("attachments_drop_image_nobrowse"),
                notype: d ? lang("attachments_drop_notype_canattach") : lang("attachments_drop_notype")
            },
            success: function(g, h) {
                a._addAttachment(f, h.id);
                c.removeFile(g)
            },
            stop: function() {
                App.Dropzone.hide()
            }
        })
    }
};

;

