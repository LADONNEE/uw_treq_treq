
let Bloodhound = require("typeahead.js/dist/bloodhound.min.js");

let make = function() {
    let engine = new Bloodhound({
        datumTokenizer: function (option) {
            return Bloodhound.tokenizers.nonword(option.name);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        identify: function(option) {
            return option.id;
        },
        prefetch: {
            url: '/treq/person/prefetch.json?scope=uworg-uwnetid' //, cache: false
        },
        remote: {
            url: '/searchpersons/suggest?q={{SEARCHTERM}}&scope=uwnetid',
            wildcard: '{{SEARCHTERM}}'
        }
    });

    return function(q, sync, async) {
        engine.search(q, sync, async);
    };
};

export default { make }
