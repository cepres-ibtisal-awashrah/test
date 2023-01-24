/*******************************************************************/
/* Test Runs  */

/* [Permissions checked!] */

App.Runs = new function () {
    var self = this;

    // Fields for keeping the current state (grouping options, etc)
    self.project_id = null;
    self.run_id = null;
    self.suite_id = null;
    self.group_id = null;
    self.display = null;
    self.format = null;
	self.filters = null;
	self.scroll_offset = 0;
	self.user_ids = null;
	self.case_ids = null;
	self.columns_for_qpane = null;
	self.paginating = false;
	self.backwards = false; // If we navigate rows backwards
	self.prev_id = null;    // For pass-and-next, to prevent duplicates
	self.can_pass = false;  // For pass-and-next, check if skip dialog
	self.goto_next = false; // For add-result, goto next test or not
	self.initialized = false;
	self.attachmentsCode = {};
	self.statusText = 'Status';

    self.applyActions = function () {
        self._applyLinkBind();
        self._applyTreeHeight();
    }

    self._applyLinkBind = function () {
        if (self.display != 'tree') { // Only needed in tree mode
            return;
        }

        // This event is triggered for links with the keep-get option
        // set (see application.js). We simply set the current state
        // URL before leaving the page.
        $.subscribe(
            'page.set_get',
            'suites',
            function (data) {
                var a = $(data.link);

                // Check if the link was part of a group (e.g. click
                // on a test).
                var group = a.closest('.group');
                if (group.length > 0) {
                    self.group_id = group.attr('rel');
                    self._setStateUrl();
                }
            }
        );
    }

    self.applyResponsive = function () {
        App.Responsive.registerMany(
            '#content',
            {
                600: self._applyResponsiveContentStage3,
                750: self._applyResponsiveContentStage2,
                900: self._applyResponsiveContentStage1
            }
        );

        App.Responsive.registerMany(
            '#qpane',
            {
                600: self._applyResponsiveQPaneStage2,
                750: self._applyResponsiveQPaneStage1
            }
        );
    }

    self._applyResponsiveContentStage1 = function (is_below) {
        // This stage operates on the content area and resizes the
        // status chart to medium size if we deal more than 4 statuses
        // (and hence two legend columns).

        var chart = $('#statsContainer .chart-pie');
        if (chart.attr('rel') <= 4) {
            return;
        }

        if (chart.hasClass('chart-pie-tiny')) { // Already tiny?
            return;
        }

        if (is_below) {

			chart.addClass('chart-pie-compact');
		}
		else
		{
			chart.removeClass('chart-pie-compact');
        }
    }

    self._applyResponsiveContentStage2 = function (is_below) {
        // This stage operates on the content and 1) hides the button
        // texts (e.g. toolbar) and 2) resizes the status chart to the
        // smallest possible size.

        var buttons = $('#contentToolbar, #content-header').find(
            '.button-responsive'
        );

        if (is_below) {
            buttons.addClass('button-notext');
        } else {
            buttons.removeClass('button-notext');
        }

        // Depending on the status counts (and the resulting number of
        // legend columns), we either switch to compact mode (< 4) or
        // tiny mode (> 4 statuses).

        var chart = $('#statsContainer .chart-pie');
        var status_count = parseInt(chart.attr('rel'));

        if (is_below) {
            chart.addClass('chart-pie-compact');
            if (status_count > 4) {
                chart.addClass('chart-pie-tiny');
                $("#tablechart_testun").removeClass('table-extended');
                $("#tablechart_testun").addClass('table');
                $("#statusChart").addClass('chart-pie-status-small');
                $("#chart_legd_comp").addClass('chart_leg_compact_padding');
                $("#chart_legd_large").addClass('chart-legend-compact-padd-custom-sm');
                $("#legend-compactgraph").addClass('chart-pie-column-legend-compact-normalstatus-small');
                $("#legend-largegraph").addClass('chart-pie-column-legend-compact-customstatus-small');
            }
        } else {
            chart.removeClass('chart-pie-tiny');
            $("#tablechart_testun").addClass('table-extended');
            $("#tablechart_testun").removeClass('table');
            $("#statusChart").removeClass('chart-pie-status-small');
            $("#chart_legd_comp").removeClass('chart_leg_compact_padding');
            $("#chart_legd_large").removeClass('chart-legend-compact-padd-custom-sm');
            $("#legend-compactgraph").removeClass('chart-pie-column-legend-compact-normalstatus-small');
            $("#legend-largegraph").removeClass('chart-pie-column-legend-compact-customstatus-small');
            if (status_count <= 4) {
                chart.removeClass('chart-pie-compact');
            }
        }
    }

    self._applyResponsiveContentStage3 = function (is_below) {
        // This stage operates on the content and switches some elements
        // to XS state (e.g. statuses in grids).

        if (is_below) {
            $('#content .hidden-xs').hide();
            $('#content col.status').addClass('status-xs');
            $('#content .visible-xs').show();
        } else {
            $('#content .visible-xs').hide();
            $('#content col.status').removeClass('status-xs');
            $('#content .hidden-xs').show();
        }
    }

    self._applyResponsiveQPaneStage1 = function (is_below) {
        // This stage operates on the QPane. We first switch steps to
        // vertical if any.

        var steps = $('#qpane table.steps');
        if (is_below) {
            steps.addClass('steps-vertical');
        } else {
            steps.removeClass('steps-vertical');
        }

        // The following step reduces the width of the change status/
        // property columns of the change list.

        var changes = $('#changes');
        if (is_below) {
            $('.change-column-properties', changes).addClass(
                'change-column-properties-compact'
            );
        } else {
            $('.change-column-properties', changes).removeClass(
                'change-column-properties-compact'
            );
        }

        // The last step hides the legends of the line charts on the
        // History/Defects tab and some (optional) table parts on this
        // tabs (e.g. plan/milestones/defect title, if any). We hide
        // table columns via our hidden class which sets the width to
        // 0. This only works with tables without th. Hiding columns
        // via display: none does not work cross-browser.

        var charts = $('#qpane .chart-line, #qpane .defect-chart-line');
		if (charts.length) {
      if (is_below) {
        charts.addClass('chart-line-compact');
      } else {
        charts.removeClass('chart-line-compact');
      }
    }

                if (is_below) {
            $('#qpane .hidden-sm').addClass('hidden');
        } else {
            $('#qpane .hidden-sm').removeClass('hidden');
        }
    }

    self._applyResponsiveQPaneStage2 = function (is_below) {
        // This stage operates on the QPane. We hide/show the remaining
        // XS elements that can be hidden. We hide table columns via
        // our hidden class which sets the width to 0. This only works
        // with table without th. Hiding columns via display: none does
        // not work cross-browser.

        if (is_below) {
            $('#qpane .hidden-xs').addClass('hidden');
        } else {
            $('#qpane .hidden-xs').removeClass('hidden');
        }
    }

    //---------------------------------------------------------------
    // OVERVIEW
    //---------------------------------------------------------------
    self.loadActive = function (project_id, e, offset, paginationCookieKey) {
        var busy = $('.busy', $(e).prev('label'));
        busy.show();

        indicator('#active #groupPagination');

        App.Ajax.call(
            {
                target: '/runs/ajax_render_active',

                arguments:
                {
                    project_id: project_id,
                    group_by: $('#groupbySelection').val(),
                    order_by: $('#orderbySelection').val(),
                    offset: offset,
                    "pagination_cookie_key": paginationCookieKey || undefined
                },

                success: function (html) {
                    $('#active').html(html);
                    busy.hide();
                },

                error: function (data) {
                    busy.hide();
                    App.Ajax.handleError(data);
                }
            }
        );
    }

    self.loadCompletionPending = function (project_id, e, offset, paginationCookieKey) {
        var busy = $('.busy', $(e).prev('label'));
        busy.show();

        indicator('#completion_pending #groupPagination');

        App.Ajax.call(
            {
                target: '/runs/ajax_render_completion_pending',

                arguments:
                    {
                        project_id: project_id,
                        group_by: $('#groupbySelection').val(),
                        order_by: $('#orderbySelection').val(),
                        offset: offset,
                        "pagination_cookie_key": paginationCookieKey || undefined
                },

                success: function (html) {
                    $('#completion_pending').html(html);
                    $('#delete-run').hide();
				$('input[name="select_all"]').prop('checked', false);
				busy.hide();
			},

                error: function (data) {
                    busy.hide();
                    App.Ajax.handleError(data);
                }
            }
        );
    }

    self.loadCompleted = function (project_id, offset, paginationCookieKey) {
        $('#completedPaginationBusy').show();

        indicator('#completed #groupPagination');

        App.Ajax.call(
            {
                target: '/runs/ajax_render_completed',

                arguments:
                {
                    project_id: project_id,
                    offset: offset,
                    "pagination_cookie_key": paginationCookieKey || undefined
                },

                success: function (data) {
                    $('#completed').html(data.runs);
                    $('#completedPagination').html(data.pagination);
                    $('#completedPaginationBusy').hide();
                },

                error: function (data) {
                    $('#completedPaginationBusy').hide();
                    App.Ajax.handleError(data);
                }
            }
        );
    }

    //---------------------------------------------------------------
    // ACTIVITIES
    //---------------------------------------------------------------

    self.loadActivities = function (run_id, offset) {
        $('#activitiesPaginationBusy').show();

        App.Ajax.call(
            {
                target: '/runs/ajax_render_activities',

                arguments: {
                    run_id: run_id,
                    offset: offset
                },

                success: function (data) {
                    $('#activities').html(data.activities);
                    $('#activitiesPagination').html(data.pagination);
                    $('#activitiesPaginationBusy').hide();
                },

                error: function (data) {
                    $('#activitiesPaginationBusy').hide();
                    App.Ajax.handleError(data);
                }
            }
        );
    }

    self.selectActivityDays = function (run_id) {
        App.Charts.selectTimeframe(
            {
                success: function (days) {
                    self._reloadActivityChart(run_id, days);
                }
            }
        );
    }

    self._reloadActivityChart = function (run_id, days) {
        App.Ajax.call(
            {
                target: '/runs/ajax_render_activity_chart',

                arguments: {
                    run_id: run_id,
                    days: days
                },

                success: function (html) {
                    App.Dialogs.closeTop();
                    App.Charts.reload(
                        App.Charts.activity,
                        '#activityContainer',
                        html
                    );
                },

                error: function (data) {
                    App.Ajax.handleError(data);
                }
            }
        );
    }

    //---------------------------------------------------------------
    // RERUN
    //---------------------------------------------------------------

    self.rerun = function (run_id, return_location) {
        self.rerunDialog(
            {
                submit: function (status_ids, fetch_assignedto) {
                    App.Page.load(
                        '/runs/rerun/{0}/{1}&status_ids={2}&fetch_assignedto={3}&{4}',
                        run_id,
                        return_location ? return_location : '',
                        status_ids.join(','),
					fetch_assignedto ? 1 : 0,
                        self._getStateOptions()
                    );
                }
            }
        );
    }

    self.rerunDialog = function (o) {
        $('#rerunForm input.selectionCheckbox').prop('checked', true);

        $('#rerunForm').unbind('submit');
        $('#rerunForm').submit(function (e) {
            var status_ids = App.Controls.Checkboxes.getValues(
                'rerunStatuses'
            );
            o.submit(status_ids, $('#fetch_assignedto').is(':checked'));
            return false;
        });

        App.Dialogs.open(
            {
                selector: '#rerunDialog'
            }
        );
    }

    //---------------------------------------------------------------
    // FORM
    //---------------------------------------------------------------

    self.chooseSuite = function (return_location) {
        $('#chooseSuiteForm').unbind('submit');
        $('#chooseSuiteForm').submit(function (e) {
            var value = $('#choose_suite_id').val();
            if (return_location) {
                App.Page.load(
                    '/runs/add/{0}/{1}',
                    value,
                    return_location
                );
            } else {
                App.Page.load('/runs/add/{0}', value);
            }

            return false;
        });

        App.Dialogs.open(
            {
                selector: '#chooseSuiteDialog',
                focusedControl: '#choose_suite_id'
            }
        );
    }

    self.reuseDescription = function (description) {
        $('#description').val(description);
    }

    self.selectCases = function (suite_id) {
        var select = new App.Suites.Select(
            {
                project_id: self.project_id,
                suite_id: suite_id,
                case_ids: self.case_ids,
                columns_custom: false,
                column_area_id: 3, // Area ID for the run form
                filters: self.filters
            }
        );

        // Bind the form submit event to render the info string and
        // save the test cases/filters afterwards.
        $('#selectCasesSubmit').unbind('click');
        $('#selectCasesSubmit').bind(
            'click',
            function () {
                var case_ids = select.getSelection().case_ids;

                self._selectCasesSubmit(
                    {
                        suite_id: suite_id,
                        case_ids: case_ids,

                        success: function (info) {
                            select.close();
                            self.filters = select.filters;
                            self._selectCases(case_ids, info);
                        }
                    }
                );

                return false;
            }
        );

        select.open();
    }

    self._selectCasesSubmit = function (o) {
        $('#selectCasesSubmit').addClass('button-busy');

        App.Ajax.call(
            {
                target: '/runs/ajax_render_cases_info',
                arguments: {
                    suite_id: o.suite_id,
                    case_ids: o.case_ids
                },

                stop: function () {
                    $('#selectCasesSubmit').removeClass('button-busy');
                },

                success: function (html) {
                    o.success(html);
                    $('#case_ids').trigger("input");
                },

                error: function (data) {
                    App.Ajax.handleError(data);
                }
            }
        );
    }

    self._selectCases = function (case_ids, info) {
        $('#includeSpecificInfo').html(info);
        $('#include_all').val('0');
        $('#case_ids').val(case_ids.join(','));
        self.case_ids = case_ids;
    }

    self.selectCasesAll = function () {
        $('#include_all').val('1');
    }

    //---------------------------------------------------------------
    // ASSIGN TO
    //---------------------------------------------------------------

    // Opens the Users dialog and then assigns all tests to the selected
    // user.
    self.assignAllTo = function () {
        $('#selectUser').val('').trigger('liszt:updated');
        App.Users.selectDialog(
            {
                submit: function (user) {
                    self._assignTo(user.id, false);
                }
            }
        );
    }

    // Opens the Users dialog and then assigns all tests of the current
    // view (section/group) to the selected user.
    self.assignViewTo = function () {
        App.Users.selectDialog(
            {
                submit: function (user) {
                    self._assignTo(user.id, true);
                }
            }
        );
    }

    self._assignTo = function (user_id, group_only) {
        $('#selectUserSubmit').addClass('button-busy');

        App.Ajax.call(
            {
                target: '/runs/ajax_assign',

                arguments: {
                    run_id: self.run_id,
                    user_id: user_id,
                    display: self.display,
                    group_only: group_only,
                    group_by: App.Tables.group_by,
                    group_id: self.group_id,
                    filters: self.filters,
                    qpane_id: App.QPane.isVisible() ?
                    App.QPane.getCurrentRowID() : null
                },

                stop: function () {
                    $('#selectUserSubmit').removeClass('button-busy');
                },

                success: function (data) {
                    App.Dialogs.closeTop();
                    self._reloadTests();

                    if (data.qpane) {
                        App.QPane.update(data.qpane);
                    }
                },

                error: function (data) {
                    App.Ajax.handleError(data);
                }
            }
        );
    }

    //---------------------------------------------------------------
    // SUBSCRIPTIONS
    //---------------------------------------------------------------

    self.subscribe = function (run_id) {
        $('#unsubscribed .subscribe').hide();
        $('#unsubscribed .busy').show();

        App.Ajax.call(
            {
                target: '/runs/ajax_subscribe',

                arguments: {
                    run_id: run_id
                },

                success: function (data) {
                    App.Effects.replace('#unsubscribed', '#subscribed');
                    $('#unsubscribed .subscribe').show(); // Restore link
                    $('#unsubscribed .busy').hide();
                },

                error: function (data) {
                    $('#unsubscribed .subscribe').show(); // Restore link
                    $('#unsubscribed .busy').hide();
                    App.Ajax.handleError(data);
                }
            }
        );
    }

    self.unsubscribe = function (run_id) {
        $('#subscribed .unsubscribe').hide();
        $('#subscribed .busy').show();

        App.Ajax.call(
            {
                target: '/runs/ajax_unsubscribe',

                arguments: {
                    run_id: run_id
                },

                success: function (data) {
                    App.Effects.replace('#subscribed', '#unsubscribed');
                    $('#subscribed .unsubscribe').show(); // Restore link
                    $('#subscribed .busy').hide();
                },

                error: function (data) {
                    $('#subscribed .unsubscribe').show();
                    $('#subscribed .busy').hide();
                    App.Ajax.handleError(data);
                }
            }
        );
    }

    //---------------------------------------------------------------
    // QPANE & ROWS
    //---------------------------------------------------------------

    self.applyQPane = function (is_active) {
        App.QPane.init('tests', is_active); // Context for user preferences

        App.QPane.bindRowEvents(
            {
                hide: self._hideQPane,
                show: self._showQPane,
                change: self._changeQPane
            }
        );

        if (is_active) {
            App.QPane.show();
        }
    }

    self._hideQPane = function () {
        self.columns_for_qpane = App.Tables.popColumns();
        self._updateForQPane(self.columns_for_qpane);
    }

    self._updateForQPane = function (columns) {
        if (App.Tables.matchesColumns(columns)) {
            return; // Nothing to do
        }

        // Increase page min width if regular column layout is in fact
        // larger (and vice versa).
        var delta = App.Tables.getColumnWidthDelta(columns)
        if (delta) {
            App.Page.updateMinWidth(delta);
        }

        // Ensure that the same group is loaded again in subtree/group
        // mode. Avoid any reloads before the full run is initialized
        // and set up and the tests are first loaded by showInitial.
        if (self.initialized) {
            self._reloadTests(
                self.display != 'tree' ? self.group_id : null
            );
        }
    }

    self._showQPane = function () {
        var columns = App.Tables.columns_for_user;
        App.Tables.pushColumns(self.columns_for_qpane);
        self._updateForQPane(columns);
    }

    self._changeQPane = function (test_id, done) {
        App.Ajax.call(
            {
                target: '/tests/ajax_render_qpane',
                reflow: true, // For responsive qpane

                arguments: {
                    test_id: test_id
                },

                success: function (html) {
                    done(html);
                    $('.chart-legend-name, .chart-legend-description').addClass('text-ppp');
                    self.prev_id = null; // Reset pass-and-next
                    $('.searchable').each(function (ix, v) {
                        var dropdown = $(v);
                        // Apply the chosen control
                        dropdown.chosen();
                    });
                $.each($('.editor-bindable'), function(_idx, el) {
					App.Editor.bind($(el).data('attribute'));
				});
				$.each($('.editor-bindable'), function(_idx, el) {
					App.Editor.bind($(el).data('attribute'));
				});
				$.each($('.editor-bindable'), function(_idx, el) {
					App.Editor.bind($(el).data('attribute'));
				});

                var qpanevisible = $("#qpane").is(":visible");
                if (qpanevisible) {
                    $("#tablechart_testun").removeClass('table-extended');
                    $("#tablechart_testun").addClass('table');
                } else {
                    $("#tablechart_testun").removeClass('table');
                    $("#tablechart_testun").addClass('table-extended');
                }
			},

                error: function (data) {
                    App.Ajax.handleError(data);
                }
            }
        );
    }

    self._checkQPane = function () {
        // Make sure to check the qpane state (e.g. after the cases were
        // reloaded). This might hide the qpane if the current case is
        // not shown on the page. This might also load the first or last
        // row if the previous row is no longer visible. We ask to use
        // the last row if we are going backwards (see prevRow).

        var backwards = self.backwards;

        if (!self.paginating && backwards) {
            var page = $('#groupPagination .pagination-current ~ a:last');
            if (page.length) {
                page.click();
                return;
            }
        }

        self.backwards = false; // Always reset for next call
        var ctx = self.group_id ? $('#group-' + self.group_id) :
            $(document);
        App.QPane.checkRow(ctx, backwards);
    }

    self.nextRow = function (force) {
        // In subtree/group mode, we may also need to go to the next
        // group in the list, if any (if the last row is the current
        // one). We only load the next group if there's currently no
        // active JS request, because this action here can be triggered
        // via a hotkey. The row navigation for the qpane itself has a
        // smart timing/ratelimit algo to prevent too many requests and
        // the group loading needs to be handled as well (here). The
        // user needs to wait for the current load operation to finish
        // before we load the next group.

        if (self.display == 'tree') {
            App.QPane.nextRow();
        } else {
            var last = $('tr.row:last');
            if (last.attr('rel') == App.QPane.getCurrentRowID()) {
                if (!App.Ajax.isBusy() || force) {
                    self._nextRowLoadGroup();
                }
            } else {
                App.QPane.nextRow();
            }
        }
    }

    self._nextRowLoadGroup = function () {
        // If we deal with a paginated group, we try to the load the
        // next page of this group first. If there isn't one, we go to
        // the next group in the tree.

        var page = $('#groupPagination .pagination-current').next('a');
        if (page.length) {
            page.click();
        } else {
            self._nextGroup();
        }
    }

    self.prevRow = function () {
        // In subtree/group mode, we may also need to go to the previous
        // group in the list, if any (if the last row is the current
        // one). Also see the comment above for the request handling.

        if (self.display == 'tree') {
            App.QPane.prevRow();
        } else {
            var first = $('tr.row:first');
            if (first.attr('rel') == App.QPane.getCurrentRowID()) {
                if (!App.Ajax.isBusy()) {
                    self.backwards = true; // See checkQPane
                    self._prevRowLoadGroup();
                }
            } else {
                App.QPane.prevRow();
            }
        }
    }

    self._prevRowLoadGroup = function () {
        // If we deal with a paginated group, we try to the load the
        // previous page of this group first. If there isn't one, we go
        // to the previous group in the tree.

        var page = $('#groupPagination .pagination-current').prev('a');
        if (page.length) {
            page.click();
        } else {
            self._prevGroup();
        }
    }

    self.passRowAndNext = function (test_id) {
        if (!test_id) {
            return;
        }

        if (self.can_pass) {
            if (self.prev_id == test_id) {
                return;
            }
        }

        // Prevent duplicate calls to this function until the row has
        // changed.
        self.prev_id = test_id;

        App.Tests.addResultAndNext(
            self.project_id,
            test_id,
            Consts.statusPassed,
            self.can_pass
        );
    }

    //---------------------------------------------------------------
    // TREE
    //---------------------------------------------------------------

    self.applyTree = function (selected_group_id) {
        if (selected_group_id !== undefined) {
            var initially_select = ['#node-' + selected_group_id];
        } else {
            var initially_select = [];
        }

        $('#groupTree').jstree({
            core: {
                animation: 0
            },
            ui: {
                select_limit: 1,
                selected_parent_close: false,
                select_prev_on_delete: false,
                initially_select: initially_select
            },
            'plugins': ['themes', 'ui', 'html_data']
        }).
        bind('select_node.jstree', function (e, data) {
            self.selectGroup(self._getTreeNodeID(data));
        }).
        bind('open_node.jstree', function (e, data) {
            var node_id = self._getTreeNodeID(data);
            self._setExpandStateForGroup(node_id, true);
        }).
        bind('close_node.jstree', function (e, data) {
            var node_id = self._getTreeNodeID(data);
            self._setExpandStateForGroup(node_id, false);
        });
    }

    self._getTreeNodeID = function (data) {
        var args = data.args;
        var node = data.inst._get_node(args[0]);
        return node.attr('rel');
    }

    self._setExpandStateForGroup = function (group_id, expanded) {
        App.Storage.setObjectItem(
            'runs.groups.expands',
            self.run_id,
            group_id,
            expanded ? 1 : 0
        );
    }

    self._getExpandState = function () {
        return App.Storage.getObject(
            'runs.groups.expands',
            self.run_id
        );
    }

    self._applyTreeHeight = function () {
        var w = $(window);
        w.scroll(self._setTreeHeight);
        w.resize(self._setTreeHeight);
        $.subscribe('body.changed', 'runs', self._setTreeHeight);
    }

    self._setTreeHeight = function () {
        var groups = $('#groupTreeContent');
        if (groups.length == 0) {
            return;
        }

        var sticky = $('#sidebarSticky');
        var height;

        if (sticky.hasClass('sidebar-sticky')) {
            height = $(window).height() - 30 -
                $('#sidebarToolbar').outerHeight();
        } else {
            var top = groups.offset().top;

            // If we are dealing with a non-sticky sidebar, we need to
            // make sure that the height of the tree doesn't exceed
            // the sidebar height (minus the diff between the tree and
            // sidebar offsets). The desired height of the tree is the
            // maximum window size minus the visible offset of the
            // tree (original offset - scroll position, if any).

            if (self.page_type !=='plot') {
				var sidebar = $('#sidebar');
				height = Math.min(
					$(window).height() - (top - $(document).scrollTop()),
					sidebar.height() - (top - sidebar.offset().top)
				);
				$('body').css('overflow', 'auto');
			}
		}

        // Make sure to take goals banner into account as well, if any.
        height -= $('#goals-banner').height();

        groups.height(height - 15);
    }

    self.selectGroup = function (group_id) {
        var node = $('#node-' + group_id);

        if (self.display == 'tree') {
            node.children('a').removeClass('jstree-clicked');

            var group = $('#group-' + group_id);
            if (group.length) {
                group[0].scrollIntoView();
                window.scrollBy(0, -self.scroll_offset); // Adjust for toolbar
            }

            self.group_id = group_id;
            self._setStateUrl();
        } else {
            if (self.group_id != group_id) {
                self.showGroup(self.run_id, group_id);
            }
        }
    }

    //---------------------------------------------------------------
    // EXPORT (CSV/Excel)
    //---------------------------------------------------------------

    self.exportTestsCsv = function (run_id) {
        self._exportTests(run_id, 'csv');
    }

    self.exportTestsExcel = function (run_id) {
        self._exportTests(run_id, 'excel');
    }

    self._exportTests = function (run_id, format) {
        var dialog = new App.ExportCsv(
            {
                format: format,
                init: function () {
                    // Get the sections and fill the section selection of
                    // the dialog (concurrently, while it opens).
                    self._exportLoadSections(run_id);
                }
            }
        );

        dialog.open();
    }

    self._exportLoadSections = function (run_id) {
        $('#exportCsvSectionsSelectedBusy').show();

        App.Ajax.call(
            {
                target: 'runs/ajax_render_section_list',

                arguments:
                {
                    run_id: run_id,
                    show_empty: false
                },

                stop: function () {
                    $('#exportCsvSectionsSelectedBusy').hide();
                },

                success: function (html) {
                    $('#exportCsvSectionsSelection').html(html);
                },

                error: function (data) {
                    App.Ajax.handleError(data);
                }
            }
        );
    }

    //---------------------------------------------------------------
    // CONTENT
    //---------------------------------------------------------------

    self._showTests = function (o) {
        var defaults = {
            run_id: self.run_id,
            display: self.display, // Does not change
            format: $('#formatSelection').val(),
			group_id: self.group_id,
			include_sidebar: false,
			save_columns: false,
			page_type: self.page_type,
			filters: self.filters,
            url_link: self.url_link
		};

        $('#contentLoading').show();
        $('#groupContainer').hide();

        var s = $.extend(defaults, o);
        let run_id =  self.run_id;
        let url_link =  self.url_link;

        App.Ajax.call(
            {
                target: '/runs/ajax_render_tests',
                arguments: self._getGridArguments(s),

                success: function (html) {

                $('#contentLoading').hide();
                $('#groupContainer').show();

				if (s.display == 'tree' || s.include_sidebar)
				{
                    if (run_id && url_link) {
                        $('#groupContainer' + run_id).html(html);
                    } else {
                        self._injectTests(html);
                    }
				} else {
                    $('#groupContainer').html(html);
				}

                    self._onTestsLoaded(s);

                    if (o.success) {
                        o.success();
                    }

                    self._checkQPane();
                },

                error: function (data) {
                    if (o.error) {
                        o.error(data);
                    }

                    App.Ajax.handleError(data);
                }
            }
        );
    }

    self._injectTests = function (html) {
        // The server sends multiple views (grids and sidebar tree).
        // We add them to a hidden div (#ajaxResponse) and then
        // move them to the right position (separately). This a)
        // saves one ajax request for the sidebar and b) guarantees
        // that the sidebar and the grids are in sync.

        $('#groupContent').remove();
        $('#groupTreeContent').remove();
        $('#ajaxResponse').html(html);
        $('#groupTreeContent').appendTo('#groupTreeContainer');
        if (self.url_link) {
            $('#groupContent' + self.run_id).appendTo('#groupContainer');
        } else {
            $('#groupContent').appendTo('#groupContainer');
        }

        // Also make sure to set/update the height of the sidebar tree.
        self._setTreeHeight();
    }

    self._onTestsLoaded = function (o) {
        self.group_id = o.group_id || null;

        var tree_changed = o.display == 'tree' ||
            o.include_sidebar;

        if (tree_changed) {
            // Check if the current group (still) exists
            if (self.group_id !== null) {
                if ($('#node-' + self.group_id).length == 0) {
                    self.group_id = null;
                }
            }

            // If no group is selected or the group no longer exists,
            // we use the first group as current group (in compact
            // mode, there's no need to select the first group when
            // in tree mode).
            if (self.group_id === null) {
                if (self.display != 'tree') {
                    var group = $('#groupTree ul li:first');
                    if (group.length > 0) {
                        self.group_id = group.attr('rel');
                    }
                }
            }

            self.applyTree(self.group_id);
        }

        self._disableMassActions();

        // Should not be required but actually is by IE9, for example
        // (in some rare cases). May be needed to reposition the sticky
        // elements.
        $(window).trigger('scroll');

        // Fire the relevant events for external modules (e.g. sidebar,
        // or defect lookup)
        $.publish({
            'body.changed': null,
            'tests.loaded': {
                project_id: self.project_id
            }
        });

        self._syncToolbar();
        self._setStateUrl();
    }

    self._syncToolbar = function () {
        // Reset the global order-by link and update the order-by name,
        // if necessary.
        $('#orderBy .busy').hide();
        $('#orderByChange').removeClass('link link-dashed nolink');

        $('#orderByName').show();

        if (App.Tables.group_by == 'cases:section_id') {
            $('#orderByAsc').hide();
            $('#orderByDesc').hide();
            $('#orderByReset').hide();
            $('#orderByName').hide();
            $('#orderByChange').addClass('link link-dashed');
            $('#orderByEmpty').show();
        } else {
            if (App.Tables.group_order == 'desc') {
                $('#orderByAsc').hide();
                $('#orderByDesc').show();
            } else {
                $('#orderByDesc').hide();
                $('#orderByAsc').show();
            }

            $('#orderByChange').addClass('nolink');
            if (App.Tables.group_by == 'tests:status_id') {
                // The status column is not part of the regular column
                // definition and is handled special here.
                $('#orderByName').text(self.statusText);
            } else {
                $('#orderByName').text(
                    App.Tables.getColumnName(App.Tables.group_by)
                );
            }

            $('#orderByEmpty').hide();
            $('#orderByName').show();
            $('#orderByReset').show();
        }

        $('#orderByChange').show();
    }

    self._getGridArguments = function (o) {
        // Besides the given arguments, we also include the column
        // definition for the grids, the grouping options and the
        // property filters.
        return $.extend({
            columns: App.Tables.columns_for_user,
            group_by: App.Tables.group_by,
            group_order: App.Tables.group_order,
            filters: self.filters,
            user_ids: self.user_ids ?
                    self.user_ids.join(',') :
                    null
            }, o);
    }

    self.showGroup = function (run_id, group_id, offset) {
        var node = $('#node-' + group_id);
        var a = node.children('a');

        self.paginating = offset !== undefined;
        if (self.paginating) {
            $('#paginationBusy').show();
        } else {
            a.addClass('jstree-loading');
        }

        self._showTests(
            {
                run_id: run_id,
                group_id: group_id,
                offset: offset,

                success: function () {
                    $('#paginationBusy').hide();
                    a.removeClass('jstree-loading');
                },

                error: function (data) {
                    $('#paginationBusy').hide();
                    a.removeClass('jstree-loading');
                }
            }
        );
    }

    self._nextGroup = function () {
        var next = App.Sections.next(self.group_id, self.display);
        if (next) {
            App.QPane.clearRow();
            $('#groupTree').jstree('select_node', next, true);
        }
    }

    self._prevGroup = function () {
        var prev = App.Sections.prev(self.group_id);
        if (prev) {
            App.QPane.clearRow();
            $('#groupTree').jstree('select_node', prev, true);
        }
    }

    self._disableMassActions = function () {
        $('#massAssignSelected').hide();
        $('#massAssignSelectedDisabled').show();
        $('#massAddResult').hide();
        $('#massAddResultDisabled').show();
    }

    self.showInitial = function () {
        var toolbar = $('#contentToolbar');

        if (!toolbar.length) {
            return;
        }

        // Calculate the height of the visible area for the test cases.
        var height = $(window).height() - toolbar.offset().top;

        // Calculate and set a suitable top padding for the loading
        // spinner
        var top = Math.max(Math.round(height / 2 - 125), 50);
        $('#contentLoading').css('padding-top', top);
        $('#contentLoading').show();

        self._showTests(
            {
                include_sidebar: true,
                group_expands: self._getExpandState(),

                success: function (data) {
                    $('#contentLoading').hide();
                    if (self.display != 'tree' && self.group_id) {
                        self._openParents(self.group_id);
                    }
                }
            }
        );
    }

    self._openParents = function (group_id) {
        var node = $('#node-' + group_id);

        // Iterate the parents of the given node/group and expand the
        // respective sub-tree (until we reach root).
        var parent = node.parent('ul').parent('li');
        while (parent.length > 0) {
            parent.addClass('jstree-open');
            $('#groupTree').jstree('open_node', parent);
            parent = parent.parent('ul').parent('li');
        }
    }

    self._reloadTests = function (group_id) {
        self.group_id = group_id || null; // Reset the group, if none
        $('#groupContent').remove();
        $('#groupTreeContent').remove();
        self.showInitial();
    }

	self._setStateUrl = function()
	{
		var currentUrl = self._getStateOptions();
		var replacedUrl = (currentUrl.includes('outline'))
			? currentUrl.replace('outline', $('#formatSelection').val())
			: currentUrl.replace('details', $('#formatSelection').val());

        App.Page.replaceState(
            self.url_link ? self.url_link  : '/runs/' + self.page_type +'/' + self.run_id,
            replacedUrl
        );

		if (self.page_type == 'view') {
			$('#printPopupLink').attr(
				'href',
				'index.php?/' + self.url_link ? self.url_link  : '/runs/' + '/plot/'+ self.run_id +'&format=outline&'+ self._getStateOptions()
			);
		}
	}

    self._getStateOptions = function () {
        // Get the current query string and only override the grouping
        // related options (the remaining options are preserved).

        var options = App.Page.getQueryOptions();
        options['group_by'] = App.Tables.group_by;
        options['group_order'] = App.Tables.group_order;

        if (self.group_id !== null) {
            options['group_id'] = self.group_id;
        } else {
            delete options['group_id'];
        }

        return App.Page.formatQueryOptions(options);
    }

    //---------------------------------------------------------------
    // COLUMNS
    //---------------------------------------------------------------

    self.selectTestColumns = function (group_id, project_id) {
        App.Tables.selectColumns(
            {
                group_id: group_id,
                project_id: project_id,
                area_id: App.QPane.isVisible() ? 7 : 2,

                submit: function (callbacks) {
                    self._showTests(callbacks);
                }
            }
        );
    }

    self.setTestGrouping = function (column, show_progress) {
        App.Tables.setGrouping(column);

        if (show_progress) {
            $('#orderByChange').hide();
            $('#orderBy .busy').show();
        }

        // When we are re-grouping, we use the partial option to make
        // sure that the new content is limited.
        self._showTests(
            {
                group_id: null,
                include_sidebar: true,
                group_expands: self._getExpandState(),
                save_columns: (self.page_type === 'view'), // Store current columns for user

                error: function () {
                    $('#orderBy .busy').hide();
                    $('#orderByChange').show();
                }
            }
        );
    }

    self.setRunsPrintViewChange = function(viewType) {

		self._showTests({
			group_id: null,
			format: viewType,
		});
	}

    //---------------------------------------------------------------
    // FILTERING
    //---------------------------------------------------------------

    self.filterTests = function (e) {
        var bubble = $('#filterByChange').bubble(
            {
                bubble: '#filterTestsBubble',
                toggleEvent: 'null'
            }
        );

        self._filterLoad(
            {
                show: function () {
                    self._filterBind(
                        {
                            bubble: bubble
                        }
                    );

                    bubble.show(e);
                }
            }
        );
    }

    self._filterLoad = function (o) {
        var busy = $('#filterBy .busy');
        var target = '/runs/ajax_render_test_filter';
        App.Ajax.call(
            {
                target: target,

                arguments: {
                    run_id: self.run_id,
                    filters: self.filters
                },

                start: function () {
                    $('#filterByChange').hide();
                    busy.show();
                },

                stop: function () {
                    busy.hide();
                    $('#filterByChange').show();
                },

                success: function (html) {
                    $('#filterTestsContent').html(html);
                    o.show();
                },

                error: function (data) {
                    App.Ajax.handleError(data);
                }
            }
        );
    }

    self._filterBind = function (o) {
        $('#filterTestsApply').click(
            function () {
                self._filterApply(o);
            }
        );

        $('#filterTestsCancel').click(
            function () {
                self._filterCancel(o);
            }
        );
    }

    self._filterApply = function (o) {
        var filters = App.Filters.getAll($('#filterTestsContent'));

        App.Ajax.call(
            {
                target: '/runs/ajax_render_test_filter_info',

                arguments: {
                    run_id: self.run_id,
                    filters: filters,
				save_filters: (self.page_type === 'view')
			},

                start: function () {
                    $('#filterTestsApply').addClass('button-busy');
                },

                stop: function () {
                    $('#filterTestsApply').removeClass('button-busy');
                },

                success: function (html) {
                    self._filterSync(filters, html);
                    self._reloadTests();
                    o.bubble.hide();
                },

                error: function (data) {
                    App.Ajax.handleError(data);
                }
            }
        );
    }

    self._filterSync = function (filters, info) {
        $('#filterByInfo').hide();
        $('#filterByEmpty').hide();
        $('#filterByChange').removeClass('link link-dashed nolink');

        info = $.trim(info);
        if (info) {
            $('#filterByChange').addClass('nolink');
            $('#filterByInfo').html(info);
            $('#filterByInfo').show();
            $('#filterByReset').show();
            $('#filterCasesReset').hide();
            self.filters = filters; // Save for later
        } else {
            $('#filterByReset').hide();
            $('#filterByChange').addClass('link link-dashed');
            $('#filterByEmpty').show();
            self.filters = null; // Reset filter
        }
    }

    self._filterCancel = function (o) {
        o.bubble.hide();
    }

    self.filterReset = function (o) {
        App.Ajax.call(
            {
                target: '/runs/ajax_render_test_filter_info',

                arguments: {
                    run_id: self.run_id,
                    filters: null,
				save_filters:  (self.page_type === 'view')
			},

                start: function () {
                    $('#filterByChange').hide();
                    $('#filterBy .busy').show();
                },

                stop: function () {
                    $('#filterBy .busy').hide();
                    $('#filterByChange').show();
                },

                success: function (html) {
                    self._filterSync(null, '');
                    self._reloadTests();
                },

                error: function (data) {
                    App.Ajax.handleError(data);
                }
            }
        );
    }

    //---------------------------------------------------------------
    // RESULTS
    //---------------------------------------------------------------

    self.updateStats = function (run_id) {
        var hasStats = $('#statusChart').length > 0;

        if (!hasStats) {
            return;
        }

        App.Ajax.call(
            {
                target: '/runs/ajax_render_stats',

                arguments: {
                    run_id: run_id
                },

                success: function (html) {
                    // Replace the HTML of the chart container with the
                    // new chart and legend (this also executes the inline
                    // JS and re-creates the chart object).
                    App.Charts.reload(
                        App.Charts.status,
                        '#statsContainer',
                        html
                    );

                    App.Responsive.invalidate();
                },

                error: function (data) {
                    App.Ajax.handleError(data);
                }
            }
        );
    }

    self.updateGroupStats = function (e) {
        var stats = {};
        var grids = null;

        // If we deal with an event for a single test, we only update
        // the single group.
        if (e.hasOwnProperty('test_id')) {
            grids = $('#row-' + e.test_id).closest('.grid-container');
        } else {
            grids = $('.grid-container');
        }

        // Get the statuses per group and let the server re-render the
        // statistics and tooltips.
        grids.each(
            function () {
                var group_id = $(this).attr('rel');

                var s = [];
                $('.js-status', $('#grid-' + group_id)).each(
                    function () {
                        s.push($(this).attr('rel'));
                    }
                );

                stats[group_id] = s;
            }
        );

        self._updateGroupStats(stats)
    }

    self._updateGroupStats = function (stats) {
        App.Ajax.call(
            {
                target: '/runs/ajax_render_group_stats',
                blockUI: false,

                arguments: {
                    stats: stats
                },

                success: function (html) {
                    $(html).each(function () {
                        var t = $(this);
                        $('#' + t.attr('rel')).empty().append(t);
                    });
                },

                error: function (data) {
                    // Errors here are ignored as this is non-critical
                }
            }
        );
    }

    // We subscribe to the '.changed' event for test changes/results
    // in order to update the stats of the run overview when a test
    // result was added.
    App.ready(function () {
        $.subscribe(
            'tests.changed',
            'runs',
            function (data) {
                self.updateStats(data.run_id);
                self.updateGroupStats(data);
                self._checkQPane();
            }
        );

        $.subscribe(
            'body.drag_started',
            'runs',
            function () {
                var dialog = App.Dialogs.getActive();
                if (dialog) {
                    return; // Only show if no dialog is active
                }

                if (App.QPane.isVisible()) {
                    App.Tests.addCommentNoDialogActivate(
                        App.QPane.getCurrentRowID()
                    );
                }
            }
        );
    });

    //---------------------------------------------------------------
    // DEFECTS
    //---------------------------------------------------------------

    self.loadDefects = function (run_id) {
        $('#showDefects .showAll').hide();
        $('#showDefects .busy').show();

        App.Ajax.call(
            {
                target: '/runs/ajax_render_defects',

                arguments:
                {
                    run_id: run_id
                },

                stop: function () {
                    $('#showDefects .busy').hide();
                },

                success: function (html) {
                    $('#defects').html(html);
                },

                error: function (data) {
                    App.Ajax.handleError(data);
                }
            }
        );
    }

    //---------------------------------------------------------------
    // DYNAMIC FILTERS
    //---------------------------------------------------------------

    self.dynamicFilters = function (suite_id, filters_for_run) {
        if (!filters_for_run) {
            self.filters = null;
            self.case_ids = null;
        }

        var select = new App.Suites.Select({
            project_id: self.project_id,
            suite_id: suite_id,
            case_ids: self.case_ids,
            columns_custom: false,
            column_area_id: 3, // Area ID for the run form
            filters: self.filters
        });

        $('#selectCasesSubmit').unbind('click').bind(
            'click',
            function () {
                var case_ids = select.getSelection().case_ids;

                self.filters = App.Filters.getAll($('#selectCasesFilter'));
                self._selectCasesSubmit(
                    {
                        suite_id: suite_id,
                        case_ids: case_ids,

                        success: function (data) {
                            self._dynamicFilterApply(suite_id, case_ids);
                            select.close();
                            self._selectCases(case_ids, data);
                        }
                    }
                );
                return false;
            }
        );
        select.open();
    }

    self._dynamicFilterApply = function (suite_id, case_ids) {
        case_ids = case_ids || [];
        App.Ajax.call(
            {
                target: '/runs/ajax_dynamic_filters_save',
                arguments: {
                    project_id: self.project_id,
                    suite_id: suite_id,
                    filters: self.filters
                },

                start: function () {
                    $('#selectCasesSubmit').addClass('button-busy');
                },

                stop: function () {
                    $('#selectCasesSubmit').removeClass('button-busy');
                },

                success: function (data) {
                    $('#includeDynamicInfo').html(data.info.replace(new RegExp("<strong>[0-9]+</strong>", "g"), "<strong>" + case_ids.length + "</strong>"));
                    $('#dynamic_filters').val(data.dynamic_filters.toString());
                    $('#case_ids').val(case_ids.join(','));
                    $('#case_ids').trigger('input');
                },

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self.bulkDeleteMessage = function() {
		let ids = [];
		$('input:checked[name="entity_run"]').each(function () {
			ids.push($(this).attr('value'));
		});
		App.Ajax.call({
			target: '/runs/get_confirmation_message',
			arguments:
			{
				ids: ids
			},
			success: function(data) {
				if (data.message && data.confirmation) {
					$('.dialog-message').html(data.message);
					$('.dialog-confirm').html(data.confirmation);
				}
			},
			error: function(data) {
				App.Ajax.handleError(data);
			}
		});

	}
	self.BulkRunDelete = function () {
		self.bulkDeleteMessage();
		App.Dialogs.BulkDeleteDialog();
		App.Bulk.deleteBulk(
			'run',
			$('.dialog-action-default'),
			'/runs/delete_run_by_id'
		);
	}

	self.removeRuns = function(run_id)
	{
		var $row = $('#run-' + run_id);
		$('.deleteLink', $row).hide();
		$('.deleteBusy', $row).show();
		App.Ajax.call(
			{
				target: '/runs/delete_run_by_id',
				blockUI: true,
				arguments:
					{
						ids: [run_id]
					},
				success: function(data)
				{
					$row.remove();
					App.Bulk.redirectSuccess(data.message);
				},
				error: function(data)
				{
					$('.deleteBusy', $row).hide();
					$('.deleteLink', $row).show();
					App.Ajax.handleError(data);
				}
			});
	};
}


;

