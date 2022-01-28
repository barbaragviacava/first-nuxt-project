<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProdutoResource extends JsonResource
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'active' => (bool)$this->active,
            'categoria_id' => $this->categoria_id,
            'categoria' => new CategoriaResource($this->whenLoaded('categoria')),
        ];
    }
}
