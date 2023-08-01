<?php

namespace App\Http\Controllers;

use App\Http\Resources\FuncionarioCollection;
use App\Services\FuncionarioService;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    private $funcionarioService;

    public function __construct()
    {
        $this->funcionarioService = new FuncionarioService();
    }

    public function listarFuncionarios(Request $request)
    {
        return $this->funcionarioService->listarFuncionarios($request);
    }

    public function cadastrarFuncionario(Request $request)
    {
        return $this->funcionarioService->cadastrarFuncionario($request);
    }

    public function excluirFuncionario($codFuncionario)
    {
        return $this->funcionarioService->excluirFuncionario($codFuncionario);
    }

    public function alterarFuncionario($codFuncionario, Request $request)
    {
        return $this->funcionarioService->alterarFuncionario($codFuncionario, $request);
    }

    public function ativarFuncionario($codFuncionario)
    {
        return $this->funcionarioService->ativarFuncionario($codFuncionario);
    }

    public function inativarFuncionario($codFuncionario)
    {
        return $this->funcionarioService->inativarFuncionario($codFuncionario);
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
