<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;

class AccController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::whereName($request->username)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::loginUsingId($user->id, $request->remember);
            return ['success' => true];
        }else {
            return ['success' => false, 'message' => __('WRONG_CREDENTIALS')];
        }
    }
}
