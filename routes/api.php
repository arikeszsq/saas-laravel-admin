<?php

use Illuminate\Support\Facades\Route;


Route::any('/add', 'IndexController@add');
Route::any('/update', 'IndexController@update');
Route::any('/upload', 'IndexController@upload');

Route::any('/upload-file', 'IndexController@uploadFile');


