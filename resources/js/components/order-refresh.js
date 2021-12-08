import axios from "axios";

let OrderRefresh = (function($){
    let href = null;

    let request = function(event) {
        event.preventDefault();
        if (href) {
            axios({
                method: 'get',
                url: href
            })
                .then((r) => applyState(r))
                .catch(apiError);
        }

    };
    let applyState = function(response) {
        $('.js-order-refresh--stage').html(response.data.stage);
        if (response.data.assigned) {
            $('.js-order-refresh--assigned').html(response.data.assigned);
        } else {
            $('.js-order-refresh--assigned').html('<span class="empty">No fiscal contact</span>');
        }
        if (response.data.projectButtons) {
            $('.js-order-refresh--project-buttons').html(response.data.projectButtons);
        }
    };

    let apiError = function(error) {
        console.log('OrderRefresh.apiError()');
        console.log(error.response);
        console.log(error);
    };

    return {
        init: function(){
            let trigger = $('#js-order-refresh');
            href = trigger.data('href');
            if (href) {
                trigger.on('click', request);
            }
        }
    };
})($);

$( document ).ready(function(){
    OrderRefresh.init();
});
