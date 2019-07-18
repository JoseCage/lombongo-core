<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => [
                    $validator->errors(),
                ],
            ], 401);
        }

        $user = User::create(
            [
            'name' => $request->name,
            'email' => $request->email,
            //'username' => $request->username,
            'password' => Hash::make($request->password),
            ]
        );

        // Send mail to user
        //Mail::to($user->email)->send(new UserCreated($user));

        $token = JWTAuth::attempt($request->only('email', 'password'));

        // all good so return the token
        return response()->json(
            [
            'access_token' => $token,
            'token_type' => 'Bearer'
            ], 201
        );
    }

    // Login
    public function login(Request $request)
    {
        // Validate fields

        $validator = Validator::make($request->all(), [
            'email' => 'string|email',
            'password' => 'required',
        ]);

        try {

            // grab credentials from the request
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt(
                $request->only('email', 'password'), [
                'exp' => \Carbon\Carbon::now()->addWeek()->timestamp,
                ]
            )
            ) {
                return response()->json([ 'error' => 'invalid_credentials' ], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([ 'error' => 'could_not_create_token' ], 500);
        }

        // all good so return the token
        return response()->json(
            [
            'access_token' => $token,
            'token_type' => 'Bearer'
            ], 200
        );

    }

    public function getUser()
    {
        //$user_id = Auth::user()->id;

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                "message" => "User was not found!",
            ], 404);
        }

        return response()->json([
            "data" => [
                $user
            ],
        ], 200);

    }
}
