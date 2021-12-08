let ToggleTarget = (function($){
    // put this class on single button and give it a data-target="some_id" attribute
    const triggerSelector = '.js-toggle-target';
    // put this class on a container that has .js-toggle-targets and whose html will be replaced
    const containerSelector = '.js-toggle-target--container';

    let toggle = function(event) {
        event.preventDefault();
        event.stopPropagation();
        let id = $(event.target).closest(triggerSelector).data('target');
        if (!id) {
            return;
        }
        let target = $('#' + id);
        if (target.is(":visible")) {
            target.hide();
        } else {
            target.show();
        }
    };

    return {
        init: function(){
            $(triggerSelector).on('click', toggle);
            $(containerSelector).on('click', triggerSelector, toggle);
        }
    };
})($);

$( document ).ready(function() {
    ToggleTarget.init();
})
