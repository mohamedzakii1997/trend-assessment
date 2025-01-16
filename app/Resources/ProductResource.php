<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;


class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {


        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'stock'=>$this->stock,
            'price'=>$this->price,
            'category' => $this->whenLoaded('category', fn () => CategoryResource::make($this->category)),

        ];
    }
}
