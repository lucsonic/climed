<?php

namespace App\Services;

use App\Repositories\PermissaoRepository;
use Illuminate\Http\Request;

class PermissaoService
{
    private $permissaoRepository;

    public function __construct()
    {
        $this->permissaoRepository = new PermissaoRepository();
    }

    public function listarPermissoes()
    {
        return $this->permissaoRepository->listarPermissoes();
    }

    public function cadastrarPermissao(Request $request)
    {
        return $this->permissaoRepository->cadastrarPermissao($request);
    }

    public function excluirPermissao($codPermissao)
    {
        return $this->permissaoRepository->excluirPermissao($codPermissao);
    }

    public function alterarPermissao($codPermissao, Request $request)
    {
        return $this->permissaoRepository->alterarPermissao($codPermissao, $request);
    }
}
