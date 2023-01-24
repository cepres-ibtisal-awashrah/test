$('.notifications ul').on('click', 'li', function (e) {
    if (e.ctrlKey || e.metaKey) {
        $(this).toggleClass('selected');
    } else {
        $(this).addClass('selected').siblings().removeClass('selected');
    }
}).sortable({
    connectWith: 'ul',
    delay: 150,
    revert: 0,
    helper: function (e, item) {
        if (!item.hasClass('selected')) {
            item.addClass('selected').siblings().removeClass('selected');
        }
        var elements = item.parent().children('.selected').clone();
        item .data('multidrag', elements).siblings('.selected').remove();
        var helper = $('<li/>');
        return helper.append(elements);
    },
    stop: function (e, ui) {
        var elements = ui.item.data('multidrag');
        ui.item.after(elements).remove();
        $(this).addClass("selected").siblings().removeClass('selected');
        elements.removeClass('selected');
        select_templates();
    }
});

var bindDraggables = function() {
    $('.drag-button-menu').attr("contenteditable", false);
    $('.drag-button-menu').off('dragstart').on('dragstart', function(e) {
        if (!e.target.id) {
            e.target.id = (new Date()).getTime();
        }
        e.originalEvent.dataTransfer.setData('text/html', e.target.outerHTML);
        $(e.target).addClass('dragged');
    });
}

$('#templateEdit').on('dragover', function(e) {
    e.preventDefault();

    return false;
});

$('#templateEdit').on('drop', function(e) {
    e.preventDefault();
    var e = e.originalEvent;
    var content = e.dataTransfer.getData('text/html');
    var range = null;
    let target_id = e.target.id;
    let subject_id = 'email_template_subject_display';

    if (
        !$(e.target).is('div')
        || $.inArray(
            target_id,
            [
                subject_id,
                'email_template_body_display',
                'template-variables'
            ]
        ) === -1
    ) {
        $('.dragged').removeClass('dragged');
        return false;
    }

    if (target_id === subject_id && $('#' + subject_id + ' span').length >= 2) {
        $('.dragged').removeClass('dragged');
        return false;
    }

    if (document.caretRangeFromPoint) {
        range = document.caretRangeFromPoint(e.clientX, e.clientY);
    } else if (e.rangeParent) {
        range = document.createRange();
        range.setStart(e.rangeParent, e.rangeOffset);
    }

    var sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);
    $('#templateEdit').get(0).focus();
    var spanId = 'temp-' + (new Date()).getTime();
    let new_node = document.createElement('span');
    range.surroundContents(new_node);
    new_node.setAttribute('id', spanId);
    new_node.setAttribute('class','changed');

    if (target_id === 'template-variables') {
        $('#' + target_id).append(content);
        $('.changed').remove();
    } else {
        $('#' + spanId).after(' ').before(' ').replaceWith(content);
    }
    sel.removeAllRanges();
    $('.dragged').remove();
    bindDraggables();
});

bindDraggables();

function select_templates () {
    let active = '';
    let inactive = '';
    $('#listboxone li').each(function(){
        active = active === ''
            ? $(this).attr('rel')
            :  active + ',' + $(this).attr('rel');
    });
    $('#listboxtwo li').each(function(){
        inactive = inactive === ''
            ? $(this).attr('rel')
            : inactive + ',' + $(this).attr('rel');
    });
    $('#active_template').val(active);
    $('#inactive_template').val(inactive);
}

function moveAllItems(origin, dest) {
    $(origin).children('li').appendTo(dest);
    $(origin).children('span').appendTo(dest);
}

$('#leftall').on('click', function () {
    moveAllItems('#listboxtwo', '#listboxone');
    select_templates();
    $('#inactive_template').val('');
});

$('#rightall').on('click', function () {
    moveAllItems('#listboxone', '#listboxtwo');
    select_templates();
    $('#active_template').val('');
});

$('#leftall-edit').on('click', function () {
    moveAllItems('#template-variables', '#email_template_body_display');
});

$('#rightall-edit').on('click', function () {
    moveAllItems('#email_template_body_display', '#template-variables');
});

$('div[contenteditable="true"]').keypress(function(event) {
    if (event.which != 13) {
        return true;
    }
    let docFragment = document.createDocumentFragment();
    let newEle = document.createTextNode('\n');
    docFragment.appendChild(newEle);
    newEle = document.createElement('br');
    docFragment.appendChild(newEle);
    let range = window.getSelection().getRangeAt(0);
    range.deleteContents();
    range.insertNode(docFragment);
    range = document.createRange();
    range.setStartAfter(newEle);
    range.collapse(true);
    let sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);

    return false;
});

;

