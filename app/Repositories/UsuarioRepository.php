<?php

namespace App\Repositories;

use App\Models\Auditoria;
use App\Models\Perfil;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioRepository extends BaseRepository
{
    private $usuariolModel;
    private $currentUser;

    public function __construct()
    {
        $this->usuariolModel = new Usuario();
        $this->currentUser = auth()->user();
    }

    public function listarUsuarios(Request $request)
    {
        $consulta = $this->usuariolModel->query();
        $consulta->select(Usuario::TABLE . '.' . '*', Perfil::TABLE . '.' . '*');
        $consulta->leftJoin(Perfil::TABLE, Perfil::TABLE . '.' . Perfil::COD_PERFIL, '=', Usuario::TABLE . '.' . Usuario::COD_PERFIL);

        if ($request->filled('busca')) {
            $busca = ['%' . trim(strtolower($request->get('busca'))) . '%'];
            $consulta->where(function ($query) use ($busca) {
                $query->whereRaw(self::LOWER . '(' . Usuario::TABLE . '.' . Usuario::NOM_USUARIO . ') ' . self::LIKE . ' ? ', array($busca));
                $query->orWhereRaw(self::LOWER . '(' . Usuario::TABLE . '.' . Usuario::SIG_USUARIO . ') ' . self::LIKE . ' ? ', array($busca));
                $query->orWhereRaw(self::LOWER . '(' . Usuario::TABLE . '.' . Usuario::DSC_EMAIL . ') ' . self::LIKE . ' ? ', array($busca));
            });
        }

        $consulta->orderBy(Usuario::TABLE . '.' . Usuario::NOM_USUARIO, 'ASC');

        return $consulta->distinct()->get();
    }

    public function cadastrarUsuario(Request $request)
    {
        $existe = '';
        $usuario_email = Usuario::where(Usuario::DSC_EMAIL, '=', $request->dsc_email)->first();
        $usuario_cpf = Usuario::where(Usuario::CPF_USUARIO, '=', $request->cpf_usuario)->first();

        if ($usuario_email) {
            $existe = [
                'mensagem' => [
                    'message' => 'Já existe um usuário cadastrado com este email!',
                ],
            ];
        }
        if ($usuario_cpf) {
            $existe = [
                'mensagem' => [
                    'message' => 'Já existe um usuário cadastrado com este CPF!',
                ],
            ];
        }

        if ($existe == '') {
            try {
                DB::beginTransaction();

                Usuario::create([
                    Usuario::NOM_USUARIO => $request->nom_usuario,
                    Usuario::SIG_USUARIO => $request->sig_usuario,
                    Usuario::DSC_SENHA => password_hash($request->dsc_senha, PASSWORD_DEFAULT),
                    Usuario::DSC_EMAIL => $request->dsc_email,
                    Usuario::FLG_ATIVO => Usuario::USUARIO_ATIVO,
                    Usuario::NUM_TOKEN => rand(),
                    Usuario::FLG_EMAIL_CONFIRMADO => Usuario::USUARIO_FLG_EMAIL_NAO_CONFIRMADO,
                    Usuario::COD_PERFIL => $request->cod_perfil,
                    Usuario::CPF_USUARIO => removeMascara($request->cpf_usuario)
                ]);

                Auditoria::adicionar('Cadastro de Usuário', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' cadastrou o usuário ' . $request->nom_usuario);
                DB::commit();
                return SuccessResponse();
            } catch (\Exception $e) {
                DB::rollBack();
                return ErrorResponse($e);
            }
        }

        return $existe;
    }

    public function excluirUsuario(int $codUsuario)
    {
        $usuario = Usuario::find($codUsuario);

        try {
            DB::beginTransaction();
            Usuario::where('cod_usuario', $codUsuario)->delete();
            Auditoria::adicionar('Exclusão de Usuário', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' excluiu o usuário ' . $usuario->nom_usuario);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function alterarUsuario($codUsuario, Request $request)
    {
        $usuario = Usuario::find($codUsuario);

        try {
            DB::beginTransaction();

            $usuario->update([
                Usuario::NOM_USUARIO => $request->nom_usuario,
                Usuario::SIG_USUARIO => $request->sig_usuario,
                Usuario::DSC_SENHA => password_hash($request->dsc_senha, PASSWORD_DEFAULT),
                Usuario::DSC_EMAIL => $request->dsc_email,
                Usuario::FLG_ATIVO => $request->flg_ativo,
                Usuario::COD_PERFIL => $request->cod_perfil,
                Usuario::CPF_USUARIO => $request->cpf_usuario
            ]);

            Auditoria::adicionar('Alteração de Usuário', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' alterou o usuário ' . $usuario->nom_usuario);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function ativarUsuario(int $codUsuario)
    {
        $usuario = Usuario::find($codUsuario);

        try {
            DB::beginTransaction();

            $usuario->update([
                Usuario::FLG_ATIVO => Usuario::USUARIO_ATIVO
            ]);

            Auditoria::adicionar('Ativar Usuário', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' ativou o usuário ' . $usuario->nom_usuario);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function inativarUsuario(int $codUsuario)
    {
        $usuario = Usuario::find($codUsuario);

        try {
            DB::beginTransaction();

            $usuario->update([
                Usuario::FLG_ATIVO => Usuario::USUARIO_INATIVO
            ]);

            Auditoria::adicionar('Inativar Usuário', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' inativou o usuário ' . $usuario->nom_usuario);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }
}
