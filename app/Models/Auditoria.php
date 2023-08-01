<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    use HasFactory;

    const TABLE = 'tab_auditoria';
    const COD_AUDITORIA = 'cod_auditoria';
    const DSC_TITULO = 'dsc_titulo';
    const DAT_CADASTRO = 'dat_cadastro';
    const COD_USUARIO = 'cod_usuario';
    const NUM_IP = 'num_ip';
    const DSC_DETALHADA = 'dsc_detalhada';
    const CREATED_AT = null;
    const UPDATED_AT = null;
    const DELETED_AT = null;

    protected $table = self::TABLE;
    public $primaryKey = self::COD_AUDITORIA;

    public $fillable = [
        self::COD_AUDITORIA,
        self::DSC_TITULO,
        self::DAT_CADASTRO,
        self::COD_USUARIO,
        self::NUM_IP,
        self::DSC_DETALHADA
    ];

    //Carbon Dates
    protected $dates = [
        self::DELETED_AT,
        self::CREATED_AT,
        self::UPDATED_AT
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, Usuario::COD_USUARIO, self::COD_USUARIO);
    }

    public static function adicionar($dsc, $user = null, $descricao = null)
    {
        $log = new self;
        $log->dsc_titulo = $dsc;
        $log->cod_usuario = !empty($user) ? $user : null;
        $log->dat_cadastro = Carbon::now();
        $log->num_ip = $_SERVER['REMOTE_ADDR'] != '127.0.0.1' ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
        $log->dsc_detalhada = $descricao;
        $log->save();
    }
}
