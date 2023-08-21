<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;

use App\Interfaces\AuthInterface;

class AuthController extends Controller
{
    private AuthInterface $repository;

    public function __construct(AuthInterface $repository){
        $this->repository = $repository;
    }

    public function login(Request $request){
        return $this->repository->login($request);
    }

    public function register(RegisterRequest $request){
        return $this->repository->register($request);
    }

    public function me(Request $request){
        return $this->repository->me($request);
    }

}
