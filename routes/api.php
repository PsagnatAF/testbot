<?php

Route::resource('/', 'Api\TelegramBotController');
Route::get('/lessons/deletevideo', 'Api\LessonsController@deletevideo');
Route::post('/lessons/delaymethod', 'Api\LessonsController@delaymethod');