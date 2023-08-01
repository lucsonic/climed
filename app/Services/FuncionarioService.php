<?php

namespace App\Services;

use App\Repositories\FuncionarioRepository;
use Illuminate\Http\Request;

class FuncionarioService
{
    private $funcionarioRepository;

    public function __construct()
    {
        $this->funcionarioRepository = new FuncionarioRepository();
    }

    public function listarFuncionarios(Request $request)
    {
        return $this->funcionarioRepository->listarFuncionarios($request);
    }

    public function cadastrarFuncionario(Request $request)
    {
        return $this->funcionarioRepository->cadastrarFuncionario($request);
    }

    public function excluirFuncionario($codFuncionario)
    {
        return $this->funcionarioRepository->excluirFuncionario($codFuncionario);
    }

    public function alterarFuncionario($codFuncionario, Request $request)
    {
        return $this->funcionarioRepository->alterarFuncionario($codFuncionario, $request);
    }

    public function ativarFuncionario($codFuncionario)
    {
        return $this->funcionarioRepository->ativarFuncionario($codFuncionario);
    }

    public function inativarFuncionario($codFuncionario)
    {
        return $this->funcionarioRepository->inativarFuncionario($codFuncionario);
    }
}
