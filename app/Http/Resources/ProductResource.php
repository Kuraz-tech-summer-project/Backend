<?php

namespace App\Http\Resources;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray( $request)
    {
        return [
            // 'id' => $this->id,
            // 'quantity' => $this->quantity,
            'price' => $this->price,
            'date' => $this->date,
            'category' => $this->category,
        ];
    }
}
