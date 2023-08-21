<?php
namespace App\Repository;

use App\Interfaces\AuthInterface;

use App\Actions\Auth\AuthLoginAction;
use App\Actions\Auth\AuthRegisterAction;
use App\Actions\Auth\AuthMeAction;

class AuthRepository implements AuthInterface{

    public function login($request){
        $action = new AuthLoginAction();
        $data = $action->execute($request);
        return $data;
    }

    public function register($request){
        $action = new AuthRegisterAction();
        $data = $action->execute($request);
        return $data;
    }

    public function me($request){
        $action = new AuthMeAction();
        $data = $action->execute($request);
        return $data;
    }

}
?>
