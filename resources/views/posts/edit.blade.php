@extends('layouts.app')

@section('content')
<div id="wrapper">
    <div id="page" class="container">
        <h1 class="heading has-text-weight-bold is-size-4">Update Post: {{ $post->heading }}</h1>

        <!-- Form uses csrf tag to prevent CSRF attacks -->
        <!-- Send a spoofed PUT request using method('PUT') -->
        <form method="POST" action="/posts/{{ $post->id }}" enctype="multipart/form-data" autocomplete="off">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="heading" class="form-label">Heading</label>
                <!-- If there is an error, add a class -->
                <!-- Default value comes from existing post -->
                <input type="text" class="form-control {{ $errors->has('heading') ? 'border-danger' : '' }}" id="heading" name="heading" value="{{ $post->heading }}">

                @error('heading')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="subheading" class="form-label">Subheading</label>
                <!-- If there is an error, add a class -->
                <!-- Default value comes from existing post -->
                <textarea class="form-control {{ $errors->has('subheading') ? 'border-danger' : '' }}" name="subheading" id="subheading" rows="3">{{ $post->subheading }}</textarea>

                @error('subheading')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="body" class="form-label">Body</label>
                <!-- If there is an error, add a class -->
                <!-- Default value comes from existing post -->
                <textarea class="form-control {{ $errors->has('body') ? 'border-danger' : '' }}" name="body" id="body" rows="5">{{ $post->body }}</textarea>

                @error('body')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <p class="mb-3">
                Current Image:
                <br>
                @if (file_exists('storage/img/posts/post_img_' . $post->id . '.jpg'))
                <img src="/storage/img/posts/post_img_{{ $post->id }}.jpg" style="width:auto;max-height:40vh;object-fit:cover;" alt="{{ $post->heading }}">
                @else
                No image.
                @endif
            </p>

            <div class="mb-3">
                <label for="image" class="form-label">Choose New Image</label>
                <!-- If there is an error, add a class -->
                <!-- Default value comes from existing post -->
                <input type="file" class="form-control {{ $errors->has('image') ? 'border-danger' : '' }}" id="image" name="image" value="">

                @error('image')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tags" class="form-label">Tags</label>
                <!-- If there is an error, add a class -->
                <!-- Default value comes from existing post -->
                <select class="form-select {{ $errors->has('tags') ? 'border-danger' : '' }}" name="tags[]" id="tags" multiple>
                    @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
                <p class="form-text">(Hold ctrl/cmd to select multiple)</p>
                <p class="form-text">To keep the existing tags, ignore this section</p>
                <p class="my-2">
                    Existing tags:
                    @foreach ($post->tags as $tag)
                    <span class="badge bg-dark">{{ $tag->name }}</span>
                    @endforeach
                </p>

                @error('tags')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <button class="btn btn btn-success" type="submit">Submit</button>
        </form>
    </div>
</div>
@endsection