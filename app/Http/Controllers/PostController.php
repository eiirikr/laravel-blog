<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Access the authenticated user via the Auth

use Illuminate\Support\Facades\Auth;

//Import the Post Model
use App\Models\Post;

class PostController extends Controller
{
    //Action to return a view containing a form for creating a blogpost

    public function create()
    {
        return view('posts.create');
    }

    //Action to store a new blog post in the database

    public function store(Request $request)
    {

        //check if there is an authenticated user
        if(Auth::user()){
            //instantiate a new Post object from the Post Model
            $post = new Post;

            //define the properties of the $post object using the received form data
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            //Get the user ID of the authenticated user and set it as our FK (foreign key) user_id of the new post
            $post->user_id = (Auth::user()->id);
            //Save the post object in the database
            $post->save();

            return redirect('/posts');
        }else{
            return redirect('/login');
        }


    }
    //Action that returns a view (index.blade.php) displaying all() blog posts
    public function index()
    {
        $posts = Post::all();
        return view('posts.index')->with('posts',$posts);
    }

}


//view method is used to render a specific view in the browser
//Blade (.blade.php) is Laravel's templating engine
    //to embed PHP code and provides additional features such as template inheritance, conditional statements, loops, and more
