@extends('layouts.app')

@section('content')
<!-- Jumbotron shows some basic nformation and links to login/register -->
<div class="jumbotron mb-0 text-center">
    <h1>Welcome to SooperBlog</h1>
    <hr>
    <p>Feel free to read through the blog posts, or start creating your own!</p>
    <a class="btn btn-dark mb-3" href="{{ route('posts.index') }}">Recent Posts</a>
    <p>To create or edit your own blog posts, <a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">Register</a>.
    </p>
</div>
@endsection