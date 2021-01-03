@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Viewing: {{ $post->heading }}</h1>
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
        </div>
    </div>
    <!-- Links back to the index.blade file (view all posts) -->
    <a href="{{ route('posts.index') }}" class="btn btn-dark">Back to Blog Posts</a>
</div>
@endsection