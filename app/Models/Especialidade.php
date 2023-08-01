<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    use HasFactory;

    const TABLE = 'tab_especialidade';
    const COD_ESPECIALIDADE = 'cod_especialidade';
    const NOM_ESPECIALIDADE = 'nom_especialidade';
    const FLG_ATIVO = 'flg_ativo';
    const CREATED_AT = null;
    const UPDATED_AT = null;
    const DELETED_AT = null;

    //Constantes
    const ESPECIALIDADE_ATIVA = 1;
    const ESPECIALIDADE_INATIVA = 0;

    protected $table = self::TABLE;
    public $primaryKey = self::COD_ESPECIALIDADE;

    public $fillable = [
        self::COD_ESPECIALIDADE,
        self::NOM_ESPECIALIDADE,
        self::FLG_ATIVO
    ];

    //Carbon Dates
    protected $dates = [
        self::DELETED_AT,
        self::CREATED_AT,
        self::UPDATED_AT
    ];
}
