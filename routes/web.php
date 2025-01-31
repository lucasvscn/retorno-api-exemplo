<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/post', 'App\Http\Controllers\PostController@index')->name('post.index');
    Route::get('/post/create', 'App\Http\Controllers\PostController@create')->name('post.create');
    Route::post('/post', 'App\Http\Controllers\PostController@store')->name('post.store');
});

// Para fins de demonstraçõa, esta rota responde apenas JSON e não requer autenticação.
Route::get('/post/{post}', 'App\Http\Controllers\PostController@show')->name('post.show');

// Para simular a chamada via Web e API ao mesmo tempo, vamos criar uma rota
// que responde JSON e HTML ao mesmo tempo. Estou reaproveitando o método index
// do PostController para isso.
Route::get('/api/posts', 'App\Http\Controllers\PostController@index');

// Rota para simular o erro de validação em uma rota POST.
Route::post('/api/post', 'App\Http\Controllers\PostController@store');
