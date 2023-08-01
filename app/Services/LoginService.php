<?php

namespace App\Services;

use App\Repositories\LoginRepository;
use Illuminate\Http\Request;

class LoginService
{
    private $loginRepository;

    public function __construct()
    {
        $this->loginRepository = new LoginRepository();
    }

    public function login(Request $request)
    {
        return $this->loginRepository->login($request);
    }
}