<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Hash;
use Auth;
use App\Http\Resources\Auth\AuthResource;

class AuthMeAction
{
    public function execute($request)
    {
        return new AuthResource(Auth::user());
    }
}
