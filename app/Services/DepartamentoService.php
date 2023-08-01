<?php

namespace App\Services;

use App\Repositories\DepartamentoRepository;
use Illuminate\Http\Request;

class DepartamentoService
{
    private $departamentoRepository;

    public function __construct()
    {
        $this->departamentoRepository = new DepartamentoRepository();
    }

    public function listarDepartamentos()
    {
        return $this->departamentoRepository->listarDepartamentos();
    }

    public function cadastrarDepartamento(Request $request)
    {
        return $this->departamentoRepository->cadastrarDepartamento($request);
    }

    public function excluirDepartamento($codDepartamento)
    {
        return $this->departamentoRepository->excluirDepartamento($codDepartamento);
    }

    public function alterarDepartamento($codDepartamento, Request $request)
    {
        return $this->departamentoRepository->alterarDepartamento($codDepartamento, $request);
    }

    public function ativarDepartamento($codDepartamento)
    {
        return $this->departamentoRepository->ativarDepartamento($codDepartamento);
    }

    public function inativarDepartamento($codDepartamento)
    {
        return $this->departamentoRepository->inativarDepartamento($codDepartamento);
    }
}
