<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsuarioCollection;
use App\Services\UsuarioService;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    private $usuarioService;

    public function __construct()
    {
        $this->usuarioService = new UsuarioService();
    }

    public function listarUsuarios(Request $request)
    {
        return $this->usuarioService->listarUsuarios($request);
    }

    public function cadastrarUsuario(Request $request)
    {
        return $this->usuarioService->cadastrarUsuario($request);
    }

    public function excluirUsuario($codUsuario)
    {
        return $this->usuarioService->excluirUsuario($codUsuario);
    }

    public function alterarUsuario($codUsuario, Request $request)
    {
        return $this->usuarioService->alterarUsuario($codUsuario, $request);
    }

    public function ativarUsuario($codUsuario)
    {
        return $this->usuarioService->ativarUsuario($codUsuario);
    }

    public function inativarUsuario($codUsuario)
    {
        return $this->usuarioService->inativarUsuario($codUsuario);
    }

    protected function makeResource($query)
    {
        return null;
    }

    protected function makeCollection($query)
    {
        return null;
    }
}
