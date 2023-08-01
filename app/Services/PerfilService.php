<?php

namespace App\Services;

use App\Repositories\PerfilRepository;
use Illuminate\Http\Request;

class PerfilService
{
    private $perfilRepository;

    public function __construct()
    {
        $this->perfilRepository = new PerfilRepository();
    }

    public function listarPerfis()
    {
        return $this->perfilRepository->listarPerfis();
    }

    public function cadastrarPerfil(Request $request)
    {
        return $this->perfilRepository->cadastrarPerfil($request);
    }

    public function excluirPerfil($codPerfil)
    {
        return $this->perfilRepository->excluirPerfil($codPerfil);
    }

    public function alterarPerfil($codPerfil, Request $request)
    {
        return $this->perfilRepository->alterarPerfil($codPerfil, $request);
    }

    public function ativarPerfil($codPerfil)
    {
        return $this->perfilRepository->ativarPerfil($codPerfil);
    }

    public function inativarPerfil($codPerfil)
    {
        return $this->perfilRepository->inativarPerfil($codPerfil);
    }
}
