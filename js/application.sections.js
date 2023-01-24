/*******************************************************************/
/* Sections  */

/* [Permissions checked!] */

App.Sections = new function()
{
    var self = this;

	// Fields for keeping the current state (drag & drop, etc.)
	self.drop_data = null;
	self.current_section = {};
	self.editorFiles = {};
	self.attachmentsCode = {};

    //---------------------------------------------------------------
    // DRAG & DROP (COPY/MOVE)
    //---------------------------------------------------------------

    self.drop = function(e, drop_data)
    {
        // Is there a previous, incomplete drag & drop operation?
        if (self.drop_data)
        {
            self.dropCancel();
        }

        self.drop_data = drop_data;
        var show_menu = false;

        // If the user holds the shift key when dropping the section,
        // we execute the copy directly. The same is true for ctrl/cmd +
        // move. Otherwise, we show a dropdown menu.
        if (e.shiftKey)
        {
            self.dropCopy();
        }
        else if (e.ctrlKey || e.metaKey)
        {
            if (self._dropCanMove(self.drop_data))
            {
                self.dropMove();
            }
            else
            {
                show_menu = true;
            }
        }
        else
        {
            show_menu = true;
        }

        if (show_menu)
        {
            self._dropShowHighlight(drop_data.section_id, drop_data.droppable_id);
            self._dropShowMenu(e, drop_data);
        }
    }

    self._dropShowMenu = function(e, drop_data)
    {
        if (self._dropCanMove(drop_data))
        {
            $('#sectionsDndMoveDisabled').hide();
            $('#sectionsDndMove').show();
        }
        else
        {
            $('#sectionsDndMove').hide();
            $('#sectionsDndMoveDisabled').show();
        }

        App.Dropdowns.show('#sectionsDndDropdown', e.pageX, e.pageY);
    }

    self._dropIsChild = function(parent_id, child_id)
    {
        var parent = $('#node-' + parent_id);
        return parent.find('#node-' + child_id).length > 0;
    }

    self._dropCanMove = function(drop_data)
    {
        if (drop_data.section_id == drop_data.parent_id)
        {
            return false; // Moved directly inside itself -> false
        }

        if (drop_data.section_id == drop_data.after_id)
        {
            return false; // Moved after itself -> not supported
        }

        if (drop_data.parent_id)
        {
            if (self._dropIsChild(drop_data.section_id,
                drop_data.parent_id))
            {
                // The new parent is a (maybe indirect) child of the
                // section to move -> false
                return false;
            }
        }

        return true;
    }

    self._dropHideMenu = function()
    {
        App.Dropdowns.hide('#sectionsDndDropdown');
    }

    self._dropAddClass = function(section_id, cls)
    {
        $('> a', $('#node-' + section_id)).addClass(cls);
    }

    self._dropRemoveClass = function(section_id, cls)
    {
        $('> a', $('#node-' + section_id)).removeClass(cls);
    }

    self._dropShowProgress = function(section_id)
    {
        self._dropAddClass(section_id, 'jstree-loading');
    }

    self._dropHideProgress = function(section_id)
    {
        self._dropRemoveClass(section_id, 'jstree-loading');
    }

    self._dropShowHighlight = function(section_id, droppable_id)
    {
        self._dropAddClass(section_id, 'jstree-dragging');
        self._dropAddClass(droppable_id, 'jstree-highlighted');
    }

    self._dropHideHighlight = function(section_id, droppable_id)
    {
        self._dropRemoveClass(section_id, 'jstree-dragging');
        self._dropRemoveClass(droppable_id, 'jstree-highlighted');
    }

    self.dropCancel = function()
    {
        self._dropStop(self.drop_data);
    }

    self._dropStop = function(o)
    {
        self._dropHideMenu();
        self._dropHideHighlight(o.section_id, o.droppable_id);
        self._dropHideProgress(o.droppable_id);
        self.drop_data = null;
    }

    self.dropCopy = function()
    {
        self._dropCopy(self.drop_data);
    }

    self._dropCopy = function(o)
    {
        self._dropShowProgress(o.droppable_id);

        App.Ajax.call(
        {
            target: '/sections/ajax_copy',

            arguments:
            {
                section_id: o.section_id,
                parent_id: o.parent_id,
                after_id: o.after_id,
                columns: App.Tables.columns_for_user,
                filters: App.Suites.filters
            },

            success: function(data)
            {
                self._dropStop(o);

                if (App.Suites.display == 'tree')
                {
                    var grid = $(data.grid);

                    if (o.after_id)
                    {
                        grid.insertAfter('#section-' + o.after_id);
                    }
                    else
                    {
                        if (o.parent_id)
                        {
                            var sub = $('#subsections-' + o.parent_id);
                            grid.prependTo(sub);
                            sub.show();
                        }
                        else
                        {
                            grid.prependTo($('#groups'));
                        }
                    }
                }

                var tree = $('#groupTree');
                var parent = null;

                if (o.parent_id)
                {
                    parent = $('#node-' + o.parent_id);
                }

                if (o.after_id)
                {
                    var after = $('#node-' + o.after_id);
                    after.after(data.node);
                }
                else
                {
                    if (parent)
                    {
                        if (parent.children('ul').length == 0)
                        {
                            parent.append('<ul>');
                        }

                        parent.children('ul').prepend(data.node);
                    }
                    else
                    {
                        tree.children('ul').prepend(data.node);
                    }
                }

                if (parent)
                {
                    self._open(parent);
                }

                self._fixTree();
                App.Suites.onCasesAdded();
            },

            error: function(data)
            {
                self._dropStop(o);
                App.Ajax.handleError(data);
            }
        });
    }

    self.dropMove = function()
    {
        self._dropMove(self.drop_data);
    }

    self._dropMove = function(o)
    {
        self._dropShowProgress(o.droppable_id);
        var node = $('#node-' + o.section_id);

        App.Ajax.call(
        {
            target: '/sections/ajax_move',

            arguments:
            {
                section_id: o.section_id,
                parent_id: o.parent_id,
                after_id: o.after_id
            },

            success: function(data)
            {
                self._dropStop(o);

                var parent = null;
                if (o.parent_id)
                {
                    parent = $('#node-' + o.parent_id);
                }

                if (o.after_id)
                {
                    var after = $('#node-' + o.after_id);
                    node.insertAfter(after);
                }
                else
                {
                    var tree = parent || $('#groupTree');
                    if (parent)
                    {
                        if (!parent.children('ul').length)
                        {
                            parent.append('<ul>');
                        }
                    }

                    node.prependTo(tree.children('ul'));
                }

                if (parent)
                {
                    self._open(parent);
                }

                self._fixTree();

                if (App.Suites.display == 'tree')
                {
                    var grid = $('#section-' + o.section_id);
                    if (o.after_id)
                    {
                        grid.insertAfter('#section-' + o.after_id);
                    }
                    else
                    {
                        if (o.parent_id)
                        {
                            var p = $('#subsections-' + o.parent_id);
                            grid.prependTo(p);
                            p.show();
                        }
                        else
                        {
                            grid.prependTo($('#groups'));
                        }
                    }
                }
            },

            error: function(data)
            {
                self._dropStop(o);
                App.Ajax.handleError(data);
            }
        });
    }

    self._fixTree = function()
    {
        $('#groupTree li').each(function()
        {
            var t = $(this);
            var is_open = t.hasClass('jstree-open');

            t.removeClass('jstree-open jstree-closed jstree-leaf jstree-last');

            if (!t.next().length)
            {
                t.addClass('jstree-last')
            }

            if (!t.find('> ul > li').length)
            {
                t.addClass('jstree-closed');
                t.addClass('jstree-leaf');
            }
            else
            {
                if (is_open)
                {
                    t.addClass('jstree-open');
                }
                else
                {
                    t.addClass('jstree-closed');
                }
            }
        });
    }

    //---------------------------------------------------------------
    // ADD/EDIT/DELETE
    //---------------------------------------------------------------

    self.remove = function(section_id)
    {
        var busy = $('#sectionBusy-' + section_id);
        busy.show();

        App.Ajax.call(
        {
            target: '/sections/ajax_delete',

            arguments:
            {
                section_id: section_id
            },

            success: function(data)
            {
                $('#section-' + section_id).remove();

                var tree = $('#groupTree');
                var node = $('#node-' + section_id);

                var to_select = node.prev();
                if (!to_select.length)
                {
                    to_select = node.parent('ul').parent('li');
                    if (!to_select.length)
                    {
                        to_select = node.next();
                    }
                }

                tree.jstree('delete_node', node);
                if (tree.find('> ul > li').length == 0)
                {
                    if (!$('#loadCases').is(':visible'))
                    {
                        App.Suites.filterCasesReset();
                    }
                }
                else
                {
                    if (App.Suites.display != 'tree')
                    {
                        if (section_id == App.Suites.group_id &&
                            to_select.length)
                        {
                            tree.jstree('select_node', to_select);
                        }
                    }
                }

                App.Suites.onCasesDeleted();
                busy.hide();
            },

            error: function(data)
            {
                busy.hide();
                App.Ajax.handleError(data);
            }
        });
    }

    self.removeInit = function(section_id)
    {
        App.Ajax.call(
        {
            target: '/sections/ajax_render_delete_extra',

            arguments:
            {
                section_id: section_id
            },

            success: function(html)
            {
                App.Dialogs.removeLoaded(html);
            },

            error: function(data)
            {
                App.Ajax.handleError(data);
            }
        });
    }

    self._editDialog = function(o)
    {
        var prevImageDialogUploadSuccess = null;
        var prevImageDialogSuccess = null;
        var prevRemoveSuccess = null;
        var prevAttachmentContainerParent = null;
		var prevInputParent = null;
		App.Validation.hideErrors();
		self.current_section = o;

        // Initialize the dialog
        $('#editSectionName').val(o.name);
        if (o.description) {
			var regex = /\!\[\]\(index.php\?\/attachments\/?get\/?([\w-]+)\)/g;
			var attachmentIds = [];
			match = regex.exec(o.description);
			while (match != null) {
				attachmentIds.push(match[1]);
				match = regex.exec(o.description);
			}
			attachmentIds = attachmentIds.map(function (el) { return { id: el, dataId: '' } });
			App.Ajax.call({
				target: '/attachments/ajax_get_entity_list_items',

				arguments: {
					project_id: self.projectId,
					attachment_ids: JSON.stringify(attachmentIds)
				},

				success: function success(data) {
					html = o.description.replace(
						regex,
						function (match, p1) {
							return data.data[p1];
						}
					);
					$('#editSectionDescription_display').html(html);
					$('#editSectionDescription_display').trigger('keyup');
				},

				error: function error(data) {
					App.Ajax.handleError(data);
				}
			});
		} else {
			$('#editSectionDescription_display').html('');
		}
		$('#editSectionForm').unbind('submit');
		$('#editSectionForm').submit(function(e)
		{
			App.Validation.hideErrors();

			o.submit(
				$.trim($('#editSectionName').val()),
				$.trim($('#editSectionDescription').val())
			);

            return false;
        });

        App.Dialogs.open(
        {
            selector: '#editSectionDialog',
            focusedControl: '#editSectionName',
            selectedControl: '#editSectionName',
            titleSelector: o.titleSelector,
            cancel: o.cancel,
            show: function() {
                var selector = '#editSectionAttachments';
                App.Attachments.initEditorAttachments(
                    App.Sections.attachmentsCode,
                    {
                        inputParent: selector,
                        itemsParent: selector
                    }
                );
                App.Editor.entity_id = '';
                if (App.Editor.editor_dropzone['#editSectionDescription_drop']) {
                    App.Editor.editor_dropzone['#editSectionDescription_drop'].options.params.entity_id = o.section_id || '';
                }
                self._showAttachments(o.attachments);
                prevImageDialogUploadSuccess = App.Editor.imageDialogUploadSuccess;
                prevImageDialogSuccess = App.Editor.imageDialogSuccess;
                prevRemoveSuccess = App.Attachments.removeSuccess;
                prevAttachmentContainerParent = App.Editor.attachmentContainerParent;
                prevInputParent = App.Attachments.inputParent;
            },
            close: function() {
                self.current_section = {};
                self.editorFiles = {};
                $('#editSectionAttachments #entityAttachmentList .attachment-list-item').remove();
                $('#editSectionAttachments #entityAttachmentListAdd').hide();
                $('#editSectionAttachments #entityAttachmentListEmptyIcon').show();
                App.Editor.entity_id = null;
                App.Editor.imageDialogUploadSuccess = prevImageDialogUploadSuccess;
                App.Editor.imageDialogSuccess = prevImageDialogSuccess;
                App.Attachments.removeSuccess = prevRemoveSuccess;
                App.Editor.attachmentContainerParent = prevAttachmentContainerParent;
                App.Attachments.inputParent = prevInputParent;
            }
        });

        setTimeout(
            function(){
                App.DirtyChecker.init('editSectionSubmit', 'editSectionForm');
            },
            500
        );
    }

    self._showAttachments = function(attachments)
    {
        attachments.forEach(function (attachment) {
			App.Attachments._addRow(attachment, '#editSectionAttachments');
        });
    }

    self.removeAttachment = function(attachment_id, project_id)
	{
		App.Attachments.remove(attachment_id, {
			override: true,
			entity_type: 'section',
            project_id: project_id || 0,
            success: function(data) {
                self._removeAttachment(attachment_id)
            }
        });
    }

    self._removeAttachment = function(attachment_id)
    {
        var attachments = self.current_section.attachments || [];
        self.current_section.attachments = attachments.filter(function(attachment){
            return attachment.id !== attachment_id
        })
        self._showAttachments(self.current_section.attachments);
        var $description = $('#sectionDesc-' + self.current_section.section_id);
        $description.html($description.html())
    }

    self._onEditorImageUpload = function(file, data)
    {
        self.editorFiles[data.id] = data.attachment;
    }

    self._onEditorImageDialogSuccess = function(control, attachment_ids)
    {
        var attachments = self.current_section.attachments || [];
        attachment_ids.forEach(function (attachment_id) {
            attachments.push(self.editorFiles[attachment_id]);
        });
        self.current_section.attachments = attachments;
        self._showAttachments(self.current_section.attachments);
        self.editorFiles = {};
    }

    self.edit = function(section_id, projectId)
	{
		self.projectId = projectId;
        self._load(
        {
            section_id: section_id,
            success: function(section)
            {
                $('.editSectionEdit').show();
                $('.editSectionAdd').hide();

                self._editDialog(
                {
                    name: section.name,
                    description: section.description,
                    attachments: section.attachments,
                    section_id: section_id,
                    titleSelector: '.dialogTitleEdit',

                    submit: function(name, description)
                    {
                        self.current_section.attachments = $('#editSectionAttachments #attachments').val();
						self._edit(
						{
							section_id: section_id,
							name: name,
							description: description,
							attachments: self.current_section.attachments
                        });
                    }
                });
            }
        });
    }

    self._load = function(o)
    {
        var busy = $('#sectionBusy-' + o.section_id);
        busy.show();

        App.Ajax.call(
        {
            target: '/sections/ajax_get',

            arguments:
            {
                section_id: o.section_id
            },

            stop: function()
            {
                busy.hide();
            },

            success: function(section)
            {
                o.success(section);
            },

            error: function(data)
            {
                App.Ajax.handleError(data);
            }
        });
    }

    self._edit = function(o)
    {
        $('#editSectionSubmit').addClass('button-busy');

        self._make_request({
            url: '/sections/ajax_update',
            request_data: {
                section_id: o.section_id,
                name: o.name,
                description: o.description,
                attachments: o.attachments
            },
            on_success: function(desc) {
                if (desc) {
                    $('#sectionDesc-' + o.section_id).children('div').html(desc);
                    $('#sectionDesc-' + o.section_id).show();
                } else {
                    $('#sectionDesc-' + o.section_id).hide();
                }

                $('#sectionName-' + o.section_id).text(o.name);
                $('#sectionNameAlt-' + o.section_id).text(o.name);
                $('#editSectionDescription').val('');App.Effects.add('#sectionName-' + o.section_id);
            }
        })
    }

    self.addSub = function(suite_id, parent_id)
    {
        self.add(suite_id, parent_id);
    }

    self.add = function(suite_id, parent_id)
    {
        $('.editSectionEdit').hide();
        $('.editSectionAdd').show();

        self._editDialog(
        {
            name: '',
            description: '',
            attachments: [],
            titleSelector: '.dialogTitleAdd',

            submit: function(name, description)
            {
                self.current_section.attachments = $('#editSectionAttachments #attachments').val();
				self._add(
				{
					suite_id: suite_id,
					name: name,
					description: description,
					parent_id: parent_id,
					attachments: self.current_section.attachments
                });
            }
        });
    }

    self._make_request = function(config)
    {
        var url = config.url || '';
        var request_data = config.request_data || {};
        var on_success = config.on_success || function(){};

        if (url) {
            App.Ajax.call(
                {
                    target: url,

                    arguments: request_data,

                    stop: function () {
                        $('#editSectionSubmit').removeClass('button-busy');
                    },

                    error: function (data) {
                        App.Ajax.handleError(data, '#editSectionErrors');
                    },

                    success: function (data) {
                        App.Dialogs.closeTop();

                        $('#noSectionContainer').hide();
                        $('#noSectionContainerSidebar').hide();
                        $('#contentToolbar').show();
                        $('#sidebarToolbar').show();
                        $('#groupsEmpty').remove(); // If available

                        if (on_success && typeof on_success === 'function') {
                            on_success(data);
                        }
                    },
                }
            );
        }
    }

    self._update_tree = function(data, parent_id)
    {
        // Add to sidebar tree
        var $tree = $('#groupTree');
        var node = $(data.node);

        if (parent_id) {
            var parent = $('#node-' + parent_id);
            if (parent.children('ul').length == 0) {
                parent.append('<ul>');
            }

            node.appendTo(parent.children('ul'));
            self._open(parent);
        } else {
            node.appendTo($tree.children('ul'));
        }

        if ($('#groups').children().length === 0) {
            // Initialize the tree if it's the first section.
            // In case of the compact/subtree view modes, we
            // also make sure to select the section.
            App.Suites.applyTree(App.Suites.display === 'tree' ? undefined : data.id);
        }

		// Append grid to sections (left) (depending on mode)
		if (App.Suites.display === 'tree' || (App.Suites.display === 'subtree' && parent_id) ) {
			var grid = $(data.grid);
			if (parent_id) {
				var sub = $('#subsections-' + parent_id);
				grid.appendTo(sub);
				sub.show();
			} else {
				grid.appendTo($('#groups'));
			}
		}

        self._fixTree();
        App.Suites.onCasesAdded();
    }

    self._add = function(o)
    {
        $('#editSectionSubmit').addClass('button-busy');

        // Reset the overflow attribute to the body to enable scrolling again
        $('body').css('overflow', 'auto');

        self._make_request({
            url: '/sections/ajax_add',
            request_data: {
                suite_id: o.suite_id,
                parent_id: o.parent_id,
                name: o.name,
                description: o.description,
                attachments: o.attachments,
                columns: App.Tables.columns_for_user
            },
            on_success: function(data) {
                self._update_tree(data, o.parent_id);
            $('#editSectionDescription').val('');}
        });
    }

    self._open = function(node)
    {
        $(node).addClass('jstree-open');
        $('#groupTree').jstree('open_node', node);
    }

    //---------------------------------------------------------------
    // NAVIGATION
    //---------------------------------------------------------------

    self.next = function(group_id, display)
    {
        var node = $('#node-' + group_id);

        var next = $();
        if (display != 'subtree')
        {
            next = node.find('li:first'); // First child
        }

        if (!next.length)
        {
            next = node.next();
            if (!next.length)
            {
                // Find next sibling for direct or indirect
                // parent.
                var parent = node.parent('ul').parent('li');
                while (parent.length > 0)
                {
                    next = parent.next();
                    if (next.length)
                    {
                        break;
                    }

                    parent = parent.parent('ul').parent('li');
                }
            }
        }

        return next.length ? ('#' + next.attr('id')) : null;
    }

    self.prev = function(group_id)
    {
        var node = $('#node-' + group_id);

        var prev = node.prev();
        if (prev.length)
        {
            var child = prev.find('li:last'); // Last child
            if (child.length)
            {
                prev = child;
            }
        }

        if (!prev.length)
        {
            prev = node.parent('ul').parent('li');
        }

        return prev.length ? ('#' + prev.attr('id')) : null;
    }
}

;

