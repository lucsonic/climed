<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartamentoCollection;
use App\Services\DepartamentoService;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    private $departamentoService;

    public function __construct()
    {
        $this->departamentoService = new DepartamentoService();
    }

    public function listarDepartamentos(Request $request)
    {
        return $this->departamentoService->listarDepartamentos($request);
    }

    public function cadastrarDepartamento(Request $request)
    {
        return $this->departamentoService->cadastrarDepartamento($request);
    }

    public function excluirDepartamento($codDepartamento)
    {
        return $this->departamentoService->excluirDepartamento($codDepartamento);
    }

    public function alterarDepartamento($codDepartamento, Request $request)
    {
        return $this->departamentoService->alterarDepartamento($codDepartamento, $request);
    }

    public function ativarDepartamento($codDepartamento)
    {
        return $this->departamentoService->ativarDepartamento($codDepartamento);
    }

    public function inativarDepartamento($codDepartamento)
    {
        return $this->departamentoService->inativarDepartamento($codDepartamento);
    }

    protected function makeResource($query)
    {
        return new DepartamentoCollection($query);
    }

    protected function makeCollection($query)
    {
        return new DepartamentoCollection($query);
    }
}
