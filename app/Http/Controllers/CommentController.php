<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Mail\NewCommentMail;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public function index($postId)
    {
        $post = Post::find($postId);

        if (!$post) {
            return response()->json([
                'message' => 'Post no encontrado'
            ], 404);
        }

        $comments = Comment::where('post_id', $postId)->get();

        return response()->json($comments);
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
        'content' => 'required|string',
    ]);

    $comment = Comment::create([
        'post_id' => $post->id,
        'author' => $request->user()->name,
        'content' => $request->content,
    ]);

    Mail::to($post->user->email)
        ->send(new NewCommentMail($comment));

    return response()->json($comment, 201);
}

}