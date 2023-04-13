<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    //

    public function getAllCategories()
    {
        $categories = DB::table('categories')->get()->toArray();
        return response()->json($categories, 200);
    }
}
