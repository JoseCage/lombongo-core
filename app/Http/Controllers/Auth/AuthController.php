<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;

use AppModels\User;
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

        // Create the new User
        $user = User::firstOrNew([
            'name' => $request->name,
            'email' => $request->email,
            //'firebase_token' => $request->firebase_token,
            'password' => Hash::make($request->name),
        ]);

        if ($use['id']) {
            return response()->json([
                'error' => 'This user already exist. Try to login please!',
            ], 401);
        }

        $user->save();

        // Notify the User that his account is set

        // Generate the token after
        $token = JWTAuth::attempt($request->only('email', 'pssword'));

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'name' => $user->name,
                'email' => $user->email
            ]
        ], 201);
    }

    // Login
    public function login(Request $requst)
    {
        // Validate fields

        $validator = Validator::make($request->all(), [
            'email' => 'string|email',
            'password' => 'required',
        ]);

        /**
         * Test if user passed an email and return something
         */

        $credentials = $request->only('email', 'password');

        // Work in JWT
        $token = JWTAuth::attempt($credentials);

        try {
            if (!$token) {
                return response()->json([
                    'error' => 'Invalid Credentials!',
                ], 401);
            }

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email
                ],
            ], 200);

        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not create token!',
            ], 500);
        }
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
