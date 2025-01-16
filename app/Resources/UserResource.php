<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;


class UserResource extends JsonResource
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
                'email'=>$this->email,
                'role'=>$this->role,
            ] ;
    }
}
