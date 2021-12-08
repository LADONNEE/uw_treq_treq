<?php

return [
    'Travel & Requisitions' => [
        [ 'Home', route('home') ],
        [ 'About', route('help', 'about') ],
    ],
    'Reports' => [
        [ 'Closable Projects', route('closable-projects')  ],
        [ 'Delete Folders', route('delete-folders')  ],
        [ 'Food', route('reports', 'food-orders')  ],
        [ 'Gift Cards', route('reports', 'gift-cards')  ],
        [ 'Open Trips', route('reports', 'open-trips')  ],
        [ 'Recent Orders', route('reports', 'recent')  ],
        [ 'RSP', route('reports', 'rsp-orders')  ],
        [ 'User Tasks', route('user-tasks-index')  ],
    ],
    'Admin' => [
        [ 'Pending Email', route('pending-email') ],
        [ 'Settings', action('SettingsController@index'), 'settings' ],
        [ 'Workflows', action('Workflows') ],
        [ 'Users', action('UserController@index'), 'user-mgmt' ],
    ],
];
