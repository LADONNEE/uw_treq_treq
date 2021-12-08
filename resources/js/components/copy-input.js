let copyInput = function(e) {
    let $target = $('#' + $(this).data('copy'));
    if ($target.length) {
        $target.select();
        document.execCommand('copy');
    }
};

$( document ).ready(function(){
    $('.js-copy-input').on('click', copyInput);
});
