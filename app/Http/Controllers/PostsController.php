<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use App\Models\Posts;
use Exception;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    //

    public function createPosts(Request $request)
    {
        try {
            Posts::create([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => $request->user_id,
                'category_id' => $request->category_id,
                'post_id' => $request->post_id,
            ]);
            Likes::create([
                'category_id' => $request->category_id,
                'post_id' => $request->post_id,
            ]);
            return response()->json(['success' => 'Post created Successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'oops an error occured'], 400);
        }
    }

    public function getHomePost()
    {
        $results = Posts::with(['user' => function ($query) {
            $query->select('name', 'id');
        }])
            ->where('post_id', 3805)
            ->first()
            ->toArray();
        $likes_count = Likes::where('post_id', $results['post_id'])->first('count')->toArray();
        $results = array_merge($results, $likes_count);
        return response()->json([$results], 200);
    }
}
