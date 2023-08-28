<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        // echo Auth::id();

        $searchQuery = $request->input('search');
        $posts = Post::with('user', 'categories',)
            ->whereHas('categories', function ($query) use ($searchQuery) {
                $query->where('name', 'LIKE', '%' . $searchQuery . '%');
            })
            ->get();
        return view('post.read', compact('posts'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login first to create a post.');
        }
        $categories = Category::get();
        return view('post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'views' => 'required|integer',
        ]);

        // ...
        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->views = $request->views;
        $post->user_id = Auth::user()->id;
        $post->save();
        // Attach the selected category to the post
        $post->categories()->attach($request->category_id);

        return response()->json(['res' => 'Post created successfully', 'post'=>'$post']);
        // ...

    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('post.update', compact('post', 'categories'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'views' => 'required|integer',
            'category_id' => 'required', // Add validation for category_id
        ]);
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->views = $request->views;
        $post->save();

        // Update the categories for the post using sync
        $post->categories()->sync($request->category_id);

        return redirect()->route('posts.read')->with('success', 'Post data updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Check if the authenticated user is the owner of the post or an admin
        if (Auth::id() === $post->user_id || Auth::user()->isAdmin()) {
            $post->delete();
            return redirect()->back()->with('success', 'Post deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'You are not authorized to delete this post.');
        }
    }
}
