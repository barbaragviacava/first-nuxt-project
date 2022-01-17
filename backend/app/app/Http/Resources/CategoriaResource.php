<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoriaResource extends JsonResource
{
    public $preserveKeys = true;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'active' => (bool)$this->active,
            'categoria_pai_id' => $this->categoria_pai_id,
            'categoriasFilhas' => CategoriaResource::collection($this->whenLoaded('categoriasFilhas')),
            'categoriaPai' => new CategoriaResource($this->whenLoaded('categoriaPai')),
        ];
    }
}
