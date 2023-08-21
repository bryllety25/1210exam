<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Hash;
use Auth;
use App\Models\User;
use App\Http\Resources\Auth\AuthResource;

class AuthRegisterAction
{
    public function execute($request)
    {
        $data = $request->validated();
        $record = User::create($data);

        return new AuthResource($record);
    }
}
