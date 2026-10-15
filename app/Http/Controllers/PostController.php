<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['images', 'comments'])->get();

        return response()->json($posts);
    }

    public function show($id)
    {
        $post = Post::with(['images', 'comments'])->find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post no encontrado'
            ], 404);
        }

        return response()->json($post);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'likes_count' => 0,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('post_images', 'public');

                $post->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        $post->load(['images', 'comments']);

        return response()->json($post, 201);
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post no encontrado'
            ], 404);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post eliminado correctamente'
        ]);
    }

    public function like($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post no encontrado'
            ], 404);
        }

        $post->increment('likes_count');

        return response()->json($post);
    }
}
