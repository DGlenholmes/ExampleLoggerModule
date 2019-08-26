<?php

Route::get('/', 'Controller@index');

Route::get('/logs-from-file', 'Controller@logsFromFile');

Route::get('/logs-from-database', 'Controller@logsFromDatabase');

Route::post('/', 'Controller@log');
