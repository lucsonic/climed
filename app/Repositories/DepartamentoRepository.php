<?php

namespace App\Repositories;

use App\Models\Auditoria;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartamentoRepository extends BaseRepository
{
    private $departamentoModel;
    private $currentUser;

    public function __construct()
    {
        $this->departamentoModel = new Departamento();
        $this->currentUser = auth()->user();
    }

    public function listarDepartamentos()
    {
        return $this->departamentoModel->all();
    }

    public function cadastrarDepartamento(Request $request)
    {
        $existe = '';
        $departamento = Departamento::where(Departamento::NOM_DEPARTAMENTO, '=', $request->nom_departamento)->first();

        if ($departamento) {
            $existe = [
                'mensagem' => [
                    'message' => 'Já existe um departamento cadastrado com esse nome!',
                ],
            ];
        }

        if ($existe == '') {
            try {
                DB::beginTransaction();

                Departamento::create([
                    Departamento::NOM_DEPARTAMENTO => $request->nom_departamento,
                    Departamento::FLG_ATIVO => Departamento::DEPARTAMENTO_ATIVO
                ]);

                Auditoria::adicionar('Cadastro de Departamento', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' cadastrou o departamento ' . $request->nom_departamento);
                DB::commit();
                return SuccessResponse();
            } catch (\Exception $e) {
                DB::rollBack();
                return ErrorResponse($e);
            }
        }

        return $existe;
    }

    public function excluirDepartamento(int $codDepartamento)
    {
        $departamento = Departamento::where('cod_departamento', $codDepartamento)->first();

        try {
            DB::beginTransaction();
            Departamento::where('cod_departamento', $codDepartamento)->delete();
            Auditoria::adicionar('Exclusão de Departamento', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' excluiu o departamento ' . $departamento->nom_departamento);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function alterarDepartamento($codDepartamento, Request $request)
    {
        $departamento = Departamento::find($codDepartamento);

        try {
            DB::beginTransaction();

            $departamento->update([
                Departamento::NOM_DEPARTAMENTO => $request->nom_departamento,
                Departamento::FLG_ATIVO => $request->flg_ativo
            ]);

            Auditoria::adicionar('Alteração de Departamento', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' alterou o departamento ' . $departamento->nom_departamento);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function ativarDepartamento(int $codDepartamento)
    {
        $departamento = Departamento::find($codDepartamento);

        try {
            DB::beginTransaction();

            $departamento->update([
                Departamento::FLG_ATIVO => Departamento::DEPARTAMENTO_ATIVO
            ]);

            Auditoria::adicionar('Ativar Departamento', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' ativou o departamento ' . $departamento->nom_departamento);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function inativarDepartamento(int $codDepartamento)
    {
        $departamento = Departamento::find($codDepartamento);

        try {
            DB::beginTransaction();

            $departamento->update([
                Departamento::FLG_ATIVO => Departamento::DEPARTAMENTO_INATIVO
            ]);

            Auditoria::adicionar('Inativar Departamento', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' inativou o departamento ' . $departamento->nom_departamento);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }
}
