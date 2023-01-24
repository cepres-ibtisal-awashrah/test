/*******************************************************************/
/* Todos */

App.Todos = new function()
{
	var self = this;

	// Fields for keeping the current state (grouping options etc.)
	self.runs_by = null;
	self.runs_by_options = null;
	self.status_options = null;
	self.user_ids = null;
	self.status_ids = null;
	self.milestone_id = null;
	self.milestones = null;
	self.include_unassigned = false;
	self.currentMode = 'run';

	//---------------------------------------------------------------
	// FILTERS & RUN GROUPING
	//---------------------------------------------------------------

	self.regroupRuns = function(project_id, mode, runs_by)
	{
		$('#groupByName').hide();
		$('#groupByBusy').show();
		self.runs_by = runs_by;
		self.currentMode = mode;
		if (self.currentMode === 'run') {
			self._loadRuns(
				{
					project_id: project_id,
					runs_by: runs_by,

					success: function() 
					{
						self._onRunsLoaded();
					},
						
					error: function(data) 
					{
						$('#groupByBusy').hide();
						$('#groupByName').show();
					}
				}
			);
		} else {
			self._loadCases(
				{
					project_id: project_id,
					group_by: runs_by,

					success: function() 
					{
						self._onRunsLoaded();
					},
						
					error: function(data) 
					{
						$('#groupByBusy').hide();
						$('#groupByName').show();
					}
				}
			);
		}
	}

	self._loadRuns = function(o)
	{
		App.Ajax.call(
		{
			target: '/todos/ajax_render_runs',
			
			arguments: {
				project_id: o.project_id,
				runs_by: o.runs_by,
				user_ids: self.user_ids,
				status_ids: self.status_ids,
				milestone_id: self.milestone_id,
				include_unassigned: self.include_unassigned,
				offset: o.offset || 0
			},
			
			success: function(data)
			{
				$('#runs').html(data.runs);
				$('#runsPaginationBusy').hide();
				$('#runs').html(data.cases);
				$('#casePagination').html(data.pagination);
				$("#userChart").html(data.stats);

				if (data.showPagination) {
					$('#casePagination').show();
				} else {
					$('#casePagination').hide();
				}
				if (o.success)
				{
					o.success();
				}
			},
			
			error: function(data)
			{
				$('#runsPaginationBusy').hide();
				if (o.error)
				{
					o.error(data);
				}

				App.Ajax.handleError(data);
			}
		});
	}

	self._onRunsLoaded = function()
	{
		$('#groupByName').text(self.runs_by_options[self.runs_by]);
		$('#groupByName').show();
		$('#groupByChange').removeClass('link link-dashed nolink');

		if (self.runs_by == 'none')
		{
			$('#groupByReset').hide();
			$('#groupByName').hide();
			$('#groupByEmpty').show();
		} else
		{
			$('#groupByReset').show();
			$('#groupByEmpty').hide();
			$('#groupByName').show();
		}
	}

	self.selectUser = function(field_id, user_id)
	{
		App.Controls.Checkboxes.checkNone(field_id);
		App.Controls.Checkboxes.checkOne(field_id, user_id);
	}

	self.applyFilter = function(project_id, mode, global)
	{

		self.currentMode = mode;
		self.user_ids = 
			App.Controls.Checkboxes.getValues('userSelection');
		self.status_ids = 
			App.Controls.Checkboxes.getValues('statusSelection');
		self.milestone_id = $('#milestoneSelection').val();
		self.include_unassigned = 
			$('#includeUnassigned').is(':checked');

		
		self.setStatusLine();
		$('#filterByChange').bubble({
			bubble: '#filterBubble',
			toggleEvent: 'null'
		}).hide();


		if (self.currentMode == 'case') {
			self._loadCases(
			{
				project_id: project_id,
				user_ids: self.user_ids,
				status_ids: self.status_ids,
				milestone_id: 0,
				include_unassigned: self.include_unassigned,

				success: function() 
				{
				},
				
				error: function(data) 
				{
					$('#groupByBusy').hide();
					$('#groupByName').show();
				}
			});
		} else {
			self._loadRuns(
				{
					project_id: project_id,
					runs_by: self.runs_by,
					success: function() 
					{
						self._onRunsLoaded();
					},

					error: function(data) 
					{
						$('#groupByBusy').hide();
						$('#groupByName').show();
					}
			});
		}
	}

	self._loadCases = function(o)
	{
		$('#casesPaginationBusy').show();
		App.Ajax.call(
		{
			target: '/todos/ajax_render_cases',
			
			arguments: {
				project_id: o.project_id,
				group_by: self.runs_by,
				user_ids: self.user_ids,
				status_ids: self.status_ids,
				include_unassigned: self.include_unassigned,
				milestone_id: 0,
				offset: o.offset || 0,
			},
			
			success: function(data)
			{
				$('#casesPaginationBusy').hide();
				$('#cases').html(data.cases);
				$('#casePagination').html(data.pagination);
				$("#userChart").html(data.stats);

				if (data.showPagination) {
					$('#casePagination').show();
				} else {
					$('#casePagination').hide();
				}
				if (o.success) {
					o.success();
				}
			},
			
			error: function(data)
			{
				$('#casesPaginationBusy').hide();
				if (o.error) {
					o.error(data);
				}

				App.Ajax.handleError(data);
			}
		});
	}

	self.cancelFilter = function()
	{
		$('#filterByChange').bubble(
		{
			bubble: '#filterBubble',
			toggleEvent: 'null'
		}).hide();
	}

	self.resetFilter = function(project_id, mode)
	{
		self.status_ids = [];
		self.milestone_id = 0;
		self.currentMode = mode;

		App.Controls.Checkboxes.checkNone('statusSelection');

		$('#filterReset').hide();
		$('#filterByEmpty').show();
		$('#filterByName').hide();
		$('#filterByChange').addClass('link link-dashed nolink');

		if (self.currentMode === 'case') {
			self._loadCases(
			{
				project_id: project_id,
			});
		} else {
			self._reload(project_id);
			self._loadRuns(
				{
					project_id: project_id,
					runs_by: self.runs_by,
					success: function() 
					{
						self._onRunsLoaded();
					},
			});
		}
	}

	self._reload = function(project_id)
	{
		$('#groupByReset').hide();
		$('#groupByName').hide();
		$('#groupByEmpty').show();
		
		App.Page.load(
			'/todos/overview/{0}&user_ids={1}&status_ids={2}&milestone_id={3}&unassigned={4}&mode={5}&runs_by=none',
			project_id,
			self.user_ids.join(','),
			self.status_ids.join(','),
			self.milestone_id ? self.milestone_id : '',
			self.include_unassigned ? 1 : 0,
			self.currentMode
		);
	}

	self.showRuns = function(project_id)
	{
		self.currentMode = 'run';
		self.status_ids = [];
		App.Controls.Checkboxes.checkNone('statusSelection');
		self._reload(project_id);
	}

	self.showCases = function(project_id)
	{
		self.currentMode = 'case';
		self.status_ids = [];
		self.milestone_id = null;
		App.Controls.Checkboxes.checkNone('statusSelection');
		self._reload(project_id);
	}

	self.toggleComments = function(caseId)
	{
		var trRow = $('#todoCommentsPlaceholder-' + caseId);
		var trDiv = $('#todoCommentsContent-' + caseId);
		if (trRow.height() === 0) {
			trRow.css('height', '10px');
			self._loadComments({
					caseId: caseId,
					limit: 3,
					offset: 0
			});

		} else {
			trRow.css('height', '0px');
			trDiv.addClass('hidden');
		}
	}

	self.fetchComments = function(caseId, limit)
	{
		self._loadComments(
		{
			caseId: caseId,
			limit: limit,
			offset: 0
		});
	}

	self.setStatusLine = function()
	{
		$('#filterByChange').removeClass('link link-dashed nolink');
		var statusLine = [];
		if (self.status_ids && self.status_ids.length > 0) {
			var options = self.status_options;

			for (var item of self.status_ids) {
				statusLine.push(options[item]);
			}
		}
		var milestone =self.milestones.find(m => m.id == self.milestone_id);
		if (milestone) {
			statusLine.push(milestone.name);
		}
		if (statusLine.length > 0) {
			console.log("statusLine!" + JSON.stringify(statusLine));
			$('#filterByEmpty').hide();
			$('#filterByName').show();
			$('#filterByName').text(statusLine.join('&'));
			$('#filterReset').show();
		} else {
		  $('#filterByChange').addClass('link link-dashed nolink');
			$('#filterByEmpty').show();
			$('#filterByName').hide();
			$('#filterReset').hide();
		}
	}

	self.loadRuns = function(projectId, offset)
	{
		self._loadRuns(
			{
				project_id: projectId,
				runs_by: self.runs_by,
				offset: offset
			}
		);
	}

	self.loadCases = function(projectId, offset)
	{
		self._loadCases(
			{
				project_id: projectId,
				offset: offset
			}
		);
	}

	self._loadComments = function(o)
	{

		App.Ajax.call(
		{
			target: '/todos/ajax_render_case_comments',
			
			arguments: {
				case_id: o.caseId,
				limit: o.limit,
				offset: o.offset
			},
			
			success: function(data)
			{
				var trDiv = $('#todoCommentsContent-' + o.caseId);

				trDiv.html(data.case_comments);
				trDiv.removeClass('hidden');
				if (o.success) {
					o.success();
				}
			},
			
			error: function(data)
			{
				if (o.error) {
					o.error(data);
				}
				App.Ajax.handleError(data);
			}
		});
	}
};

;

