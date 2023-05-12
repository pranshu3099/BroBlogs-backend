<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //

    public function create(Request $request)
    {
        $comment = Comment::where('posts_id', $request->post_id)->first();
        $user_id = array($request->user_id);
        $user_comment = array($request->comment);
        if (!$comment) {
            Comment::create([
                'posts_id' => $request->post_id,
                'user_id' => json_encode($user_id),
                'comment' => json_encode($user_comment),
                'likes' => $request->likes,
            ]);
        } else {
            $userId_array = json_decode($comment->user_id);
            $userId_array = array_merge($userId_array, $user_id);
            $comment_array = json_decode($comment->comment);
            $comment_array = array_merge($comment_array, $user_comment);
            Comment::where('posts_id', $request->post_id)->update(['comment' => json_encode($comment_array), 'user_id' => json_encode($userId_array)]);
            return response()->json('success', 200);
        }
    }
}
