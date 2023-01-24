/*******************************************************************/
/* Attachment dialogs and routines  */

/* [Permissions checked!] */

App.Attachments = new function () {
    var self = this;

    self.removeSuccess = null;
    self.attachmentsData = null;
    self.inputSelector = 'input#attachments';
    self.inputParent = '#form';
    self.attachmentsLoaded = false;
    self.page = 0;
    self.orderBy = '';
    self.orderDir = '';
    self.entityId = null;
    self.entityType = null;
    self.filters = null;
    self.migrationIsDone = null;
    self.icons = {
        'bmp': 'bitmap',
        'doc': 'word',
        'docx': 'word',
        'exe': 'application',
        'gif': 'picture',
        'htm': 'html',
        'html': 'html',
        'jpeg': 'picture',
        'jpg': 'picture',
        'odp': 'powerpoint',
        'ods': 'excel',
        'odt': 'word',
        'pdf': 'pdf',
        'png': 'bitmap',
        'ppt': 'powerpoint',
        'pptx': 'powerpoint',
        'sil': 'smartinspect',
        'txt': 'text',
        'tif': 'picture',
        'tiff': 'picture',
        'xhtml': 'html',
        'xls': 'excel',
        'xlsx': 'excel',
        'xml': 'xml',
        'zip': 'zip'
    };

    self.init = function (config) {
        var selector = config.selector,
            entity_id = config.entity_id || '',
            entity_type = config.entity_type || 'run',
            itemsParent = config.itemsParent || '#sidebar';

        var $target = $(selector);
        self.inputSelector = config.inputSelector || 'input#attachments';
        self.inputParent = config.inputParent || '#form';
        self.project_id = config.project_id || 0;

        if (self.migrationIsDone === null) {
            App.Ajax.call({
				target: '/updater/ajax_get_attachments_migration_status',

				success: function(data)
				{
					self.migrationIsDone = data.done || false;
				},

				failure: function(data)
				{
					App.Ajax.handleError(data);
				}
			});
        }

        var dropzone = App.Dropzone.applyDrop(selector, {
            url: App.Page.formatUri(
                '{0}/attachments/add_attachment_to_' + entity_type + '/{1}/{2}',
                Consts.ajaxBaseUrl,
                self.project_id,
                entity_id
            ),

            params: config.params,
            clickable: config.clickable,

            dict: {
                drop: lang('attachments_drop')
            },

            start: function start() {
                // Hide volatile dropzones if we are dropping to a
                // persistent dropzone.
                if ($target.is('.dz-persistent')) {
                    App.Dropzone.hide();
                }
            },

            stop: function stop() {
                App.Dropzone.hide(); // Hide all volatile dropzones
            },

            success: function success(file, data) {
                self._addId(data.id, self.inputParent, data.data_id);
                self._addRow(data.code, itemsParent);
                App.Attachments.lazyLoad(itemsParent, 0.35);
                dropzone.removeFile(file);
                if (config.success) {
                    config.success(file, data);
                }
            }
        });

        return dropzone;
    };

    self._addRow = function (html, parent) {
        var row = $(html);
        var _parent = parent || '';
        var itemContainer = $(_parent + ' #entityAttachmentListAdd').parent();
        $(_parent + ' #noEntityAttachments').hide();
        $(_parent + ' #entityAttachmentListAdd').before(row);
        $(_parent + ' #entityAttachmentListEmptyIcon').hide();
        $(_parent + ' #entityAttachmentListAdd').show();

        if ($(itemContainer).data('observer') && row[0]) {
            var observer = $(itemContainer).data('observer');
            observer.observe(row[0]);
        }
    };

    self._addId = function (id, parent, dataId) {
        var _parent = parent || '';
        var $attachments = $(_parent + ' ' + self.inputSelector);
        if ($attachments.length === 0) {
            $attachments = $('input#attachments');
        }
        var value = $attachments.val();
        if (value) {
            value = JSON.parse(value);
            value.push({ id: id, dataId: dataId });
        } else {
            value = [];
            value.push({ id: id, dataId: dataId });
        }
        $attachments.val(JSON.stringify(value));
    };

    self._removeId = function (attachment_id, parent) {
        var _parent = parent || '';
        var attachments = $(_parent + ' ' + self.inputSelector);
        var values = attachments.val();
        if (values) {
            values = JSON.stringify(values);
            values = JSON.parse(values);
            values = Object.values(values).filter(function(obj) {
                return obj.id !== attachment_id;
            });
        }
        attachments.val(values ? JSON.stringify(values) : '[]');
    }

    self.remove = function (attachment_id, config) {
        var action_config = $.extend({}, config || {});
        App.Ajax.call({
            target: '/attachments/ajax_delete',

            arguments: {
                attachment_id: attachment_id,
                entity_attachments_id: config?.entity_attachments_id || '',
                project_id: config?.project_id || '',
                plan_id: config?.plan_id || '',
            },

            success: function success(data) {
                if (!action_config.override) {
                    $('a[href$="/attachments/get/'+attachment_id+'"]').remove();
                    $('[id=attachment-' + attachment_id + ']').remove();
                    if ($('#entityAttachmentList div').length === 0) {
                        $('[id=noEntityAttachments]').show();
                    }
                }
                if (action_config.success) {
                    action_config.success(attachment_id);
                } else if (self.removeSuccess) {
                    self.removeSuccess(attachment_id);
                }
            },

            error: function error(data) {
                App.Ajax.handleError(data);
            }
        });
    };

    self.showViewTemplate = function(template_selector, attachment)
    {
        var $templateHTML = $($(template_selector).html());
        var imgUrlData = $templateHTML.find('.attachment-image img').data();
        var urlRegExp = new RegExp('(.*)/(.*)(' + imgUrlData.iconBackground + imgUrlData.iconSize + '.png)');
        var attachmentExtension = attachment.filename.split('.').pop();
        var iconName = self.icons[attachmentExtension] || 'default';

        $templateHTML.find('.attachment-image img').attr('src', imgUrlData.iconDefaultSrc.replace(urlRegExp, "$1/" + iconName + "$3"));

        return $templateHTML[0].outerHTML
            .replace(/\{\{attachment_id\}\}/g, attachment.id)
            .replace(/\{\{entity_attachments_id\}\}/g, attachment.entity_attachments_id || 0)
            .replace(/\{\{attachment_icon_name\}\}/g, attachment.icon_name)
            .replace(/\{\{attachment_name\}\}/g, attachment.name)
            .replace(/\{\{attachment_size\}\}/g, attachment.size);
    }

    self.initEditorAttachments = function(storage, config)
    {
        var _config = $.extend({}, {
            inputParent: '#form',
            itemsParent: '#sidebar'
        }, config || {});
        App.Editor.imageDialogUploadSuccess = self.imageDialogUploadSuccess(storage, _config);
        App.Editor.imageDialogSuccess = self.imageDialogSuccess(storage, _config);
        App.Editor.attachmentContainerParent = _config.itemsParent;
        self.inputParent = _config.inputParent;
        App.Attachments.removeSuccess = self.onAttachmentRemove(_config);
    }

    self.imageDialogUploadSuccess = function(storage) {
        return function(file, data)
        {
            storage[data.id] = data.code;
        }
    }

    self.imageDialogSuccess = function(storage, config) {
        return function(control, attachment_ids)
        {
            attachment_ids.forEach(function(attachment){
                App.Attachments._addId(attachment.id, config.inputParent, attachment.dataId);
                App.Attachments._addRow(storage[attachment.id], config.itemsParent);
                delete(storage[attachment.id]);
            });
        }
    }

    self.onAttachmentRemove = function(config)
    {
        return function(attachment_id)
        {
            App.Attachments._removeId(attachment_id, config.inputParent);
        }
    }

    self.initLibraryDropzone = function(fullLibrary, projectID)
    {
        self.project_id = projectID;
        if (fullLibrary) {
            var dropzone = App.Dropzone.applyDrop('#libraryDropzone', {
                files: '*',
                url: App.Page.formatUri('{0}/attachments/ajax_add_to_library', Consts.ajaxBaseUrl),
                clickable: ['#libraryDropzoneButton'],
                dict: {
                    drop: ''
                },
                start: function() {
                    $('#libraryDropzoneContent').hide();
                },

                stop: function() {
                    $('#libraryDropzoneContent').show();
                },
                success: function success(file, data) {
                    dropzone.removeFile(file);
                    $('#libraryDropzoneContent').show();
                    setTimeout(
                        function() {
                            App.Attachments.loadRepository();
                        },
                        1000
                    );
                }
            });
        } else {
            var dropzone = App.Dropzone.applyDrop('#attachmentsNewList', {
                files: '*',
                url: App.Page.formatUri('{0}/attachments/ajax_add_for_project/{1}', Consts.ajaxBaseUrl, self.project_id),
                clickable: ['#libraryAddAttachment'],
                dict: {
                    drop: ''
                },
                success: function success(file, data) {
                    dropzone.removeFile(file);
                    setTimeout(
                        function() {
                            App.Attachments.reloadRepository();
                            App.Attachments.toggleSelection(data.attachment.data_id, '', projectID);
                        },
                        1000
                    );
                }
            });
        }
    }

    self.setSort = function(orderBy, orderDir)
    {
        self.orderBy = orderBy;
        self.orderDir = orderDir;

        $('#attachmentsByName').text(self.orderByOptions[self.orderBy]);
        if (self.orderDir === 'desc') {
            $('#orderByAsc').hide();
            $('#orderByDesc').show();
        } else {
            $('#orderByDesc').hide();
            $('#orderByAsc').show();
        }
    }

    self.sortAttachments = function(orderBy)
    {
        if (self.orderBy === orderBy) {
            self.orderDir = self.orderDir === 'desc' ? 'asc' : 'desc';
        }
        self.setSort(orderBy, self.orderDir);

        self.loadAttachments(self.project_id, self.page, {
            field: self.orderBy,
            dir: self.orderDir
        }, self.search);
    }

    self.loadAttachments = function(projectID, page, order, search)
    {
        var selfPtr = self;
        $('#attachmentsPaginationBusy').show();
        App.Ajax.call({
            target: '/attachments/overview/' + (projectID || 0),

            arguments: {
                offset: page,
                order_by: order.field,
                order_dir: order.dir,
                search: search
            },

            success: function(data) {
                var $attachmentsList = $('#attachmentsNewList');
                $attachmentsList.html('');
                selfPtr.attachmentsData = data.data;
                selfPtr.attachmentsData.forEach(function(attachment) {
                    $attachmentsList.append(
                        $(App.Attachments.renderAttachmentTemplate(
                            '#newAttachmentTemplate',
                            attachment
                        ))
                    );
                });
                if (selfPtr.filters === null && data.filters && data.filters.filters) {
                    App.Attachments._filterRestore(data.filters);
                }
                $attachmentsList.append($('#libraryAttachmentsAddItemTemplate').html().replace(/\{\{element_id\}\}/g, 'libraryAttachmentsAddItem'));
                self.lazyLoad('#attachmentsNewList', 0.5);
                $('#attachmentsPagination').html(data.pagination);
                $('#filteredAttachmentsSize').text(data.total_size);
                $('#attachmentsPaginationBusy').hide();

                if (selfPtr.project_id) {
                    var dropzone = App.Dropzone.applyDrop('#libraryAttachmentsAddItem', {
                        files: '*',
                        url: App.Page.formatUri('{0}/attachments/ajax_add_for_project/{1}', Consts.ajaxBaseUrl, selfPtr.project_id),
                        clickable: ['#libraryAttachmentsAddItem', '#libraryAttachmentsAddItem .attachment-library-add-icon'],
                        previewsContainer: '#attachmentsNewList',
                        dict: {
                            drop: ''
                        },
                        success: function success(file, data) {
                            dropzone.removeFile(file);
                            setTimeout(
                                function() {
                                    App.Attachments.reloadRepository();
                                    App.Attachments.toggleSelection(data.attachment.data_id, '', selfPtr.project_id);
                                },
                                1000
                            );
                        }
                    });
                } else {
                    var dropzone = App.Dropzone.applyDrop('#libraryAttachmentsAddItem', {
                        files: '*',
                        url: App.Page.formatUri('{0}/attachments/ajax_add_to_library', Consts.ajaxBaseUrl),
                        clickable: ['#libraryAttachmentsAddItem', '#libraryAttachmentsAddItem .attachment-library-add-icon'],
                        previewsContainer: '#libraryDropzone',
                        dict: {
                            drop: ''
                        },
                        start: function() {
                            $('#libraryDropzoneContent').hide();
                        },
                        stop: function() {
                            $('#libraryDropzoneContent').show();
                        },
                        success: function success(file, data) {
                            dropzone.removeFile(file);
                            $('#libraryDropzoneContent').show();
                            setTimeout(
                                function() {
                                    App.Attachments.loadRepository();
                                },
                                1000
                            );
                        }
                    });
                }
            },

            error: function(data) {
                self.attachmentsLoaded = false;
                $('#attachmentsPaginationBusy').hide();
                if (data.error !== 'Operation timed out - received only 0 responses.') {
                    App.Ajax.handleError(data);
                }
            },
        });
    }

    self.renderAttachmentTemplate = function(selector, attachment)
    {
        var html = $(selector).html();
        var values = $('#newAttachments').val().split(',');

        var attachmentThumbTemplate = App.Page.formatUri(
            'background-image: url({0}/attachments/get/{1}/{2}/{3}); background-size: 100% 100%;',
            Consts.ajaxBaseUrl,
            attachment.id,
            1, // Thumbnail index
            new Date().getTime()
        );
        let attachmentImgSrc = App.Page.formatUri(
            '{0}/attachments/get/{1}/{2}/{3}',
            Consts.ajaxBaseUrl,
            attachment.id,
            1, // Thumbnail index
            new Date().getTime()
        );
        var truncatedName = attachment.name.length > 20 ? attachment.name.substr(0, 16) + '...' : attachment.name;
        var project_id =  attachment.project_id.toString() ? attachment.project_id.toString() : 0;

        return html
            .replace(/\{\{attachment_src_tag\}\}/g, 'src')
            .replace(/\{\{attachment_onerror_tag\}\}/g, 'onerror')
            .replace(/\{\{project_id\}\}/g, project_id)
            .replace(/\{\{attachment_truncated_name\}\}/g, attachment.is_image ? '&nbsp;' : truncatedName)
            .replace(/\{\{attachment_name\}\}/g, attachment.name)
            .replace(/\{\{attachment_icon\}\}/g, attachment.icon)
            .replace(/\{\{attachment_selected_class\}\}/g, values.includes(attachment.id.toString()) ? 'attachment-selected' : '')
            .replace(/\{\{attachment_id\}\}/g, attachment.id)
            .replace(/\{\{attachment_thumbnail\}\}/g, attachment.is_image ? attachmentThumbTemplate : '')
            .replace(/\{\{attachment_imgurl\}\}/g, attachment.is_image ? attachmentImgSrc : '')
            .replace(/\{\{attachment_img_onerror\}\}/g, attachment.is_image ? 'App.Attachments.handleBackgroundError(this);' : '')
            .replace(/\{\{attachment_icon_style\}\}/g, attachment.is_image ? 'background: none;' : '');
    }

    self.loadRepository = function()
    {
        self.page = 0;
        self.orderBy = 'created_on';
        self.orderDir = 'desc';
        self.project_id = 0;
        self.search = null;
        self.loadAttachments(self.project_id, self.page, {
            field: self.orderBy,
            dir: self.orderDir
        }, self.search);
    }

    self.reloadRepository = function()
    {
        self.search = $('#libraryAttachmentsSearch').val();
        self.loadAttachments(self.project_id, self.page, {
            field: self.orderBy,
            dir: self.orderDir
        }, self.search);
    }

    self.loadPageRepository = function(page)
    {
        self.page = page;
        self.loadAttachments(self.project_id, page, {
            field: self.orderBy,
            dir: self.orderDir
        }, self.search);
    }

    self.editName = function()
    {
        $('#attachmentName').hide();
        $('#attachmentNameEdit').show();
    }

    self.confirmEditName = function(attachmentId, attachmentOldName)
    {
        var attachmentName = $("#attachmentNameEditField").val();

        if (attachmentName !== attachmentOldName) {
            App.Ajax.call({
                target: '/attachments/update_name',

                arguments: {
                    attachment_id: attachmentId,
                    new_name: attachmentName,
                    project_id: self.project_id
                },

                success: function success(data) {
                    $("#attachmentNameValue").text(attachmentName);
                },

                error: function error(data) {
                    App.Ajax.handleError(data);
                }
            });
        }

        $('#attachmentName').show();
        $('#attachmentNameEdit').hide();
    }

    self.showInfoDialog = function(attachmentId)
    {
        App.Ajax.call({
            target: '/attachments/ajax_render_attachment_info',

            arguments: {
                attachment_id: attachmentId
            },

            success: function success(data) {
                $('#attachmentInfoDialog').html(data.info);
                $('#attachment_project_select').chosen({placeholder_text_multiple: "Select projects"});
                $('#attachment_project_select').on('change', function () {
                    if (!$('#attachmentAllProjects').length) {
                        $('.chzn-results').prepend('<li id="attachmentAllProjects" class="active-result" style="font-weight: bold;">' + lang('attachment_info_all_projects') + '</li>');
                        $('#attachmentAllProjects').on('click', function(e) {
                            $('#attachment_project_select').find('option').each(function () {
                                $(this).prop('selected', true);
                            });
                            $('#attachment_project_select').trigger("liszt:updated");
                        });
                    }
                });
                $('#attachment_project_select').change();
                var attachmentId = $('#attachmentInfoId').val();
                var prevNewAttachments = $('#newAttachments').val();
                $('#newAttachments').val(attachmentId);

                App.Dialogs.open({
                    titleSelector: '.addAttachment',
                    selector: '#attachmentInfoDialog',
                    focusedControl: '#attachment',
                    close: function close() {
                        $('#newAttachments').val(prevNewAttachments);
                        var projects = $('#attachment_project_select').val() ? $('#attachment_project_select').val() : [];
                        if (self.project_id && !projects.includes(self.project_id.toString())) {
                            $('[data-attachment-data-id="' + attachmentId + '"').remove();
                        }
                    },
                    show: function show() {
                        var dropzone = App.Dropzone.applyDrop('#libraryReplaceAttachment', {
                            files: '*',
                            url: App.Page.formatUri('{0}/attachments/ajax_replace_file/{1}', Consts.ajaxBaseUrl, attachmentId),
                            clickable: ['#libraryReplaceAttachment'],
                            previewsContainer: false,
                            autoProcessQueue: false,
                            doNotStartBlockUI: true,
                            dict: {
                                drop: ''
                            },
                            addedfile: function addedfile(file) {
                                App.Dialogs.confirm(
                                    lang('attachments_confirm_replace'),
                                    function() {
                                        App.Ajax.start();
                                        dropzone.processQueue();
                                    },
                                    function () {
                                        dropzone.removeFile(file);
                                    }
                                );
                                var dialog = App.Dialogs.getActive();
                                dialog.dialog('option', 'title', lang('attachments_replace_title'));
                                dialog.prev().css('background', '#E40046');
                                dialog.prev().css('color', '#FFFFFF');
                            },
                            success: function success(file, data) {
                                dropzone.removeFile(file);
                                App.Dialogs.closeTop();
                                setTimeout(
                                    function() {
                                        var attachmentThumbTemplate = App.Page.formatUri(
                                            'url({0}/attachments/get/{1}/{2}/{3})',
                                            Consts.ajaxBaseUrl,
                                            attachmentId,
                                            1, // Thumbnail index
                                            new Date().getTime()
                                        );
                                        $('#libraryAttachment-' + attachmentId).css('background-image', attachmentThumbTemplate);
                                        $('[data-attachment-data-id="' + attachmentId + '"').each(function () {
                                            attachmentThumbTemplate = App.Page.formatUri(
                                                'url({0}/attachments/get/{1}/{2}/{3})',
                                                Consts.ajaxBaseUrl,
                                                attachmentId,
                                                2, // Thumbnail index
                                                new Date().getTime()
                                            );
                                            $(this).css('background-image', attachmentThumbTemplate);
                                        });
                                    },
                                    1000
                                );
                            }
                        });
                    }
                });
            },

            error: function error(data) {
                App.Ajax.handleError(data);
            }
        });
    }

    self.handleError = function(obj)
    {
        obj.onclick = 'return false;';
        if (self.migrationIsDone === null) {
            App.Ajax.call({
				target: '/updater/ajax_get_attachments_migration_status',

				success: function(data)
				{
		                    self.migrationIsDone = data.done || false;
                		    self._setErrorImgSrc(obj);
				},

				failure: function(data)
				{
					App.Ajax.handleError(data);
				}
			});
        } else {
            self._setErrorImgSrc(obj);
        }
    }

    self.handleBackgroundError = function(obj, removeSelectors)
    {
        removeSelectors = removeSelectors || [];
        if (self.migrationIsDone === null) {
            App.Ajax.call({
				target: '/updater/ajax_get_attachments_migration_status',

				success: function(data)
				{
					self.migrationIsDone = data.done || false;
					self._setErrorBackgroundImgSrc(obj.parentNode, !!removeSelectors.length);
					if (!self.migrationIsDone) {
			                        self._removeSelectors(removeSelectors);
                    			}
				},

				failure: function(data)
				{
					App.Ajax.handleError(data);
				}
			});
        } else {
            self._setErrorBackgroundImgSrc(obj.parentNode, !!removeSelectors.length);
            if (!self.migrationIsDone) {
                self._removeSelectors(removeSelectors);
            }
        }
    }

    self._setErrorImgSrc = function(obj)
    {
        if (!self.migrationIsDone) {
            obj.src = Consts.resourceBaseUrl + 'images/svg-icons/attachments/image-being-migrated.svg';
            obj.alt = 'Image being migrated'
        } else {
            obj.src = Consts.resourceBaseUrl + 'images/svg-icons/attachments/image-not-found.svg';
            obj.alt = 'Image not found'
        }
    }

    self._setErrorBackgroundImgSrc = function(obj, smallSize)
    {
        if (!self.migrationIsDone) {
            obj.style.backgroundImage = 'url(' + Consts.resourceBaseUrl + 'images/svg-icons/attachments/image-being-migrated.svg' + ')';
            obj.alt = 'Image being migrated'
        } else {
            obj.style.backgroundImage = 'url(' + Consts.resourceBaseUrl + 'images/svg-icons/attachments/image-not-found.svg' + ')';
            obj.alt = 'Image not found'
        }
        if (smallSize) {
            obj.style.backgroundSize = '65%';
        }
    }

    self._removeSelectors = function(selectors)
    {
        selectors.forEach(function(element) {
            $(element).each(function(){
                $(this).hide();
            });
        });
    }

    self.assignAvailableProjects = function(attachmentID)
    {
        var projects = $('#attachment_project_select').val();

        App.Ajax.call({
            target: '/attachments/set_available_projects',

            arguments: {
                attachment_id: attachmentID,
                project_ids: projects ? projects : []
            },

            error: function error(data) {
                App.Ajax.handleError(data);
            }
        });
    }

    self.showDialog = function(itemsParent, projectId, entityId, entityType, o, isPasted)
    {
        isPasted = isPasted || false;
        self.page = 0;
        self.orderBy = 'created_on';
        self.orderDir = 'desc';
        self.project_id = projectId;
        self.entityId = entityId;
        self.entityType = entityType;
        self.search = null;
        self.setSort('created_on', 'desc');
        self.filterReset();

        var inputParent = o && o.inputParent ? o.inputParent : '';
        var value = $('#newAttachments').val();
        var values = value.length > 0 ? value.split(',') : [];
        values.forEach(function(attachmentID) {
            self.toggleSelection(attachmentID, '', self.project_id);
        });
        $('#newAttachments').val('');
        App.Dialogs.open({
            titleSelector: '.addAttachment',
            selector: '#attachmentNewDialogFile',
            focusedControl: '#attachment',
            show: function () {
                self.initLibraryDropzone(false, self.project_id);
                if (!self.migrationIsDone) {
                    if ($('#attachmentNewDialogFile .empty').length === 0) {
                        $('#attachmentNewDialogFile').prepend(
                            '<div class="empty">'
                            + '<div class="empty-content empty-warning">'
                            + '<div class="empty-title">Your attachments are currently being upgraded.</div>'
                            + '<div class="empty-body">'
                            + '<p>Edit and delete functions are temporarily disabled until the migration process is completed.</p>'
                            + '</div></div></div>'
                        );
                    }
                    $('#libraryDeleteAttachment').hide();
                }
            },
            additionalCss: {
                opacity: Number(!isPasted)
            }
        });

        $('#attachmentNewSubmit').off('click');
        if (o.success) {
            $('#attachmentNewSubmit').on('click', o.success);
        } else {
            $('#attachmentNewSubmit').on('click', function () {
                self.linkNewAttachments(itemsParent, inputParent);
            });
        }
    }

    self.linkNewAttachments = function(itemsParent, inputParent, o)
    {
        var value = $('#newAttachments').val();
        if (value.length === 0) return;
        var values = value.split(',');
        inputParent = inputParent || self.inputParent;

        App.Ajax.call({
            target: '/attachments/link_to_entity',

            arguments: {
                attachment_ids: values,
                entity_id: self.entityId,
                entity_type: self.entityType,
                project_id: self.project_id || 0,
            },

            success: function success(data) {
                if (data.attachments) {
                    $(itemsParent + ' #entityAttachmentListEmptyIcon').hide();
                    $(itemsParent + ' #entityAttachmentListAdd').show();
                    data.attachments.forEach(function(attachment) {
                        $(itemsParent + ' #entityAttachmentListAdd').before(attachment);
                    });
                    var attachments = JSON.parse(data.attachment_ids);
                    attachments.forEach(function(attachment) {
                        self._addId(attachment.id, inputParent, attachment.data_id);
                    });
                    if (o && o.success) {
                        o.success(data.attachments);
                    }
                    App.Attachments.lazyLoad(itemsParent + ' #entityAttachmentList', 0.35);
                }
                self.entityId = null;
                self.entityType = null;
                App.Dialogs.closeTop();
            },

            error: function error(data) {
                self.entityId = null;
                self.entityType = null;
                App.Ajax.handleError(data);
            }
        });
    }

    self.toggleSelection = function(attachmentID, e, project_id)
    {
        if (e) e.stopPropagation();
        var value = $('#newAttachments').val();
        if (value.length === 0) {
            $('#libraryAddAttachment').hide();
            $('#libraryDeleteAttachment').show();
        }

        var values = value.length > 0 ? value.split(',') : [];
        var index = values.indexOf(attachmentID);
        if (values.length === 1 && index > -1) {
            $('#libraryAddAttachment').show();
            $('#libraryDeleteAttachment').hide();
        }
        var isSelected = false;
        if (index > -1) {
            isSelected = true;
            values.splice(index, 1);
        } else {
            values.push(attachmentID);
        }

        self.project_id = project_id ?? 0;

        $('#libraryAttachment-' + attachmentID).find('.attachment-selection').toggleClass('attachment-selected');
        $('#libraryAttachment-' + attachmentID).toggleClass('attachment-selected');

        $('#newAttachments').val(values.join(','));
    }

    self.toggleSelectionEntity = function(attachmentID, parent)
    {
        if (typeof $('#attachment-' + attachmentID).attr('style') === undefined) {
            return;
        }

        var value = $(parent).attr('deleteIds') || '';
        if (value.length === 0) {
            $(parent + ' #entityAttachmentListAdd').hide();
            $(parent + ' #entityAttachmentListRemove').show();
            $(parent + ' .inlineAttachmentListAdd').hide();
            $(parent + ' .inlineAttachmentListRemove').show();
            $(parent + ' #entityAttachmentListDropzoneText').hide();
            $(parent + ' #entityAttachmentListRemoveBottom').show();
            $(parent).prop('deleteMode', true);
        }

        var values = value.length > 0 ? value.split(',') : [];
        var index = values.indexOf(attachmentID);
        if (values.length === 1 && index > -1) {
            $(parent + ' #entityAttachmentListAdd').show();
            $(parent + ' #entityAttachmentListRemove').hide();
            $(parent + ' .inlineAttachmentListAdd').show();
            $(parent + ' .inlineAttachmentListRemove').hide();
            $(parent + ' #entityAttachmentListDropzoneText').show();
            $(parent + ' #entityAttachmentListRemoveBottom').hide();
            $(parent).prop('deleteMode', false);
        }
        if (index > -1) {
            values.splice(index, 1);
        } else {
            values.push(attachmentID);
        }

        $(parent + ' #attachment-' + attachmentID).toggleClass('attachment-delete-selected');

        $(parent).attr('deleteIds', values.join(','));
    }

    self.toggleSelectionInline = function(target, attachmentID, parent) {
        var value = $(parent).attr('deleteIds');
        if (!value || value.length === 0) {
            $(parent).prop('deleteMode', true);
            value = '';
            $(parent + ' .inlineAttachmentListAdd').hide();
            $(parent + ' .inlineAttachmentListRemove').show();
        }

        var values = value.length > 0 ? value.split(',') : [];
        var index = values.indexOf(attachmentID);
        if (values.length === 1 && index > -1) {
            $(parent).prop('deleteMode', false);
            $(parent + ' .inlineAttachmentListAdd').show();
            $(parent + ' .inlineAttachmentListRemove').hide();
        }
        var isSelected = false;
        if (index > -1) {
            isSelected = true;
            values.splice(index, 1);
        } else {
            values.push(attachmentID);
        }

        $(target).toggleClass('attachment-delete-selected');

        $(parent).attr('deleteIds', values.join(','));
    }

    self.removeAttachments = function(closeDialog, linkedAttachmentId)
    {
        var value = $('#newAttachments, #attachmentInfoId').val();
        var values = value.length > 0 ? value.split(',') : [];
        var project_id = self.project_id;
        let attachment_select = document.getElementById('attachment_project_select').value;

        if (project_id === undefined) {
            attachmentDropzone = document.getElementById("attachmentDropzone");
            project_id = attachmentDropzone
              ? attachmentDropzone.getAttribute("data-project-id")
              : (document.getElementById("attachment_project_select")
                 ? document.getElementById("attachment_project_select").value
                 : null);
        }

        App.Ajax.call({
            target: '/attachments/ajax_delete_many',

            arguments: {
                attachment_ids: values,
                project_id: project_id
            },

            success: function success(data) {
                if (closeDialog) App.Dialogs.closeTop();
                if ($('#attachmentsNewList').is(":visible")) {
                    self.loadAttachments(self.project_id, self.page, {
                        field: self.orderBy,
                        dir: self.orderDir
                    }, self.search);
                    $('#libraryAddAttachment').show();
                    $('#libraryDeleteAttachment').hide();
                }
                $('#newAttachments').val('');
                values.forEach(function (attachmentId) {
                    var attachment_element = $('[data-attachment-data-id="' + attachmentId + '"');
                    var field_id = attachment_element.parent().parent().attr('data-attribute');
                    if (field_id !== undefined) {
                         let attachmentImgSrc = App.Page.formatUri(
                             '{0}/attachments/get/{1}',
                             Consts.ajaxBaseUrl,
                             attachment_element.attr('data-attachment-id'),
                         );
                         var remove_attachemt = '![](' + attachmentImgSrc + ')';
                         var custom_field = $('#' + field_id);
                         var current_value = custom_field.val().replace(remove_attachemt, '');
                         custom_field.val(current_value);
                     }
                     $('[data-attachment-data-id="' + attachmentId + '"').remove();
                });
                $('input#attachments').each(function () {
                    var attachments = $(this);
                    var ids = attachments.val();
                    if (ids) {
                        ids = JSON.stringify(ids);
                        ids = JSON.parse(ids);
                        ids = Object.values(ids).filter(function(obj) {
                            return !values.includes(obj.dataId);
                        });
                    }
                    attachments.val(ids ? JSON.stringify(ids) : '[]');
                });

                App.Tests.removeDeletedImage();
            },

            error: function error(data) {
                App.Ajax.handleError(data);
            }
        });
    }

    self.removeFromEntity = function(config)
    {
        var parent = config.listParent;
        var value = $(parent).attr('deleteIds');

        if ((value === undefined) || (value === '')) {
            parent = parent.replace(/_attachments_wrapper/g, "-attachments-wrapper");
            value = $(parent).attr('deleteIds');
            $("div.inlineAttachmentListRemove .attachment-list-delete-inline").hide();
        }

        var values = value.length > 0 ? value.split(',') : [];
        App.Ajax.call({
            target: '/attachments/ajax_delete_many_from_entity',

            arguments: {
                attachment_ids: values,
                project_id: config.project_id || '',
                plan_id: config.plan_id || '',
            },

            success: function success(data) {
                values.forEach(function(attachmentId) {
                    $('.attachment-list-item[data-attachment-id="' + attachmentId + '"]').remove();

                    if (!$('.attachment-list-item', $(parent)).length) {
                        $('.attachment-list-delete-inline', $(parent)).remove();
                    }

                    if (self.removeSuccess) {
                        self.removeSuccess(attachmentId);
                    }

                    if ($(parent).attr('contenteditable')) {
                        $(parent).trigger('keyup');
                    } else {
                        $('div[contenteditable="true"]').each(function () {
                            $(this).trigger('keyup');
                        });
                    }
                });
                if ($(parent + ' .attachment-list div').length === 5) {
                    $(parent + ' #entityAttachmentListEmptyIcon').show();
                    $(parent + ' #entityAttachmentListDropzoneText').show();
                    $(parent + ' #entityAttachmentListAdd').hide();
                    $(parent + ' #entityAttachmentListRemove').hide();
                    $(parent + ' #entityAttachmentListRemoveBottom').hide();
                } else {
                    $(parent + ' #entityAttachmentListAdd').show();
                    $(parent + ' #entityAttachmentListRemove').hide();
                    $(parent + ' #entityAttachmentListDropzoneText').show();
                    $(parent + ' #entityAttachmentListRemoveBottom').hide();
                }
                $(parent).attr('deleteIds', '');
                if (config.success) {
                    config.success(values);
                }
            },

            error: function error(data) {
                App.Ajax.handleError(data);
            }
        });
    }

    self.entityRemoveAttachmentsDialog = function (confirmMessage, projectId, entityType, listParent, inputParent) {
        if (self.dontShowEntityDeleteDialog) {
            self.removeFromEntity(
                {
                    'project_id': projectId,
                    'entity_type': entityType,
                    'listParent': listParent
                }
            );
        } else {
            App.Dialogs.confirm(
                confirmMessage,
                function() {
                    self.removeFromEntity(
                        {
                            'project_id': projectId,
                            'entity_type': entityType,
                            'listParent': listParent
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
    }

    self.lazyLoad = function(selector, threshold) {
        if ($(selector).data('observer')) {
            var observer = $(selector).data('observer');
            observer.disconnect();
        }
        var lazyloadImages = $(selector).find(".lazy");
        var imageObserver = new IntersectionObserver(function(entries, observer) {
            $.each(entries, function(_, entry) {
                if (entry.isIntersecting) {
                    var image = entry.target;
                    image.classList.remove("lazy");
                    imageObserver.unobserve(image);
                }
            });
        }, { root: $(selector)[0], rootMargin: '0px', threshold: threshold });

        $(selector).data('observer', imageObserver);
        $.each(lazyloadImages, function(_, image) {
          imageObserver.observe(image);
        });
    }

    //---------------------------------------------------------------
	// FILTERING
	//---------------------------------------------------------------

	self.filterAttachments = function(e)
	{
		var bubble = $('#attachmentFilterByChange').bubble(
		{
			bubble: '#filterAttachmentsBubble',
			toggleEvent: 'null'
		});

		self._filterLoad(
		{
			show: function()
			{
				self._filterBind(
				{
					bubble: bubble
				});

				bubble.show(e);
			}
		});
	}

	self._filterLoad = function(o)
	{
		var busy = $('#attachmentFilterByBusy');
		var target = '/attachments/ajax_render_attachments_filter/' + self.project_id;
		App.Ajax.call(
		{
			target: target,

			arguments: {
				filters: self.filters
			},

			start: function()
			{
				$('#attachmentFilterByChange').hide();
				busy.show();
			},

			stop: function()
			{
				busy.hide();
				$('#attachmentFilterByChange').show();
			},

			success: function(html)
			{
				$('#filterAttachmentsContent').html(html);
				o.show();
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self._filterBind = function(o)
	{
		$('#filterAttachmentsApply').click(
			function()
			{
				self._filterApply(o);
			}
		);

		$('#filterAttachmentsCancel').click(
			function()
			{
				self._filterCancel(o);
			}
		);
	}

	self._filterApply = function(o)
	{
		var filters = App.Filters.getAll($('#filterAttachmentsContent'));

		App.Ajax.call(
		{
			target: '/attachments/ajax_render_attachments_filter_info/' + self.project_id,

			arguments: {
				filters: filters
			},

			start: function()
			{
				$('#filterAttachmentsApply').addClass('button-busy');
			},

			stop: function()
			{
				$('#filterAttachmentsApply').removeClass('button-busy');
			},

			success: function(html)
			{
				self._filterSync(filters, html);
                self.page = 0;
				self.loadAttachments(self.project_id, self.page, {
                    field: self.orderBy,
                    dir: self.orderDir
                }, self.search);
				o.bubble.hide();
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
    }

    self._filterRestore = function(filters)
    {
        self.filters = filters;

		App.Ajax.call(
        {
            target: '/attachments/ajax_render_attachments_filter_info/' + self.project_id,

            arguments: {
                filters: self.filters
            },

            start: function()
            {
                $('#filterAttachmentsApply').addClass('button-busy');
            },

            stop: function()
            {
                $('#filterAttachmentsApply').removeClass('button-busy');
            },

            success: function(html)
            {
                self._filterSync(self.filters, html);
            },

            error: function(data)
            {
                App.Ajax.handleError(data);
            }
        });
    }

	self._filterSync = function(filters, info)
	{
		$('#attachmentFilterByInfo').hide();
		$('#attachmentFilterByEmpty').hide();
		$('#attachmentFilterByChange').removeClass('link link-dashed nolink');

		info = $.trim(info);
		if (info)
		{
			$('#attachmentFilterByChange').addClass('nolink');
			$('#attachmentFilterByInfo').html(info);
			$('#attachmentFilterByInfo').show();
			$('#attachmentFilterByReset').show();
			self.filters = filters;
		}
		else
		{
			$('#attachmentFilterByReset').hide();
			$('#attachmentFilterByChange').addClass('link link-dashed');
			$('#attachmentFilterByEmpty').show();
			self.filters = null;
		}
	}

	self._filterCancel = function(o)
	{
		o.bubble.hide();
	}

	self.filterReset = function()
	{
		App.Ajax.call(
		{
			target: '/attachments/ajax_render_attachments_filter_info/' + self.project_id,

			arguments: {
				filters: null
			},

			start: function()
			{
				$('#attachmentFilterByChange').hide();
				$('#attachmentFilterBy .busy').show();
			},

			stop: function()
			{
				$('#attachmentFilterBy .busy').hide();
				$('#attachmentFilterByChange').show();
			},

			success: function(html)
			{
                self._filterSync(null, '');
                self.page = 0;
				self.loadAttachments(self.project_id, self.page, {
                    field: self.orderBy,
                    dir: self.orderDir
                }, self.search);
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}
}();

;

