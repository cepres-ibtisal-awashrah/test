App.CaseStatuses=new function(){var a=this;a.moveUp=function(c){var b=$("#case-status-"+c);$(".moveUp",b).hide();$(".moveUpBusy",b).show();App.Ajax.call({target:"/admin/case_statuses/ajax_move_up",arguments:{case_status_id:c},success:function(d){$(".moveUp",b).show();$(".moveUpBusy",b).hide();var e=b.prev();b.insertBefore(e);a._syncMoveButtons(b,e)},error:function(d){$(".moveUp",b).show();$(".moveUpBusy",b).hide();App.Ajax.handleError(d)}})};a.moveDown=function(c){var b=$("#case-status-"+c);$(".moveDown",b).hide();$(".moveDownBusy",b).show();App.Ajax.call({target:"/admin/case_statuses/ajax_move_down",arguments:{case_status_id:c},success:function(e){$(".moveDown",b).show();$(".moveDownBusy",b).hide();var d=b.next();b.insertAfter(d);a._syncMoveButtons(b,d)},error:function(d){$(".moveDown",b).show();$(".moveDownBusy",b).hide();App.Ajax.handleError(d)}})};a._syncMoveButtons=function(f,e){var d=$(".moveUp",f).is(":visible");var c=$(".moveDown",f).is(":visible");var b=$(".moveUp",e).is(":visible");var g=$(".moveDown",e).is(":visible");App.Effects.setVisible($(".moveUp",f),b);App.Effects.setVisible($(".moveDown",f),g);App.Effects.setVisible($(".moveUp",e),d);App.Effects.setVisible($(".moveDown",e),c)};$(document).ready(function(){$("#is_default").on("click",function(b){var c=$("#is_approved_div");if($(b.target).is(":checked")){$("input",c).prop("checked",false);c.hide()}else{c.show()}});$("#is_approved").on("click",function(b){var c=$("#is_default_div");if($(b.target).is(":checked")){$("input",c).prop("checked",false);c.hide()}else{c.show()}})})};