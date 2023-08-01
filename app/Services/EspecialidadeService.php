<?php

namespace App\Services;

use App\Repositories\EspecialidadeRepository;
use Illuminate\Http\Request;

class EspecialidadeService
{
    private $especialidadeRepository;

    public function __construct()
    {
        $this->especialidadeRepository = new EspecialidadeRepository();
    }

    public function listarEspecialidades()
    {
        return $this->especialidadeRepository->listarEspecialidades();
    }

    public function cadastrarEspecialidade(Request $request)
    {
        return $this->especialidadeRepository->cadastrarEspecialidade($request);
    }

    public function excluirEspecialidade($codEspecialidade)
    {
        return $this->especialidadeRepository->excluirEspecialidade($codEspecialidade);
    }

    public function alterarEspecialidade($codEspecialidade, Request $request)
    {
        return $this->especialidadeRepository->alterarEspecialidade($codEspecialidade, $request);
    }

    public function ativarEspecialidade($codEspecialidade)
    {
        return $this->especialidadeRepository->ativarEspecialidade($codEspecialidade);
    }

    public function inativarEspecialidade($codEspecialidade)
    {
        return $this->especialidadeRepository->inativarEspecialidade($codEspecialidade);
    }
}
