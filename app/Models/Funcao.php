<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcao extends Model
{
    use HasFactory;

    const TABLE = 'tab_funcao';
    const COD_FUNCAO = 'cod_funcao';
    const NOM_FUNCAO = 'nom_funcao';
    const FLG_ATIVO = 'flg_ativo';
    const CREATED_AT = null;
    const UPDATED_AT = null;
    const DELETED_AT = null;

    //Constantes
    const FUNCAO_ATIVA = 1;
    const FUNCAO_INATIVA = 0;

    protected $table = self::TABLE;
    public $primaryKey = self::COD_FUNCAO;

    public $fillable = [
        self::COD_FUNCAO,
        self::NOM_FUNCAO,
        self::FLG_ATIVO
    ];

    //Carbon Dates
    protected $dates = [
        self::DELETED_AT,
        self::CREATED_AT,
        self::UPDATED_AT
    ];
}
