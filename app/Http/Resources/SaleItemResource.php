<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $stock = (new StockResource($this->whenLoaded('stock')))->toArray($request);
        return [
            ...$stock,
            'qty' => $this->qty
        ];
    }
}
