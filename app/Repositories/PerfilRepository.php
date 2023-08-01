<?php

namespace App\Repositories;

use App\Models\Auditoria;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerfilRepository extends BaseRepository
{
    private $perfilModel;
    private $currentUser;

    public function __construct()
    {
        $this->perfilModel = new Perfil();
        $this->currentUser = auth()->user();
    }

    public function listarPerfis()
    {
        return $this->perfilModel->all();
    }

    public function cadastrarPerfil(Request $request)
    {
        $existe = '';
        $perfil = Perfil::where(Perfil::NOM_PERFIL, '=', $request->nom_perfil)->first();

        if ($perfil) {
            $existe = [
                'mensagem' => [
                    'message' => 'Já existe um perfil cadastrado com esse nome!',
                ],
            ];
        }

        if ($existe == '') {
            try {
                DB::beginTransaction();

                Perfil::create([
                    Perfil::NOM_PERFIL => $request->nom_perfil,
                    Perfil::FLG_ATIVO => Perfil::PERFIL_ATIVO
                ]);

                Auditoria::adicionar('Cadastro de Perfil', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' cadastrou o perfil ' . $request->nom_perfil);
                DB::commit();
                return SuccessResponse();
            } catch (\Exception $e) {
                DB::rollBack();
                return ErrorResponse($e);
            }
        }

        return $existe;
    }

    public function excluirPerfil(int $codPerfil)
    {
        $perfil = Perfil::where('cod_perfil', $codPerfil)->first();

        try {
            DB::beginTransaction();
            Perfil::where('cod_perfil', $codPerfil)->delete();
            Auditoria::adicionar('Exclusão de Perfil', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' excluiu o perfil ' . $perfil->nom_perfil);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function alterarPerfil($codPerfil, Request $request)
    {
        $perfil = Perfil::find($codPerfil);

        try {
            DB::beginTransaction();

            $perfil->update([
                Perfil::NOM_PERFIL => $request->nom_perfil,
                Perfil::FLG_ATIVO => $request->flg_ativo
            ]);

            Auditoria::adicionar('Alteração de Perfil', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' alterou o perfil ' . $perfil->nom_perfil);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function ativarPerfil(int $codPerfil)
    {
        $perfil = Perfil::find($codPerfil);

        try {
            DB::beginTransaction();

            $perfil->update([
                Perfil::FLG_ATIVO => Perfil::PERFIL_ATIVO
            ]);

            Auditoria::adicionar('Ativar Perfil', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' ativou o perfil ' . $perfil->nom_perfil);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function inativarPerfil(int $codPerfil)
    {
        $perfil = Perfil::find($codPerfil);

        try {
            DB::beginTransaction();

            $perfil->update([
                Perfil::FLG_ATIVO => Perfil::PERFIL_INATIVO
            ]);

            Auditoria::adicionar('Inativar Perfil', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' inativou o perfil ' . $perfil->nom_perfil);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }
}
