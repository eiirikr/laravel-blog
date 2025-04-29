<?php

use Illuminate\Support\Facades\Route;

//Link the PostController for handling post-related actions

use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Define  a route that returns a view for creating a post to the user
Route::get('/posts/create',[PostController::class,'create']);

//Define a route that handles form data sent via POST method to the /posts URI endpoint
Route::post('/posts',[PostController::class,'store']);

//Define a route that returns a view containing all posts
Route::get('/posts',[PostController::class,'index']);