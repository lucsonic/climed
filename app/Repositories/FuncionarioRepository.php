<?php

namespace App\Repositories;

use App\Models\Auditoria;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FuncionarioRepository extends BaseRepository
{
    private $funcionariolModel;
    private $currentUser;

    public function __construct()
    {
        $this->funcionariolModel = new Funcionario();
        $this->currentUser = auth()->user();
    }

    public function listarFuncionarios(Request $request)
    {
        $consulta = $this->funcionariolModel->query();
        $consulta->select(Funcionario::TABLE . '.' . '*');

        if ($request->filled('busca')) {
            $busca = ['%' . trim(strtolower($request->get('busca'))) . '%'];
            $consulta->where(function ($query) use ($busca) {
                $query->whereRaw(self::LOWER . '(' . Funcionario::TABLE . '.' . Funcionario::NOM_FUNCIONARIO . ') ' . self::LIKE . ' ? ', array($busca));
                $query->orWhereRaw(self::LOWER . '(' . Funcionario::TABLE . '.' . Funcionario::NUM_CPF . ') ' . self::LIKE . ' ? ', array($busca));
                $query->orWhereRaw(self::LOWER . '(' . Funcionario::TABLE . '.' . Funcionario::NUM_RG . ') ' . self::LIKE . ' ? ', array($busca));
                $query->orWhereRaw(self::LOWER . '(' . Funcionario::TABLE . '.' . Funcionario::DSC_EMAIL . ') ' . self::LIKE . ' ? ', array($busca));
            });
        }

        $consulta->orderBy(Funcionario::TABLE . '.' . Funcionario::NOM_FUNCIONARIO, 'ASC');

        return $consulta->distinct()->get();
    }

    public function cadastrarFuncionario(Request $request)
    {
        $existe = '';
        $funcionario_cpf = Funcionario::where(Funcionario::NUM_CPF, '=', removeMascara($request->num_cpf))->first();
        $funcionario_email = Funcionario::where(Funcionario::DSC_EMAIL, '=', $request->dsc_email)->first();

        if ($funcionario_cpf) {
            $existe = [
                'mensagem' => [
                    'message' => 'Já existe um funcionário cadastrado com este CPF!',
                ],
            ];
        
        }
        if ($funcionario_email) {
            $existe = [
                'mensagem' => [
                    'message' => 'Já existe um funcionário cadastrado com este Email!',
                ],
            ];
        }

        if ($existe == '') {
            try {
                DB::beginTransaction();

                Funcionario::create([
                    Funcionario::NOM_FUNCIONARIO => $request->nom_funcionario,
                    Funcionario::NUM_CPF => removeMascara($request->num_cpf),
                    Funcionario::NUM_RG => $request->num_rg,
                    Funcionario::DSC_EMAIL => $request->dsc_email,
                    Funcionario::NUM_CRM => $request->num_crm,
                    Funcionario::DSC_ENDERECO => $request->dsc_endereco,
                    Funcionario::DSC_BAIRRO => $request->dsc_bairro,
                    Funcionario::DSC_CIDADE => $request->dsc_cidade,
                    Funcionario::DSC_UF => $request->dsc_uf,
                    Funcionario::NUM_CEP => removeMascara($request->num_cep),
                    Funcionario::DAT_NASCIMENTO => dateDB($request->dat_nascimento),
                    Funcionario::DSC_SEXO => $request->dsc_sexo,
                    Funcionario::COD_DEPARTAMENTO => $request->cod_departamento,
                    Funcionario::COD_FUNCAO => $request->cod_funcao,
                    Funcionario::COD_ESPECIALIDADE => $request->cod_especialidade,
                    Funcionario::FLG_ESPECIALIDADE => $request->flg_especialidade,
                    Funcionario::FLG_ATIVO => Funcionario::FUNCIONARIO_ATIVO
                ]);

                Auditoria::adicionar('Cadastro de Funcionário', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' cadastrou o funcionário ' . $request->nom_funcionario);
                DB::commit();
                return SuccessResponse();
            } catch (\Exception $e) {
                DB::rollBack();
                return ErrorResponse($e);
            }
        }

        return $existe;
    }

    public function excluirFuncionario(int $codFuncionario)
    {
        $funcionario = Funcionario::find($codFuncionario);

        try {
            DB::beginTransaction();
            Funcionario::where('cod_funcionario', $codFuncionario)->delete();
            Auditoria::adicionar('Exclusão de Funcionário', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' excluiu o funcionário ' . $funcionario->nom_funcionario);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function alterarFuncionario($codFuncionario, Request $request)
    {
        $funcionario = Funcionario::find($codFuncionario);

        try {
            DB::beginTransaction();

            $funcionario->update([
                Funcionario::NOM_FUNCIONARIO => $request->nom_funcionario,
                Funcionario::NUM_CPF => removeMascara($request->num_cpf),
                Funcionario::NUM_RG => $request->num_rg,
                Funcionario::DSC_EMAIL => $request->dsc_email,
                Funcionario::NUM_CRM => $request->num_crm,
                Funcionario::DSC_ENDERECO => $request->dsc_endereco,
                Funcionario::DSC_BAIRRO => $request->dsc_bairro,
                Funcionario::DSC_CIDADE => $request->dsc_cidade,
                Funcionario::DSC_UF => $request->dsc_uf,
                Funcionario::NUM_CEP => removeMascara($request->num_cep),
                Funcionario::DAT_NASCIMENTO => dateDB($request->dat_nascimento),
                Funcionario::DSC_SEXO => $request->dsc_sexo,
                Funcionario::COD_DEPARTAMENTO => $request->cod_departamento,
                Funcionario::COD_FUNCAO => $request->cod_funcao,
                Funcionario::COD_ESPECIALIDADE => $request->cod_especialidade,
                Funcionario::FLG_ESPECIALIDADE => $request->flg_especialidade,
                Funcionario::FLG_ATIVO => $request->flg_ativo
            ]);

            Auditoria::adicionar('Alteração de Funcionário', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' alterou o funcionário ' . $funcionario->nom_funcionario);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function ativarFuncionario(int $codFuncionario)
    {
        $funcionario = Funcionario::find($codFuncionario);

        try {
            DB::beginTransaction();

            $funcionario->update([
                Funcionario::FLG_ATIVO => Funcionario::FUNCIONARIO_ATIVO
            ]);

            Auditoria::adicionar('Ativar Funcionário', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' ativou o funcionário ' . $funcionario->nom_funcionario);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function inativarFuncionario(int $codFuncionario)
    {
        $funcionario = Funcionario::find($codFuncionario);

        try {
            DB::beginTransaction();

            $funcionario->update([
                Funcionario::FLG_ATIVO => Funcionario::FUNCIONARIO_INATIVO
            ]);

            Auditoria::adicionar('Inativar Funcionário', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' inativou o funcionário ' . $funcionario->nom_funcionario);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }
}
