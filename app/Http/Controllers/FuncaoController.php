<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\FuncaoCollection;
use App\Services\FuncaoService;
use Illuminate\Http\Request;

class FuncaoController extends Controller
{
    private $funcaoService;

    public function __construct()
    {
        $this->funcaoService = new FuncaoService();
    }

    public function listarFuncoes(Request $request)
    {
        return $this->funcaoService->listarFuncoes($request);
    }

    public function cadastrarFuncao(Request $request)
    {
        return $this->funcaoService->cadastrarFuncao($request);
    }

    public function excluirFuncao($codFuncao)
    {
        return $this->funcaoService->excluirFuncao($codFuncao);
    }

    public function alterarFuncao($codFuncao, Request $request)
    {
        return $this->funcaoService->alterarFuncao($codFuncao, $request);
    }

    public function ativarFuncao($codFuncao)
    {
        return $this->funcaoService->ativarFuncao($codFuncao);
    }

    public function inativarFuncao($codFuncao)
    {
        return $this->funcaoService->inativarFuncao($codFuncao);
    }

    protected function makeResource($query)
    {
        return new FuncaoCollection($query);
    }

    protected function makeCollection($query)
    {
        return new FuncaoCollection($query);
    }
}
