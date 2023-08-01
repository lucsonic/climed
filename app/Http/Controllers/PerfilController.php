<?php

namespace App\Http\Controllers;

use App\Http\Resources\PerfilCollection;
use App\Services\PerfilService;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    private $perfilService;

    public function __construct()
    {
        $this->perfilService = new PerfilService();
    }

    public function listarPerfis(Request $request)
    {
        return $this->perfilService->listarPerfis($request);
    }

    public function cadastrarPerfil(Request $request)
    {
        return $this->perfilService->cadastrarPerfil($request);
    }

    public function excluirPerfil($codPerfil)
    {
        return $this->perfilService->excluirPerfil($codPerfil);
    }

    public function alterarPerfil($codPerfil, Request $request)
    {
        return $this->perfilService->alterarPerfil($codPerfil, $request);
    }

    public function ativarPerfil($codPerfil)
    {
        return $this->perfilService->ativarPerfil($codPerfil);
    }

    public function inativarPerfil($codPerfil)
    {
        return $this->perfilService->inativarPerfil($codPerfil);
    }

    protected function makeResource($query)
    {
        return new PerfilCollection($query);
    }

    protected function makeCollection($query)
    {
        return new PerfilCollection($query);
    }
}
