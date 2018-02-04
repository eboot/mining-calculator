<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth;
use Response;

class AuthController extends Controller
{
    /**
     * Method to handle user login
     * @return JSON response with the result of the login
     */
    public function login(Request $request){
        $credentials = $request->only('login', 'password');
        try {

            if (!Auth::attempt($credentials)) {
                return response()->json(
                    [
                        'success' => false,
                        'data' => [],
                        'message' => 'Невозможно авторизоваться: логин или пароль неверны!'
                    ]);
            }
            $loggedUser = Auth::user();
            $token = JWTAuth::fromUser($loggedUser, ['name' => $loggedUser->name, 'type' => $loggedUser->type, 'user_id' => $loggedUser->id]);
        } catch (JWTException $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Error creating authentication token, please try again'], 500);
        }
        return response()->json(
            [
                'success' => true,
                'data' => [
                    'token' => $token,
                    'user' => $loggedUser,
                ],
                'message' => 'User authenticated successfully'], 200);
    }

    /**
     * Method to handle user logout
     * @return void
     */
    public function logout(){
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['success' => true, 'data' => [], 'message' => 'User logged out successfully'], 200);
    }

    public function getUser(){
        return response()->json(['success' => true, 'data' => Auth::user()], 200);
    }
}
