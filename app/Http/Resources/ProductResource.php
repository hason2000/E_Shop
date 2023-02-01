<?php

namespace App\Http\Resources;

use App\Models\Tag;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        TagResource::withoutWrapping();
        return [
            'id' => $this->id,
            'product_name' => $this->name,
            'product_price' => $this->price,
//            'tags' => TagResource::collection($this->tags)
            'tags' => TagResource::collection($this->whenLoaded('tags'))
        ];
    }
}
