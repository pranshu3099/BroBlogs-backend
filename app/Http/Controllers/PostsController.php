<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    //

    public function createPosts(Request $request)
    {
        Posts::create([
            'title' => $request->title,
            'content' => $request->Blog,
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
        ]);
    }
}
