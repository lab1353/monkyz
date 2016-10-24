<?php

Route::group(['prefix' => config('monkyz.prefix'), 'middleware'=>['web'] ], function () {
	// panel
	Route::get('/', [ 'as'=>'monkyz.dashboard', 'uses'=>'Lab1353\Monkyz\Controllers\PanelController@getDashboard' ]);
	Route::get('/info', [ 'as'=>'monkyz.info', 'uses'=>'Lab1353\Monkyz\Controllers\PanelController@getInfo' ]);

	// dynamic
	Route::get('/{section}/list', [ 'as'=>'monkyz.dynamic.list', 'uses'=>'Lab1353\Monkyz\Controllers\DynamicController@getList' ]);
	Route::get('/{section}/add', [ 'as'=>'monkyz.dynamic.add', 'uses'=>'Lab1353\Monkyz\Controllers\DynamicController@getEdit' ]);
	Route::get('/{section}/edit/{id}', [ 'as'=>'monkyz.dynamic.edit', 'uses'=>'Lab1353\Monkyz\Controllers\DynamicController@getEdit' ]);
	Route::post('/{section}/save', [ 'as'=>'monkyz.dynamic.save', 'uses'=>'Lab1353\Monkyz\Controllers\DynamicController@postSave' ]);
	Route::get('/{section}/delete/{id}', [ 'as'=>'monkyz.dynamic.delete', 'uses'=>'Lab1353\Monkyz\Controllers\DynamicController@getDelete' ]);

	// settings
	Route::get('/settings', [ 'as'=>'monkyz.settings', 'uses'=>'Lab1353\Monkyz\Controllers\SettingsController@getIndex' ]);
	Route::post('/settings/counters', [ 'as'=>'monkyz.settings.counters', 'uses'=>'Lab1353\Monkyz\Controllers\SettingsController@postCounters' ]);

	// tools
	Route::get('/tools/files', [ 'as'=>'monkyz.tools.files', 'uses'=>'Lab1353\Monkyz\Controllers\ToolsController@getFiles' ]);
	Route::get('/tools/files/clean', [ 'as'=>'monkyz.tools.files.clean', 'uses'=>'Lab1353\Monkyz\Controllers\ToolsController@getFilesClean' ]);

	// users
	Route::get('/users/login', [ 'as'=>'monkyz.users.login', 'uses'=>'Lab1353\Monkyz\Controllers\UsersController@getLogin' ]);
	Route::post('/users/login', [ 'as'=>'monkyz.users.login', 'uses'=>'Lab1353\Monkyz\Controllers\UsersController@postLogin' ]);
	Route::get('/users/logout', [ 'as'=>'monkyz.users.logout', 'uses'=>'Lab1353\Monkyz\Controllers\UsersController@getLogout' ]);
});
