App.SiteSettings = new function()
{
   var self = this;

   self.filters = null;

   //---------------------------------------------------------------
   // FILTERING
   //---------------------------------------------------------------

   self.filterLogs = function(e)
   {
       var filter = self._createFilter(e);
       filter.open();
   }

   self.filterLogsReset = function()
   {
       var filter = self._createFilter();
       filter.reset();
   }

   self._createFilter = function(e)
   {
       return new App.SiteSettings.Filter(
       {
           event: e,
           filters: self.filters,
           save_filters: true,

           changed: function(filters)
           {
               self.filters = filters;
               App.SiteSettings.loadAuditLogs(filters);
           }
       });
   }
   
}

//-------------------------------------------------------------------
// FILTERING
//-------------------------------------------------------------------

App.SiteSettings.Filter = function(o)
{
   var self = this;

   self.filters = o.filters;
   self.save_filters = o.save_filters;
   self.changed = o.changed;
   self.event = o.event;

   self.open = function(e)
   {
       var bubble = $('#filterByChange').bubble(
       {
           bubble: '#filterLogsBubble',
           toggleEvent: 'null'
       });

       self._load(
       {
           show: function()
           {
               self._bind(
               {
                   bubble: bubble
               });

               bubble.show(self.event);
           }
       });
   }

   self._load = function(o)
   {
       var busy = $('#filterBy .busy');

       App.Ajax.call(
       {
           target: '/admin/audit/ajax_render_log_filter',

           arguments: {
               filters: self.filters
           },

           start: function()
           {
               $('#filterByChange').hide();
               busy.show();
           },

           stop: function()
           {
               busy.hide();
               $('#filterByChange').show();
           },

           success: function(html)
           {
               $('#filterLogsContent').html(html);
               o.show();
           },

           error: function(data)
           {
               App.Ajax.handleError(data);
           }
       });
   }

   self._bind = function(o)
   {
       $('#filterLogsApply').click(
           function()
           {
               self._apply(o);
               return false; // Important for confirm-leave behavior
                             // with IE, e.g. on bulk-edit for logs
           }
       );

       $('#filterLogsCancel').click(
           function()
           {
               self._cancel(o);
               return false; // Important for confirm-leave behavior
                             // with IE, e.g. on bulk-edit for logs
           }
       );
   }

   self._apply = function(o)
   {
       var filters = App.Filters.getAll($('#filterLogsContent'));

       App.Ajax.call(
       {
           target: '/admin/audit/ajax_render_log_filter_info',

           arguments: {
               filters: filters,
               save_filters: self.save_filters
           },

           start: function()
           {
               $('#filterLogsApply').addClass('button-busy');
           },

           stop: function()
           {
               $('#filterLogsApply').removeClass('button-busy');
           },

           success: function(html)
           {
               self._sync(filters, html);
               self._changed();
               o.bubble.hide();
           },

           error: function(data)
           {
               App.Ajax.handleError(data);
           }
       });
   }

   self._sync = function(filters, info)
   {
       $('#filterByInfo').hide();
       $('#filterByEmpty').hide();
       $('#filterByChange').removeClass('link link-dashed nolink');

       info = $.trim(info);
       if (info)
       {
           $('#filterByChange').addClass('nolink');
           $('#filterByInfo').html(info);
           $('#filterByInfo').show();
           $('#filterByReset').show();
           self.filters = filters; // Save for later
       }
       else
       {
           $('#filterByReset').hide();
           $('#filterByChange').addClass('link link-dashed');
           $('#filterByEmpty').show();
           self.filters = null; // Reset filter
       }
   }

   self._changed = function()
   {
       self.changed(self.filters);
   }

   self._cancel = function(o)
   {
       o.bubble.hide();
   }

   self.reset = function()
   {
       App.Ajax.call(
       {
           target: '/admin/audit/ajax_render_log_filter_info',

           arguments: {
               filters: null,
               save_filters: self.save_filters
           },

           start: function()
           {
               $('#filterByChange').hide();
               $('#filterBy .busy').show();
           },

           stop: function()
           {
               $('#filterBy .busy').hide();
               $('#filterByChange').show();
           },

           success: function(html)
           {
               self._sync(null, '');
               self._changed();
           },

           error: function(data)
           {
               App.Ajax.handleError(data);
           }
       });
   }
}

//---------------------------------------------------------------
// AUDIT LOG
//---------------------------------------------------------------

App.SiteSettings.loadAuditLogs = function(filters, offset)
{
  $('#auditlogsPaginationBusy').show();
    App.Ajax.call(
        {
            target: '/admin/audit/ajax_render_auditlogs',
            arguments: {
                filters: filters || [],
                offset: offset || 0,
            },
            blockUI: false,

            success: function (data) {
                $('#auditlogs').html(data.auditlogs);
                $('#auditlogsPagination').html(data.pagination);
                $('#auditlogsPaginationBusy, #auditProgress').hide();
            },

            error: function (data) {
                $('#auditlogsPaginationBusy, #auditProgress').hide();
                App.Ajax.handleError(data);
            }
        });
}
App.SiteSettings.renderLogsOnFilterUpdate = function() {
    $("#auditlogsPaginationBusy").show();
    App.Ajax.call({
        target: '/admin/audit/ajax_render_log_on_filter_update',
        arguments: {
            offset: 0,
        },
        blockUI: false,

        success: function(data) {
            $("#auditlogs").html(data.auditlogs);
            $("#auditlogsPagination").html(data.pagination);
            $("#auditlogsPaginationBusy, #auditProgress").hide()
        },
        error: function(data) {
            $("#auditlogsPaginationBusy, #auditProgress").hide();
            App.Ajax.handleError(data)
        }
    })
    App.Ajax.call({
        target: "/admin/audit/ajax_render_filterinfo_on_filter_update",
        arguments: {
            save_filters: true,
        },
        start: function() {
            $("#filterLogsApply").addClass("button-busy")
        },
        stop: function() {
            $("#filterLogsApply").removeClass("button-busy")
        },
        success: function(info) {
            info = $.trim(info);
            $("#filterByInfo").hide();
            $("#filterByEmpty").hide();
            $("#filterByChange").removeClass("link link-dashed nolink");
            if(info){
               $("#filterByChange").addClass("nolink");
               $("#filterByInfo").html(info);
               $("#filterByInfo").show();
               $("#filterByReset").show();
            }
            else {
               $("#filterByReset").hide();
               $("#filterByChange").addClass("link link-dashed");
               $("#filterByEmpty").show();
            }
        },
        error: function(info) {
            App.Ajax.handleError(info);
        }

    })
}
App.SiteSettings.viewTemplates = function() {
    App.Ajax.call({
        target: '/admin/notification/ajax_get_template_view',
        arguments: {
            template: $('#email_template').val(),
        },
        blockUI: false,
        success: function(data) {
            $('#notifications').html(data);
        },
        error: function(data) {
            App.Ajax.handleError(data)
        }
    });
}

App.SiteSettings.editTemplates = function() {
    App.Ajax.call({
        target: '/admin/notification/ajax_get_template_edit',
        arguments: {
            template: $('#email_template').val(),
        },
        blockUI: false,
        success: function(data) {
            $('#notifications').html(data);
        },
        error: function(data) {
            App.Ajax.handleError(data)
        }
    });
}

App.SiteSettings.sendEmails = function() {
    App.Dialogs.open(
        {
            selector: '#send_email_sample',
        });
}

App.SiteSettings.sendSampleEmail = function() {
    App.Ajax.call({
        target: '/admin/notification/ajax_send_sample_mail',
        arguments: {
            emails: $('#emails').val(),
            subject: $('#email_template_subject_display').html(),
            body: $('#email_template_body_display').html()
        },
        blockUI: true,
        start: function() {
            $('#send-sample-email').addClass('button-busy');
        },
        stop: function() {
            $('#send-sample-email').removeClass('button-busy');
        },
        success: function(data) {
            $('#emails').val('');
            App.Dialogs.closeTop();
            App.Dialogs.open(
                {
                    selector: '#sampleEmailConfirm',
                });
        },
        error: function(data) {
            App.Ajax.handleError(data)
        }
    });
}

App.SiteSettings.setEmailTemplateDefault = function() {
    App.Ajax.call({
        target: '/admin/notification/ajax_reset_email_template',
        arguments: {
            template : $('#template_restore').val(),
        },
        blockUI: true,
        success: function() {
            App.Dialogs.closeTop();
            App.Dialogs.open({
                selector: '#resetConfirm',
            });
            $('#notifications').html('');
        },
        error: function(data) {
            App.Ajax.handleError(data)
        }
    });
}

App.SiteSettings.resetTemplatePrompt = function() {
    App.Ajax.call({
        target: '/admin/notification/ajax_reset_template_dialog',
        arguments: {
            template: $('#template_edit').val(),
        },
        blockUI: false,
        success: function (data) {
            $('#notifications').html(data);
            App.Dialogs.open({
                selector: '#resetPrompt',
            });
        },
        error: function (data) {
            App.Ajax.handleError(data)
        }
    });
}

App.SiteSettings.closeTemplateView = function() {
    $('#notifications').html('');
}

;

