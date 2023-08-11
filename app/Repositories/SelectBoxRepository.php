<?php

namespace App\Repositories;

use App\Models\Perfil;
use App\Utils\ConstanteSistema;
use Illuminate\Support\Facades\DB;

class SelectBoxRepository extends BaseRepository
{
    private $perfis;

    public function __construct()
    {
        $this->perfis = new Perfil();
    }

    public function perfis()
    {
        $consulta = DB::table(Perfil::TABLE);
        $consulta->select(Perfil::COD_PERFIL . ConstanteSistema::AS_ID, Perfil::NOM_PERFIL . ConstanteSistema::AS_NAME);
        $consulta->where(Perfil::FLG_ATIVO, '1');
        $consulta->orderBy(Perfil::NOM_PERFIL);

        return $consulta->distinct()->get();
    }
}
