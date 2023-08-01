<?php

namespace App\Repositories;

use App\Models\Auditoria;
use App\Models\Funcao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FuncaoRepository extends BaseRepository
{
    private $funcaoModel;
    private $currentUser;

    public function __construct()
    {
        $this->funcaoModel = new Funcao();
        $this->currentUser = auth()->user();
    }

    public function listarFuncoes()
    {
        return $this->funcaoModel->all();
    }

    public function cadastrarFuncao(Request $request)
    {
        $existe = '';
        $perfil = Funcao::where(Funcao::NOM_FUNCAO, '=', $request->nom_funcao)->first();

        if ($perfil) {
            $existe = [
                'mensagem' => [
                    'message' => 'Já existe uma função cadastrada com esse nome!',
                ],
            ];
        }

        if ($existe == '') {
            try {
                DB::beginTransaction();

                Funcao::create([
                    Funcao::NOM_FUNCAO => $request->nom_funcao,
                    Funcao::FLG_ATIVO => Funcao::FUNCAO_ATIVA
                ]);

                Auditoria::adicionar('Cadastro de Função', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' cadastrou a função ' . $request->nom_funcao);
                DB::commit();
                return SuccessResponse();
            } catch (\Exception $e) {
                DB::rollBack();
                return ErrorResponse($e);
            }
        }

        return $existe;
    }

    public function excluirFuncao(int $codFuncao)
    {
        $funcao = Funcao::where('cod_funcao', $codFuncao)->first();

        try {
            DB::beginTransaction();
            Funcao::where('cod_funcao', $codFuncao)->delete();
            Auditoria::adicionar('Exclusão de Função', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' excluiu a função ' . $funcao->nom_funcao);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function alterarFuncao($codFuncao, Request $request)
    {
        $funcao = Funcao::find($codFuncao);

        try {
            DB::beginTransaction();

            $funcao->update([
                Funcao::NOM_FUNCAO => $request->nom_funcao,
                Funcao::FLG_ATIVO => $request->flg_ativo
            ]);

            Auditoria::adicionar('Alteração de Função', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' alterou a função ' . $funcao->nom_funcao);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function ativarFuncao(int $codFuncao)
    {
        $funcao = Funcao::find($codFuncao);

        try {
            DB::beginTransaction();

            $funcao->update([
                Funcao::FLG_ATIVO => Funcao::FUNCAO_ATIVA
            ]);

            Auditoria::adicionar('Ativar Função', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' ativou a função ' . $funcao->nom_funcao);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function inativarFuncao(int $codFuncao)
    {
        $funcao = Funcao::find($codFuncao);

        try {
            DB::beginTransaction();

            $funcao->update([
                Funcao::FLG_ATIVO => Funcao::FUNCAO_INATIVA
            ]);

            Auditoria::adicionar('Inativar Função', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' inativou a função ' . $funcao->nom_funcao);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }
}
