<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Hash;
use Auth;

class AuthLoginAction
{
    public function execute($request)
    {
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('indx-dental')->plainTextToken;
            return $success;
        }
        else{
            return response()->json(['error'=>'Unauthorized','message'=>'Invalid email or password'], 401);
        }
    }
}
