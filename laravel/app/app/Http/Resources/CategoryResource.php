<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public $preserveKeys = true;

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'active' => (bool)$this->active,
            'parent_category_id' => $this->parent_category_id,
            'childCategories' => self::collection($this->whenLoaded('childCategories')),
            'parentCategory' => new self($this->whenLoaded('parentCategory')),
        ];
    }
}
