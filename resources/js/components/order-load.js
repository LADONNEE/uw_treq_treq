$( document ).ready(function(){
    $('.js-order-load').on('click', function(e) {
        e.preventDefault();
        let jq = $(this);
        let href = jq.attr('href');
        console.log('order-load -> ' + href);
        if (href) {
            jq.closest('.js-order-load--target').load(href);
        }
    });
});
