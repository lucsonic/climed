<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    use HasFactory;

    const TABLE = 'tab_permissao';
    const COD_PERMISSAO = 'cod_permissao';
    const COD_USUARIO = 'cod_usuario';
    const MOD_USUARIO = 'mod_usuario';
    const MOD_PERFIL = 'mod_perfil';
    const MOD_ESPECIALIDADE = 'mod_especialidade';
    const MOD_FUNCAO = 'mod_funcao';
    const MOD_DEPARTAMENTO = 'mod_departamento';
    const MOD_CLIENTE = 'mod_cliente';
    const CREATED_AT = null;
    const UPDATED_AT = null;
    const DELETED_AT = null;

    protected $table = self::TABLE;
    public $primaryKey = self::COD_PERMISSAO;

    public $fillable = [
        self::COD_PERMISSAO,
        self::COD_USUARIO,
        self::MOD_USUARIO,
        self::MOD_PERFIL,
        self::MOD_ESPECIALIDADE,
        self::MOD_FUNCAO,
        self::MOD_DEPARTAMENTO,
        self::MOD_CLIENTE
    ];

    //Carbon Dates
    protected $dates = [
        self::DELETED_AT,
        self::CREATED_AT,
        self::UPDATED_AT
    ];

    public function usuario()
    {
        return $this->hasOne(Usuario::class, Usuario::COD_USUARIO, self::COD_USUARIO);
    }
}
