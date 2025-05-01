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


// Activity S2
// Define a route that returns a view for the welcome page.
Route::get('/', [PostController::class, 'welcome']);



//Stretch Goals (S2)
//1. Create a new route so that GET requests to the /myPosts endpoint will call the myPosts controller action.

// Define a route that returns a view containing only the authenticated user's posts.
Route::get('/myPosts', [PostController::class, 'myPosts']);

//3. In the index view we built in our discussion, we made the Post titles clickable links that show the post content. Define a route for this.

// Define a route that returns a view displaying a specific post based on the matching URL parameter ID.
Route::get('/posts/{id}', [PostController::class, 'show']);

/*
    Route Parameters or Wildcards {}: Route parameters are enclosed in curly braces {} and should consist of alphabetic characters. They are injected into route callbacks or controllers based on their order.
*/


// Define a route that returns an edit form for a specific post when a GET request is received at the /posts/{id}/edit endpoint.
Route::get('/posts/{id}/edit', [PostController::class, 'edit']);

//Define a route that will update an existing post with a matching URL parameter ID using the PUT Method

Route::put('/posts/{id}', [PostController::class, 'update']);

//Define a route that will delete a post with the matching URL parameter ID

Route::delete('/posts/{id}', [PostController::class, 'destroy']);