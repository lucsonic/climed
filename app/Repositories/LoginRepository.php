<?php

namespace App\Repositories;

use App\Models\Usuario;
use Illuminate\Http\Request;

class LoginRepository extends BaseRepository
{
    public function login(Request $request)
    {
        return Usuario::where(Usuario::DSC_EMAIL, '=', $request->dsc_email)->first();
    }
}