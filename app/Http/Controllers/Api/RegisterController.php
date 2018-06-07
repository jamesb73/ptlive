<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use App\User;
use App\Group;


class RegisterController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function Register( Request $request)
    {
        $this->validateSignup($request);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make( $request->password),
        ]);

        $code = $request->group_code;

        $group = Group::whereHas('inviteCode', function ($query) use( $code) {
            $query->where('code', $code);
        })->first();

        $group->users()->syncWithoutDetaching([
            $user->id => [ 'is_admin' => 0]
        ]);
        
        return response()->json([
            'data' => [
                'user' => $user,
                'token' => JWTAuth::fromUser( $user)
            ]
        ]);
    }

    protected function validateSignup(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'group_code' => 'required|string|exists:groups_invite_codes,code',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|min:6|same:password',
        ], [
            'group_code.in' => 'Incorrect group code provided',
            '*.min' => 'password must be 6 characters minimum',
            'password_confirmation.same' => 'The password confirmation does not match'
        ]);
    }

}
