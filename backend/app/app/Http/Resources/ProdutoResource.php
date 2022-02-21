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
            'categoria_id' => $this->categoria_id,
            'preco' => $this->preco,
            'categoria' => new CategoriaResource($this->whenLoaded('categoria')),
            'active' => (bool)$this->active,
        ];
    }
}
