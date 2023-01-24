/*******************************************************************/
/* Defects */

/* [Permissions checked!] */

App.Defects = {};

App.ready(function() {
    // Whenever tests are modified or (re-)loaded, we need to re-apply
    // the defect lookup.
    $.subscribe(
        'tests.loaded, tests.changed',
        'defects',
        function(o) {
            if (o.project_id) {
                App.Defects.applyLookup(o.project_id);
            }
        }
    );
});

App.Defects.preparePush = function(project_id, test_id, page, entity_id) {
    $('#pushDefectLink').hide();
    $('#pushDefectLinkBusy').show();

    if (test_id || parseInt(test_id) === 0) {
        var test_ids = test_id;
    } else {
        var test_ids = App.Tests.getSelected();

        if (test_ids == '') {
            return;
        }
    }

    // Read the standard input fields from the form of the
    // result dialog.
    var context = App.Tests.resultDialogValues();

    var error = function(data) {
        $('#pushDefectLink').show();
        $('#pushDefectLinkBusy').hide();
        App.Ajax.handleError(data);
    };

    context.project_id = project_id;
    context.test_ids = test_ids;
    context.page = page;
    context.entity_id = entity_id;

    App.Ajax.call({
        target: '/defects/ajax_prepare_push',

        arguments: context,
        success: function(data) {
            if (data.show_dialog) {
                $('#pushDefectDialog').remove();
                $('body').append(data.dialog);
                $('#pushDefectLink').show();
                $('#pushDefectLinkBusy').hide();
                App.applyTextAreaResizer();
                App.Defects.pushDialog(context);
                let defect_pages = [
                    '/runs/overview/',
                    '/runs/edit/',
                    '/milestones/overview/',
                    '/milestones/edit/',
                    '/suites/view/',
                    '/cases/view/',
                    '/cases/edit/'
                ];

                defect_pages.forEach(function (defect_page) {
                    if (window.location.search.indexOf(defect_page) > -1) {
                        $.each($('.textarea-resizable textarea'), function (index, element) {
                            $(element).addClass('form-fields');
                        });
                    }
                });
            } else {
                App.Defects.push(
                    context, {
                        success: function(data) {
                            $('#pushDefectLink').show();
                            $('#pushDefectLinkBusy').hide();
                        },

                        error: error
                    }
                );
            }
        },

        error: error
    });
}

App.Defects.getInput = function(context) {
    // Append the defect fields. All defect field controls have
    // 'defect' class in order to identify them as such.
    $('#pushDefectDialog .defect').each(function (ix, e) {
        var t = $(this);
        context[t.attr('name')] = t.val();
    });
    let $attachmentsArea = $('#defectAttachments input#attachments');
    let att = $attachmentsArea.val();
    if ($attachmentsArea.length === 0) {
        att = $('#addResultForm input#attachments').val();
    }

    if (att) {
        att = JSON.parse(att);
        att = att.map(function (attachment) {
            return attachment.dataId;
        });
    }
    if (att !== undefined) {
        context.attachments = att.join(',');
    }

    return context;
}

App.Defects.pushDialog = function(context) {
    App.Validation.hideErrors();
    let $pushDefectForm = $('#pushDefectForm');
    let $pushDefectsErrors = $('#pushDefectsErrors');
    let $pushDefectSubmit = $('#pushDefectSubmit');
    let buttonBusyClassName = 'button-busy';

    $pushDefectsErrors.empty();
    $pushDefectForm.unbind('submit');
    $pushDefectForm.submit(function (e) {
        App.Validation.hideErrors();
        $pushDefectsErrors.empty();
        context = App.Defects.getInput(context);
        $pushDefectSubmit.addClass(buttonBusyClassName);

        App.Defects.push(
            context,
            {
                success: function (data) {
                    $pushDefectSubmit.removeClass(buttonBusyClassName);
                    // Reset the overflow attribute to the body to enable scrolling again
                    $('body').css('overflow', 'auto');
                    App.Dialogs.close('#pushDefectDialog');
                    if (data.message) {
                        if (context.page !== 'tests') {
                            App.Dialogs.message(
                                data.message,
                                'Success'
                            );
                        }
                    }
                },
                error: function (data) {
                    $pushDefectSubmit.removeClass(buttonBusyClassName);
                    App.Ajax.handleError(
                        data,
                        '#pushDefectErrors'
                    );
                }
            }
        );

        return false;
    });

    // Implement the cascading feature for dropdowns
    $('#pushDefectForm select.single').each(function (ix, v) {
        var dropdown = $(v);

        // Apply the chosen control
        dropdown.chosen();

        if (dropdown.attr('rel') == 'cascading') {
            dropdown.unbind('change');
            dropdown.bind('change', function (e) {
                context = App.Defects.getInput(context);
                App.Defects.onFieldChange(context, this);
            });
        }
    });

    // Apply the chosen control for multiselect fields
    $('#pushDefectForm select.multi').each(function (ix, v) {
        $(v).chosen();
    });

    App.Dialogs.open({
        selector: '#pushDefectDialog',
        enter: function () {
            if (!$('input[tabindex=0]').is(":focus") || $(":input.form-control").is(":focus")) {
                $('#pushDefectSubmit').click();
            }
        }
    });

    $.publish('push_dialog.loaded');
}

App.Defects.push = function (context, callbacks) {
    App.Ajax.call({
        target: '/defects/ajax_push',

        arguments: context,

        success: function (data) {
            let $addResultDefects = $('#addResultDefects');
            callbacks.success(data);
            if (data.defect_id) {
                var ids = $addResultDefects.val();
                if (ids) {
                    ids = ids + ',' + data.defect_id;
                } else {
                    ids = data.defect_id;
                }
                $addResultDefects.val(ids);
            }
            App.Effects.add('#pushDefectLink');
        },

        error: function (data) {
            callbacks.error(data);
        }
    });
}

App.Defects.onFieldChange = function(context, e) {
    context.field = $(e).attr('field');
    var busy = $('#defect_' + context.field + 'Busy');
    busy.show();

    App.Ajax.call({
        target: '/defects/ajax_get_dependent_fields',

        arguments: context,

        success: function(data) {
            $.each(data.fields, function(ix, v) {
                var e = $('#defect_' + ix);
                var isDropdown = v.type === 'dropdown';
                var isListField = isDropdown || v.type === 'multiselect';

                if (isListField) {
                    $('option', e).remove();

                    if (isDropdown) {
                        e.append('<option value="">&nbsp;</option>');
                    }

                    // Maintain the right order as received from the
                    // server with the 'keys' array
                    if (v.options && v.keys) {
                        $.each(v.keys, function(ix, k) {
                            var option = $('<option></option>');
                            option.val(k);
                            option.text(v.options[k]);
                            option.appendTo(e);
                        });
                    }
                }

                if (v.value) {
                    e.val(v.value);
                }

                var isDisabled = v.disabled || (isDropdown && v.keys === undefined);
                e.prop('disabled', isDisabled);

                // Refresh the chosen control if this is a multiselect or
                // dropdown field
                if (isListField) {
                    e.trigger('liszt:updated');
                }

                if(isDropdown) {
                    App.Defects.toggleEpic();
                }

            });

            busy.hide();
        },

        error: function(data) {
            busy.hide();
            App.Ajax.handleError(data);
        }
    });
}

App.Defects.applyLookup = function(project_id, ctx) {
    var request = null;

    $('a.defectLink, span.defectLink', ctx || $(document)).bubble({
        bubble: '#defectBubble',

        onShow: function(e) {
            var id = $(e).attr('rel');
            request = App.Defects.lookup(project_id, id);
        },

        onHide: function(e) {
            var content = $('.content', $('#defectBubble'));
            content.html('');

            if (request) {
                App.Ajax.abort(request);
            }
        }
    });
}

App.Defects.lookup = function(project_id, defect_id) {
    var bubble = $('#defectBubble');
    var busy = $('.busy', bubble);
    var content = $('.content', bubble);
    var errors = $('.error', bubble);

    errors.hide();
    content.hide();
    content.html('');
    busy.show();

    return App.Ajax.call({
        target: '/defects/ajax_lookup',
        blockUI: false,

        arguments: {
            project_id: project_id,
            defect_id: defect_id
        },

        success: function(html) {
            content.html(html);
            content.show();
            $('.container', content).css(
                'height',
                bubble.height() -
                $('.header', content).outerHeight() -
                $('.attributes', content).outerHeight() -
                $('.footer', content).outerHeight()
            );

            busy.hide();
        },

        error: function(data) {
            busy.hide();

            if (data && data.error) {
                $('#defectBubbleError').text(data.error);
                errors.show();
            } else {
                bubble.hide();
            }
        }
    });
}

App.Defects._loadDetailsStopped = false;

App.Defects.loadDetails = function(project_id, chunk_size) {
    var defects = {};

    $('#defects .js-defect').each(function(ix, v) {
        var id = $(v).attr('rel');
        if (!defects.hasOwnProperty(id)) // Avoid duplicates
        {
            defects[id] = true;
        }
    });

    defects = Object.keys(defects);

    // We go through the list of found defects chunk-wise in order to
    // limit the requests to a reasonable time (think about asking a
    // slow bug tracker for 100 defects). This also heavily improves
    // concurrency for large defect sets since we can ask for multiple
    // defects in parallel. In order to limit the impact on TestRail,
    // we don't send all requests at once but with delays between them.

    App.Defects._loadDetailsStopped = false;

    if (chunk_size) {
        var chunk_no = 0;

        for (i = 0; i < defects.length; i += chunk_size) {
            var ids = defects.slice(i, i + chunk_size);
            App.Defects._scheduleDetails(project_id, ids, chunk_no);
            chunk_no++;
        }
    } else {
        App.Defects._loadDetails(project_id, defects);
    }
}

App.Defects._scheduleDetails = function(project_id, defect_ids, chunk_no) {
    setTimeout(
        function() {
            App.Defects._loadDetails(project_id, defect_ids);
        },
        chunk_no * 1000
    );
}

App.Defects._loadDetails = function(project_id, defect_ids) {
    if (App.Defects._loadDetailsStopped) {
        // A previous load failed and we don't start additional requests
        // (also see below).
        return;
    }

    App.Ajax.call({
        target: '/defects/ajax_get_details',
        blockUI: false,

        arguments: {
            project_id: project_id,
            defect_ids: defect_ids
        },

        stop: function() {},

        success: function(data) {
            $('#defects .js-defect').each(function(ix, v) {
                var defect_id = $(v).attr('rel');
                if (data[defect_id]) {
                    var row = $(this).closest('tr');
                    var defect = data[defect_id];
                    $('.js-title', row).html(defect.title);
                    $('.js-status', row).html(defect.status);
                }
            });
        },

        error: function(data) {
            App.Defects._loadDetailsStopped = true; // Stop loading

            // Errors are ignored here (can happen if the user leaves
            // the page before loading has finished).
            if (data && data.error) {
                App.Ajax.handleError(data);
            }
        }
    });
}

App.Tests.Attachments = new function() {
    var self = this;

    self.dropzones = [];

    self.init = function(selector, project_id, test_id) {
        var dropzone = App.Dropzone.applyDrop(
            selector, {
                url: App.Page.formatUri(
                    '{0}/attachments/ajax_add_for_test_change/{1}/{2}',
                    Consts.ajaxBaseUrl,
                    project_id,
                    test_id
                ),

                dict: {
                    drop: lang('attachments_drop')
                },

                start: function() {
                    App.Dropzone.hide(); // Hide volatile dropzones
                },

                success: function(file, data) {
                }
            }
        );

        self.dropzones.push(dropzone);
        return dropzone;
    }

    self.clear = function() {
        $.each(self.dropzones, function(ix, v) {
            v.removeAllFiles();
        });
    }
}

// Toggle the Epic field when selected value of issueType dropdown is Epic.
App.Defects.toggleEpic = function() {
    var $selector = $("#defect_epic_chzn, #labeldefect_epic");
    if ($('#defect_issuetype option:selected').html() === 'Epic') {
        $selector.hide();
    } else {
        $selector.show();
    }
}

;

