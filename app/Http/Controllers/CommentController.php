<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Exception;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


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

    public function getComments(Request $request, $id)
    {
        try {
            $comments = Comment::where('posts_id', $id)->first();
            $index = 0;
            $user_comment = json_decode($comments->comment);
            $results = DB::table('users')->join('comments', function ($join) use ($comments) {
                $join->whereIn('users.id', json_decode($comments->user_id));
            })->select('users.name')->get()->toArray();
            $results =  array_map(function ($item) use ($user_comment, &$index) {
                $item->comment = $user_comment[$index];
                $index++;
                return $item;
            }, $results);
            return response()->json(['comments' => $results], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
