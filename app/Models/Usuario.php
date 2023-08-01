<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Usuario
 * @package App\Models
 */
class Usuario extends Authenticatable implements JWTSubject
{
    use HasFactory, HasApiTokens, Notifiable;

    const TABLE = 'tab_usuario';
    const COD_USUARIO = 'cod_usuario';
    const NOM_USUARIO = 'nom_usuario';
    const SIG_USUARIO = 'sig_usuario';
    const DSC_SENHA = 'dsc_senha';
    const DSC_EMAIL = 'dsc_email';
    const FLG_ATIVO = 'flg_ativo';
    const NUM_TOKEN = 'num_token';
    const FLG_EMAIL_CONFIRMADO = 'flg_email_confirmado';
    const CPF_USUARIO = 'cpf_usuario';
    const COD_PERFIL = 'cod_perfil';
    const CREATED_AT = null;
    const UPDATED_AT = null;
    const DELETED_AT = null;

    //Constantes
    const USUARIO_ATIVO = 1;
    const USUARIO_INATIVO = 0;
    const USUARIO_FLG_EMAIL_CONFIRMADO = 1;
    const USUARIO_FLG_EMAIL_NAO_CONFIRMADO = 0;
    const USUARIO_TOKEN_ZERADO = 0;

    protected $table = self::TABLE;
    public $primaryKey = self::COD_USUARIO;

    public $fillable = [
        self::COD_USUARIO,
        self::NOM_USUARIO,
        self::SIG_USUARIO,
        self::DSC_SENHA,
        self::DSC_EMAIL,
        self::FLG_ATIVO,
        self::NUM_TOKEN,
        self::NOM_USUARIO,
        self::FLG_EMAIL_CONFIRMADO,
        self::CPF_USUARIO,
        self::COD_PERFIL
    ];

    //Carbon Dates
    protected $dates = [
        self::DELETED_AT,
        self::CREATED_AT,
        self::UPDATED_AT
    ];

    /*
     * JWT
     */
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function perfil()
    {
        return $this->hasOne(Perfil::class, Perfil::COD_PERFIL, self::COD_PERFIL);
    }
}
