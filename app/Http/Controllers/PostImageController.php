<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostImageController extends Controller
{
    public function index($postId)
    {
        $post = Post::find($postId);

        if (!$post) {
            return response()->json([
                'message' => 'Post no encontrado'
            ], 404);
        }

        return response()->json($post->images);
    }

    public function store(Request $request, $postId)
    {
        $post = Post::find($postId);

        if (!$post) {
            return response()->json([
                'message' => 'Post no encontrado'
            ], 404);
        }

        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $savedImages = [];

        foreach ($request->file('images') as $image) {
            $path = $image->store('post_images', 'public');

            $savedImages[] = $post->images()->create([
                'image_path' => $path,
            ]);
        }

        return response()->json([
            'message' => 'Imágenes guardadas correctamente',
            'images' => $savedImages,
        ], 201);
    }

    public function destroy($id)
    {
        $image = \App\Models\PostImage::find($id);

        if (!$image) {
            return response()->json([
                'message' => 'Imagen no encontrada'
            ], 404);
        }

        Storage::disk('public')->delete($image->image_path);

        $image->delete();

        return response()->json([
            'message' => 'Imagen eliminada correctamente'
        ]);
    }
}