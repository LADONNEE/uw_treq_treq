import axios from "axios";
import OnCall from "../on-call/OnCall.vue";

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
        $('.js-order-refresh--stage').html(response.data.stage == 'Department Approval' ? 'Spend Authorizer Approval' : response.data.stage);

        // Update On Call if stage other than Department Approval
        //if(response.data.stage != 'Department Approval') {
           //$('.js-order-refresh--oncall').load(location.href + " .js-order-refresh--oncall"); //.html('<span>Stage Department ready for On Call</span>');
        //}
        // $('.js-order-refresh--oncall').val("");
        
        // if(response.data.oncall) {
        //    $('.js-order-refresh--oncall').html(response.data.stage);
        // }
        console.log(response.data.stage);
        if(response.data.stage != 'Complete'){

            var onCallVue = new Vue({
                ...OnCall,
                parent: this,
                propsData: { 
                /* pass props here*/
                    url: response.data.urlApiOnCall
                }
              }).$mount();
            
            $('.js-order-refresh--oncall').html(onCallVue.$el);

        }
        else {
            $('.js-order-refresh--oncall').html('');
        }
        

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
