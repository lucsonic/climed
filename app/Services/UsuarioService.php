<?php

namespace App\Services;

use App\Repositories\UsuarioRepository;
use Illuminate\Http\Request;

class UsuarioService
{
    private $usuarioRepository;

    public function __construct()
    {
        $this->usuarioRepository = new UsuarioRepository();
    }

    public function listarUsuarios(Request $request)
    {
        return $this->usuarioRepository->listarUsuarios($request);
    }

    public function cadastrarUsuario(Request $request)
    {
        return $this->usuarioRepository->cadastrarUsuario($request);
    }

    public function excluirUsuario($codUsuario)
    {
        return $this->usuarioRepository->excluirUsuario($codUsuario);
    }

    public function alterarUsuario($codUsuario, Request $request)
    {
        return $this->usuarioRepository->alterarUsuario($codUsuario, $request);
    }

    public function ativarUsuario($codUsuario)
    {
        return $this->usuarioRepository->ativarUsuario($codUsuario);
    }

    public function inativarUsuario($codUsuario)
    {
        return $this->usuarioRepository->inativarUsuario($codUsuario);
    }
}
