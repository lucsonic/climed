<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    const TABLE = 'tab_cliente';
    const COD_CLIENTE = 'cod_cliente';
    const NOM_CLIENTE = 'nom_cliente';
    const NUM_CPF = 'num_cpf';
    const NUM_RG = 'num_rg';
    const DSC_ENDERECO = 'dsc_endereco';
    const DSC_BAIRRO = 'dsc_bairro';
    const DSC_CIDADE = 'dsc_cidade';
    const DSC_UF = 'dsc_uf';
    const NUM_CEP = 'num_cep';
    const DAT_NASCIMENTO = 'dat_nascimento';
    const DSC_SEXO = 'dsc_sexo';
    const FLG_ATIVO = 'flg_ativo';
    const CREATED_AT = null;
    const UPDATED_AT = null;
    const DELETED_AT = null;

    //Constantes
    const CLIENTE_ATIVO = 1;
    const CLIENTE_INATIVO = 0;

    protected $table = self::TABLE;
    public $primaryKey = self::COD_CLIENTE;

    public $fillable = [
        self::COD_CLIENTE,
        self::NOM_CLIENTE,
        self::NUM_CPF,
        self::NUM_RG,
        self::DSC_ENDERECO,
        self::DSC_BAIRRO,
        self::DSC_CIDADE,
        self::DSC_UF,
        self::NUM_CEP,
        self::DAT_NASCIMENTO,
        self::DSC_SEXO,
        self::FLG_ATIVO
    ];

    //Carbon Dates
    protected $dates = [
        self::DAT_NASCIMENTO,
        self::DELETED_AT,
        self::CREATED_AT,
        self::UPDATED_AT
    ];
}
