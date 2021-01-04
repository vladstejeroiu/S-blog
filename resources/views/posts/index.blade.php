@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Most Recent SooperBlog Posts</h1>
    <!-- Allow user to view posts by tag - all tags are displayed -->
    <p>Filter posts by tag:<br>
        @foreach ($tags as $tag)
        <a href="{{ route('posts.index', ['tag' => $tag->name]) }}" class="badge bg-dark">
            {{ $tag->name }}
        </a>
        @endforeach
    </p>
    <!-- Loop through all of the posts -->
    <!-- forelse allows an if/else approach within a loop (eg, IF there are posts do A, if not do B) -->
    @forelse ($posts as $post)
    <div class="card my-4">
        <!-- Check if the current post has an associated image -->
        @if (file_exists('storage/img/posts/post_img_' . $post->id . '.jpg'))
        <a href="/posts/{{ $post->id }}">
            <img src="/storage/img/posts/post_img_{{ $post->id }}.jpg" class="card-img-top" alt="{{ $post->heading }}">
        </a>
        <!-- If a photo doesn't exist, use a placeholder image (different for odd and even ids) -->
        <!-- Posts with an odd id (checks the id with bitchecking) -->
        @elseif ($post->id & 1)
        <a href="/posts/{{ $post->id }}">
            <img src="/storage/placeholder-sea.jpg" class="card-img-top" alt="Placeholder image for {{ $post->heading }}">
        </a>
        <!-- Posts with an even id -->
        @else
        <a href="/posts/{{ $post->id }}">
            <img src="/storage/placeholder-trees.jpg" class="card-img-top" alt="Placeholder image for {{ $post->heading }}">
        </a>
        @endif

        <div class="card-body">
            <!-- Post heading - links to the show.blade file (shows individual post) -->
            <h2 class="card-title">
                <a href="/posts/{{ $post->id }}" class="text-dark">
                    {{ $post->heading }}
                </a>
            </h2>
            <!-- Display information about when the post was written and who wrote it-->
            <!-- Date format of j F Y, g:ia displays the date as DD Month YYYY, HH:MM with am/pm -->
            <!-- The created_at->diffForHumans() function displays a user-friendly time based on the current time and created_at field (eg, 2 hour ago) -->
            <p>Written by <em>{{ $post->author->name }}</em> on {{ $post->created_at->format('j F Y, g:ia') }} ({{$post->created_at->diffForHumans()}})
                <!-- Check if post has been edited and show the time -->
                @if ($post->created_at != $post->updated_at)
                <br><small>Edited: {{ $post->updated_at->format('j F Y, g:ia') }}</small>
                @endif
            </p>
            <p>
                @foreach ($post->tags as $tag)
                <a href="{{ route('posts.index', ['tag' => $tag->name]) }}" class="badge bg-dark">
                    {{ $tag->name }}
                </a>
                @endforeach
            </p>

            <!-- If a user has an admin role, they can delete any post -->
            @if (Auth::user() && Auth::user()->role === 'admin')
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
            @endif
        </div>
    </div>

    <!-- If there are no posts -->
    @empty
    <p>No relevant articles yet!</p>
    @endforelse

    <!-- Displays posts with pagination -->
    <div>
        {{ $posts->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
