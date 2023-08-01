<?php

namespace App\Http\Resources;

use App\Models\Auditoria;
use Illuminate\Http\Resources\Json\JsonResource;

class AuditoriaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            Auditoria::COD_AUDITORIA => $this->{Auditoria::COD_AUDITORIA},
            Auditoria::DSC_TITULO => $this->{Auditoria::DSC_TITULO},
            Auditoria::DAT_CADASTRO => $this->{Auditoria::DAT_CADASTRO}->format('d/m/Y H:i:s'),
            'usuario' => $this->usuario
        ];
    }
}
