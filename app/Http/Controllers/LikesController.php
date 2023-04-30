<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Likes;

class LikesController extends Controller
{
    //
    public function AddremoveLikes(Request $request)
    {
        $post = Likes::where('post_id', $request->post_id)->first();
        if (!($post->count == NULL || $post->count == 0)) {
            $user_id_array = json_decode($post->user_id);
            $post_user_id_array = array($request->user_id);
            $user_id = [];
            if ($request->likes > $post->count) {
                $user_id = json_encode(array_merge($user_id_array, $post_user_id_array));
            } else {
                $user_id = array_diff($user_id_array, array($request->user_id));
            }
            Likes::where('post_id', $request->post_id)->update(['count' => $request->likes, 'user_id' => $user_id]);
        } else {
            $user_id_array = array($request->user_id);
            $user_id = json_encode($post->user_id);
            Likes::where('post_id', $request->post_id)->update(['count' => $request->likes, 'user_id' => $user_id_array]);
        }
        return response()->json(['likes' => $request->likes], 200);
    }
}
