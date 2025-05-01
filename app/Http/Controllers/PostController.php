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


    // Activity S2
    // Action that returns a view displaying all blog posts
    public function welcome(){
        $posts = Post::inRandomOrder()
        ->limit(3)
        ->get();

        return view('welcome')->with('posts', $posts);
    }


    //Stretch Goals (S2)
    //2. Create a new action in the PostController named myPosts. This action will pass only the posts authored by the authenticated user to the index view.

    // Action for showing only the posts authored by the authenticated user
    public function myPosts() {
        if(Auth::user()){
            $posts = Auth::user()->posts;
            return view('posts.index')->with('posts', $posts);  
        }else{
            return redirect('/login');
        }
    }

    //4. Create an action that returns a view showing a specific post by using the URL parameter $id to query the database for the entry to be displayed.

    // Action that returns a view showing a specific post by using the URL parameter $id to query the database for the entry to be displayed
       public function show($id)
       {
           $post = Post::find($id);
           return view('posts.show')->with('post', $post);
       }


     // Action that returns an edit form for a specific post when a GET request is received at the /posts/{id}/edit endpoint.
    public function edit($id){
        //$post = Post::find($id);

        //Stretch Goal
        $post = Post::findOrFail($id); //this will return 404 if no records are found
        //return view('posts.edit')->with('post', $post);

        if(Auth::user()){
            if(Auth::user()->id == $post->user_id){
                return view('posts.edit')->with('post', $post);
            }
            return redirect('/posts');
        }
        else{
            return redirect('/login');
        }
    }

    //Action for updating an existing post with a matching URL parameter ID

    public function update(Request $request, $id){

        //find the post by its ID
        $post = Post::find($id);

        //check if the authenticated user's ID matches the post's user_id
        if(Auth::user()->id == $post->user_id){
            $post->title = $request->input('title');
            $post->content = $request->input('content');

            //save the updated post to the database
            $post->save();
        }

        return redirect('/posts');
    }

    //Action for deleting a post with the matching url parameter ID
    public function destroy($id){

        //check if the post exists
        $post = Post::find($id);
        //check if the authenticated user's ID matches the post's user_id
        if(Auth::user()->id == $post->user_id){
           //delete the post from the database
           $post->delete();
        }
        return redirect('/posts');
    }


}


//view method is used to render a specific view in the browser
//Blade (.blade.php) is Laravel's templating engine
    //to embed PHP code and provides additional features such as template inheritance, conditional statements, loops, and more
