import { suggestions } from '../suggestions/suggestion-factory';

let UwpersonTypeahead = (function($){
    let classPersonChanging = 'uwperson-changing';
    let classPersonEmpty = 'uwperson-empty';
    let classPersonSelected = 'uwperson-selected';
    let bhSource = null;

    let storeOriginalValue = function(typeaheads)
    {
        typeaheads.each(function(index){
            let typeahead = $(this);
            let personId = getValueInput(this).val();
            if (personId) {
                typeahead = $(typeahead);
                typeahead.data('selected-name', typeahead.val());
                typeahead.data('original', {
                    "id": personId,
                    "name": typeahead.val()
                });
            }
        });
    };

    let getValueInput = function(typeahead)
    {
        // typeahead's data-for="" attribute, refers to value input's ID
        let selector = '#' + $(typeahead).data('for');
        if (selector === '#undefined') {
            // default name for legacy person select inputs
            return $('#uwperson_id');
        }
        return $(selector);
    };

    let onChanging = function(event)
    {
        let typeahead = $(this);
        if (typeahead.val() !== typeahead.data('selected-name')) {
            getValueInput(typeahead).val('');
            typeahead.data('selected-name', null);
            typeahead.removeClass(classPersonEmpty);
            typeahead.removeClass(classPersonSelected);
            typeahead.addClass(classPersonChanging);
            $('#search-spinner').removeClass('d-none');
        }

        

        if( typeahead.val() == ""){
            $('#search-spinner').addClass('d-none');
        }
        

    };

    let onKeyPress = function(event) {
        // catch Enter (13) events and re-trigger as Tab (9)
        if (event.which === 13) {
            event.preventDefault();
            let e = jQuery.Event("keydown");
            e.keyCode = e.which = 9;
            $(this).trigger(e);
        }
        // Escape key reverts to original value
        if (event.which === 27) {
            revert(this);
        }
    };

    let onSelected = function(event, option)
    {
        let typeahead = $(this);
        getValueInput(typeahead).val(option.id);
        typeahead.data('selected-name', typeahead.val());
        typeahead.removeClass(classPersonChanging);
        typeahead.removeClass(classPersonEmpty);
        typeahead.addClass(classPersonSelected);
        typeahead.typeahead('close');
        let cb = typeahead.data('typeaheadSelectedCallback');
        if (typeof cb === 'function') {
            cb(option);
        }
    };

    let revert = function(typeahead)
    {
        typeahead = $(typeahead);
        let original = typeahead.data('original');
        if (original) {
            typeahead.typeahead('val', original.name);
            getValueInput(typeahead).val(original.id);
            typeahead.data('selected-name', original.name);
            typeahead.removeClass(classPersonChanging);
            typeahead.removeClass(classPersonEmpty);
            typeahead.addClass(classPersonSelected);
        }
    };

    let setup = function(elem, selectedCallback)
    {
        // Assume your spinner ID is 'search-spinner' as per the HTML provided
        let $spinner = $('#search-spinner');
        
        if (elem.length === 0 || elem.data('typeaheadStarted')) {
            $spinner.addClass('d-none');
            return;
        }

        

        bhSource = suggestions('uwperson');
        elem.typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            },
            {
                name: 'people',
                limit: 20,
                source: bhSource,
                display: function(option) { return option.name }
            })
            .on('keydown', onKeyPress)
            .on('keyup', onChanging)
            .on('typeahead:change', onChanging)
            .on('typeahead:render', function() {
                // Hide spinner when suggestions are rendered
                $spinner.addClass('d-none');
            })
            .on('typeahead:selected typeahead:autocompleted', onSelected)
            .data('typeaheadSelectedCallback', selectedCallback)
            .data('typeaheadStarted', true);
        storeOriginalValue(elem);

        // Initially hide the spinner
        $spinner.addClass('d-none');

        return elem;
    };

    return {
        init: function(selector, selectedCallback) {
            return setup($(selector), selectedCallback);
        }
    }
})(jQuery);

$( document ).ready(function() {  
    UwpersonTypeahead.init('input.uwperson-typeahead');
});

export default  UwpersonTypeahead;
