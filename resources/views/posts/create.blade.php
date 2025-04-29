{{-- 
	@ symbol is used to indicate the start of a blade directive
		- blade directives are special instructions or control structures that allows us to embed PHP codes and perform a lot of operations within blade templates
	
	@extends -> include a common structure from master layout/view

	master layout - contains the common structure of our web pages such as headers, footers, navigation menus and more

	@section('content')...@endsection -> define a named section in our blade view
	
	@csrf -> Cross Site Request Forgery

 --}}

@extends('layouts.app')

@section('content')

	<form method="POST" action="/posts">
		@csrf
		<div class="form-group">
			<label for="title">Title:</label>
			<input type="text" class="form-control" id="title" name="title">
		</div>
		<div class="form-group">
			<label for="content">Content:</label>
			<textarea class="form-control" id="content" name="content" rows="3"></textarea>
		</div>
		<div class="mt-2">
			<button type="submit" class="btn btn-primary">Create Post</button>
		</div>	
	</form>

@endsection