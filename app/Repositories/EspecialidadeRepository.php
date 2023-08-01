<?php

namespace App\Repositories;

use App\Models\Auditoria;
use App\Models\Especialidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EspecialidadeRepository extends BaseRepository
{
    private $especialidadeModel;
    private $currentUser;

    public function __construct()
    {
        $this->especialidadeModel = new Especialidade();
        $this->currentUser = auth()->user();
    }

    public function listarEspecialidades()
    {
        return $this->especialidadeModel->all();
    }

    public function cadastrarEspecialidade(Request $request)
    {
        $existe = '';
        $especialidade = Especialidade::where(Especialidade::NOM_ESPECIALIDADE, '=', $request->nom_especialidade)->first();

        if ($especialidade) {
            $existe = [
                'mensagem' => [
                    'message' => 'Já existe uma especialidade cadastrada com esse nome!',
                ],
            ];
        }

        if ($existe == '') {
            try {
                DB::beginTransaction();

                Especialidade::create([
                    Especialidade::NOM_ESPECIALIDADE => $request->nom_especialidade,
                    Especialidade::FLG_ATIVO => Especialidade::ESPECIALIDADE_ATIVA
                ]);

                Auditoria::adicionar('Cadastro de Especialidade', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' cadastrou a especialidade ' . $request->nom_especialidade);
                DB::commit();
                return SuccessResponse();
            } catch (\Exception $e) {
                DB::rollBack();
                return ErrorResponse($e);
            }
        }

        return $existe;
    }

    public function excluirEspecialidade(int $codEspecialidade)
    {
        $especialidade = Especialidade::where('cod_especialidade', $codEspecialidade)->first();

        try {
            DB::beginTransaction();
            Especialidade::where('cod_especialidade', $codEspecialidade)->delete();
            Auditoria::adicionar('Exclusão de Especialidade', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' excluiu a especialidade ' . $especialidade->nom_especialidade);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function alterarEspecialidade($codEspecialidade, Request $request)
    {
        $especialidade = Especialidade::find($codEspecialidade);

        try {
            DB::beginTransaction();

            $especialidade->update([
                Especialidade::NOM_ESPECIALIDADE => $request->nom_especialidade,
                Especialidade::FLG_ATIVO => $request->flg_ativo
            ]);

            Auditoria::adicionar('Alteração de Especialidade', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' alterou a especialidade ' . $especialidade->nom_especialidade);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function ativarEspecialidade(int $codEspecialidade)
    {
        $especialidade = Especialidade::find($codEspecialidade);

        try {
            DB::beginTransaction();

            $especialidade->update([
                Especialidade::FLG_ATIVO => Especialidade::ESPECIALIDADE_ATIVA
            ]);

            Auditoria::adicionar('Ativar Especialidade', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' ativou a especialidade ' . $especialidade->nom_especialidade);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function inativarEspecialidade(int $codEspecialidade)
    {
        $especialidade = Especialidade::find($codEspecialidade);

        try {
            DB::beginTransaction();

            $especialidade->update([
                Especialidade::FLG_ATIVO => Especialidade::ESPECIALIDADE_INATIVA
            ]);

            Auditoria::adicionar('Inativar Especialidade', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' inativou a especialidade ' . $especialidade->nom_especialidade);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }
}
