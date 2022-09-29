<?php

$route = app('router');
if (!$route instanceof Illuminate\Routing\Router) {
    exit;
}

// Workaround for route:cache breaks the '/' route app is in an Apache Aliased directory 
$route->get('treq', 'HomeController@index')->name('treq');

Route::group(array('prefix' => 'treq'), function($route) { 
    $route->get('/', 'HomeController@index')->name('home');

    $route->get('closable-projects', 'ClosableProjects')->name('closable-projects');
    $route->get('delete-folders', 'DeleteFoldersController@index')->name('delete-folders');
    $route->get('delete-folder/{project}', 'DeleteFoldersController@edit')->name('delete-folder');
    $route->post('delete-folder/{project}', 'DeleteFoldersController@update')->name('delete-folder-update');

    $route->get('create/{type}', 'ProjectController@create')->name('project-create');
    $route->post('create/{type}', 'ProjectController@store')->name('project-store');

    $route->get('help/{slug}', 'Help')->name('help');

    $route->get('order/{order}/attachments', 'AttachmentsController@edit')->name('attachments');
    $route->post('order/{order}/attachments', 'AttachmentsController@update')->name('attachments-update');

    $route->get('order/{order}/budgets', 'BudgetController@edit')->name('budgets');
    $route->post('order/{order}/budgets', 'BudgetController@update')->name('budgets-update');

    $route->get('order/{order}/cancel', 'OrderCancelController@edit')->name('cancel-order');
    $route->post('order/{order}/cancel', 'OrderCancelController@update')->name('cancel-order-update');
    $route->post('order/{order}/delete', 'OrderCancelController@destroy')->name('cancel-order-destroy');

    $route->post('order/{order}/close', 'ProjectCloseController@order')->name('close-order');

    $route->get('order/{order}/department', 'DepartmentController@create')->name('department');
    $route->post('order/{order}/department', 'DepartmentController@store')->name('department-store');
    $route->post('order/{order}/department/submit', 'DepartmentController@store')->name('department-update');

    $route->get('order/{order}/items', 'ItemsController@edit')->name('items');
    $route->post('order/{order}/items', 'ItemsController@update')->name('items-update');

    $route->get('order/{order}/fiscal', 'FiscalController@edit')->name('fiscal');
    $route->post('order/{order}/fiscal', 'FiscalController@update')->name('fiscal-update');

    $route->get('order/{order}/log', 'Log')->name('log');

    $route->get('order/{order}/resubmit', 'ResubmitController@edit')->name('resubmit');
    $route->post('order/{order}/resubmit', 'ResubmitController@update')->name('resubmit-update');

    $route->get('order/{order}/next', 'Next')->name('next');

    $route->get('order/{order}/print', 'PrintOrder')->name('print');

    $route->get('order/{order}/project', 'ProjectController@edit')->name('project-edit');
    $route->post('order/{order}/project', 'ProjectController@update')->name('project-update');

    $route->get('order/{order}/folder', 'ProjectFolderController@edit')->name('folder');
    $route->post('order/{order}/folder', 'ProjectFolderController@update')->name('folder-update');

    $route->get('order/{order}/project/trip', 'TripsController@edit')->name('trip-edit');
    $route->post('order/{order}/project/trip', 'TripsController@update')->name('trip-update');

    $route->get('order/{order}/items/trip', 'TripItemsController@edit')->name('trip-items');
    $route->post('order/{order}/items/trip', 'TripItemsController@update')->name('trip-items-update');

    $route->get('order/{order}/trip-notes', 'TripNotesController@edit')->name('trip-notes');
    $route->post('order/{order}/trip-notes', 'TripNotesController@update')->name('trip-notes-update');

    $route->get('order/{order}', 'OrderController@show')->name('order');

    $route->get('order-types', 'OrderTypes')->name('order-types');

    $route->get('pending/{stage}', 'PendingOrders')->name('pending-orders');

    $route->get('pending-email', 'PendingEmail')->name('pending-email');

    $route->get('person', 'PersonController@index');

    $route->get('project/{project}/print', 'PrintProject')->name('print-project');
    $route->get('project/{project}/{adding?}', 'ProjectController@show')->name('project');
    $route->post('project/{project}/add', 'AddOrderToProject')->name('project-add-store');

    $route->post('project/{project}/close', 'ProjectCloseController@project')->name('close-project');

    $route->get('reports/{slug}', 'ShowReport')->name('reports');

    $route->get('search', 'Search')->name('search');
    $route->get('search/advanced', 'AdvancedSearchController')->name('advanced-search');

    $route->get('settings', 'SettingsController@index');
    $route->post('settings', 'SettingsController@store');

    $route->get('/user', 'UserController@index')->name('users');
    $route->get('/user/add', 'UserController@add')->name('user-create');
    $route->get('/user/{user}', 'UserController@show')->name('user-orders');
    $route->get('/user/{user}/edit', 'UserController@edit')->name('user-edit');
    $route->post('/user/{user}/edit', 'UserController@update')->name('user-update');

    $route->get('user-tasks', 'UserTasksController@index')->name('user-tasks-index');
    $route->get('user-tasks/{uwnetid}', 'UserTasksController@show')->name('user-tasks');

    $route->get('whoami', 'WhoamiController@index');
    $route->post('whoami', 'WhoamiController@update');
    $route->get('logout', 'WhoamiController@logout');

    $route->get('workflows', 'Workflows')->name('workflows');

    $route->get('api/ariba/{order}', 'AribaApiController@index')->name('ariba-api');
    $route->post('api/ariba/{order}', 'AribaApiController@store');
    $route->post('api/ariba/{order}/{ariba}', 'AribaApiController@update');

    $route->get('api/budgets', 'BudgetApiController@search');
    $route->get('api/budgets.json', 'BudgetApiController@prefetch');
    $route->get('api/budgets/{order}', 'BudgetsApiState')->name('budgets-api-state');

    $route->get('api/items/{order}/{trip?}', 'ItemsApiState')->name('items-api-state');

    $route->get('api/notes/{order}/{section?}', 'NoteApiController@index');
    $route->post('api/notes/{order}/{section}', 'NoteApiController@store');
    $route->post('api/notes/{note}', 'NoteApiController@update');

    $route->get('api/order/{order}/partial', 'OrderReadOnlyPartial')->name('order-partial');
    $route->get('api/order/{order}/refresh', 'OrderRefreshApi')->name('order-refresh-api');

    $route->get('api/on-call/{order}', 'OnCallApiController@show')->name('on-call-api');
    $route->post('api/on-call/{order}', 'OnCallApiController@update');

    $route->get('api/perdiem/{order}', 'PerdiemApiState')->name('perdiem-api-state');

    $route->get('api/tasks/{order}', 'TaskList')->name('tasks-api');
    $route->post('api/tasks/{order}', 'TaskUpdate')->name('tasks-update-api');

    $route->get('coming-soon', 'ComingSoon')->name('coming-soon');

    $route->get('mail', 'Mail');

});