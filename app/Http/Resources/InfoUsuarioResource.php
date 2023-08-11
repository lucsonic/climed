<?php

namespace App\Http\Resources;

use App\Models\Perfil;
use App\Models\Usuario;
use Illuminate\Http\Resources\Json\JsonResource;

class InfoUsuarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return (array(
            'cod_usuario' => $this->{Usuario::COD_USUARIO},
            'nom_usuario' => $this->{Usuario::NOM_USUARIO},
            'flg_ativo' => $this->{Usuario::FLG_ATIVO},
            'dsc_email' => $this->{Usuario::DSC_EMAIL},
            'perfil' => Perfil::where(Perfil::COD_PERFIL, $this->{Usuario::COD_PERFIL})->get()
        )
        );
    }
}
