/*******************************************************************/
/* Report related routines */

/* [Permissions checked!] */

App.Reports = new function()
{
	var self = this;

	self.applyProgressCheck = function(report_ids)
	{
		window.setTimeout(
			function() {
				self._applyProgressCheck(
					report_ids,
					20000
				);
			},
			10000
		);
	}

	self._applyProgressCheck = function(report_ids, interval)
	{
		var offset = 0;

		$.each(report_ids, function(ix, v)
		{
			// Queue the requests for the reports with one second
			// between each request.
			window.setTimeout(
				function() 
				{
					self._checkProgress(v, interval);
				},
				offset * 1000
			);

			offset++;
		});
	}

	self._checkProgress = function(report_id, interval)
	{
		App.Ajax.call(
		{
			target: '/reports/ajax_check_status',
			blockUI: false,
			
			arguments:
			{
				report_id: report_id
			},
			
			success: function(data)
			{
				if (data.status != 1)
				{
					$('#report-' + report_id).replaceWith(data.html);
					App.Effects.add('#report-' + report_id);
				}
				else 
				{
					window.setTimeout(
						function() 
						{
							self._checkProgress(
								report_id,
								Math.min(interval + 10000, 60000)
							);
						},
						interval
					)
				}
			},
			
			error: function(data)
			{
				// Possible errors are ignored.
			}
		});
	}

	self.print = function(id)
	{
		var iframe = document.frames ? document.frames[id] : 
			document.getElementById(id);

		var win = iframe.contentWindow || iframe;

		var icon = $('#reportPrint .icon');
		icon.css(
			'padding-top', 
			Math.max(
				0,
				Math.round($('#content').outerHeight() / 2) - 100
			) + 'px'
		);
		
		$('#reportPrint').show();
		
		win.focus();
		win.print();

		if (win.afterPrint)
		{
			win.afterPrint();
		}

		$('#reportPrint').hide();
		return false;
	}

	self.share = function(id, is_private)
	{
		self._shareDialog(
		{
			is_private: is_private,
			submit: function() 
			{
				self._share(id);
			}
		});
	}	

	self._shareDialog = function(o)
	{
		App.Validation.hideErrors();
		$('#shareReportSuccess').hide();

		if (o.is_private)
		{
			$('#shareReportLinkContainer').hide();
		}
		else 
		{
			$('#shareReportLinkContainer').show();
		}

		$('#shareReportLink').attr('checked', false);
		$('#shareReportPDFAttachment').attr('checked', false);
        $('#shareReportHTMLAttachment').attr('checked', false);

		// Initialize the dialog
		$('#shareReportForm').unbind('submit');	
		$('#shareReportSubmit').removeClass('button-busy');
		
		$('#shareReportForm').submit(function(e)
		{
			App.Validation.hideErrors();
			$('#shareReportSuccess').hide();
			
			o.submit();
			return false;
		});
		
		App.Dialogs.open(
		{
			selector: '#shareReportDialog'
		});
	}

	self._share = function(id)
	{
		$('#shareReportSubmit').addClass('button-busy');
		var html_format =  $('#shareReportHTMLAttachment').is(':checked');
		var pdf_format = $('#shareReportPDFAttachment').is(':checked');
		var has_attachment = pdf_format || html_format;

		App.Ajax.call(
		{
			target: '/reports/ajax_share',
			
			arguments:
			{
				report_id: id,
				link: $('#shareReportLink').is(':checked'),
				link_recipients: $('#shareReportLinkRecipients').val(),
				attachment: has_attachment,
                notify_attachment_html_format: html_format,
                notify_attachment_pdf_format: pdf_format,
				attachment_recipients: 
					$('#shareReportAttachmentRecipients').val()
			},
			
			success: function(data)
			{
				$('#shareReportSubmit').removeClass('button-busy');
				$('#shareReportSuccess').show();
			},
			
			error: function(data)
			{
				$('#shareReportSubmit').removeClass('button-busy');
				App.Ajax.handleError(data, '#shareReportErrors');
			}
		});		
	}

	self.showError = function()
	{
		$('#statusTraceLink').hide();
		$('#statusMessage').hide();
		$('#statusTrace').show();
	}

	self.addTextToName = function(text)
	{
		$('#name').insertAtCaret(text);
	}

	self.loadPrivate = function(project_id, offset)
	{
		$('#privatePaginationBusy').show();
		
		App.Ajax.call(
		{
			target: '/reports/ajax_render_private',
			
			arguments: 
			{
				project_id: project_id,
				offset: offset
			},
			
			success: function(data)
			{
				$('#private').html(data.reports);
				$('#privatePagination').html(data.pagination);
				$('#privatePaginationBusy').hide();
				$('.delete-selected').hide();
			},
			
			error: function(data)
			{
				$('#privatePaginationBusy').hide();
				App.Ajax.handleError(data);
			}
		});
	}

	self.loadShared = function(project_id, offset)
	{
		$('#sharedPaginationBusy').show();
		
		App.Ajax.call(
		{
			target: '/reports/ajax_render_shared',
			
			arguments: 
			{
				project_id: project_id,
				offset: offset
			},
			
			success: function(data)
			{
				$('#shared').html(data.reports);
				$('#sharedPagination').html(data.pagination);
				$('#sharedPaginationBusy').hide();
				$('.delete-selected').hide();
			},
			
			error: function(data)
			{
				$('#sharedPaginationBusy').hide();
				App.Ajax.handleError(data);
			}
		});
	}

	self.remove = function(report_id, isBulk)
	{
		var row = $('#report-' + report_id);
		$('.deleteLink', row).hide();
		$('.deleteBusy', row).show();
		
		App.Ajax.call(
		{
			target: '/reports/ajax_delete',
			
			arguments: 
			{
				report_id: report_id,
				flag: true
			},
			
			success: function(data)
			{
				row.remove();
				if (!isBulk) {
					App.Bulk.redirectSuccess('Report deleted');
				}
			},
			
			error: function(data)
			{		
				$('.deleteBusy', row).hide();
				$('.deleteLink', row).show();
				App.Ajax.handleError(data);
			}
		});	
	}

	self.removeJob = function(report_job_id, isBulk)
	{
		var row = $('#reportJob-' + report_job_id);
		$('.deleteLink', row).hide();
		$('.deleteBusy', row).show();
		
		App.Ajax.call(
		{
			target: '/reports/ajax_delete_job',
			
			arguments: 
			{
				report_job_id: report_job_id,
				flag: true
			},
			
			success: function(data)
			{
				row.remove();
				if (!isBulk) {
					App.Bulk.redirectSuccess('Scheduled report deleted');
				}
			},
			
			error: function(data)
			{		
				$('.deleteBusy', row).hide();
				$('.deleteLink', row).show();
				App.Ajax.handleError(data);
			}
		});	
	}

    self.removeTemplate = function(report_template_id, isBulk)
    {
        var row = $('#report-template-' + report_template_id);
        $('.deleteLink', row).hide();
        $('.deleteBusy', row).show();

        App.Ajax.call(
            {
                target: '/reports/ajax_delete_template',

                arguments:
                    {
                        report_template_id: report_template_id,
                        flag: true
                    },

                success: function(data)
                {
					row.remove();
					if (!isBulk) {
						App.Bulk.redirectSuccess('Report Template deleted');
					}
                },

                error: function(data)
                {
                    $('.deleteBusy', row).hide();
                    $('.deleteLink', row).show();
                    App.Ajax.handleError(data);
                }
            });
    };

	self.deleteBulkReport = function(report_type) {
		let parent = $(report_type).parent().closest('div').attr('id');
		let count = $('#'+parent).find('input:checked[name="report"]').length;
		App.Dialogs.BulkDeleteDialog();
		$('.dialog-action-default').on('click', function() {
			$(this).addClass('button-busy');
			$.blockUI();
			let i = 0;
			let reports = [];
			$('input:checked[name="report"]').each(function () {
				let valueToPush = {};
				valueToPush.id = $(this).val();
				valueToPush.type = $(this).data('type');
				reports.push(valueToPush);
			});
			App.Ajax.call(
				{
					target: '/reports/ajax_delete_bulk',
					blockUI: true,
					arguments:
						{
							reports: JSON.stringify(reports)
						},

					success: function(data)
					{
						$(this).removeClass('button-busy');
						App.Dialogs.closeTop();
						App.Bulk.redirectSuccess(data.message);

					},

					error: function(data)
					{
						App.Ajax.handleError(data);
					}
				});
		});
	}
}


;

