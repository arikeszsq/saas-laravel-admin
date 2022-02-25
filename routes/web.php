<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'IndexController@index');
Route::get('/result', 'IndexController@resultPage');
