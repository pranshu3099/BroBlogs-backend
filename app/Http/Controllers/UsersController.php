<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //

    public function getusers(Request $request)
    {
        try {
            $name = urldecode(request('q'));
            $users = User::where('name', 'LIKE', '%?%')->setBindings(['%' . $name . '%'])->get();
            $users = $users->toArray();
            return response()->json(['users' => $users], 200);
        } catch (\Exception $e) {
            return response()->json(['err' => $e], 400);
        }
    }
}
