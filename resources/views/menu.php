<?php

return [
    'Travel & Requisitions' => [
        [ 'Home', route('home') ],
        [ 'About', route('help', 'about') ],
    ],
    'Reports' => [
        [ 'Closable Projects', route('closable-projects'), 'treq:fiscal'  ],
        [ 'Delete Folders', route('delete-folders'), 'treq:fiscal'  ],
        [ 'Food', route('reports', 'food-orders'), 'treq:fiscal'  ],
        [ 'Gift Cards', route('reports', 'gift-cards'), 'treq:fiscal'  ],
        [ 'Open Trips', route('reports', 'open-trips'), 'treq:fiscal'  ],
        [ 'Recent Orders', route('reports', 'recent'), 'treq:fiscal'  ],
        [ 'RSP', route('reports', 'rsp-orders'), 'treq:fiscal'  ],
        [ 'User Tasks', route('user-tasks-index'), 'treq:fiscal'  ],
    ],
    'Admin' => [
        [ 'Pending Email', route('pending-email') ],
        [ 'Settings', action('SettingsController@index'), 'settings' ],
        [ 'Manage questions', action('QuestionController@index') ],
        [ 'List Workflows', action('Workflows') ],
        [ 'Edit Workflows', action('WorkflowManagementController@index') ],
        [ 'Users', action('UserController@index'), 'user-mgmt' ],
        


    ],
];
