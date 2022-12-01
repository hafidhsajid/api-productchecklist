<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth as JWTAuth;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        // $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required'
        // ]);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 400);
        }

        $credentials = $request->only('email', 'password');
        // $token = JWTAuth::attempt($credentials);
        try {

            if (!$token =  auth()->attempt($validator->validated())) {
                // if ($token = FacadesAuth::attempt($credentials)) {
                // $request->session()->regenerate();

                return response()->json([
                    'message' => 'Login Fail',
                    // 'user' => User::where('email', $request->email)->first()

                ], 401);
            }
            return $this->respondWithToken($token);
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'login failed',
                'error' => $e
            ], 400);
        }

        return response()->json([
            'message' => 'Email or password is wrong.'
        ], 401);
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 400);
        }
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        try {
            if ($user->save()) {
                return response()->json([
                    'message' => 'success',
                    'user' => $user
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'error',
                'error' => $th
            ]);
        } catch (\Error $e) {
            return response()->json([
                'message' => 'error',
                'error' => $e
            ], 500);
        }

        // return redirect()->route('login');
    }
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'token_type' => 'bearer',
            'user' => auth()->user(),
            'access_token' => $token,
        ]);
    }
}
