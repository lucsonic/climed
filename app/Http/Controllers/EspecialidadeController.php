<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\EspecialidadeCollection;
use App\Services\EspecialidadeService;
use Illuminate\Http\Request;

class EspecialidadeController extends Controller
{
    private $especialidadeService;

    public function __construct()
    {
        $this->especialidadeService = new EspecialidadeService();
    }

    public function listarEspecialidades(Request $request)
    {
        return $this->especialidadeService->listarEspecialidades($request);
    }

    public function cadastrarEspecialidade(Request $request)
    {
        return $this->especialidadeService->cadastrarEspecialidade($request);
    }

    public function excluirEspecialidade($codEspecialidade)
    {
        return $this->especialidadeService->excluirEspecialidade($codEspecialidade);
    }

    public function alterarEspecialidade($codEspecialidade, Request $request)
    {
        return $this->especialidadeService->alterarEspecialidade($codEspecialidade, $request);
    }

    public function ativarEspecialidade($codEspecialidade)
    {
        return $this->especialidadeService->ativarEspecialidade($codEspecialidade);
    }

    public function inativarEspecialidade($codEspecialidade)
    {
        return $this->especialidadeService->inativarEspecialidade($codEspecialidade);
    }

    protected function makeResource($query)
    {
        return new EspecialidadeCollection($query);
    }

    protected function makeCollection($query)
    {
        return new EspecialidadeCollection($query);
    }
}
