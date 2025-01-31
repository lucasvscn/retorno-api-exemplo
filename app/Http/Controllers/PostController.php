<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return request()->expectsJson()
            ? ApiResponse::withData(Post::latest()->select(['id', 'title', 'created_at'])->get())->send()
            : view('post.index', [
                'posts' => Post::latest()->get()
            ]);
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post = Post::create($request->all());

        return request()->expectsJson()
            ? ApiResponse::withData($post->only(['id', 'title']))->send()
            : redirect()->route('post.index');
    }

    public function show(Post $post, \App\ApiResponse $response)
    {
        $response->statusCode = 200;
        $response->data = $post->only(['id', 'title', 'body', 'updated_at']);

        return $response->send();
    }
}
