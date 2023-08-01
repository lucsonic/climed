<?php

namespace App\Repositories;

use App\Models\Auditoria;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteRepository extends BaseRepository
{
    private $clientelModel;
    private $currentUser;

    public function __construct()
    {
        $this->clientelModel = new Cliente();
        $this->currentUser = auth()->user();
    }

    public function listarClientes(Request $request)
    {
        $consulta = $this->clientelModel->query();
        $consulta->select(Cliente::TABLE . '.' . '*');

        if ($request->filled('busca')) {
            $busca = ['%' . trim(strtolower($request->get('busca'))) . '%'];
            $consulta->where(function ($query) use ($busca) {
                $query->whereRaw(self::LOWER . '(' . Cliente::TABLE . '.' . Cliente::NOM_CLIENTE . ') ' . self::LIKE . ' ? ', array($busca));
                $query->orWhereRaw(self::LOWER . '(' . Cliente::TABLE . '.' . Cliente::NUM_CPF . ') ' . self::LIKE . ' ? ', array($busca));
                $query->orWhereRaw(self::LOWER . '(' . Cliente::TABLE . '.' . Cliente::NUM_RG . ') ' . self::LIKE . ' ? ', array($busca));
            });
        }

        $consulta->orderBy(Cliente::TABLE . '.' . Cliente::NOM_CLIENTE, 'ASC');

        return $consulta->distinct()->get();
    }

    public function cadastrarCliente(Request $request)
    {
        $existe = '';
        $cliente_cpf = Cliente::where(Cliente::NUM_CPF, '=', removeMascara($request->num_cpf))->first();

        if ($cliente_cpf) {
            $existe = [
                'mensagem' => [
                    'message' => 'Já existe um cliente cadastrado com este CPF!',
                ],
            ];
        }

        if ($existe == '') {
            try {
                DB::beginTransaction();

                Cliente::create([
                    Cliente::NOM_CLIENTE => $request->nom_cliente,
                    Cliente::NUM_CPF => removeMascara($request->num_cpf),
                    Cliente::NUM_RG => $request->num_rg,
                    Cliente::DSC_ENDERECO => $request->dsc_endereco,
                    Cliente::DSC_BAIRRO => $request->dsc_bairro,
                    Cliente::DSC_CIDADE => $request->dsc_cidade,
                    Cliente::DSC_UF => $request->dsc_uf,
                    Cliente::NUM_CEP => removeMascara($request->num_cep),
                    Cliente::DAT_NASCIMENTO => dateDB($request->dat_nascimento),
                    Cliente::DSC_SEXO => $request->dsc_sexo,
                    Cliente::FLG_ATIVO => Cliente::CLIENTE_ATIVO
                ]);

                Auditoria::adicionar('Cadastro de Cliente', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' cadastrou o cliente ' . $request->nom_cliente);
                DB::commit();
                return SuccessResponse();
            } catch (\Exception $e) {
                DB::rollBack();
                return ErrorResponse($e);
            }
        }

        return $existe;
    }

    public function excluirCliente(int $codCliente)
    {
        $cliente = Cliente::find($codCliente);

        try {
            DB::beginTransaction();
            Cliente::where('cod_cliente', $codCliente)->delete();
            Auditoria::adicionar('Exclusão de Cliente', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' excluiu o cliente ' . $cliente->nom_cliente);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function alterarCliente($codCliente, Request $request)
    {
        $cliente = Cliente::find($codCliente);

        try {
            DB::beginTransaction();

            $cliente->update([
                Cliente::NOM_CLIENTE => $request->nom_cliente,
                Cliente::NUM_CPF => removeMascara($request->num_cpf),
                Cliente::NUM_RG => $request->num_rg,
                Cliente::DSC_ENDERECO => $request->dsc_endereco,
                Cliente::DSC_BAIRRO => $request->dsc_bairro,
                Cliente::DSC_CIDADE => $request->dsc_cidade,
                Cliente::DSC_UF => $request->dsc_uf,
                Cliente::NUM_CEP => removeMascara($request->num_cep),
                Cliente::DAT_NASCIMENTO => dateDB($request->dat_nascimento),
                Cliente::DSC_SEXO => $request->dsc_sexo,
                Cliente::FLG_ATIVO => $request->flg_ativo
            ]);

            Auditoria::adicionar('Alteração de Cliente', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' alterou o cliente ' . $cliente->nom_cliente);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function ativarCliente(int $codCliente)
    {
        $cliente = Cliente::find($codCliente);

        try {
            DB::beginTransaction();

            $cliente->update([
                Cliente::FLG_ATIVO => Cliente::CLIENTE_ATIVO
            ]);

            Auditoria::adicionar('Ativar Cliente', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' ativou o cliente ' . $cliente->nom_cliente);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }

    public function inativarCliente(int $codCliente)
    {
        $cliente = Cliente::find($codCliente);

        try {
            DB::beginTransaction();

            $cliente->update([
                Cliente::FLG_ATIVO => Cliente::CLIENTE_INATIVO
            ]);

            Auditoria::adicionar('Inativar Cliente', $this->currentUser->cod_usuario, 'O usuário ' . $this->currentUser->nom_usuario . ' inativou o cliente ' . $cliente->nom_cliente);
            DB::commit();
            return SuccessResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return ErrorResponse($e);
        }
    }
}
