<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    const TABLE = 'tab_perfil';
    const COD_PERFIL = 'cod_perfil';
    const NOM_PERFIL = 'nom_perfil';
    const FLG_ATIVO = 'flg_ativo';
    const CREATED_AT = null;
    const UPDATED_AT = null;
    const DELETED_AT = null;

    //Constantes
    const PERFIL_ATIVO = 1;
    const PERFIL_INATIVO = 0;

    protected $table = self::TABLE;
    public $primaryKey = self::COD_PERFIL;

    public $fillable = [
        self::COD_PERFIL,
        self::NOM_PERFIL,
        self::FLG_ATIVO
    ];

    //Carbon Dates
    protected $dates = [
        self::DELETED_AT,
        self::CREATED_AT,
        self::UPDATED_AT
    ];
}
