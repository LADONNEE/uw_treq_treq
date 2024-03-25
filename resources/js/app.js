require('./utilities/polyfills');

window._ = require('lodash');
window.$ = window.jQuery = require('jquery');

// Provide access to Laravel CSRF token
window.csrf_token = function() {
    let header = document.head.querySelector('meta[name="csrf-token"]');
    if (header) {
        return header.content;
    }
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    return null;
};

require("typeahead.js/dist/typeahead.jquery.min.js");
window.Bloodhound = require("typeahead.js/dist/bloodhound.min.js");
require('./components/app-menu');
require('./components/approval-from');
require('./components/collapse');
require('./components/confirm-dialog');
require('./components/copy-input');
require('./components/dismissable');
require('./components/order-load');
require('./components/order-refresh');
require('./components/person-typeahead');
require('./components/uwperson-typeahead');     
require('./components/budget-typeahead');
require('./components/search-bar');
require('./components/show-when-checked');
require('./components/toggle-target');
require('./components/treq-settings');
require('./components/trip-form');
require('./components/trip-notes');

// Boot Vue app
import Vue from 'vue';
window.Vue = Vue;
import PortalVue from 'portal-vue';
window.Vue.use(PortalVue);

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.csrf_token();

import AppIcon from './components/AppIcon';
import AribaSection from "./ariba/AribaSection";
import BudgetTool from './budgets/BudgetTool';
import ExternalLink from "./components/ExternalLink";
import ItemsInput from './items/ItemsInput';
import NotesSection from "./notes/NotesSection";
import OnCall from "./on-call/OnCall";
import PerDiem from "./perdiem/PerDiem";
import TaskItem from "./tasks/TaskItem";
import TaskList from "./tasks/TaskList";

Vue.component('app-icon', AppIcon);

const app = new Vue({
    el: '#vue_app',
    components: {
        AribaSection,
        BudgetTool,
        ExternalLink,
        ItemsInput,
        NotesSection,
        OnCall,
        PerDiem,
        TaskItem,
        TaskList,
    },
});
