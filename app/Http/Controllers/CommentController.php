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
        $user_id = $request->user_id;
        $user_comment = $request->comment;
        Comment::create([
            'posts_id' => $request->post_id,
            'user_id' => $user_id,
            'comment' => $user_comment,
            'likes' => $request->likes,
        ]);
        return response()->json('success', 200);
    }

    public function getComments(Request $request, $id)
    {
        try {
            $results = DB::table('users')
                ->join('comments', 'users.id', '=', 'comments.user_id')
                ->where('comments.posts_id', $id)
                ->select('users.name', 'comments.comment')
                ->get()
                ->toArray();
            return response()->json($results, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
