let ConfirmDialog = (function($){
    let confirm = function(event) {
        event.preventDefault();
        let trigger = $(event.target);
        let container = trigger.closest('.js-confirm-dialog');
        if (container.length === 0) {
            return;
        }
        container.find('.js-confirm-dialog--home').hide();
        container.find('.js-confirm-dialog--confirm').show();

        let focusId = trigger.data('focus');
        if (trigger.data('focus')) {
            $('#' + focusId).focus();
        }
    };
    let cancel = function(event) {
        event.preventDefault();
        let container = $(event.target).closest('.js-confirm-dialog');
        container.find('.js-confirm-dialog--confirm').hide();
        container.find('.js-confirm-dialog--home').show();
    };
    return {
        init: function(){
            $('.js-confirm-dialog .js-confirm-dialog--show').on('click', confirm);
            $('.js-confirm-dialog .js-confirm-dialog--cancel').on('click', cancel);
        }
    };
})($);

$( document ).ready(function(){
    ConfirmDialog.init();
});
