<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissaoCollection;
use App\Services\PermissaoService;
use Illuminate\Http\Request;

class PermissaoController extends Controller
{
    private $permissaoService;

    public function __construct()
    {
        $this->permissaoService = new PermissaoService();
    }

    public function listarPermissoes(Request $request)
    {
        return $this->permissaoService->listarPermissoes($request);
    }

    public function cadastrarPermissao(Request $request)
    {
        return $this->permissaoService->cadastrarPermissao($request);
    }

    public function excluirPermissao($codPermissao)
    {
        return $this->permissaoService->excluirPermissao($codPermissao);
    }

    public function alterarPermissao($codPermissao, Request $request)
    {
        return $this->permissaoService->alterarPermissao($codPermissao, $request);
    }

    protected function makeResource($query)
    {
        return new PermissaoCollection($query);
    }

    protected function makeCollection($query)
    {
        return new PermissaoCollection($query);
    }
}
