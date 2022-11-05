<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountingUnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        $item = $this->item;

        return [
            'counting_unit_id' => $this->id,
            'unit_name' => $this->unit_name,
            'quantity' => $this->current_quantity,
            'normal_sale_price' => $this->normal_sale_price,
            'whole_sale_price' => $this->whole_sale_price,
            'item' => $item->item_name,
        ];
    }
}
