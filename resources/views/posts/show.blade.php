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
        <p class="card-subtitle text-muted">Likes: {{count($post->likes)}}</p>
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
        @endif

        <div class="mt-3">
            <a href="/posts" class="card-link">View all posts</a>
        </div>
      </div>
    </div>
@endsection


