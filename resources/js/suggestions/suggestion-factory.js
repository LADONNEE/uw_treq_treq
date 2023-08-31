let suggestionsInstances = {};

import makeBudgets from './budget-suggestions';
import makeWorktags from './worktag-suggestions';
import makePerson from './person-suggestions';
import makeProjectCodes from './project-code-suggestions';

let suggestionsFactories = {
    budgets: makeBudgets,
    worktags: makeWorktags,
    person: makePerson,
    project_codes: makeProjectCodes,
};

let suggestionsCreate = function(name) {
    if (suggestionsFactories.hasOwnProperty(name)) {
        return suggestionsFactories[name].make();
    }
    throw "No suggestion configured for " + name;
};

let suggestions = function(name) {
    if (!suggestionsInstances.hasOwnProperty(name)) {
        suggestionsInstances[name] = suggestionsCreate(name);
    }
    return suggestionsInstances[name];
};

export { suggestions }
