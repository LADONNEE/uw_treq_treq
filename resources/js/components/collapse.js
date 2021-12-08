let Collapse = (function($){
    let buttonSelector = '.js-collapse__button';
    let contentSelector = '.js-collapse__content';

    let toggle = function(event) {
        let trigger = $(event.target).closest(buttonSelector);
        trigger.next(contentSelector).each(function(){
            let content = $(this);
            if (content.is(':hidden')) {
                expand(trigger, content);
            } else {
                collapse(trigger, content);
            }
        });
    };

    let collapse = function(trigger, content) {
        content.hide().attr('aria-hidden', true);
        trigger.removeClass('open').addClass('closed').attr('aria-pressed', false);
    };

    let expand = function(trigger, content) {
        content.show().attr('aria-hidden', false);
        trigger.addClass('open').removeClass('closed').attr('aria-pressed', true);
    };

    return {
        init : function(context) {
            let items = [];
            if (typeof context === "undefined") {
                items = $(buttonSelector);
            } else {
                items = $(context).find(buttonSelector);
            }
            items.each(function(){
                let trigger = $(this);
                trigger.on('click.collapse-content', toggle);
                if (trigger.hasClass('closed')) {
                    collapse(trigger, trigger.next(contentSelector));
                }
            });
        }
    };

})(jQuery);

$( document ).ready(function() {
    Collapse.init();
});

export default Collapse;
