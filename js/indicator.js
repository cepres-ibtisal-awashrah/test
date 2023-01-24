function indicator (element, insertBefore) {
    let $indicator = $(
        '<div>',
        { class: 'icon-progress-inline' }
    );
    if (insertBefore) {
        $indicator.prependTo(element);
    } else {
        $indicator.appendTo(element);
    }
}

;

