<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\PostLike;

class PostController extends Controller
{
    
public function index()
{
    $posts = Post::with(['user', 'images', 'comments'])
        ->orderBy('id', 'desc')
        ->paginate(10);

    return response()->json($posts);
}


    public function show($id)
    {
        $post = Post::with(['user', 'images', 'comments'])->find($id);

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
            'user_id' => $request->user()->id,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('post_images', 'public');

                $post->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        $post->load(['user', 'images', 'comments']);

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

    public function like(Request $request, $id)
{
    $post = Post::find($id);

    if (!$post) {
        return response()->json([
            'message' => 'Post no encontrado'
        ], 404);
    }

    $user = $request->user();

    $likeExistente = PostLike::where('post_id', $post->id)
        ->where('user_id', $user->id)
        ->first();

    if ($likeExistente) {
        return response()->json([
            'message' => 'Ya has dado like a esta publicación',
            'likes_count' => $post->likes_count
        ], 409);
    }

    PostLike::create([
        'post_id' => $post->id,
        'user_id' => $user->id,
    ]);

    $post->increment('likes_count');

    return response()->json([
        'message' => 'Like registrado correctamente',
        'likes_count' => $post->fresh()->likes_count
    ]);
}
}
