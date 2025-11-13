<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'note' => $this->id_note,
            'date' => $this->date,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'subtotal' => $this->subtotal,
            'products' => SaleItemResource::collection($this->whenLoaded('saleItems'))
        ];
    }
}
