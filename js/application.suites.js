/*******************************************************************/
/* Test Suites  */

// TODO: fix issue where scrolling to a group sometimes does not work
//       on page load (tree mode)

App.Suites = new function()
{
	var self = this;

	// Fields for keeping the current state (drag & drop, content,
	// etc.)
	self.project_id = null;
	self.suite_id = null;
	self.allow_dnd = false;
	self.can_dnd = false;
	self.group_id = null;
	self.display = null;
	self.scroll_offset = 0;
	self.filters = null;
	self.filters_for_copy = null;
	self.columns_for_copy = null;
	self.columns_for_qpane = null;
	self.paginating = false;
	self.backwards = false; // If we navigate rows backwards
	self.initialized = false;
	self.attachmentsCode = {};
	self.page_reset = false;

	self.applyActions = function()
	{
		self._applyLinkBind();
		self._applyTreeHeight();
		self._applyDeletedCasesLinkBind();
	}

	self._applyLinkBind = function()
	{
		if (self.display != 'tree') // Only needed in tree mode
		{
			return;
		}

		// This event is triggered for links with the keep-get option
		// set (see application.js). We simply set the current state
		// URL before leaving the page.
		$.subscribe(
			'page.set_get',
			'suites',
			function(data)
			{
				var a = $(data.link);

				// Check if the link was part of a group (e.g. click
				// on a test case). If not, we find out most suitable
				// group to restore by looking at the scroll position
				// and group offsets.
				var group = a.closest('.group');
				if (group.length == 0)
				{
					group = self._findVisibleGroup();
					if (!group)
					{
						return;
					}
					else
					{
						// Don't add the group to the URL if it's the
						// first group.
						if (!group.prev().length &&
							!group.parent().closest('.group').length)
						{
							return;
						}
					}
				}

				self.group_id = group.attr('rel');
				self._setStateUrl();
			}
		);
	}

	self._applyDeletedCasesLinkBind = function()
	{
		$('#displayDeletedTestCases').click(function()
		{
			App.Tables.displayDeletedCases = Math.abs(1 - App.Tables.displayDeletedCases);
			var $link = $(this), removeClass = 'button-toggle-unchecked', addClass = 'button-toggle-checked';
			if (!App.Tables.displayDeletedCases) {
				var temp = removeClass;
				removeClass = addClass;
				addClass = temp;
			}
			$link.removeClass(removeClass).addClass(addClass);
			self._setStateUrl();

			self._reloadCases(
				self.display == 'tree' ? null : self.group_id
			);
			self.refreshSidebarStats();
		});
	}

	self._findVisibleGroup = function()
	{
		var top = $(window).scrollTop();
		var groups = $('div.group');

		var dist_prev = null,
			group_prev = null,
			group_ret = null;

		// Return the most suitable group depending on the scroll
		// position and group offset. The group offset must be larger
		// than the scroll position and the 'previous' check ensures
		// that the group with the smaller distance to the scroll
		// position is returned.

		$.each(groups, function(ix, v)
		{
			var group = $(v);
			var dist = group.offset().top - top;

			if (dist >= 0)
			{
				if (dist_prev !== null)
				{
					if (Math.abs(dist_prev) < Math.abs(dist))
					{
						group_ret = group_prev;
						return false;
					}
				}

				group_ret = group;
				return false;
			}

			dist_prev = dist;
			group_prev = group;
		});

		return group_ret;
	}

	self.applyResponsive = function()
	{
		App.Responsive.register(
			'#content',
			750,
			function(is_below)
			{
				self._applyResponsiveContentStage1(is_below);
			}
		);

		App.Responsive.register(
			'#qpane',
			700,
			function(is_below)
			{
				self._applyResponsiveQPaneStage1(is_below);
			}
		);
	}

	self._applyResponsiveContentStage1 = function(is_below)
	{
		// This stage operates on the content area and hides the button
		// texts (e.g. toolbar).

		var buttons = $('#contentToolbar, #content-header').find(
			'.button-responsive'
		);

		if (is_below)
		{
			buttons.addClass('button-notext');
		}
		else
		{
			buttons.removeClass('button-notext');
		}
	}

	self._applyResponsiveQPaneStage1 = function(is_below)
	{
		// This stage operates on the QPane and switches any steps to
		// vertical.

		var steps = $('#qpane table.steps');
		if (is_below)
		{
			steps.addClass('steps-vertical');
		}
		else
		{
			steps.removeClass('steps-vertical');
		}
	}

	//---------------------------------------------------------------
	// QPANE & ROWS
	//---------------------------------------------------------------

	self.applyQPane = function(is_active)
	{
		App.QPane.init('cases', is_active); // Context for user preferences

		App.QPane.bindRowEvents(
		{
			hide: self._hideQPane,
			show: self._showQPane,
			change: self._changeQPane
		});

		if (is_active)
		{
			App.QPane.show();
		}
	}

	self._hideQPane = function()
	{
		self.columns_for_qpane = App.Tables.popColumns();
		self._updateForQPane(self.columns_for_qpane);
	}

	self._updateForQPane = function(columns)
	{
		if (App.Tables.matchesColumns(columns))
		{
			return; // Nothing to do
		}

		// Increase page min width if regular column layout is in fact
		// larger (and vice versa).
		var delta = App.Tables.getColumnWidthDelta(columns)
		if (delta)
		{
			App.Page.updateMinWidth(delta);
		}

		// Ensure that the same group is loaded again in subtree/group
		// mode. Avoid any reloads before the full suite is initialized
		// and set up and the cases are first loaded by showInitial.
		if (self.initialized)
		{
			self._reloadCases(
				self.display != 'tree' ? self.group_id : null
			);
		}
	}

	self._showQPane = function()
	{
		var columns = App.Tables.columns_for_user;
		App.Tables.pushColumns(self.columns_for_qpane);
		self._updateForQPane(columns);
	}

	self._changeQPane = function(case_id, done)
	{
		App.Ajax.call(
		{
			target: '/cases/ajax_render_qpane',
			reflow: true, // For responsive qpane

			arguments: {
				case_id: case_id
			},

			success: function(html)
			{
				done(html);
				$('.searchable').chosen().trigger('chosen:updated');
				$.each($('.editor-bindable'), function(_idx, el) {
					if ($(el).data('attribute') !== 'editSectionDescription') {
                        App.Editor.bind($(el).data('attribute'));
                    }
				});
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self.deleteCookie = function() {
		App.Ajax.call(
		{
			target: '/suites/ajax_reset_pagination'
		});
	}

	self._checkQPane = function()
	{
		// Make sure to check the qpane state (e.g. after the cases were
		// reloaded). This might hide the qpane if the current case is
		// not shown on the page. This might also load the first or last
		// row if the previous row is no longer visible. We ask to use
		// the last row if we are going backwards (see prevRow).

		var backwards = self.backwards;

		if (!self.paginating && backwards)
		{
			var page = $('#groupPagination .pagination-current ~ a:last');
			if (page.length)
			{
				page.click();
				return;
			}
		}

		self.backwards = false; // Always reset for next call
		var ctx = self.group_id ? $('#section-' + self.group_id) :
			$(document);
		App.QPane.checkRow(ctx, backwards);
	}

	self.nextRow = function()
	{
		// In subtree/group mode, we may also need to go to the next
		// group in the list, if any (if the last row is the current
		// one). We only load the next group if there's currently no
		// active JS request, because this action here can be triggered
		// via a hotkey. The row navigation for the qpane itself has a
		// smart timing/ratelimit algo to prevent too many requests and
		// the group loading needs to be handled as well (here). The
		// user needs to wait for the current load operation to finish
		// before we load the next group.

		if (self.display == 'tree')
		{
			App.QPane.nextRow();
		}
		else
		{
			var last = $('tr.row:last');
			if (last.attr('rel') == App.QPane.getCurrentRowID())
			{
				if (!App.Ajax.isBusy())
				{
					self._nextRowLoadGroup();
				}
			}
			else
			{
				App.QPane.nextRow();
			}
		}
	}

	self._nextRowLoadGroup = function()
	{
		// If we deal with a paginated group, we try to the load the
		// next page of this group first. If there isn't one, we go to
		// the next group in the tree.

		var page = $('#groupPagination .pagination-current').next('a');
		if (page.length)
		{
			page.click();
		}
		else
		{
			self._nextGroup();
		}
	}

	self.prevRow = function()
	{
		// In subtree/group mode, we may also need to go to the previous
		// group in the list, if any (if the last row is the current
		// one). Also see the comment above for the request handling.

		if (self.display == 'tree')
		{
			App.QPane.prevRow();
		}
		else
		{
			var first = $('tr.row:first');
			if (first.attr('rel') == App.QPane.getCurrentRowID())
			{
				if (!App.Ajax.isBusy())
				{
					self.backwards = true; // See checkQPane
					self._prevRowLoadGroup();
				}
			}
			else
			{
				App.QPane.prevRow();
			}
		}
	}

	self._prevRowLoadGroup = function()
	{
		// If we deal with a paginated group, we try to the load the
		// previous page of this group first. If there isn't one, we go
		// to the previous group in the tree.

		var page = $('#groupPagination .pagination-current').prev('a');
		if (page.length)
		{
			page.click();
		}
		else
		{
			self._prevGroup();
		}
	}

	//---------------------------------------------------------------
	// TREE
	//---------------------------------------------------------------

	self.applyTree = function(selected_group_id)
	{
		var tree = $('#groupTree');

		// If the tree was already applied, we don't call jstree again
		// (the tree doesn't like double-apply and might display/use an
		// incorrect icon for the first group). We just make sure to
		// select the given group in this case, if any.

		if (tree.data('is_tree'))
		{
			if (selected_group_id !== undefined)
			{
				self.group_id = null;
				self.selectGroup(selected_group_id);
			}

			return;
		}

		if (selected_group_id !== undefined)
		{
			var initially_select = ['#node-' + selected_group_id];
		}
		else
		{
			var initially_select = [];
		}

		if (self.allow_dnd && self.can_dnd)
		{
			var plugins = ['themes', 'ui', 'html_data', 'dnd'];
		}
		else
		{
			var plugins = ['themes', 'ui', 'html_data'];
		}

		tree.data('is_tree', true); // See check above
		tree.jstree({
			core: {
				animation: 0,
				html_titles: true
			},
			ui: {
				select_limit: 1,
				selected_parent_close: false,
				select_prev_on_delete: false,
				initially_select: initially_select
			},
			plugins: plugins
		}).
		bind('select_node.jstree', function(e, data)
		{
			self.selectGroup(self._getTreeNodeID(data));
		}).
		bind('open_node.jstree', function(e, data)
		{
			var node_id = self._getTreeNodeID(data);
			self._setExpandStateForGroup(node_id, true);
		}).
		bind('close_node.jstree', function(e, data)
		{
			var node_id = self._getTreeNodeID(data);
			self._setExpandStateForGroup(node_id, false);
		}).
		bind('move_node.jstree', function(e, data)
		{
			var info = data.args[0];
			var parent = data.inst._get_node(info.np);

			if (parent == -1)
			{
				var parent_id = null;
			}
			else
			{
				var parent_id = $(parent).attr('rel');
			}

			var ref = $(data.inst._get_node(info.r));
			var node_id = $(info.o).attr('rel');
			var after_id = null;

			switch (info.p)
			{
				case 'before':
					var prev = ref.prev();
					if (prev.length > 0)
					{
						after_id = prev.attr('rel');
					}
					break;

				case 'after':
					after_id = ref.attr('rel');
					break;

				case 'inside':
					var last_child = ref.children('ul').children('li:last');
					if (last_child.length > 0)
					{
						after_id = last_child.attr('rel');
					}
					break;
			}

			App.Sections.drop(
				info.e.originalEvent, // Also pass the original mouse event
				{
					section_id: node_id,
					droppable_id: ref.attr('rel'),
					parent_id: parent_id,
					after_id: after_id
				}
			);
		});
	}

	self._getTreeNodeID = function(data)
	{
		var args = data.args;
		var node = data.inst._get_node(args[0]);
		return node.attr('rel');
	}

	self._setExpandStateForGroup = function(group_id, expanded)
	{
		App.Storage.setObjectItem(
			'suites.groups.expands',
			self.suite_id,
			group_id,
			expanded ? 1 : 0
		);
	}

	self._getExpandState = function()
	{
		return App.Storage.getObject('suites.groups.expands',
			self.suite_id);
	}

	self._applyTreeHeight = function()
	{
		var w = $(window);
		w.scroll(self._setTreeHeight);
		w.resize(self._setTreeHeight);
		$.subscribe('body.changed', 'suites', self._setTreeHeight);
	}

	self._setTreeHeight = function()
	{
		var groups = $('#groupTreeContent');
		if (groups.length == 0)
		{
			return;
		}

		var sticky = $('#sidebarSticky');
		var height;

		if (sticky.hasClass('sidebar-sticky'))
		{
			height = $(window).height() - 30 -
				$('#sidebarToolbar').outerHeight();
		}
		else
		{
			var top = groups.offset().top;

			// If we are dealing with a non-sticky sidebar, we need to
			// make sure that the height of the tree doesn't exceed
			// the sidebar height (minus the diff between the tree and
			// sidebar offsets). The desired height of the tree is the
			// maximum window size minus the visible offset of the
			// tree (original offset - scroll position, if any).

			var sidebar = $('#sidebar');
			height = Math.min(
				$(window).height() - (top - $(document).scrollTop()),
				sidebar.height() - (top - sidebar.offset().top)
			);
		}

		// Make sure to take goals banner into account as well, if any.
		height -= $('#goals-banner').height();

		groups.height(height - 15);
	}

	self.selectGroup = function(group_id)
	{
		var node = $('#node-' + group_id);

		if (self.display == 'tree')
		{
			node.children('a').removeClass('jstree-clicked');

			var grid = $('#section-' + group_id);
			if (grid.length)
			{
				grid[0].scrollIntoView();
				window.scrollBy(0, -self.scroll_offset); // Adjust for toolbar
			}

			self.group_id = group_id;
			self._setStateUrl();
		}
		else
		{
			if (self.group_id != group_id)
			{
				self.showGroup(self.suite_id, group_id);
			}
		}
	}

	//---------------------------------------------------------------
	// CONTENT & STATE
	//---------------------------------------------------------------

	self._showCases = function(o)
	{
		var defaults = {
			suite_id: self.suite_id,
			display: self.display, // Does not change
			group_id: self.group_id,
			include_sidebar: false,
			save_columns: false,
			page_type: self.page_type,
			format: $('#formatSelection').val(),
			filters: self.filters,
			page_reset: self.page_reset
		};

        $('#contentLoading').show();
        $('#groupContainer').hide();

		var s = $.extend(defaults, o);

		App.Ajax.call(
		{
			target: '/suites/ajax_render_cases',
			arguments: self._getGridArguments(s),

			success: function(html)
			{
				$('#contentLoading').hide();
				$('#groupContainer').show();
				if (s.display == 'tree' || s.include_sidebar)
				{
					self._injectCases(html);
				}
				else
				{
					$('#groupContainer').html(html);
				}

				self._onCasesLoaded(s);

				if (o.success)
				{
					o.success();
				}

				self._checkQPane();
			},

			error: function(data)
			{
				if (o.error)
				{
					o.error();
				}

				App.Ajax.handleError(data);
			}
		});
	}

	self.setCasesPrintViewChange = function(viewType) {

		self._showCases({
			group_id: null,
			format: viewType,
		});
	}

	self._getGridArguments = function(o)
	{
		// Besides the given arguments, we also include the column
		// definition for the grids, the grouping options and the
		// property filters.
		return $.extend({
				columns: App.Tables.columns_for_user,
				group_by: App.Tables.group_by,
				group_order: App.Tables.group_order,
				display_deleted_cases: App.Tables.displayDeletedCases,
				filters: self.filters
			}, o
		);
	}

	self._injectCases = function(html)
	{
		// The server sends multiple views (grids and sidebar). We
		// add them to a hidden div (#ajaxResponse) and then move
		// them to the right position (separately).  This a) saves
		// one ajax request for the sidebar and b) guarantees that
		// the sidebar and the grids are in sync.
		$('#groupContent').remove();
		$('#groupTreeContent').remove();
		$('#ajaxResponse').html(html);
		$('#groupTreeContent').appendTo('#groupTreeContainer');
		$('#groupContent').appendTo('#groupContainer');

		// Also make sure to set/update the height of the sidebar tree.
		self._setTreeHeight();
	}

	self._onCasesLoaded = function(o)
	{
		if (App.Tables.group_by == 'cases:section_id')
		{
			self.can_dnd = true;
			$('#addSectionInline').show();
		}
		else
		{
			self.can_dnd = false;
			$('#addSectionInline').hide();
		}

		self.group_id = o.group_id || null;
		var tree_changed = o.display == 'tree' ||
			o.include_sidebar;

		if (tree_changed)
		{
			// Check if the current group (still) exists
			if (self.group_id !== null)
			{
				if ($('#node-' + self.group_id).length == 0)
				{
					self.group_id = null;
				}
			}

			// If no group is selected or the group no longer exists,
			// we use the first group as current group (in compact
			// mode, there's no need to select the first group when
			// in tree mode).
			if (self.group_id === null)
			{
				if (self.display != 'tree')
				{
					var group = $('#groupTree ul li:first');
					if (group.length > 0)
					{
						self.group_id = group.attr('rel');
					}
				}
			}

			self.applyTree(self.group_id);
		}

		// Should not be required but actually is by IE9, for example
		// (in some rare cases). May be needed to reposition the sticky
		// elements.
		$(window).trigger('scroll');

		// Fire the relevant events for external modules (e.g. sidebar,
		// or reference lookup)
		$.publish({
			'body.changed': null,
			'cases.loaded': {
				project_id: self.project_id
			}
		});

		self._syncToolbar();
		self._setStateUrl();
	}

	self._syncToolbar = function()
	{
		if (App.Tables.group_by == 'cases:section_id')
		{
			$('#addSectionDisabled').hide();
			$('#addSection').show();
		}
		else
		{
			$('#addSection').hide();
			$('#addSectionDisabled').show();
		}

		// Reset the global order-by link and update the order-by name,
		// if necessary.
		$('#orderBy .busy').hide();
		$('#orderByChange').removeClass('link link-dashed nolink');

		if (App.Tables.group_by == 'cases:section_id')
		{
			$('#orderByAsc').hide();
			$('#orderByDesc').hide();
			$('#orderByReset').hide();
			$('#orderByName').hide();
			$('#orderByChange').addClass('link link-dashed');
			$('#orderByEmpty').show();
			if (self.filters) {
				$('#filterByReset').removeClass('hidden');
			}
		}
		else
		{
			if (App.Tables.group_order == 'desc')
			{
				$('#orderByAsc').hide();
				$('#orderByDesc').show();
			}
			else
			{
				$('#orderByDesc').hide();
				$('#orderByAsc').show();
			}

			$('#orderByChange').addClass('nolink');
			$('#orderByName').text(
				App.Tables.getColumnName(App.Tables.group_by)
			);

			$('#orderByEmpty').hide();
			$('#orderByName').show();
			$('#orderByReset').show();
			if (self.filters) {
				$('#filterByReset').removeClass('hidden');
				$('#filterCasesReset').show();
			}
		}

		$('#orderByChange').show();
	}

	self.onCasesAdded = function()
	{
		// Fire the relevant events for external modules (e.g. sidebar,
		// or reference lookup)
		$.publish({
			'body.changed': null,
			'cases.loaded': {
				project_id: self.project_id
			}
		});

		self.refreshSidebarStats();
		self._checkQPane();
	}

	self.onCasesDeleted = function()
	{
		$.publish('body.changed'); // To reposition the sidebar, e.g.
		self.refreshSidebarStats();
		self._checkQPane();
	}

	self.showGroup = function(suite_id, group_id, offset)
	{
		var node = $('#node-' + group_id);
		var a = node.children('a');

		self.paginating = offset !== undefined;
		if (self.paginating)
		{
			$('#paginationBusy').show();
		}
		else
		{
			a.addClass('jstree-loading');
		}

		self.page_reset = offset === 0 ? true : false;

		self._showCases(
		{
			suite_id: suite_id,
			group_id: group_id,
			offset: offset,

			success: function()
			{
				$('#paginationBusy').hide();
				a.removeClass('jstree-loading');
				a.addClass('jstree-clicked');
			},

			error: function(data)
			{
				$('#paginationBusy').hide();
				a.removeClass('jstree-loading');
			}
		});
	}

	self._nextGroup = function()
	{
		var next = App.Sections.next(self.group_id, self.display);
		if (next)
		{
			App.QPane.clearRow();
			$('#groupTree').jstree('select_node', next, true);
		}
	}

	self._prevGroup = function()
	{
		var prev = App.Sections.prev(self.group_id);
		if (prev)
		{
			App.QPane.clearRow();
			$('#groupTree').jstree('select_node', prev, true);
		}
	}

	self.refreshSidebarStats = function()
	{
		App.Ajax.call(
		{
			target: 'suites/ajax_render_sidebar_stats',
			blockUI: false,

			arguments: {
				suite_id: self.suite_id,
				display_deleted_cases: App.Tables.displayDeletedCases,
			},

			success: function(html)
			{
				$('#sidebarInfo').html(html);
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self.refreshGroupCount = function(group_id)
	{
		var rows = $('tr.caseRow', $('#grid-' + group_id)).length;
		var text = rows;

		// Only update the section counts which have changed. This avoids
		// unnecessary rendering and makes this a lot faster in IE.

		var count = $('#sectionCount-' + group_id);
		if (count.text() != text)
		{
			count.text(text);
		}
	}

	self.refreshGroupCounts = function()
	{
		$('.grid-container').each(
			function()
			{
				var group_id = $(this).attr('rel');
				self.refreshGroupCount(group_id);
			}
		);
	}

	self.showInitial = function()
	{
		if(self.page_type == 'view') {
			// Calculate the height of the visible area for the test cases.
			var height =
				$(window).height() - $('#contentToolbar').offset().top;

			// Calculate and set a suitable top padding for the loading
			// spinner
			var top = Math.max(Math.round(height / 2 - 125), 50);
			$('#contentLoading').css('padding-top', top);
			$('#contentLoading').show();
		}

		self._showCases(
		{
			include_sidebar: true,
			group_expands: self._getExpandState(),

			success: function(data)
			{
				$('#contentLoading').hide();
				if (self.display != 'tree' && self.group_id)
				{
					self._openParents(self.group_id);
				}
			}
		});
	}

	self._openParents = function(group_id)
	{
		var node = $('#node-' + group_id);

		// Iterate the parents of the given node/group and expand the
		// respective sub-tree (until we reach root).
		var parent = node.parent('ul').parent('li');
		while (parent.length > 0)
		{
			parent.addClass('jstree-open');
			$('#groupTree').jstree('open_node', parent);
			parent = parent.parent('ul').parent('li');
		}
	}

	self._reloadCases = function(group_id)
	{
		self.group_id = group_id || null; // Reset the group, if none
		$('#groupContent').remove();
		$('#groupTreeContent').remove();
		self.showInitial();
	}

	self._setStateUrl = function()
	{
		var currentUrl = self.getStateOptions();
		var replacedUrl = (currentUrl.includes('outline'))
			? currentUrl.replace('outline', $('#formatSelection').val())
			: currentUrl.replace('details', $('#formatSelection').val());

		App.Page.replaceState(
			'/suites/'+ self.page_type +'/' + self.suite_id,
			replacedUrl
		);

		if (self.page_type == 'view') {
			$('#printPopupLink').attr(
				'href',
				'index.php?/suites/plot/'+ self.suite_id +'&format=outline&'+ self.getStateOptions()
			);
		}
	}

	self.getStateOptions = function()
	{
		// Get the current query string and only override the grouping
		// related options (the remaining options are preserved).

		var options = App.Page.getQueryOptions();
		options['group_by'] = App.Tables.group_by;
		options['group_order'] = App.Tables.group_order;
		options['display_deleted_cases'] = App.Tables.displayDeletedCases;

		if (self.group_id !== null)
		{
			options['group_id'] = self.group_id;
		}
		else
		{
			delete options['group_id'];
		}

		return App.Page.formatQueryOptions(options);
	}

	//---------------------------------------------------------------
	// COLUMNS & GRID GROUPING
	//---------------------------------------------------------------

	self.selectCaseColumns = function(group_id, project_id)
	{
		App.Tables.selectColumns(
		{
			group_id: group_id,
			project_id: project_id,
			area_id: App.QPane.isVisible() ? 6 : 1,

			submit: function(callbacks)
			{
				self._showCases({ include_sidebar: true });
			}
		});
	}

	self.setCaseGrouping = function(column, show_progress)
	{
		App.Tables.setGrouping(column);

		if (show_progress)
		{
			$('#orderByChange').hide();
			$('#orderBy .busy').show();
		}

		self._showCases({
			group_id: null,
			include_sidebar: true,
			group_expands: self._getExpandState(),
			save_columns: (self.page_type === 'view'), // Store current columns for user

			error: function()
			{
				$('#orderBy .busy').hide();
				$('#orderByChange').show();
			}
		});
	}

	//---------------------------------------------------------------
	// FILTERING
	//---------------------------------------------------------------

	self._createFilter = function(e)
	{
		return new App.Suites.Filter(
		{
			event: e,
			suite_id: self.suite_id,
			filters: self.filters,
			save_filters: true,

			changed: function(filters)
			{
				self.filters = filters;
				self._reloadCases();
			}
		});
	}

	self.filterCases = function(e)
	{
		var filter = self._createFilter(e);
		filter.open();
	}

	self.filterCasesReset = function()
	{
		var filter = self._createFilter();
		filter.reset();
	}

	//---------------------------------------------------------------
	// ESTIMATES
	//---------------------------------------------------------------

	self.applyEstimates = function()
	{
		$('#estimatesLink').bubble({
			bubble: '#estimatesBubble',
			inContainer: true
		});
	}

	//---------------------------------------------------------------
	// IMPORT (XML)
	//---------------------------------------------------------------

	self.importCases = function(suite_id)
	{
		self._importDialog(
		{
			submit: function()
			{
				self._importSubmit(suite_id);
			}
		});
	}

	self._importDialog = function(o)
	{
		App.Validation.hideErrors();

		// Initialize the dialog
		$('#import').val(''); // Reset filename
		$('#importForm').unbind('submit');
		$('#importSubmit').removeClass('button-busy');

		$('#importForm').submit(function(e)
		{
			App.Validation.hideErrors();
			o.submit();
			return false;
		});

		App.Dialogs.open(
		{
			selector: '#importDialog',
			focusedControl: '#import'
		});
	}

	self._importSubmit = function(suite_id)
	{
		$('#importSubmit').addClass('button-busy');

		App.Import.upload(
		{
			target: 'suites/ajax_import',
			data: {
				suite_id: suite_id,
				is_update: $('#importUpdate').is(':checked') ? 1 : 0
			},
			fileElementId: 'import',

			success: function (data, status)
			{
				$('#importSubmit').removeClass('button-busy');

				if (data.result)
				{
					App.Dialogs.close('#importDialog');
					App.Page.load('/suites/view/{0}', suite_id);
				}
				else
				{
					App.Ajax.handleError(data, '#importErrors');
				}
			},

			error: function (data, status, e)
			{
				$('#importSubmit').removeClass('button-busy');
				App.Ajax.handleError(); // [sic!]
			}
		});
	}

	//---------------------------------------------------------------
	// IMPORT (CSV)
	//---------------------------------------------------------------

	self.importCasesCsv = function(suite_id)
	{
		var dialog = new App.Suites.ImportCsv(
		{
			suite_id: suite_id
		});

		// Get the sections and fill the section dropdown of the dialog
		// and open the dialog (concurrently).
		App.Ajax.call(
		{
			target: 'suites/ajax_render_section_list',
			arguments:
			{
				suite_id: suite_id
			},

			success: function(html)
			{
				$('#importCsvImportTo').html(html);
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});

		dialog.open();
	}

	//---------------------------------------------------------------
	// EXPORT (CSV/Excel)
	//---------------------------------------------------------------

	self.exportCasesCsv = function(suite_id)
	{
		self._exportCases(suite_id, 'csv');
	}

	self.exportCasesExcel = function(suite_id)
	{
		self._exportCases(suite_id, 'excel');
	}

	self._exportCases = function(suite_id, format)
	{
		var dialog = new App.ExportCsv(
		{
			format: format,
			init: function()
			{
				// Get the sections and fill the section selection of
				// the dialog (concurrently, while it opens).
				self._exportLoadSections(suite_id);
			}
		});

		dialog.open();
	}

	self._exportLoadSections = function(suite_id)
	{
		$('#exportCsvSectionsSelectedBusy').show();

		App.Ajax.call(
		{
			target: 'suites/ajax_render_section_list',

			arguments:
			{
				suite_id: suite_id,
				show_empty: false
			},

			stop: function()
			{
				$('#exportCsvSectionsSelectedBusy').hide();
			},

			success: function(html)
			{
				$('#exportCsvSectionsSelection').html(html);
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	//---------------------------------------------------------------
	// COPY CASES
	//---------------------------------------------------------------

	self.copyCases = function(suite_id)
	{
		var select = new App.Suites.Select(
		{
			project_id: self.project_id,
			suite_id: null, // Starts with no test suite
			columns: self.columns_for_copy,
			columns_custom: true,
			column_area_id: 5, // Area ID for the suite form
			filters: self.filters
		});

		self._copyCasesReset();

		// After resetting/initializing the dialog, we first register
		// event handlers for the various actions (suite changed,
		// button clicked, etc.).
		$('#copyCasesSuite').unbind('change').change(
			function()
			{
				var suite_id = $(this).val();
				self._copyCasesSuite(select, suite_id);
			}
		);

		var copyOrMove = function(button, is_move)
		{
			var selection = select.getSelection();

			button.addClass('button-busy');

			self._copySubmit(
			{
				target_suite_id: suite_id,
				source_suite_id: $('#copyCasesSuite').val(),
				section_ids: selection.section_ids,
				case_ids: selection.case_ids,
				section_mode: $('#copyCasesSections').val(),
				section_id: $('#copyCasesAppendTo').val(),
				is_move: is_move
			});
		}

		$('#copyCasesButton, #moveCasesButton').unbind('click').click(
			function()
			{
				var button = $(this);
				var is_move = button.attr('rel') == 'move';
				if (is_move)
				{
					App.Dialogs.remove(
						'l:suites_copycases_move_confirm',
						'l:suites_copycases_move_confirm_checkbox',
						null, // No extra message
						null, // No init callback
						function()
						{
							copyOrMove(button, true);
						}
					);
				}
				else
				{
					copyOrMove(button, false);
				}
			}
		);

		// We then get the sections and fill the section dropdown of
		// the dialog and open the dialog (concurrently).
		App.Ajax.call(
		{
			target: 'suites/ajax_render_section_list',
			arguments:
			{
				suite_id: suite_id
			},

			success: function(html)
			{
				$('#copyCasesAppendTo').html(html);
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});

		select.open();
	}

	self._copySubmit = function(o)
	{
		App.Ajax.call(
		{
			target: 'suites/' +
				(o.is_move ? 'ajax_move_cases' : 'ajax_copy_cases'),

			arguments:
			{
				target_suite_id: o.target_suite_id,
				source_suite_id: o.source_suite_id,
				section_ids: o.section_ids,
				case_ids: o.case_ids,
				section_mode: o.section_mode,
				section_id: o.section_id
			},

			stop: function()
			{
				$('#copyCasesButton').removeClass('button-busy');
				$('#moveCasesButton').removeClass('button-busy');
			},

			success: function(data)
			{
				App.Page.load('/suites/view/{0}', o.target_suite_id);
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self._copyCasesReset = function()
	{
		$('#copyCasesSuite').val('');
		$('#copyCasesButton').hide();
		$('#copyCasesDisabledButton').show();
		$('#moveCasesButton').hide();
		$('#moveCasesDisabledButton').show();
		$('#copyCasesButton').removeClass('button-busy');
		$('#moveCasesButton').removeClass('button-busy');
		$('#copyCasesSections').val('2');
	}

	self._copyCasesSuite = function(select, suite_id)
	{
		$('#selectCasesDoc').hide();
		$('#selectCasesContent').hide();
		$('#selectCasesIntro').hide();
		$('#copyCasesButton').hide();
		$('#copyCasesDisabledButton').show();
		$('#moveCasesButton').hide();
		$('#moveCasesDisabledButton').show();

		if (!suite_id)
		{
			$('#selectCasesIntro').show();
			return; // Nothing to load
		}

		if (suite_id == self.suite_id)
		{
			// This is the current test suite. We just load and show
			// an info message/screenshot with details on how drag &
			// drop cases.
			App.Ajax.call(
			{
				target: 'suites/ajax_render_copy_doc',

				success: function(html)
				{
					$('#selectCasesDoc').html(html);
					$('#selectCasesDoc').show();
				},

				error: function(data)
				{
					App.Ajax.handleError(data);
				}
			});
		}
		else
		{
			// Load the content for the given test suite and enable
			// the copy/move buttons afterwards (move depends on
			// permissions).
			select.load(
				suite_id,
				{
					success: function()
					{
						$('#copyCasesDisabledButton').hide();
						$('#copyCasesButton').show();
						$('#moveCasesDisabledButton').hide();

						if ($('#can_move').val() == '1')
						{
							$('#moveCasesButton').show();
						}
					}
				}
			);
		}
	}

	//---------------------------------------------------------------
	// DESCRIPTION
	//---------------------------------------------------------------

	self.editDescription = function(suite_id)
	{
		self._load(
		{
			suite_id: suite_id,
			success: function(suite)
			{
				App.Validation.hideErrors();

				// Initialize the dialog
				$('#editSuiteDescription').val(suite.description);
				if (suite.description !== null) {
					$('#editSuiteDescription_display').text(suite.description);
				}
				$('#editSuiteForm').unbind('submit');
				$('#editSuiteForm').submit(function(e)
				{
					App.Validation.hideErrors();

					self._editDescription(
					{
						suite_id: suite_id,
						description:
							$.trim($('#editSuiteDescription').val())
					});

					return false;
				});

				App.Dialogs.open(
				{
					selector: '#editSuiteDialog',
					focusedControl: '#editSuiteDescription',
					selectedControl: '#editSuiteDescription'
				});
			}
		});
	}

	self._editDescription = function(o)
	{
		$('#editSuiteSubmit').addClass('button-busy');

		App.Ajax.call(
		{
			target: '/suites/ajax_update',

			arguments:
			{
				suite_id: o.suite_id,
				description: o.description
			},

			stop: function()
			{
				$('#editSuiteSubmit').removeClass('button-busy');
			},

			success: function()
			{
				App.Dialogs.closeTop();
				App.Page.load('/suites/view/' + o.suite_id); // Reload the page
			},

			error: function(data)
			{
				App.Ajax.handleError(data, '#editSuiteErrors');
			}
		});
	}

	self._load = function(o)
	{
		$('#editDescriptionBusy').show();

		App.Ajax.call(
		{
			target: '/suites/ajax_get',

			arguments:
			{
				suite_id: o.suite_id
			},

			stop: function()
			{
				$('#editDescriptionBusy').hide();
			},

			success: function(suite)
			{
				o.success(suite);
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	//---------------------------------------------------------------
	// OVERVIEW
	//---------------------------------------------------------------

	self.toggleDetails = function(suite_id)
	{
		var suite = $('#suite-' + suite_id);
		var visible = $('.details', suite).is(':visible');

		if (visible)
		{
			self._hideDetails(suite, suite_id);
		}
		else
		{
			var has_details = $('.details .table', suite).length > 0;
			if (has_details)
			{
				self._showDetails(suite);
			}
			else
			{
				// If we don't have the details already, get them from
				// the server and show them afterwards.
				self._loadDetails(suite, suite_id);
			}
		}
	}

	self._showDetails = function(suite)
	{
		App.Effects.show($('.details', suite));
		$('.expand', suite).hide();
		$('.collapse', suite).show();
	}

	self._hideDetails = function(suite)
	{
		App.Effects.hide($('.details', suite));
		$('.collapse', suite).hide();
		$('.expand', suite).show();
	}

	self._loadDetails = function(suite, suite_id)
	{
		App.Ajax.call(
		{
			target: 'suites/ajax_get_details',

			arguments:
			{
				suite_id: suite_id
			},

			start: function()
			{
				$('.buttons', suite).hide();
				$('.busy', suite).show();
			},

			stop: function()
			{
				$('.busy', suite).hide();
				$('.buttons', suite).show();
			},

			success: function(html)
			{
				$('.details', suite).append(html);
				self._showDetails(suite);
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self.addBaseline = function(project_id)
	{
		App.Validation.hideErrors();

		// Initialize the dialog
		$('#addBaselineName').val('');
		$('#addBaselineForm').unbind('submit');
		$('#addBaselineForm').submit(function(e)
		{
			App.Validation.hideErrors();

			self._addBaseline(
			{
				project_id: project_id,
				name: $.trim($('#addBaselineName').val()),
				parent_id: $('#addBaselineParent').val()
			});

			return false;
		});

		$('#addBaselineProject').unbind('change').change(
			function()
			{
				var parent_id = $('#addBaselineProject').val();
				self._addBaselineLoad(parent_id);
			}
		);

		App.Dialogs.open(
		{
			selector: '#addBaselineDialog',
			focusedControl: '#addBaselineName',
			selectedControl: '#addBaselineName'
		});
	}

	self._addBaseline = function(o)
	{
		$('#addBaselineSubmit').addClass('button-busy');

		App.Ajax.call(
		{
			target: '/suites/ajax_add_baseline',

			arguments:
			{
				project_id: o.project_id,
				name: o.name,
				parent: o.parent_id
			},

			stop: function()
			{
				$('#addBaselineSubmit').removeClass('button-busy');
			},

			success: function()
			{
				App.Dialogs.closeTop();
				App.Page.load('/suites/overview/' + o.project_id); // Reload the page
			},

			error: function(data)
			{
				App.Ajax.handleError(data, '#addBaselineErrors');
			}
		});
	}

	self._addBaselineLoad = function(project_id)
	{
		$('#addBaselineParentBusy').show();

		App.Ajax.call(
		{
			target: '/suites/ajax_render_baselines',

			arguments:
			{
				project_id: project_id
			},

			stop: function()
			{
				$('#addBaselineParentBusy').hide();
			},

			success: function(html)
			{
				$('#addBaselineParent').html(html);
				$('#addBaselineParent').val('');
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	//---------------------------------------------------------------
	// RUNS
	//---------------------------------------------------------------

	self.loadCompletedRuns = function(suite_id)
	{
		$('#showCompleted .showAll').hide();
		$('#showCompleted .busy').show();

		App.Ajax.call(
		{
			target: '/suites/ajax_get_completed_runs',

			arguments:
			{
				suite_id: suite_id
			},

			stop: function()
			{
				$('#showCompleted .busy').hide();
			},

			success: function(html)
			{
				$('#completed').html(html);
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	//---------------------------------------------------------------
	// ASSIGN TO
	//---------------------------------------------------------------

	// Opens the Assign dialog and then assigns the currently selected
	// cases to the selected user.
	self.assignAll = function(inView)
	{
		App.Cases.setCommentType('assignTo');
		App.Cases.prepareCommentDialog(
			{
				titleSelector: '.editComment',
				method: function(o) {
					App.Cases.commentDialog(
						false,
						{ titleSelector: '.assignTo' },
						{
							show: o.show,

							submit: function(change)
							{
								App.Suites.massAssign(
									change,
									inView,
									{
										success: App.Cases.commentSuccess,
										error: App.Cases.commentError
									}
								);
							}
						}
					);
				}
			}
		);
	}

	// Assigns multiple cases and updates the corresponding html rows
	// in the case grid.
	self.massAssign = function(change, inView, callbacks)
	{
		change.suite_id = self.suite_id;
		change.columns = JSON.stringify(App.Tables.columns_for_user);
		change.group_by = App.Tables.group_by;
		change.group_order = App.Tables.group_order;
		change.filters = self.filters;
		change.group_only = inView;
		change.group_id = self.group_id;
		change.display = self.display;

		App.Ajax.call(
		{
			target: '/suites/ajax_assign',
			arguments: change,

			success: function(data)
			{
				callbacks.success(data);
				var cases = false;

				// Add and replace the individual case rows.
				for (var i = 0, len = data.rows.length; i < len; i++) {
					var testCase = data.rows[i];
					var selector = '#row-' + testCase.id;
					var element = $(selector);
					var style = element.hasClass('oddSelected') ? 'odd' : 'even';

					// Replace the test row and refresh the jQuery object (so
					// that we deal with the row).
					element.replaceWith(testCase.code);
					element = $(selector);

					element.removeClass('oddSelected evenSelected').addClass(style);

					if (cases) {
						cases = cases.add(element);
					} else {
						cases = element;
					}
				}

				App.Effects.add(cases);

				// And then uncheck all header checkboxes and update the
				// mass action buttons.
				$('tr.header input.selectionCheckbox').prop('checked', false);
				App.Cases._updateMassActions();
			},

			error: function(data)
			{
				callbacks.error(data);
			}
		});
	}
}

//-------------------------------------------------------------------
// IMPORT (CSV)
//-------------------------------------------------------------------

App.Suites.ImportCsv = function(o)
{
	var self = this;

	self.suite_id = o.suite_id;
	self.step = 1;
	self.step2_changed = false;
	self.step3_changed = false;
	self.csvfile_id = null;
	self.mapfile_id = null;

	// Fields from step 2 + 3 which are preserved when clicking Prev.
	self.skip_empty = null;
	self.layout_format = null;
	self.layout_break = null;
	self.columns = null;
	self.values = null;

	self.open = function()
	{
		App.Validation.hideErrors();

		self._reset();
		self._bindPagination();
		self._bindStep1();

		App.Dialogs.open(
		{
			selector: '#importCsvDialog'
		});
	}

	self._reset = function()
	{
		$('#importCsvFile').val('');
		$('#importCsvFileSuccess').hide();
		$('#importCsvFileDesc').hide();
		$('#importCsvFile').show();
		$('#importCsvMappingFile').val('');
		$('#importCsvMappingCreate').prop('checked', true);
		$('#importCsvMappingFile').show();
		$('#importCsvMappingFileSuccess').hide();
		$('#importCsvMappingFileContainer').hide();
		self._hideImport();
		self._hideClose();
		self._hidePrev();
		self._showNext();
		self._showCancel();
		$('#importCsvStep4').remove();
		$('#importCsvStep3').remove();
		$('#importCsvStep2').remove();
		$('#importCsvStep1').show();
	}

	self._showNext = function()
	{
		$('#importCsvNext').prop('disabled', false).
			addClass('dialog-action-default').show();
	}

	self._hideNext = function()
	{
		$('#importCsvNext').prop('disabled', true).
			removeClass('dialog-action-default').hide();
	}

	self._showImport = function()
	{
		$('#importCsvImport').prop('disabled', false).
			addClass('dialog-action-default').show();
	}

	self._hideImport = function()
	{
		$('#importCsvImport').prop('disabled', true).
			removeClass('dialog-action-default').hide();
	}

	self._showClose = function()
	{
		$('#importCsvClose').prop('disabled', false).
			addClass('dialog-action-default').show();
	}

	self._hideClose = function()
	{
		$('#importCsvClose').prop('disabled', true).
			removeClass('dialog-action-default').hide();
	}

	self._showPrev = function()
	{
		$('#importCsvPrev').prop('disabled', false).show();
	}

	self._hidePrev = function()
	{
		$('#importCsvPrev').prop('disabled', true).hide();
	}

	self._showCancel = function()
	{
		$('#importCsvCancel').show();
	}

	self._hideCancel = function()
	{
		$('#importCsvCancel').hide();
	}

	self._bindPagination = function()
	{
		// Record the clicked button that submitted the form, used to
		// decide which action to perform in form submit.
		$('#importCsvNext, #importCsvPrev, #importCsvImport, #importCsvClose').
			unbind('click').click(
			function()
			{
				$('#importCsvForm').data('event', $(this).attr('rel'));
			}
		);

		var form = $('#importCsvForm');
		form.data('event', '');
		form.unbind('submit').submit(
			function()
			{
				App.Validation.hideErrors();

				switch ($(this).data('event'))
				{
					case 'next':
						self._next();
						break;

					case 'import':
						self._import();
						break;

					case 'previous':
						self._previous();
						break;

					case 'close':
						self._close();
						break;

					default:
						// No button clicked, e.g. <Enter> in input
						switch (self.step)
						{
							case 3:
								self._import();
								break;

							case 4:
								self._close();
								break;

							default:
								self._next();
								break;
						}

						break;
				}

				$(this).data('event', ''); // Clear for next step/page
				return false;
			}
		);
	}

	self._bindStep1 = function()
	{
		$('#importCsvMappingCreate').unbind('click').click(
			function()
			{
				$('#importCsvMappingFileContainer').hide();
			}
		);

		$('#importCsvMappingLoad').unbind('click').click(
			function()
			{
				$('#importCsvMappingFileContainer').show();
			}
		);

		$('#importCsvFileDelete').unbind('click').click(
			function()
			{
				self.csvfile_id = null;
				$('#importCsvFileSuccess').hide();
				$('#importCsvFile').show();
				$('#importCsvFileDesc').show();
			}
		);

		$('#importCsvMappingFileDelete').unbind('click').click(
			function()
			{
				self.mapfile_id = null;
				$('#importCsvMappingFileSuccess').hide();
				$('#importCsvMappingFile').show();
			}
		);

		$('#importCsvDialog').off('change', '#importCsvFile').on(
			'change',
			'#importCsvFile',
			function()
			{
				self._uploadFile(
				{
					element: 'importCsvFile',
					id: 'csvfile_id',
					success: function(csvfile_id)
					{
						$('#importCsvFile').hide();
						$('#importCsvFileDesc').hide();
						$('#importCsvFileSuccess').show();
					}
				});
			}
		);

		$('#importCsvDialog').off('change', '#importCsvMappingFile').on(
			'change',
			'#importCsvMappingFile',
			function()
			{
				self._uploadFile(
				{
					element: 'importCsvMappingFile',
					id: 'mapfile_id',
					success: function(mapfile_id)
					{
						self._loadOptions(mapfile_id);
					}
				});
			}
		);
	}

	self._loadOptions = function(mapfile_id)
	{
		$('#importCsvMappingFileBusy').show();

		App.Ajax.call(
		{
			target: '/suites/ajax_get_import_csv_options',

			arguments: {
				mapfile_id: mapfile_id
			},

			stop: function()
			{
				$('#importCsvMappingFileBusy').hide();
			},

			success: function(data)
			{
				$('#importCsvMappingFile').hide();
				$('#importCsvMappingFileSuccess').show();
				$('#importCsvEncoding').val(data.encoding);

				if (data.delimiter == '\t')
				{
					data.delimiter = '\\t';
				}

				$('#importCsvDelimiter').val(data.delimiter);
				$('#importCsvStartRow').val(data.start_row);
				$('#importCsvHasHeader').prop('checked', data.has_header);

				if (data.template_id)
				{
					$('#importCsvTemplate').val(data.template_id);
				}
			},

			error: function(data)
			{
				self.mapfile_id = null; // Clear again
				App.Ajax.handleError(data, '#importCsvErrors');
			}
		});
	}

	self._bindStep2 = function()
	{
		$('#importCsvLayoutSingle').unbind('click').click(
			function()
			{
				$('#importCsvLayoutMultiBreakContainer').hide();
			}
		);

		$('#importCsvLayoutMulti').unbind('click').click(
			function()
			{
				$('#importCsvLayoutMultiBreakContainer').show();
			}
		);

		$('#importCsvStep2 :input').change(
			function()
			{
				self.step2_changed = true;
			}
		);
	}

	self._bindStep3 = function()
	{
		$('#importCsvStep3 :input').change(
			function()
			{
				self.step3_changed = true;
			}
		);
	}

	self._bindStep4 = function()
	{
		$('#importCsvConfigLink').unbind('click').click(function()
		{
			var args = self._getStepArguments();
			$('#importCsvConfigEncoding').val(args.encoding);
			$('#importCsvConfigDelimiter').val(args.delimiter);
			$('#importCsvConfigStartRow').val(args.start_row);
			$('#importCsvConfigHasHeader').val(args.has_header ? 1 : 0);
			$('#importCsvConfigTemplate').val(args.template_id);
			$('#importCsvConfigSkipEmpty').val(args.skip_empty ? 1 : 0);
			$('#importCsvConfigLayoutFormat').val(args.layout_format);
			$('#importCsvConfigLayoutBreak').val(args.layout_break);
			$('#importCsvConfigColumns').val(JSON.stringify(args.columns));
			$('#importCsvConfigValues').val(JSON.stringify(args.values));
			$('#importCsvConfigForm').submit();
			return false;
		});
	}

	self._uploadFile = function(o)
	{
		self[o.id] = null; // Clear possible previous uploads
		var selector = '#' + o.element;
		$(selector + 'Busy').show();

		App.Import.upload(
		{
			target: 'attachments/ajax_add_for_user',
			data: {
				element: o.element
			},
			fileElementId: o.element,

			success: function (data, status)
			{
				$(selector + 'Busy').hide();

				if (data.result)
				{
					self[o.id] = data.id;

					if (o.success)
					{
						o.success(data.id);
					}
				}
				else
				{
					App.Ajax.handleError(data, '#importCsvErrors');
				}
			},

			error: function (data, status, e)
			{
				$(selector + 'Busy').hide();
				App.Ajax.handleError(); // [sic!]
			}
		});
	}

	self._getStepArguments = function()
	{
		var arguments = $.extend(
			{
				suite_id: self.suite_id
			},
			self._getStep1()
		);

		if (self.step >= 2)
		{
			$.extend(arguments, self._getStep2());
		}

		if (self.step >= 3)
		{
			$.extend(arguments, self._getStep3());
		}

		return arguments;
	}

	self._getStep1 = function()
	{
		return {
			csvfile_id: self.csvfile_id,
			mapfile_enabled: $('#importCsvMappingLoad').is(':checked'),
			mapfile_id: self.mapfile_id,
			section_id: $('#importCsvImportTo').val(),
			encoding: $('#importCsvEncoding').val(),
			delimiter: $('#importCsvDelimiter').val(),
			start_row: $('#importCsvStartRow').val(),
			has_header: $('#importCsvHasHeader').is(':checked'),
			template_id: $('#importCsvTemplate').val(),
			skip_empty: self.skip_empty,       // Restore if shown before
			layout_format: self.layout_format, // Restore if shown before
			layout_break: self.layout_break,   // Restore if shown before
			columns: self.columns              // Restore if shown before
		};
	}

	self._getStep2 = function()
	{
		var columns = {};
		$('#importCsvColumns tr.mapping').each(
			function(ix, v)
			{
				var column = $(v);
				columns[column.attr('rel')] = column.find('select').val();
			}
		);

		return {
			layout_format: $('#importCsvLayoutSingle').is(':checked') ?
				'single' : 'multi',
			layout_break: $('#importCsvLayoutMultiBreak').val(),
			skip_empty: $('#importCsvSkipEmpty').is(':checked'),
			columns: columns,
			values: self.values // Restore if shown before
		};
	}

	self._getStep3 = function()
	{
		var values = {};
		$('#importCsvValues h2.mapping').each(
			function(ix, v)
			{
				var column = $(v);
				var column_id = column.attr('rel');
				var column_selector = '#importCsvValue' + column_id;
				var type_id = parseInt(column.attr('type'));

				var options = null;
				switch (type_id)
				{
					case 1: // String
					case 2: // Text
					case 6: // Steps: Step
					case 7: // Steps: Expected
						options = {
							remove_html:
								$(column_selector + 'RemoveHtml').is(':checked')
						};
						break;

					case 3: // Checkbox
					case 4: // Dropdown
					case 8: // Multi-select
						// Find out and add the value mapping for the dropdown
						// column (e.g. for a priority "High" => "Must Test").
						var mapping = {};
						$(column_selector + 'Mapping tr.mapping').each(
							function(ix, v)
							{
								var value = $(v);
								mapping[value.attr('rel')] =
									value.find('select').val();
							}
						);

						options = { mapping: mapping };
						break;

					case 5: // Date
						options = {
							date_format: $(column_selector + 'DateFormat').val()
						};
						break;
				}

				if (options)
				{
					values[column.attr('rel')] = options;
				}
			}
		);

		return {
			values: values
		};
	}

	self._next = function()
	{
		$('#importCsvNext').addClass('button-busy');

		App.Ajax.call(
		{
			target: '/suites/ajax_render_import_csv_step' +
				(self.step + 1),
			arguments: self._getStepArguments(),

			stop: function()
			{
				$('#importCsvNext').removeClass('button-busy');
			},

			success: function(html)
			{
				$('#importCsvStep' + self.step).hide();
				$('#importCsvSteps').append(html);
				self.step++;

				self._showPrev();
				switch (self.step)
				{
					case 2:
						self._bindStep2();
						break;

					case 3:
						self._bindStep3();
						break;

					case 4:
						self._hideNext();
						self._showImport();
						break;
				}
			},

			error: function(data)
			{
				App.Ajax.handleError(data, '#importCsvErrors');
			}
		});
	}

	self._previous = function()
	{
		$('#importCsvPrev').addClass('button-busy');

		// If we are on step 2/3 and want to get back to the previous
		// step, we also need to validate the current step/form. We do
		// this because we remember and restore the step settings when
		// going back and forth between the steps (and the data must
		// be valid in this case).

		if ((self.step == 2 && self.step2_changed) ||
			(self.step == 3 && self.step3_changed))
		{
			App.Ajax.call(
			{
				target: '/suites/ajax_validate_import_csv_step' +
					self.step,
				arguments: self._getStepArguments(),

				stop: function()
				{
					$('#importCsvPrev').removeClass('button-busy');
				},

				success: function(html)
				{
					switch (self.step)
					{
						case 3:
							var fields = self._getStep3();
							self.values = fields.values;
							break;

						case 2:
							var fields = self._getStep2();
							self.skip_empty = fields.skip_empty;
							self.layout_format = fields.layout_format;
							self.layout_break = fields.layout_break;
							self.columns = fields.columns;
							break;
					}

					self._previousActivate();
				},

				error: function(data)
				{
					App.Ajax.handleError(data, '#importCsvErrors');
				}
			});
		}
		else
		{
			self._previousActivate();
			$('#importCsvPrev').removeClass('button-busy');
		}
	}

	self._previousActivate = function()
	{
		$('#importCsvStep' + self.step).hide();
		$('#importCsvStep' + (self.step - 1)).show();
		$('#importCsvStep' + self.step).remove();

		self.step--;
		if (self.step == 1)
		{
			self._hidePrev();
		}

		self._hideImport();
		self._showNext();
	}

	self._import = function()
	{
		$('#importCsvImport').addClass('button-busy');

		App.Ajax.call(
		{
			target: '/suites/ajax_import_csv',
			arguments: self._getStepArguments(),

			stop: function()
			{
				$('#importCsvImport').removeClass('button-busy');
			},

			success: function(html)
			{
				$('#importCsvStep' + self.step).hide();
				$('#importCsvSteps').append(html);
				App.Dialogs.setWidth('#importCsvDialog', 525);
				self.step++;
				self._bindStep4();
				self._hidePrev();
				self._hideImport();
				self._hideCancel();
				self._showClose();
			},

			error: function(data)
			{
				App.Ajax.handleError(data, '#importCsvErrors');
			}
		});
	}

	self._close = function()
	{
		App.Dialogs.closeTop();
		App.Page.load('/suites/view/{0}', self.suite_id);
	}
}

//-------------------------------------------------------------------
// FILTERING
//-------------------------------------------------------------------

App.Suites.Filter = function(o)
{
	var self = this;

	self.suite_id = o.suite_id;
	self.filters = o.filters;
	self.save_filters = o.save_filters;
	self.changed = o.changed;
	self.event = o.event;

	self.open = function(e)
	{
		var bubble = $('#filterByChange').bubble(
		{
			bubble: '#filterCasesBubble',
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
			target: '/suites/ajax_render_case_filter',

			arguments: {
				suite_id: self.suite_id,
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
				$('#filterCasesContent').html(html);
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
		$('#filterCasesApply').click(
			function()
			{
				self._apply(o);
				return false; // Important for confirm-leave behavior
				              // with IE, e.g. on bulk-edit for cases
			}
		);

		$('#filterCasesCancel').click(
			function()
			{
				self._cancel(o);
				return false; // Important for confirm-leave behavior
				              // with IE, e.g. on bulk-edit for cases
			}
		);
	}

	self._apply = function(o)
	{
		var filters = App.Filters.getAll($('#filterCasesContent'));

		App.Ajax.call(
		{
			target: '/suites/ajax_render_case_filter_info',

			arguments: {
				suite_id: self.suite_id,
				filters: filters,
				save_filters: App.Suites.page_type === 'plot' ? false : self.save_filters
			},

			start: function()
			{
				$('#filterCasesApply').addClass('button-busy');
			},

			stop: function()
			{
				$('#filterCasesApply').removeClass('button-busy');
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
			$('#filterByReset').removeClass('hidden');
			$('#filterCasesReset').show();
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
			target: '/suites/ajax_render_case_filter_info',

			arguments: {
				suite_id: self.suite_id,
				filters: null,
				save_filters: App.Suites.page_type === 'plot' ? false : self.save_filters
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

//-------------------------------------------------------------------
// SELECTION/COPY
//-------------------------------------------------------------------

App.Suites.Select = function(o)
{
	var self = this;

	self.project_id = o.project_id;
	self.suite_id = o.suite_id;
	self.section_id = null; // The currently selected section
	self.columns = o.columns; // The custom column selection, if any
	self.columns_custom = o.columns_custom;
	self.column_area_id = o.column_area_id;
	self.filters = o.filters; // The filter selection
	self.splitter1 = null;
	self.case_ids = o.case_ids;
	self.outline = [];
	self.selection = []; // For tracking the selection state
	self.dialog = $('#selectCasesDialog');
	self.is_dynamic = o.is_dynamic;

	self.open = function()
	{
		// If the user uses a different column definition than the
		// standard App.Tables column definition, we set it here.
		if (self.columns_custom)
		{
			App.Tables.pushColumns(self.columns);
		}

		$('#selectCasesContent').html(''); // Speeds up subsequent loads
		$('#selectCasesContent').hide();
		$('#selectCasesProgress').hide();

		$('#selectCasesClose').unbind('click');
		$('#selectCasesClose').bind('click', function(e)
		{
			self.close();
		});

		App.Dialogs.open({
			minWidth: 750,
			minHeight: 550,
			resizable: true,
			resizeStop: self._dialogResized,
			selector: '#selectCasesDialog'
		});

		// Load the cases/sections and sidebar filter into the dialog.
		if (self.suite_id)
		{
			self._load();
		}

		$('.searchable').each(function(ix, v) {
			var dropdown = $(v);
			// Apply the chosen control
			dropdown.chosen();
		});
	}

	self.close = function()
	{
		// Restore the original column definition if needed.
		if (self.columns_custom)
		{
			App.Tables.popColumns();
		}

		App.Dialogs.closeTop();
	}

	self.load = function(suite_id, callbacks)
	{
		self.suite_id = suite_id;
		self.case_ids = [];
		self._load(callbacks);
	}

	self.getSelection = function()
	{
		return {
			outline: self.selection,
			section_ids: self._getSelectedSections(),
			case_ids: self._getSelectedCases()
		};
	}

	self._getSelectedCases = function(section_id)
	{
		var section_ids = null;
		if (section_id)
		{
			section_ids = [section_id];
		}
		else
		{
			section_ids = Object.keys(self.selection);
		}

		// Simply collect and return the case IDs for the given/all
		// sections using our internal selection tracking.
		var selection = [];
		$.each(section_ids, function(ix, section_id)
		{
			if (self.selection[section_id])
			{
				selection = selection.concat(
					Object.keys(
						self.selection[section_id]
					)
				);
			}
		});

		return selection;
	}

	self._getSelectedSections = function()
	{
		// Simply collect and return all section IDs with a checkbox
		// in checked or indeterminate state.
		var selection = [];
		$('#selectCasesTree li input').each(
			function()
			{
				if (this.checked || this.indeterminate)
				{
					selection.push($(this).attr('rel'));
				}
			}
		);

		return selection;
	}

	self._load = function(callbacks)
	{
		var container = $('#selectCasesContent');
		var busy = $('#selectCasesProgress');
		var height = self.dialog.find('.dialog-body').outerHeight();

		// Adjust the height of the progress div and show it
		busy.css('padding-top', Math.round((height / 2) - 60) + 'px');
		busy.show();

		container.hide();

		App.Ajax.call(
		{
			target: '/suites/ajax_render_select',
			arguments: self._getGridArguments(
				{
					suite_id: self.suite_id,
					case_ids: self.case_ids,
					filters: self.filters
				}
			),

			stop: function()
			{
				busy.hide();
			},

			success: function(html)
			{
				self._show(html);

				// The outline/selection variables were part of the
				// HTML, not nice but works. We make sure to store it
				// here for our selection tracking etc.
				self.outline = outline;
				self.selection = selection;

				self._init();
				if (callbacks)
				{
					callbacks.success();
				}

				let $dropDownLinkObject = $('.select-dialog-filter-buttons .button-droppie.button-left.dropdownLink');
				if (($('#include_dynamic').val() === '1' || self.is_dynamic) && $dropDownLinkObject.length > 0) {
					$dropDownLinkObject.hide();
				}
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self._show = function(html)
	{
		var container = $('#selectCasesContent');
		container.html(html);
		container.show();
	}

	self._init = function()
	{
		self._bind();

		self._applyTree();
		if (self.case_ids)
		{
			self._applySelection();
		}

		self.splitter1 = new App.Suites.Select.Splitter(
		{
			splitter: '#selectCasesSplitter1',
			container: '#selectCasesTree',
			neighbor: '#selectCasesMain',
			orientation: 'right',
			min: 250,
			max: 500,
			resized: self._splitterResized
		});
	}

	self._bind = function()
	{
		self._bindPagination();
		self._bindColumns();
		self._bindFilter();
		self._bindSelection();
	}

	self._bindPagination = function()
	{
		// Whenever a pagination link is clicked, we reload/load the
		// cases of the current section with the requested offset.
		$('#selectCasesGroup').off('.pagination').on({
			'click.pagination': function()
			{
				var offset = $(this).attr('rel');
				self._loadGroup(self.section_id, offset);
			}},
			'a.pagination-link'
		);
	}

	self._bindSelection = function()
	{
		// Whenever a checkbox in the tree changes, we may need to
		// update the parent/child checkboxes and also the grid (see
		// click event).
		$('#selectCasesSections input').unbind('change').change(
			function()
			{
				var container = $(this).parent();

				// If the state is not indeterminate, we make sure to
				// apply the checked/unchecked state to all childs and
				// update the parents accordingly.
				if (!this.indeterminate)
				{
					container.find('input').prop(
					{
						indeterminate: false,
						checked: this.checked
					});

					self._syncSelectionForSection(
						container,
						this.checked
					);
				}
				else
				{
					// Simply propagate indeterminate to all parents.
					container.parents("li").children('input').prop(
					{
						indeterminate: true,
						checked: false
					});
				}
			}
		);

		$('#selectCasesSections input').unbind('click').click(
			function()
			{
				var checked = this.checked;

				// Set/unset the internal selection for the section +
				// childs. Also make sure to check/uncheck the current
				// group/grid if needed.
				$('input', $(this).parent()).each(
					function()
					{
						var section_id = $(this).attr('rel');
						self._setSelectionForSection(section_id,
							checked);
						self._syncSelectionCounter(section_id);

						if (section_id == self.section_id)
						{
							self._checkGrid(checked);
						}
					}
				);
			}
		);

		// Whenever a test case or the entire table changes, we need
		// to highlight/clear the case row/rows, update the checkbox
		// of the related section (and possible parent sections) in
		// the tree and also make sure to keep the internal selection
		// in sync.
		var group = $('#selectCasesGroup');
		group.off('.selection').on({
			'click.selection': function()
			{
				var checked = this.checked;

				var all = $(this).attr('rel');
				if (all)
				{
					self._checkGrid(this.checked);
					$('td.checkbox input', group).each(
						function()
						{
							self._setSelectionForCase(
								self.section_id,
								$(this).val(),
								checked
							);
						}
					);
				}
				else
				{
					App.Tables.onRowClick(this);
					self._setSelectionForCase(
						self.section_id,
						$(this).val(),
						checked
					);
				}

				self._syncSelectionForCases(self.section_id, true);
			}},
			'th.checkbox input, td.checkbox input'
		);

		// We also need to bind the events for the Select All | None
		// links. We start with the toolbar links for the group which
		// check/uncheck the entire section (note: not just the table).
		$('#selectCasesGroupAll').unbind('click').click(
			function()
			{
				self._checkGroup(true);
			}
		);

		$('#selectCasesGroupNone').unbind('click').click(
			function()
			{
				self._checkGroup(false);
			}
		);

		// And then also handle Select All | None links for the tree.
		// They check/uncheck all sections of the suite.
		$('#selectCasesTreeAll').unbind('click').click(
			function()
			{
				self._checkTree(true);
			}
		);

		$('#selectCasesTreeNone').unbind('click').click(
			function()
			{
				self._checkTree(false);
			}
		);
	}

	self._setSelectionForSection = function(section_id, checked)
	{
		delete self.selection[section_id];

		if (!checked)
		{
			return;
		}

		// If the outline contains any cases for the given section,
		// we add all case IDs to our internal selection.
		if (self.outline[section_id])
		{
			self.selection[section_id] = {};
			$.each(
				self.outline[section_id],
				function(ix, case_id)
				{
					self.selection[section_id][case_id] = true;
				}
			);
		}
	}

	self._setSelectionForCase = function(section_id, case_id, checked)
	{
		if (checked)
		{
			if (!self.selection[section_id])
			{
				self.selection[section_id] = {};
			}

			self.selection[section_id][case_id] = true;
		}
		else
		{
			if (self.selection[section_id])
			{
				delete self.selection[section_id][case_id];

				// Make sure to delete the section from the selection
				// again if there are no cases left. Important for
				// other checks/functions (such as _hasNoneSelected).
				if ($.isEmptyObject(self.selection[section_id]))
				{
					delete self.selection[section_id];
				}
			}
		}
	}

	self._syncSelectionForSection = function(section, checked)
	{
		var parent = section.parent().parent(); // The parent <li>
		if (!parent.is('li.section'))
		{
			return; // No longer an element in the tree
		}

		// Check if all siblings have the same checked state as the
		// given node.
		var all = true;
		section.siblings().each(
			function()
			{
				var checkbox = $(this).children('input').get(0);
				if (checkbox.checked !== checked ||
					checkbox.indeterminate)
				{
					all = false;
					return false;
				}
			}
		);

		var indeterminate = false;
		var parent_id = parent.attr('rel');

		if (all && checked)
		{
			// The node itself and all siblings are checked. If all
			// test cases are checked for this parent, we can check
			// the parent as well. We use indeterminate otherwise.
			if (self._hasAllSelected(parent_id))
			{
				parent.children('input').prop(
				{
					indeterminate: false,
					checked: true
				});

				self._syncSelectionForSection(parent, checked);
			}
			else
			{
				indeterminate = true;
			}
		}
		else if (all && !checked)
		{
			// The node itself and all siblings are unchecked. We can
			// only set the parent to unchecked if no test cases are
			// selected in this section (and indeterminate otherwise).
			if (self._hasNoneSelected(parent_id))
			{
				parent.children('input').prop(
				{
					checked: false,
					indeterminate: false
				});

				self._syncSelectionForSection(parent, checked);
			}
			else
			{
				indeterminate = true;
			}
		}
		else
		{
			// Not all childs are checked/unchecked and we simply set
			// the parent to indeterminate.
			indeterminate = true;
		}

		if (indeterminate)
		{
			// Since the parent requires the indeterminate state, we
			// can simply all parents to indeterminate and can stop
			// going up further in the chain.
			section.parents('li').children('input').prop(
			{
				indeterminate: true,
				checked: false
			});
		}
	}

	self._hasAllSelected = function(section_id)
	{
		if (self.selection[section_id] && self.outline[section_id])
		{
			var case_ids =
				Object.keys(self.selection[section_id]);

			if (case_ids.length == self.outline[section_id].length)
			{
				return true;
			}
		}

		return false;
	}

	self._hasNoneSelected = function(section_id)
	{
		return self.selection[section_id] ? false : true;
	}

	self._syncSelectionForCases = function(section_id, update_parents)
	{
		var section = $('#selectCasesNode-' + section_id);

		// Check if all cases are selected. If so, check if all sub-
		// sections are selected as well.
		var all = self._hasAllSelected(section_id);
		if (all)
		{
			$('ul input', section).each(
				function()
				{
					if (!this.checked)
					{
						all = false;
						return false;
					}
				}
			);
		}

		// Check if no cases are selected. If so, check if at least
		// one subsection is selected/indeterminate.
		var none = self._hasNoneSelected(section_id);
		if (none)
		{
			$('ul input', section).each(
				function()
				{
					if (this.checked || this.indeterminate)
					{
						none = false;
						return false;
					}
				}
			);
		}

		// And finally update the state of the current section in the
		// sidebar based on all/none. This includes both the checkbox
		// and the counter stats.
		var checkbox = section.children('input');
		if (all)
		{
			checkbox.prop(
			{
				checked: true,
				indeterminate: false
			});
		}
		else if (none)
		{
			checkbox.prop(
			{
				checked: false,
				indeterminate: false
			});
		}
		else
		{
			checkbox.prop(
			{
				checked: false,
				indeterminate: true
			});
		}

		self._syncSelectionCounter(section_id);

		// If requested, make sure to keep the parents in sync as well
		// by triggering a change event (which then bubbles up, see
		// the 'change' event handler in bindSelection etc.).
		if (update_parents)
		{
			checkbox.trigger('change');
		}
	}

	self._syncSelectionCounter = function(section_id)
	{
		var count = $('#selectCasesCount-' + section_id);

		// Synchronize the count for the given section based on the
		// current selection state. We only show the count if > 0 and
		// hide it otherwise.
		if (self.selection[section_id]) {
			count.text(
				'(' +
				Object.keys(self.selection[section_id]).length
				+ ')'
			).show();
		} else {
			count.hide();
		}
	}

	self._bindColumns = function()
	{
		// The button for changing the column selection for the grid.
		$('#selectCasesColumns').unbind('click').click(
			function()
			{
				self._selectColumns();
			}
		);
	}

	self._bindFilter = function()
	{
		// The filter buttons and dropdown links in the sidebar on the
		// right.
		var filters = $('#selectCasesFilterApply').
			add('#selectCasesFilterSet').
			add('#selectCasesFilterAdd').
			add('#selectCasesFilterRemove');

		filters.unbind('click').click(
			function()
			{
				var mode = parseInt($(this).attr('rel'));
				self._filter(mode);
			}
		);
	}

	self._filter = function(mode)
	{
		var filters = App.Filters.getAll($('#selectCasesFilter'));

		App.Ajax.call(
		{
			target: '/suites/ajax_filter_cases',

			arguments: {
				suite_id: self.suite_id,
				filters: filters
			},

			start: function()
			{
				$('#selectCasesFilterApply').addClass('button-busy');
			},

			stop: function()
			{
				$('#selectCasesFilterApply').removeClass('button-busy');
			},

			success: function(data)
			{
				self.filters = filters; // Save for later
				$('#selectCasesMatches').html(data.matches).show();
				self._filterApply(data.selection, mode);
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self._filterApply = function(selection, mode)
	{
		switch (mode)
		{
			case 1:
				self.selection = selection;
				break;
			case 2:
				self._filterMerge(selection, true);
				break;
			case 3:
				self._filterMerge(selection, false);
				break;
		}

		if (self.selection[self.section_id])
		{
			App.Tables.setCheckboxesById(
				$('#selectCasesGroup'),
				Object.keys(
					self.selection[self.section_id]
				)
			);
		}
		else
		{
			self._checkGrid(false);
		}

		self._applySelection(); // Sync the checkboxes of the sections
	}

	self._filterMerge = function(selection, checked)
	{
		// Simply iterate through all sections/cases of the result and
		// check/uncheck each test case (i.e., add/remove from the
		// selection).
		$.each(selection, function(section_id, case_ids)
		{
			$.each(case_ids, function(case_id, ignored)
			{
				self._setSelectionForCase(
					section_id,
					case_id,
					checked
				);
			});
		});
	}

	self._checkGrid = function(checked)
	{
		App.Tables.setCheckboxes($('#selectCasesGroup'), checked);
	}

	self._checkGroup = function(checked)
	{
		self._checkGrid(checked);
		self._setSelectionForSection(self.section_id, checked);
		self._syncSelectionForCases(self.section_id, true);
	}

	self._checkTree = function(checked)
	{
		// For each section, we check/uncheck the checkbox, update the
		// internal selection and then sync the selection count.
		$('#selectCasesTree li').each(
			function(ix, v)
			{
				var section_id = $(this).attr('rel');

				$(this).children('input').prop(
				{
					checked: checked,
					indeterminate: false
				});

				self._setSelectionForSection(section_id, checked);
				self._syncSelectionCounter(section_id);
			}
		);

		// The last step is to check/uncheck the grid with the cases.
		self._checkGrid(checked);
	}

	self._dialogResized = function(event, ui)
	{
		App.Ajax.call(
		{
			target: '/suites/ajax_save_select_dialog_size',
			blockUI: false,

			arguments: {
				width: Math.round(ui.size.width),
				height: Math.round(ui.size.height)
			}
		});
	}

	self._splitterResized = function(o)
	{
		// After a splitter was resized, we update the min width of
		// the dialog. We want a minimum width for the column in the
		// middle and enforce this with the min width for the entire
		// dialog.
		var minWidth =
			$('#selectCasesTree').width() +
			parseInt($('#selectCasesMain').attr('min-width')) +
			$('#selectCasesFilter').width() +
			10 +   // Splitter
			24 +   // Left/right dialog padding
			2;     // Left/right dialog border

		// Make sure not to exceed the current width of the dialog.
		minWidth = Math.min(minWidth, self.dialog.outerWidth());

		App.Dialogs.setOption(
			'#selectCasesDialog',
			'minWidth',
			minWidth
		);

		// The last step is to save the new width in the user prefs.
		App.Ajax.call(
		{
			target: '/suites/ajax_save_select_splitter_width',
			blockUI: false,

			arguments: {
				name: o.splitter.attr('name'),
				width: Math.round(
					o.container.width()
				)
			}
		});
	}

	self._getGridArguments = function(o)
	{
		// Besides the given arguments, we also include the column
		// definition for the grids.
		return $.extend({
				columns: App.Tables.columns_for_user
			}, o
		);
	}

	self._applySelection = function()
	{
		// Apply the current internal case selection to the section
		// tree. We need to do this in reverse order in order to take
		// into account possible parent/child relationships.
		$($('#selectCasesSections li').get().reverse()).each(
			function()
			{
				self._syncSelectionForCases(
					$(this).attr('rel'),
					false
				);
			}
		);
	}

	self._applyTree = function()
	{
		var initially_select = [];

		// Select the first section in the tree, if any,
		var group0 = $('#selectCasesSections').find('li:first');
		if (group0.length > 0)
		{
			self.section_id = $(group0).attr('rel');
			initially_select = ['#' + group0.attr('id')];
		}

		$('#selectCasesSections').jstree({
			core: {
				animation: 0,
				html_titles: true
			},
			ui: {
				select_limit: 1,
				selected_parent_close: false,
				select_prev_on_delete: false,
				initially_select: initially_select
			},
			plugins: ['themes', 'ui', 'html_data']
		}).
		bind('select_node.jstree', function(e, data)
		{
			self._selectGroup(self._getTreeNodeID(data));
		});
	}

	self._getTreeNodeID = function(data)
	{
		var args = data.args;
		var node = data.inst._get_node(args[0]);
		return node.attr('rel');
	}

	self._selectGroup = function(section_id)
	{
		if (section_id != self.section_id)
		{
			self._loadGroup(section_id, 0);
		}
	}

	self._loadGroup = function(section_id, offset, callbacks)
	{
		var node = $('#selectCasesNode-' + section_id);
		var a = node.children('a');
		a.addClass('jstree-loading');

		App.Ajax.call(
		{
			target: '/suites/ajax_render_select_group',

			arguments: self._getGridArguments(
				{
					suite_id: self.suite_id,
					section_id: section_id,
					case_ids: self._getSelectedCases(section_id),
					offset: offset
				}
			),

			stop: function()
			{
				a.removeClass('jstree-loading');
			},

			success: function(html)
			{
				self.section_id = section_id; // Save for later
				$('#selectCasesGroup').html(html);

				// The outline/selection variables were part of the
				// HTML, not nice but works. We make sure to store it
				// here for our selection tracking etc. Note: we only
				// update the selection of the current section.
				self.outline = outline;
				if (selection[section_id])
				{
					self.selection[section_id] =
						selection[section_id];
				}
				else
				{
					delete self.selection[section_id];
				}

				// Also make sure to keep the checkboxes for the tree
				// in sync and update the parent nodes, if needed.
				self._syncSelectionForCases(section_id, true);

				if (callbacks)
				{
					callbacks.success()
				}
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self._selectColumns = function()
	{
		App.Tables.selectColumns(
		{
			project_id: self.project_id,
			area_id: self.column_area_id,
			container: '#selectCasesGroupContainer',

			submit: function(callbacks)
			{
				// Make sure to reload the currently selected section
				// after updating the columns. The callback is used
				// to reduce the container min width if the combined
				// column size was reduced.
				self._loadGroup(
					self.section_id,
					0, // No offset
					callbacks
				);
			}
		});
	}
}

//-------------------------------------------------------------------
// SELECTION/COPY (SPLITTER)
//-------------------------------------------------------------------

App.Suites.Select.Splitter = function(o)
{
	var self = this;

	self.min = o.min;
	self.max = o.max;
	self.pos = null;
	self.offset = null;
	self.splitter = $(o.splitter);
	self.container = $(o.container);
	self.neighbor = $(o.neighbor);
	self.orientation = o.orientation;
	self.document = $(document);
	self.resized = o.resized;

	self._resizeStart = function(e)
	{
		self.pos = self._getResizePosition(e);
		self.width = self.container.width();
		self.offset = self.width;
		self.document.bind('mousemove.select', self._resize);
		self.document.bind('mouseup.select', self._resizeStop);
		self._resizeShowProgress();
		return false;
	}

	self._resizeShowProgress = function()
	{
		$('body').css('cursor', 'ew-resize');
		if (self.orientation == 'left')
		{
			$(self.splitter).addClass(
				'select-dialog-splitter-left-resizing');
		}
		else
		{
			$(self.splitter).addClass(
				'select-dialog-splitter-right-resizing');
		}
	}

	self._resize = function(e)
	{
		var diff = self.pos - self._getResizePosition(e);
		if (self.orientation == 'right')
		{
			diff = -diff;
		}

		var width = self.offset + diff;
		width = Math.min(Math.max(width, self.min), self.max);

		// In case the direct neighbor (middle column) has already
		// reached a certain threshold, we can only allow to make the
		// column smaller. Also, we make sure that the desired width
		// of the neighbor is not exceeded.

		var can_update = true;

		if (width > self.width)
		{
			var neighbor_max_diff = self.neighbor.width() -
				parseInt(self.neighbor.attr('min-width'));

			if (neighbor_max_diff > 0)
			{
				// Only allow to increase the width by the maximum
				// possible value to decrease the width of the middle
				// column.
				if (width > self.width + neighbor_max_diff)
				{
					width = self.width + neighbor_max_diff;
				}
			}
			else
			{
				can_update = false; // Neighbor limit reached
			}
		}

		if (can_update)
		{
			self.container.width(width);
			self.neighbor.css('margin-left', width + 'px');
			self.width = width;
		}

		return false;
	}

	self._resizeStop = function(e)
	{
		self.document.unbind('.select');
		self._resizeHideProgress();
		self.resized(self);
		return false;
	}

	self._resizeHideProgress = function()
	{
		$('body').css('cursor', '');
		self.splitter.removeClass(
			'select-dialog-splitter-left-resizing');
		self.splitter.removeClass(
			'select-dialog-splitter-right-resizing');
	}

	self._getResizePosition = function(e)
	{
		return e.clientX;
	}

	self.splitter.bind('mousedown.select', self._resizeStart);
}

App.Suites.changePage = function (suite_id, offset) {
	App.Ajax.call(
		{
			target: '/suites/ajax_change_page',

			arguments:
			{
				suite_id: suite_id,
				offset: offset
			},

			success: function(html)
			{
				$('#active-table').html(html);
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
}

App.Suites.overviewChangePage = function(offset, project_id)
{
	App.Ajax.call(
		{
			target: '/suites/overview_change_page',

			arguments: {
				project_id: project_id,
				offset: offset
			},

			success: function(html)
			{
				$('#content-inner').html(html);
			},

			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
}

;

