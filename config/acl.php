<?php

return [
    'act-on-behalf' => [],
    'create-requests' => [],
    'create-tasks' => [],
    'reassign-tasks' => [],
    'delete-tasks' => [],
    'cancel' => [],
    'delete' => [],
    'edit-notes' => [],
    'on-call' => [],
    'settings' => [],
    'user-mgmt' => [],
    'who-am-i' => [],

    'treq:user' => [],
    'treq:requester' => [ 'treq:user', 'create-requests' ],
    'treq:fiscal' => ['treq:user', 'act-on-behalf', 'create-tasks', 'delete-tasks', 'on-call', 'reassign-tasks', 'edit-notes', 'cancel'],
    'treq:admin' => ['treq:fiscal', 'settings', 'user-mgmt', 'delete'],
    'treq:super' => ['treq:admin', 'who-am-i'],
];
