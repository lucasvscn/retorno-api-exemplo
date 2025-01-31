<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/post', 'App\Http\Controllers\PostController@index')->name('post.index');
Route::get('/post/create', 'App\Http\Controllers\PostController@create')->name('post.create');
Route::post('/post', 'App\Http\Controllers\PostController@store')->name('post.store');
