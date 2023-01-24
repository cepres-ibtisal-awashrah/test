/**********************************************************************************************/
/* Milestones  */

/* [Permissions checked!] */
App.Milestones = new function()
{
	var self = this;
	self.attachmentsCode = {};

	self.loadActivities = function(milestone_id, offset)
	{
		let status_id = $('#status_id').val();
		$('#activitiesPaginationBusy').show();
		
		App.Ajax.call(
		{
			target: '/milestones/ajax_render_activities',
			
			arguments: 
			{
				milestone_id: milestone_id,
				status_id: status_id,
				offset: offset
			},
			
			success: function(data)
			{
				$('#activities').html(data.activities);
				$('#activitiesPagination').html(data.pagination);
				$('#activitiesPaginationBusy').hide();
			},
			
			error: function(data)
			{
				$('#activitiesPaginationBusy').hide();
				App.Ajax.handleError(data);
			}
		});
	}

	self.loadCompleted = function(project_id, offset)
	{
		$('#completedPaginationBusy').show();
		
		App.Ajax.call(
		{
			target: '/milestones/ajax_render_completed',
			
			arguments: 
			{
				project_id: project_id,
				offset: offset
			},
			
			success: function(data)
			{
				$('#completed').html(data.milestones);
				$('#completedPagination').html(data.pagination);
				$('#completedPaginationBusy').hide();
			},
			
			error: function(data)
			{
				$('#completedPaginationBusy').hide();
				App.Ajax.handleError(data);
			}
		});
	}

	self.loadCompletedRuns = function(milestone_id)
	{
		$('#showCompleted .showAll').hide();
		$('#showCompleted .busy').show();
		
		App.Ajax.call(
		{
			target: '/milestones/ajax_render_completed_runs',
			
			arguments: 
			{
				milestone_id: milestone_id
			},
			
			success: function(html)
			{
				$('#showCompleted .busy').hide();
				$('#completed').html(html);
			},
			
			error: function(data)
			{
				$('#showCompleted .busy').hide();
				App.Ajax.handleError(data);
			}
		});
	}

	self.selectActivityDays = function(milestone_id)
	{
		App.Charts.selectTimeframe(
		{
			success: function(days)
			{
				App.Ajax.call(
				{
					target: '/milestones/ajax_render_activity_chart',

					arguments: {
						milestone_id: milestone_id,
						days: days
					},
					
					success: function(html)
					{
						App.Dialogs.closeTop();
						App.Charts.reload(
							App.Charts.activity,
							'#activityContainer',
							html
						);
					},
					
					error: function(data)
					{
						App.Ajax.handleError(data);
					}
				});
			}
		});
	}

	self.toggleSubs = function(milestone_id)
	{
		var milestone = $('#milestone-' + milestone_id);
		var subs = $('#milestonesubs-' + milestone_id);

		if (subs.hasClass('loaded'))
		{
			App.Effects.hide(subs);
			$('.expand', milestone).show();
			$('.collapse', milestone).hide();
			subs.removeClass('loaded');
		}
		else
		{
			// Check if we already got the details from the server. If
			// so, we simply expand the view, otherwise we load it.
			if ($('.subs', subs).length > 0)
			{
				$('.expand', milestone).hide();
				$('.collapse', milestone).show();
				App.Effects.show(subs);
				subs.addClass('loaded');
			}
			else
			{
				self._loadSubs(
				{
					milestone_id: milestone_id,

					success: function(html)
					{
						$('.expand', milestone).hide();
						$('.collapse', milestone).show();
						$('.details', subs).html(html);
						App.Effects.show(subs);
						subs.addClass('loaded');
					}
				});
			}
		}
	}

	self._loadSubs = function(o)
	{
		var milestone = $('#milestone-' + o.milestone_id);

		var signalBusy = function(busy)
		{
			if (busy)
			{
			}
			else
			{
				$(selector + ' .buttons').show();
				$(selector + ' .busy').hide();
			}
		};
		
		$('.buttons', milestone).hide();
		$('.busy', milestone).show();

		App.Ajax.call(
		{
			target: 'milestones/ajax_get_subs',
			
			arguments: 
			{
				milestone_id: o.milestone_id
			},

			stop: function()
			{
				$('.busy', milestone).hide();
				$('.buttons', milestone).show();
			},
			
			success: function(html)
			{
				o.success(html);
			},
			
			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	//---------------------------------------------------------------
	// STARTING
	//---------------------------------------------------------------

	self.start = function(milestone_id)
	{
		self._startInit(
		{
			milestone_id: milestone_id,
			success: function(html)
			{
				$('#startMilestoneControls').html(html);

				self._startDialog(
				{
					submit: function(start_on, due_on)
					{
						self._start(
						{
							milestone_id: milestone_id,
							start_on: start_on,
							due_on: due_on
						});
					}
				});
			}
		});
	}	

	self._startInit = function(o)
	{
		var link = $('#startMilestone-' + o.milestone_id);
		var busy = $('#startMilestoneBusy-' + o.milestone_id);
		
		link.hide();
		busy.show();

		App.Ajax.call(
		{
			target: '/milestones/ajax_render_start_dialog',
			
			arguments: 
			{
				milestone_id: o.milestone_id
			},

			stop: function()
			{
				busy.hide();
				link.show();
			},
			
			success: function(html)
			{
				o.success(html);
			},
			
			error: function(data) 
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self._startDialog = function(o)
	{
		App.Validation.hideErrors();

		// Initialize the dialog
		$('#startMilestoneForm').unbind('submit');	
		$('#startMilestoneForm').submit(function(e)
		{
			App.Validation.hideErrors();
			
			o.submit(
				$('#startMilestoneStartOn').val(),
				$('#startMilestoneDueOn').val()
			);

			return false;
		});
		
		App.Dialogs.open(
		{
			selector: '#startMilestoneDialog',
			autoFocus: false
		});

		$('#startMilestoneStartOn').blur();
		$('#startMilestoneStartOn').datepicker(
		{
			duration: 0,
			showAnim: ''
		});

		$('#startMilestoneDueOn').datepicker(
		{
			duration: 0,
			showAnim: ''
		});
	}

	self._start = function(o)
	{
		$('#startMilestoneSubmit').addClass('button-busy');
		
		App.Ajax.call(
		{
			target: '/milestones/ajax_start',
			
			arguments: 
			{
				milestone_id: o.milestone_id,
				start_on: o.start_on,
				due_on: o.due_on
			},

			stop: function()
			{
				$('#startMilestoneSubmit').removeClass('button-busy');
			},
			
			success: function()
			{
				location.reload();
			},
			
			error: function(data)
			{
				App.Ajax.handleError(data, '#startMilestoneErrors');
			}
		});
	}

	//---------------------------------------------------------------
	// EXPORT (CSV/Excel)
	//---------------------------------------------------------------

	self.exportTestsCsv = function(milestone_id)
	{
		self._exportTests(milestone_id, 'csv');
	}

	self.exportTestsExcel = function(milestone_id)
	{
		self._exportTests(milestone_id, 'excel');
	}

	self._exportTests = function(milestone_id, format)
	{
		var dialog = new App.ExportCsv(
		{
			format: format
		});

		dialog.open();
	}	

	//---------------------------------------------------------------
	// DEFECTS
	//---------------------------------------------------------------

	self.loadDefects = function(milestone_id, offset)
	{
		$('#defectsPaginationBusy').show();
		
		App.Ajax.call(
		{
			target: '/milestones/ajax_render_defects',
			
			arguments: 
			{
				milestone_id: milestone_id,
				offset: offset
			},

			stop: function()
			{
				$('#defectsPaginationBusy').hide();
			},
			
			success: function(data)
			{
				$('#defects').html(data.defects);
				$('#defectsPagination').html(data.pagination);
				$('#defectsPaginationBusy').hide();
			},
			
			error: function(data)
			{
				App.Ajax.handleError(data);
			}
		});
	}

	self.setMilestonePrintViewChange = function(viewType, c, message) {
		if (c > 300 && viewType === 'details') {
			App.Dialogs.confirm(message, function() {
				$('#groupContainer').append('<div class="loader"></div>');
				self._showMilestoneGroups({
					group_id: null,
					format: viewType,
				});
			});
		} else {
			self._showMilestoneGroups({
				group_id: null,
				format: viewType,
			});
		}
	}

    self.setMilestoneGrouping = function(column, show_progress) {
		App.Tables.setGrouping(column);

        if (show_progress) {
            $('#groupContainer').append('<div class="loader"></div>');
            $('#orderByChange').hide();
            $('#orderBy .busy').show();
		}

        self._showMilestoneGroups({
            group_id: null,
            error: function() {
                $('#orderBy .busy').hide();
                $('#orderByChange').show();
            }
        });
	}

    self._showMilestoneGroups = function(o) {
        var defaults = {
            milestone_id: self.milestone_id,
            display: self.display,
			group_id: self.group_id,
			format: $('#formatSelection').val()
        };

		var s = $.extend(defaults, o);

		App.Ajax.call(
        {
            target: '/milestones/ajax_render_milestones',
			blockUI: false,
            arguments: self._getGridArguments(s),
            success: function(html) {
                self._injectMilestones(html);
                self._syncToolbar();
            },
            error: function(data) {
                App.Ajax.handleError(data);
            }
        });
	}

    self._getGridArguments = function(o) {
        // Besides the given arguments, we also include the column
        return $.extend({
                group_order: App.Tables.group_order,
                filters: self.filters
            }, o
        );
	}

    self._injectMilestones = function(html) {
        $('#msGroupContent').remove();
        $('#ajaxResponse').html(html);
        $('#msGroupContent').appendTo('#msGroupContainer');
	}

    self._syncToolbar = function() {

        // Reset the global order-by link and update the order-by name,
        $('#orderBy .busy').hide();
        $('#orderByChange').removeClass('link link-dashed nolink');

		if (App.Tables.group_by === '') {
            $('#orderByChange, #orderByEmpty, #addSection').show();
            $('#orderByAsc, #orderByDesc, #orderByReset').hide();
            $('#orderByName, #filterCasesReset, #addSectionDisabled').hide();
            $('#orderByChange').addClass('link link-dashed');

			if (self.filters) {
                $('#filterByReset').removeClass('hidden');
            }
        } else {
            if (App.Tables.group_order !== '') {
                if (App.Tables.group_order == 'desc') {
                    $('#orderByAsc').hide();
                    $('#orderByDesc').show();
                } else {
                    $('#orderByDesc').hide();
                    $('#orderByAsc').show();
                }
            }

			if (App.Tables.group_by !== '') {
                $('#addSection').hide();
                $('#addSectionDisabled').show();
                $('#orderByChange').addClass('nolink');
                $('#orderByName').text(
                    App.Tables.getRunsColumnName(App.Tables.group_by)
                );
                $('#orderByEmpty').hide();
                $('#orderByReset, #orderByChange').show();
                $('#orderByName').show();
			}

            if (self.filters) {
                $('#filterByReset').removeClass('hidden');
            }
        }
	}

    self._createFilter = function(e) {
        return new App.Milestones.Filter({
            event: e,
            milestone_id: self.milestone_id,
            filters: self.filters,
            save_filters: true,
            changed: function(filters) {
                $('#groupContainer').append('<div class="loader"></div>');
                self.filters = filters;
            }
        });
	}

    self.filterMilestones = function(e) {
        var filter = self._createFilter(e);
        filter.open();
	}

    self.filterMilestonesReset = function() {
        var filter = self._createFilter();
        filter.reset();
    }
	self.BulkDelete = function (entity) {
		App.Dialogs.BulkDeleteDialog();
		App.Bulk.deleteBulk(
			'milestones',
			$('.dialog-action-default'),
			'/milestones/ajax_delete_by_id'
		);
	}

	self.removeMilestone = function(milestone_id) {
		var $row = $('#milestone-' + milestone_id);
		$('.deleteLink', $row).hide();
		$('.deleteBusy', $row).show();

		App.Ajax.call(
			{
				target: '/milestones/ajax_delete_by_id',

				arguments:
					{
						ids: [milestone_id]
					},
				success: function(data) {
					$row.remove();
					App.Bulk.redirectSuccess(data.message);
				},
				error: function(data) {
					$('.deleteBusy', $row).hide();
					$('.deleteLink', $row).show();
					App.Ajax.handleError(data);
				}
			});
	};
}

//-------------------------------------
// FILTERING
//-------------------------------------
App.Milestones.Filter = function(o) {
	var self = this;

    self.milestone_id = o.milestone_id;
    self.filters = o.filters;
    self.changed = o.changed;
	self.event = o.event;

    self.open = function(e) {
        var bubble = $('#filterByChange').bubble({
            bubble: '#filterMilestonesBubble',
            toggleEvent: 'null'
        });

		self._load({
            show: function() {
                self._bind({
                    bubble: bubble
                });
                bubble.show(self.event);
            }
        });
    }

	self._load = function(o) {
        var busy = $('#filterBy .busy');

		App.Ajax.call(
        {
            target: '/milestones/ajax_render_milestones_filter',
            arguments: {
                milestone_id: self.milestone_id,
                filters: self.filters
            },
            start: function() {
                $('#filterByChange').hide();
                busy.show();
            },
            stop: function() {
                busy.hide();
                $('#filterByChange').show();
            },
            success: function(html) {
                $('#filterMilestonesContent').html(html);
                o.show();
            },
            error: function(data) {
                App.Ajax.handleError(data);
            }
        });
    }

	self._bind = function(o) {
        $('#filterMilestonesApply').click(function() {
                self._apply(o);
                return false;
            }
        );

		$('#filterMilestonesCancel').click(function() {
                self._cancel(o);
                return false;
            }
        );
    }

	self._apply = function(o) {
        var filters = App.Filters.getAll($('#filterMilestonesContent'));
        App.Ajax.call(
        {
            target: '/milestones/ajax_render_milestone_filter_info',
            arguments: {
                milestone_id: self.milestone_id,
                filters: filters,
                save_filters: self.save_filters
            },
            start: function() {
                $('#filterCasesApply').addClass('button-busy');
            },
            stop: function(){
                $('#filterCasesApply').removeClass('button-busy');
            },
            success: function(html) {
                self._sync(filters, html);
                self._changed();
                App.Milestones._showMilestoneGroups();
                o.bubble.hide();
            },
            error: function(data) {
                App.Ajax.handleError(data);
            }
        });
    }

	self._sync = function(filters, info) {
        $('#filterByInfo').hide();
        $('#filterByEmpty').hide();
        $('#filterByChange').removeClass('link link-dashed nolink');

		info = $.trim(info);
		if (info)  {
            $('#filterByChange').addClass('nolink');
            $('#filterByInfo').html(info);
            $('#filterByInfo, #filterByReset').show();
            $('#filterByReset').removeClass('hidden');
            self.filters = filters;
        } else {
            $('#filterByReset').hide();
            $('#filterByChange').addClass('link link-dashed');
            $('#filterByEmpty').show();
            self.filters = null;
        }
    }

	self._changed = function() {
        self.changed(self.filters);
    }

	self._cancel = function(o) {
        o.bubble.hide();
	}

    self.reset = function() {
        App.Ajax.call(
        {
            target: '/milestones/ajax_render_milestone_filter_info',
            arguments: {
                milestone_id: self.milestone_id,
                filters: null,
                save_filters: self.save_filters
            },
            start: function() {
                $('#filterByChange').hide();
                $('#filterBy .busy').show();
            },
            stop: function() {
                $('#filterBy .busy').hide();
                $('#filterByChange').show();
            },
            success: function(html) {
                self._sync(null, '');
                self._changed();
                App.Milestones._showMilestoneGroups();
            },
            error: function(data) {
                App.Ajax.handleError(data);
            }
        });
    }
}

;

