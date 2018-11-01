<?php

Route::get('permission', [
    'as' => 'permission.index',
    'uses' => 'Chudeusz\Permissions\Http\Controllers\PermissionController@index'
]);