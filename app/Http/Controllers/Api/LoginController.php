<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login( Request $request)
    {
        $this->validateLogin( $request);

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt( $request->only('email', 'password'))) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json([
            'data' => [
                'user' => auth()->user(),
                'token' => $token
            ]
        ]);
    }

    public function logout(Request $request)
    {
        JWTAuth::invalidate( $request->token);

        return response()->json(['sccess' => true]);
    }
    
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
    }

}
