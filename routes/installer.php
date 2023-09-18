<?php

Route::get('/install/run-db', 'Install\InstallController@runDB');

Route::post('/install/server-requirements', 'Install\InstallController@checkServer');

Route::post('/install/permissions', 'Install\InstallController@checkPermission');

Route::post('/install/database', 'Install\InstallController@processDatabase');

Route::get('/install/update', 'Install\InstallController@confirmUpdate');

Route::post('/install/update/do_update', 'Install\InstallController@update');

Route::get('/install/update/success', 'Install\InstallController@updated_success');


Route::get('/install/{tab?}', 'Install\InstallController@index')->name('install.index');
