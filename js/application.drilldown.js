/* Fusion Charts Drill Down Integration */
App.Drilldown = new function()
{
    var self = this;

    self.changes = function (project_id, stats_date, change_count, offset = 0, chart_type = 'CHANGE', type_id = 0, status_id = 0)
    {
    	if (project_id && change_count > 0) {
    	    self.beforeAjaxCall();

    		App.Ajax.call({
    			target: '/tests/ajax_get_test_changes_for_drilldown',
    			arguments:
    				{
    					project_id: project_id,
    					stats_date: stats_date,
    					change_count: change_count,
    					status_id: status_id,
    					chart_type: chart_type,
    					type_id: type_id,
    					offset: offset
    				},
    			stop: function () {
    				$('#content_container').show();
    				$('#drilldown_container').html('').hide();
    			},
    			success: function (html) {
    				$('#content_container').hide();
    				$('#drilldown_container').show().html(html).removeClass('button-busy');
    				self.afterSuccess();
    			},
    			error: function (data) {
    				$('#content_container').show();
    				$('#drilldown_container').html('').hide();
    			}
    		});
    	}
    }

    self.tests = function (project_id, change_count, offset = 0, chart_type = 'MILESTONE', type_id = 0, status_id = 0, stats_date = '')
    {
    	if (project_id > 0 && change_count > 0) {
    		self.beforeAjaxCall();

    		App.Ajax.call({
    			target: '/tests/ajax_get_tests_for_drilldown',
    			arguments:
    				{
    					project_id: project_id,
    					change_count: change_count,
    					status_id: status_id,
    					chart_type: chart_type,
    					type_id: type_id,
    					stats_date: stats_date,
    					offset: offset
    				},
    			stop: function () {
    				$('#content_container').show();
    				$('#drilldown_container').html('').hide();
    			},
    			success: function (html) {
    				$('#content_container').hide();
    				$('#drilldown_container').show().html(html).removeClass('button-busy');
    				self.afterSuccess();
    			},
    			error: function (data) {
    				$('#content_container').show();
    				$('#drilldown_container').html('').hide();
    			}
    		});
    	}
    }

    self.defects = function (project_id, defect_count, offset = 0, chart_type = 'MILESTONE', type_id = 0)
    {
    	if (project_id > 0 && defect_count > 0) {
    		self.beforeAjaxCall();

    		App.Ajax.call({
    			target: '/tests/ajax_get_defects_for_drilldown',
    			arguments:
    				{
    					project_id: project_id,
    					defect_count: defect_count,
    					chart_type: chart_type,
    					type_id: type_id,
    					offset: offset
    				},
    			stop: function () {
    				$('#content_container').show();
    				$('#drilldown_container').html('').hide();
    			},
    			success: function (html) {
    				$('#content_container').hide();
    				$('#drilldown_container').show().html(html).removeClass('button-busy');
    			},
    			error: function (data) {
    				$('#content_container').show();
    				$('#drilldown_container').html('').hide();
    			}
    		});
    	}
    }

    self.beforeAjaxCall = function ()
    {
    	let container_html = '<div id="drilldown_container_area">' +
    		'<div class="icon-progress-inline">' +
    		'</div>' +
    		'</div>';
    	$('#drilldown_container')
    		.show()
    		.html(container_html);
    	$('#content_container').hide();
    }

    self.afterSuccess = function ()
    {
    	$('#drilldown_container .markdown-img, #drilldown_container .attachment-list-item')
    		.prop('onclick', null)
    		.off('click');
    }

    self.ready = function ()
    {
        $(document).on('click', '#close_drilldown', function (){
            $('#drilldown_container').html('');
            $('#content_container').show();
        });

        $(document).on("click", ".collapse-table tr.open-row td.open-first", function() {
            $(this)
                .parent()
                .toggleClass("open")
                .next(".closed-row")
                .toggleClass("open");
        });
    }
}

App.Drilldown.ready();

;

