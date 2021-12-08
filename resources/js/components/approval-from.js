let ApprovalFrom = (function($){
    const radio_selector = '.js-approval-from--radio';

    let toggle = function() {
        $(radio_selector).each(function() {
            let $radio = $(this);
            if ($radio.is(':checked')) {
                $('#' + $radio.data('target')).show();
            } else {
                $('#' + $radio.data('target')).hide();
            }
        });
    };

    return {
        init: function() {
            $(radio_selector).on('change', toggle);
        }
    };
})($);

$( document ).ready(function(){
    ApprovalFrom.init();
});
