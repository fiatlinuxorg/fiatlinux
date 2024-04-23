<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentication
Route::post('/auth/register', 'App\Http\Controllers\Api\UserController@createUser');
Route::post('/auth/login', 'App\Http\Controllers\Api\UserController@loginUser');
Route::post('/auth/logout', 'App\Http\Controllers\Api\UserController@logoutUser')->middleware('auth:sanctum');
Route::post('/auth/update', 'App\Http\Controllers\Api\UserController@updateUser')->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    // Posts
    Route::get('/posts', 'App\Http\Controllers\HomeController@index')->name('posts');
    Route::get('/posts/{id}', 'App\Http\Controllers\HomeController@show')->name('posts.show')->whereNumber('id');
    Route::post('/posts', 'App\Http\Controllers\HomeController@store')->name('posts.store');
    Route::put('/posts/{id}', 'App\Http\Controllers\HomeController@update')->name('posts.update')->whereNumber('id');
    Route::delete('/posts/{id}', 'App\Http\Controllers\HomeController@destroy')->name('posts.destroy')->whereNumber('id');
    Route::get('/posts/{id}/comments', 'App\Http\Controllers\HomeController@comments')->name('posts.comments')->whereNumber('id');
    // Comments
    Route::get('/comments', 'App\Http\Controllers\CommentController@index')->name('comments');
    Route::get('/comments/{id}', 'App\Http\Controllers\CommentController@show')->name('comments.show')->whereNumber('id');
    Route::post('/comments', 'App\Http\Controllers\CommentController@store')->name('comments.store');
    Route::put('/comments/{id}', 'App\Http\Controllers\CommentController@update')->name('comments.update')->whereNumber('id');
    Route::delete('/comments/{id}', 'App\Http\Controllers\CommentController@destroy')->name('comments.destroy')->whereNumber('id');
});

// Frasi
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/frasi', 'App\Http\Controllers\FrasiController@index')->name('frasi');
    Route::get('/frasi/{id}', 'App\Http\Controllers\FrasiController@show')->name('frasi.show')->whereNumber('id');
    Route::get('frasi/random', 'App\Http\Controllers\FrasiController@random')->name('frasi.random');
    Route::post('/frasi', 'App\Http\Controllers\FrasiController@store')->name('frasi.store');
    Route::put('/frasi/{id}', 'App\Http\Controllers\FrasiController@update')->name('frasi.update')->whereNumber('id');
    Route::delete('/frasi/{id}', 'App\Http\Controllers\FrasiController@destroy')->name('frasi.destroy')->whereNumber('id');
});

Route::get('/post_images/{image}', function ($image) {
    return response()->file(storage_path('app/public/post_images/' . $image));
});

Route::get('/user_avatars/{image}', function ($image) {
    return response()->file(storage_path('app/public/user_avatars/' . $image));
});
