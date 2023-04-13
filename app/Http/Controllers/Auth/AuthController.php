<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    //

    private $httpcodes;
    private $responseHttpcodes;
    private $status;
    private $info;
    private $validation;
    private $data;


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        // $this->httpcodes = config('constants.HTTP_CODE');
        $this->validation = trans('api/common');
        $this->responseHttpcodes = BAD_REQUEST;
        $this->status = false;
        $this->info = null;
        $this->data = null;
    }


    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|between:2,100',
                'email' => 'required|string|email|max:100|unique:users',
                'password' => 'required|string|confirmed|min:6',
                'mobile_number' => 'required|digits:10|unique:users',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), BAD_REQUEST);
            }

            $user = User::create(array_merge(
                $validator->validated(),
                [
                    'name' => $request->name,
                    'password' => bcrypt($request->password),
                    'mobile_number' => $request->mobile_number,
                    'email' => $request->email,
                ]
            ));
            $this->responseHttpcodes = GET;
            $this->status = true;
            $this->info = CREATED_SUCCESS;
            $this->data = User::generateToken();
        } catch (\Exception $e) {
            $this->responseHttpcodes = INTERNAL_SERVER_ERROR;
            $this->info = EXCEPTION_ERROR;
        }
        $Response = $this->validateResult($this->status, $this->info, $this->data);
        return response()->json($Response, $this->responseHttpcodes);
    }

    public function validateResult($success = "", $info = "", $params = "")
    {
        return [
            'status' => $success,
            'information' => [$info],
            'data' => $params,
        ];
    }



    public function createToken($token)
    {
        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'access_token' => $token,
                'token_type' => 'bearer',
            ],
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();
        if (!isset($user)) {
            return response()->json(['error' => ['email' => 'email does not exist']], 401);
        } else {
            if (Hash::check($request->password, $user->password)) {
                $token = Auth::attempt($credentials);
                if (!$token) {
                    return response()->json(['status' => 'error', 'message' => 'unauthorized'], BAD_REQUEST);
                }
                $response = $this->createToken($token);
                return response()->json($response);
            } else {
                return response()->json(['error' => ['password' => 'incorrect password']], 401);
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
