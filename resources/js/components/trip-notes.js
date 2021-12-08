let TripNotes = (function($){
    let toggle = function() {
        let cbx = $(this).closest('.js-trip-notes');
        let name = cbx.attr('name');
        let id = cbx.data('target');
        if (cbx.length === 0 || !name || !id) {
            return;
        }

        let val = $("input[name='" + name + "']:checked").val();

        if (val === 'Y') {
            $('#' + id).slideDown();
        } else {
            $('#' + id).hide();
        }
    };

    return {
        init: function() {
            $('.js-trip-notes').on('change', toggle).trigger('change');
        }
    };
})($);

$( document ).ready(function(){
    TripNotes.init();
});
