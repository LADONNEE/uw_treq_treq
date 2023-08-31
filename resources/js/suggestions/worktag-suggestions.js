let Bloodhound = require("typeahead.js/dist/bloodhound.min.js");

let make = function() {
    let engine = new Bloodhound({
        prefetch: {
            url: '/treq/api/budgets.json' //, cache: false
        },
        remote: {
            url: '/treq/api/worktags?q={{SEARCHTERM}}',
            wildcard: '{{SEARCHTERM}}'
        },
        identify: function(datum) {
            return datum.id;
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        datumTokenizer: function(datum) {
            return Bloodhound.tokenizers.nonword(datum.workday_code + ' ' + datum.name);
        }
    });

    return function(q, sync, async) {
        engine.search(q, sync, async);
    };
};

export default { make }
