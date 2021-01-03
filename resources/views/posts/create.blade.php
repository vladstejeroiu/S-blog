@extends('layouts.app')

@section('content')
<div id="wrapper">
    <div id="page" class="container">
        <h1 class="heading has-text-weight-bold is-size-4">Create Post</h1>

        <!-- Form uses csrf tag to prevent CSRF attacks -->
        <form method="POST" action="/posts" enctype="multipart/form-data" autocomplete="off">
            @csrf

            <div class="mb-3">
                <label for="heading" class="form-label">Heading</label>
                <!-- If there is an error, add a class -->
                <!-- Default value comes from the last submitted request -->
                <input type="text" class="form-control {{ $errors->has('heading') ? 'border-danger' : '' }}" id="heading" name="heading" value="{{ old('heading') }}">

                @error('heading')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="subheading" class="form-label">Subheading</label>
                <!-- If there is an error, add a class -->
                <!-- Default value comes from the last submitted request -->
                <textarea class="form-control {{ $errors->has('subheading') ? 'border-danger' : '' }}" name="subheading" id="subheading" rows="3">{{ old('subheading') }}</textarea>

                @error('subheading')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="body" class="form-label">Body</label>
                <!-- If there is an error, add a class -->
                <!-- Default value comes from the last submitted request -->

                <textarea class="form-control {{ $errors->has('body') ? 'border-danger' : '' }}" name="body" id="body" rows="5">{{ old('body') }}</textarea>

                @error('body')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <!-- If there is an error, add a class -->
                <!-- Default value comes from the last submitted request -->
                <input type="file" class="form-control {{ $errors->has('image') ? 'border-danger' : '' }}" id="image" name="image" value="">

                @error('image')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tags" class="form-label">Tags</label>
                <!-- If there is an error, add a class -->
                <!-- Default value comes from the last submitted request -->
                <select class="form-select {{ $errors->has('tags') ? 'border-danger' : '' }}" name="tags[]" id="tags" multiple>
                    @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
                <p class="form-text">(Hold ctrl/cmd to select multiple)</p>

                @error('tags')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <button class="btn btn btn-success" type="submit">Submit</button>
        </form>
    </div>
</div>
@endsection