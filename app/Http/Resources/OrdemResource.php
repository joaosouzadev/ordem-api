<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrdemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->user,
            'cliente' => $this->cliente,
            'data_entrada' => $this->data_entrada,
            'data_previsao' => $this->data_previsao,
            'data_entrega' => $this->data_entrega,
            'situacao' => $this->situacao,
            'valor' => $this->valor,
            'equipamento' => $this->equipamento,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'numero_serie' => $this->numero_serie,
            'garantia' => $this->garantia,
            'observacoes' => $this->observacoes,
            'servicos' => $this->servicos,
        ];
    }
}
