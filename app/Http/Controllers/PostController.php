<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use App\Models\Post;
use App\Models\Tag;

class PostController extends Controller
{
    // Show all posts
    public function index()
    {
        // Get all tag names, order by A-Z
        $tags = Tag::orderBy('name', 'asc')->get('name');
        // Check if a tag is within the request
        if (request('tag')) {
            $posts = Tag::where('name', request('tag'))->firstOrFail()->posts()->paginate(10); // Shows posts containing a certain tag and paginates
        } else {
            // Could use latest()->get();...latest()->take(x);...latest()->paginate(x);
            $posts = Post::latest()->paginate(10); // Shows latest posts and paginates
        }

        // Return the posts>index view (blade file)
        return view('posts.index', ['posts' => $posts, 'tags' => $tags]); // Pass posts and tags as an argument
    }

    // Show a single post (based on an id)
    public function show(Post $post)
    {
        // Return the posts>show view (blade file)
        return view('posts.show', ['post' => $post]); // Pass posts as an argument
    }

    // When a new post is to be created, return the create form
    public function create()
    {
        // Return the posts>create view (blade file)
        return view('posts.create', [
            'tags' => Tag::all() // Pass tags as an argument
        ]);
    }

    // Validate user input from create form and persist to database
    public function store()
    {
        // Validate the input using the reusable validation function
        $this->validatePost();

        // Create a new post instance
        $post = new Post(request(['heading', 'subheading', 'body']));

        // Set the user_id FK as the logged in user's id
        $post->user_id = Auth::id();

        // Save the post to the database
        $post->save();

        // Check if an image is included in the request
        if (request('image')) {
            // Get the image from the request
            $path = request('image');

            // Specify save location for image - public/storage/img/posts
            $path->storeAs(
                '/img/posts',
                'post_img_' . $post->id . '.jpg', // Save images as post_img_[id].jpg
                'public'
            );
        }

        // Attach any tags in the request to the post
        $post->tags()->attach(request('tags'));

        // Return a redirect to the home view (blade file) - uses a named route 'home'
        return redirect(route('home'));
    }

    // When a post is to be edited, return the edit form
    public function edit(Post $post)
    {
        // Check if PostPolicy allows current user to edit this post
        abort_unless(Gate::allows('update', $post), 403);

        // Return the posts>edit view (blade file)
        return view('posts.edit', [
            'post' => $post, // Pass posts an argument
            'tags' => Tag::all() // Pass tags as an argument
        ]);
    }

    // Validate user input from update form and persist to database
    public function update(Post $post)
    {
        // Check if PostPolicy allows current user to persist changes to this post
        abort_unless(Gate::allows('update', $post), 403);

        // Update the post, checking it is valid using the reusable validation function
        $post->update($this->validatePost());

        // Check if an image is included in the request
        if (request('image')) {
            // Get the image from the request
            $path = request('image');

            // Specify save location for image - public/storage/img/posts
            $path->storeAs(
                '/img/posts',
                'post_img_' . $post->id . '.jpg', // Save images as post_img_[id].jpg
                'public'
            );
        }

        // Check if the request contains any tags
        if (request('tags')) {
            // Detach any existing tags
            $post->tags()->detach(); // Avoids duplication of tags
            // Attach the tags in the request to the post
            $post->tags()->attach(request('tags'));
        }

        // Return a redirect to the home view (blade file) - uses a named route 'home'
        return redirect(route('home'));
    }

    // Deletes a specific post based on an id
    public function destroy(Post $post)
    {
        // Check if PostPolicy allows current user to delete this post
        abort_unless(Gate::allows('delete', $post), 403);

        // Removes specified post
        $post->destroy($post->id);

        // Return a redirect to the home view (blade file) - uses a named route 'home'
        return redirect(route('home'));
    }

    // Validates user input from the creating or updating of posts
    protected function validatePost()
    {
        // Returns a validated request
        return request()->validate([
            'heading' => 'required', // Field is required
            'subheading' => 'required', // Field is required
            'body' => 'required', // Field is required
            'image' => 'mimes:jpg,jpeg,png,gif,bmp|max:2048', // Image validation - specifies mime types and max size (in KB)
            'tags' => 'exists:tags,id' // Only tags with an existing id can be used - prevents use of faked tags
        ]);
    }
}
