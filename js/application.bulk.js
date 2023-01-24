
//-------------------------------------------------------------------
// BULK EDIT
//-------------------------------------------------------------------

App.Bulk = new function() {
    var bulkEdit = this;
    bulkEdit.bulkIds = [];
    bulkEdit.setIds = function(ids) {
        if(ids) {
            $.each(ids,function(key,value){
                bulkEdit.bulkIds.push(parseInt(value));
            })
        }
    }
    bulkEdit.getIds = function() {
        return bulkEdit.bulkIds;
    }
    bulkEdit.removeFromArray = function(array, value) {
        return array.filter(function(element){
            return element != value;
        });

    }
    bulkEdit.removeId = function(id) {
        bulkEdit.bulkIds = bulkEdit.removeFromArray(bulkEdit.bulkIds,id)
        if($("#bulk-"+id).length) {
            var node = $("#bulk-"+id);
            node.remove();
        }
    }
    bulkEdit.loadBulk = function(off) {
        $("#paginationBulkBusy").show();
        App.Ajax.call({
            target: "/admin/users/ajax_render_edit_bulk",
            arguments: {
                offset: off,
                bulk_ids: bulkEdit.getIds()
            },
            stop: function() {
                $("#paginationBulkBusy").show()
            },
            success: function(result) {
                $("#bulk").html(result)
            },
            error: function(err) {
                App.Ajax.handleError(err)
            }
        })

    }

    bulkEdit.deleteBulk = function(entity, defaultAction, target) {
        defaultAction.on('click', function() {
            $(this).addClass('button-busy button-busy-black');
            let ids = [];
            $('input:checked[name="entity_' + entity + '"]').each(function () {
                ids.push($(this).attr('value'));
            });

            App.Ajax.call(
                {
                    target: target,
                    blockUI: true,
                    arguments:
                        {
                            ids: ids
                        },
                    success: function(data) {
                        $(this).removeClass('button-busy button-busy-black');
                        bulkEdit.redirectSuccess(data.message);
                    },
                    error: function(data) {
                        $(this).removeClass('button-busy button-busy-black');
                        App.Dialogs.closeTop();
                        App.Ajax.handleError(data);
                    }
                });

        });
    }

    bulkEdit.redirectSuccess = function(message) {
        App.Ajax.call({
            target: "/runs/ajax_set_redirect_message",
            arguments: {
                message: message
            },
            success: function() {
                setTimeout(
                    function() {
                        location.reload();
                    },
                    100
                );
            },
            error: function(err) {
                App.Ajax.handleError(err)
            }
        })
    }
};

;

