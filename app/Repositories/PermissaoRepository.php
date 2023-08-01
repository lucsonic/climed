<?php

namespace App\Repositories;

use App\Models\Auditoria;
use App\Models\Permissao;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissaoRepository extends BaseRepository
{
    private $permissaoModel;
    private $currentUser;

    public function __construct()
    {
        $this->permissaoModel = new Permissao();
        $this->currentUser = auth()->user();
    }

    public function listarPermissoes()
    {
        return $this->permissaoModel->all();
    }

    public function cadastrarPermissao(Request $request)
    {
        $existe = '';
        $permissao = Permissao::where(Permissao::COD_USUARIO, '=', $request->cod_usuario)->first();
        $usuario = Usuario::where(Usuario::COD_USUARIO, '=', $request->cod_usuario)->first();

        if ($permissao) {
            $existe = [
                'mensagem' => [
                    'message' => 'Já existe uma permissão cadastrada com esse usuário!',
                ],
            ];
        }

        if ($existe == '') {
            try {
                DB::beginTransaction();

                Permissao::create([
                    Permissao::COD_USUARIO => $request->cod_usuario,
                    Permissao::MOD_USUARIO => $request->mod_usuario,
                    Permissao::MOD_PERFIL => $request->mod_perfil,
                    Permissao::MOD_ESPECIALIDADE => $request->mod_especialidade,
                    Permissao::MOD_FUNCAO => $request->mod_funcao,
                    Permissao::MOD_DEPARTAMENTO => $request->mod_departamento,
                    Permissao::MOD_CLIENTE => $request->mod_cliente
                ]);

                Auditoria::adicionar('Cadastro de Permissão', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' cadastrou permissão para ' . $usuario->nom_usuario);
                DB::commit();
                return SuccessResponse();
            } catch (\Exception $e) {
                DB::rollBack();
                return ErrorResponse($e);
            }
        }

        return $existe;
    }

    public function excluirPermissao(int $codPermissao)
    {
        $usuario = Usuario::where(Usuario::COD_USUARIO, '=', $this->currentUser->cod_usuario)->first();

        try {
            DB::beginTransaction();
            Permissao::where('cod_permissao', $codPermissao)->delete();
            Auditoria::adicionar('Exclusão de Permissão', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' excluiu a permissão do usuário ' . $usuario->nom_usuario);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function alterarPermissao($codPermissao, Request $request)
    {
        $permissao = Permissao::find($codPermissao);
        $usuario = Usuario::where(Usuario::COD_USUARIO, '=', $this->currentUser->cod_usuario)->first();

        try {
            DB::beginTransaction();

            $permissao->update([
                Permissao::MOD_USUARIO => $request->mod_usuario,
                Permissao::MOD_PERFIL => $request->mod_perfil,
                Permissao::MOD_ESPECIALIDADE => $request->mod_especialidade,
                Permissao::MOD_FUNCAO => $request->mod_funcao,
                Permissao::MOD_DEPARTAMENTO => $request->mod_departamento,
                Permissao::MOD_CLIENTE => $request->mod_cliente
            ]);

            Auditoria::adicionar('Alteração de Permissão', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' alterou as permissões de ' . $usuario->nom_usuario);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }
}
