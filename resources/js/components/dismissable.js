let AppDismissable = (function($){
    let close = function(event) {
        event.preventDefault();
        $(event.target).closest('.js-dismissable').hide();
    };
    return {
        init: function(){
            $('.js-dismissable--close').on('click', close);
        }
    };
})($);

$( document ).ready(function(){
    AppDismissable.init();
});
