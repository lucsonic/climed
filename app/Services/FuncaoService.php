<?php

namespace App\Services;

use App\Repositories\FuncaoRepository;
use Illuminate\Http\Request;

class FuncaoService
{
    private $funcaoRepository;

    public function __construct()
    {
        $this->funcaoRepository = new FuncaoRepository();
    }

    public function listarFuncoes()
    {
        return $this->funcaoRepository->listarFuncoes();
    }

    public function cadastrarFuncao(Request $request)
    {
        return $this->funcaoRepository->cadastrarFuncao($request);
    }

    public function excluirFuncao($codFuncao)
    {
        return $this->funcaoRepository->excluirFuncao($codFuncao);
    }

    public function alterarFuncao($codFuncao, Request $request)
    {
        return $this->funcaoRepository->alterarFuncao($codFuncao, $request);
    }

    public function ativarFuncao($codFuncao)
    {
        return $this->funcaoRepository->ativarFuncao($codFuncao);
    }

    public function inativarFuncao($codFuncao)
    {
        return $this->funcaoRepository->inativarFuncao($codFuncao);
    }
}
