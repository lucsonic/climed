<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    const TABLE = 'tab_funcionario';
    const COD_FUNCIONARIO = 'cod_funcionario';
    const NOM_FUNCIONARIO = 'nom_funcionario';
    const NUM_CPF = 'num_cpf';
    const DSC_EMAIL = 'dsc_email';
    const NUM_RG = 'num_rg';
    const DSC_ENDERECO = 'dsc_endereco';
    const DSC_BAIRRO = 'dsc_bairro';
    const DSC_CIDADE = 'dsc_cidade';
    const DSC_UF = 'dsc_uf';
    const NUM_CEP = 'num_cep';
    const DAT_NASCIMENTO = 'dat_nascimento';
    const DSC_SEXO = 'dsc_sexo';
    const NUM_CRM = 'num_crm';
    const FLG_ESPECIALIDADE = 'flg_especialidade';
    const FLG_ATIVO = 'flg_ativo';
    const COD_DEPARTAMENTO = 'cod_departamento';
    const COD_FUNCAO = 'cod_funcao';
    const COD_ESPECIALIDADE = 'cod_especialidade';
    const CREATED_AT = null;
    const UPDATED_AT = null;
    const DELETED_AT = null;

    //Constantes
    const FUNCIONARIO_ATIVO = 1;
    const FUNCIONARIO_INATIVO = 0;

    protected $table = self::TABLE;
    public $primaryKey = self::COD_FUNCIONARIO;

    public $fillable = [
    self::COD_FUNCIONARIO,
    self::NOM_FUNCIONARIO,
    self::NUM_CPF,
    self::DSC_EMAIL,
    self::NUM_RG,
    self::DSC_ENDERECO,
    self::DSC_BAIRRO,
    self::DSC_CIDADE,
    self::DSC_UF,
    self::NUM_CEP,
    self::DAT_NASCIMENTO,
    self::DSC_SEXO,
    self::NUM_CRM,
    self::FLG_ESPECIALIDADE,
    self::FLG_ATIVO,
    self::COD_DEPARTAMENTO,
    self::COD_FUNCAO,
    self::COD_ESPECIALIDADE
    ];

    //Carbon Dates
    protected $dates = [
        self::DAT_NASCIMENTO,
        self::DELETED_AT,
        self::CREATED_AT,
        self::UPDATED_AT
    ];
}
