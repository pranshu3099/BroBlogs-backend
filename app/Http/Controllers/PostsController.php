<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Likes;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function getHomePost(Request $request)
    {
        $results = Posts::with(['user' => function ($query) {
            $query->select('name');
        }])
            ->join('likes', 'likes.post_id', '=', 'posts.post_id')
            ->join('users', 'users.id', '=', 'posts.user_id') // Add this join clause
            ->select('posts.title', 'posts.category_id', 'posts.post_id', 'posts.content', 'users.name', 'likes.count')
            ->get()->toArray();
        $user_id = $request->user()->id;
        $results =  array_map(function ($item) use ($user_id) {
            $item['user_id'] = $user_id;
            return $item;
        }, $results);
        return response()->json($results, 200);
    }

    public function getUserPost(Request $request)
    {
        $user_id = $request->user()->id;
        $results = Posts::with(['user' => function ($query) {
            $query->select('name');
        }])
            ->join('likes', 'likes.post_id', '=', 'posts.post_id')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->where('users.id', $user_id) // Add this join clause
            ->select('posts.title', 'posts.category_id', 'posts.post_id', 'posts.content', 'users.name', 'likes.count')
            ->get()->toArray();
        $results =  array_map(function ($item) use ($user_id) {
            $item['user_id'] = $user_id;
            return $item;
        }, $results);
        return response()->json($results, 200);
    }

    public function getSinglePost(Request $request, $id)
    {
        $user_id = $request->user()->id;
        $results = DB::table('users')
            ->join('posts', 'users.id', '=', 'posts.user_id')
            ->join('likes', 'likes.post_id', '=', 'posts.post_id')
            ->where('posts.post_id', $id)
            ->select('posts.title', 'posts.category_id', 'posts.post_id', 'posts.content', 'users.name', 'users.email', 'users.created_at', 'likes.count')
            ->get()
            ->toArray();
        $results =  array_map(function ($item) use ($user_id) {
            $item->user_id = $user_id;
            return $item;
        }, $results);
        return response()->json($results, 200);
    }
}
