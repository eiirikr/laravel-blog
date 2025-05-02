{{--  5. Create a view named show in the views subdirectory that will show the individual post --}}
@extends('layouts.app')

@section('content')
    <div class="card">
      <div class="card-body">
        <h2 class="card-title">{{$post->title}}</h2>
        <p class="card-subtitle text-muted">Author: {{ $post->user->name }}</p>
        {{-- Add a like counter --}}
        <p class="card-subtitle text-muted mb-3">Created at: {{$post->created_at}}</p>
        <p class="card-text">{{$post->content}}</p>
        <p class="card-subtitle text-muted">Likes: {{count($post->likes)}} | Comments: {{count($post->comments)}}</p>
        {{-- Add a toggle button for liking and unliking a post in the show post view (until 6:15PM)--}}

        @if(Auth::user())
          @if(Auth::id() != $post->user_id)
          <form class="d-inline" method="POST" action="/post/{{$post->id}}/like">
            @method('PUT')
            @csrf

            @if($post->likes->contains("user_id",Auth::id()))
              <button type="submit" class="btn btn-danger">Unlike</button>
            @else
              <button type="submit" class="btn btn-success">Like</button>
            @endif
          </form>
          @endif


          <!-- Modal button Start -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#commentModal">
                Post Comment
            </button>
            <!-- Modal button End -->

        @endif



        <div class="mt-3">
            <a href="/posts" class="card-link">View all posts</a>
        </div>
      </div>
    </div>

    <!-- Comment Section Start -->
    @if(count($post->comments) > 0)
        <h4 class="mt-5">Comments:</h4>
        <div class="card">
            <ul class="list-group list-group-flush">
                @foreach ($post->comments as $comment)
                    <li class="list-group-item">
                        <p class="text-center">{{$comment->content}}</p>
                        <p class="text-end text-muted">posted by: {{$comment->user->name}}</p>
                        <p class="text-end text-muted">posted on: {{$comment->created_at}}</p>
                    </li>   
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Comment Section End -->

    <!-- Modal Start -->
    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentModalLabel">Post a Comment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/posts/{{$post->id}}/comment">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="content">Content:</label>
                            <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post Comment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End -->

@endsection


