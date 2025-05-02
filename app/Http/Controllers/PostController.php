<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Access the authenticated user via the Auth

use Illuminate\Support\Facades\Auth;

//Import the Post Model
use App\Models\Post;


//Import the Post Like Model
use App\Models\PostLike;

use App\Models\PostComment;


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
        //$posts = Post::all();
        $posts = Post::where('isActive', true)->get();
        return view('posts.index')->with('posts',$posts);
    }


    // Activity S2
    // Action that returns a view displaying all blog posts
    public function welcome(){
        $posts = Post::inRandomOrder()
        ->where('isActive', true)
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

     // Action to archive a post by setting its 'isActive' property to false
    public function archive($id)
    {
        // Find the post by its ID
        $post = Post::find($id);

        // Check if the authenticated user's ID matches the post's user_id
        if(Auth::user()->id == $post->user_id){
            // Set the 'isActive' property to false to archive the post
            $post->isActive = false;
            // Save the updated post to the database
            $post->save();
        }
        // Redirect to the posts page after archiving
        return redirect('/posts');
    }

    //Action for liking and unliking of a post by an authenticated user

    public function like($id){

        //find post by its ID
        $post = Post::find($id);
        //get the id of the currently authenticated user
        $user_id = Auth::user()->id;

        //check if the authenticated user is not the post author
        if($post->likes->contains("user_id",$user_id)){
            //Unlike the post by deleting the existing like record
            PostLike::where('post_id',$post->id)->where('user_id',$user_id)->delete();

        }else{

            //like the post by creating a new like record
            //instantiate a new PostLike object from the PostLike model
            $postLike = new PostLike;

            //set the properties of the new PostLike object
            $postLike->post_id = $post->id;
            $postLike->user_id = $user_id;

            //save the new like record in the database
            $postLike->save();

        }

        //redirect back to the post page
        return redirect("/posts/$id");
    }


    // Action for commenting on a post by an authenticated user
    public function comment(Request $request, $id)
    {
        // Get the ID of the currently authenticated user
        $post = Post::find($id);
        $user_id = Auth::user()->id;

        // Check if the user is authenticated
        if(Auth::user()){

        // Create a new comment instance
        $postComment = new PostComment;

        // Set the user ID and post ID for the comment
        $postComment->user_id = $user_id;
        $postComment->post_id = $post->id;

        // Set the content of the comment
        $postComment->content = $request->input('content');

        // Save the comment to the database
        $postComment->save();

        // Redirect to the post page with a success message
        return redirect("/posts/$id")->with('comment', 'Leave a comment successfully');
        }else {
            // Redirect to the login page if the user is not authenticated
            return redirect('login');
        }
    }


}


//view method is used to render a specific view in the browser
//Blade (.blade.php) is Laravel's templating engine
    //to embed PHP code and provides additional features such as template inheritance, conditional statements, loops, and more
