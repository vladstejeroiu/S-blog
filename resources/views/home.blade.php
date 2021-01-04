@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Home</h1>
    <div class="row justify-content-center my-4">
        <div class="col-md-8">
            <div class="card">
                <!-- Message welcoming user -->
                <div class="card-header">You are logged in {{ Auth::user()->name }}!</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <!-- Link to create a post -->
                    <a href="{{ url('/posts/create') }}" class="btn btn-dark d-block my-3">Create Post</a>

                    <!-- Logout link -->
                    <a class="btn btn-secondary d-block my-3" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <!-- Form uses csrf tag to prevent CSRF attacks -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <h2 id="my-posts">My Posts</h2>
    <!-- Display how many posts the current user has written -->
    <p>You've written {{ Auth::user()->posts->count() }} blog posts.</p>
    <!-- Loop through all of the current users posts -->
    @forelse ($posts as $post)
    <div class="card my-4">
        <!-- Check if the current post has an associated image -->
        @if (file_exists('storage/img/posts/post_img_' . $post->id . '.jpg'))
        <img src="/storage/img/posts/post_img_{{ $post->id }}.jpg" class="card-img-top" alt="{{ $post->heading }}">
        <!-- If a photo doesn't exist, use a placeholder image (different for odd and even ids) -->
        <!-- Posts with an odd id (checks the id with bitchecking) -->
        @elseif ($post->id & 1)
        <img src="/storage/placeholder-sea.jpg" class="card-img-top" alt="Placeholder image">
        <!-- Posts with an even id -->
        @else
        <img src="/storage/placeholder-trees.jpg" class="card-img-top" alt="Placeholder image">
        @endif

        <div class="card-body">
            <!-- Post heading -->
            <h2 class="card-title">{{ $post->heading }}</h2>
            <!-- Display information about when the post was written and who wrote it-->
            <!-- Date format of j F Y, g:ia displays the date as DD Month YYYY, HH:MM with am/pm -->
            <!-- The created_at->diffForHumans() function displays a user-friendly time based on the current time and created_at field (eg, 2 hour ago) -->
            <p>Written by <em>{{ $post->author->name }}</em> on {{ $post->created_at->format('j F Y, g:ia') }} ({{$post->created_at->diffForHumans()}})
                <!-- Check if post has been edited and show the time -->
                @if ($post->created_at != $post->updated_at)
                <br><small>Edited: {{ $post->updated_at->format('j F Y, g:ia') }}</small>
                @endif
            </p>
            <!-- Post subheading -->
            <h3>{{ $post->subheading }}</h3>
            <!-- Post body text - characters are escaped, except new lines are formatted as <br> tags -->
            <p>{!! nl2br(e($post->body)) !!}</p>
            <p>
                <!-- Loops through the post's tags -->
                @foreach ($post->tags as $tag)
                <a href="{{ route('posts.index', ['tag' => $tag->name]) }}" class="badge bg-dark">
                    {{ $tag->name }}
                </a>
                @endforeach
            </p>
            <!-- Button to edit a post -->
            <a href="/posts/{{$post->id}}/edit" class="btn btn-dark px-4">Edit</a>

            <!-- Form uses csrf tag to prevent CSRF attacks -->
            <!-- Form method spoofed with 'DELETE' -->
            <form method="POST" action="/posts/{{ $post->id }}" class="d-inline-block">
                @csrf
                @method('DELETE')

                <div class="form-group">
                    <!-- Link to delete a post -->
                    <input type="submit" class="btn btn-danger px-4" value="Delete">
                </div>
            </form>
        </div>
    </div>

    <!-- If there are no posts -->
    @empty
    <p>Time to get writing {{ Auth::user()->name }}!</p>

    @endforelse
</div>
@endsection
