<?php

Route::get('/permission/{permission}/{user}/{value}', [
    'as' => 'permission.update',
    'uses' => 'Chudeusz\Permissions\Http\Controllers\PermissionController@update'
])->middleware('can:permission.update');