<?php

namespace App\Http\Resources;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchProduct extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [

            'category'=>$this->category,
            'price'=>$this->price
        ];

    }
}
