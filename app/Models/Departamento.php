<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    const TABLE = 'tab_departamento';
    const COD_DEPARTAMENTO = 'cod_departamento';
    const NOM_DEPARTAMENTO = 'nom_departamento';
    const FLG_ATIVO = 'flg_ativo';
    const CREATED_AT = null;
    const UPDATED_AT = null;
    const DELETED_AT = null;

    //Constantes
    const DEPARTAMENTO_ATIVO = 1;
    const DEPARTAMENTO_INATIVO = 0;

    protected $table = self::TABLE;
    public $primaryKey = self::COD_DEPARTAMENTO;

    public $fillable = [
        self::COD_DEPARTAMENTO,
        self::NOM_DEPARTAMENTO,
        self::FLG_ATIVO
    ];

    //Carbon Dates
    protected $dates = [
        self::DELETED_AT,
        self::CREATED_AT,
        self::UPDATED_AT
    ];
}
