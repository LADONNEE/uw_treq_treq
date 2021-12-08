let ShowWhenChecked = (function($){
    let toggle = function() {
        let cbx = $(this).closest('.js-show-when-checked');
        let id = cbx.data('target');
        if (cbx.length === 0 || !id) {
            return;
        }
        if (cbx.is(':checked')) {
            $('#' + id).show();
        } else {
            $('#' + id).hide();
        }
    };

    return {
        init: function() {
            $('.js-show-when-checked').on('change', toggle).trigger('change');
        }
    };
})($);

$( document ).ready(function(){
    ShowWhenChecked.init();
});
