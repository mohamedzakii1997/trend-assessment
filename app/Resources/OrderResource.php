<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;


class OrderResource extends JsonResource
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
            'amount'=>$this->amount,
            'customer'=>$this->whenLoaded('user', fn () => UserResource::make($this->user)),
            'products' => $this->whenLoaded('products', fn () => FrontProductResource::collection($this->products)),

        ];
    }
}
