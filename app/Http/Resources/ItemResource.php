<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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

        $url = url("/") . '/photo/Item/' ;

        $category = $this->category;

        $counting_units = $this->counting_units()->whereColumn('current_quantity', ">" ,'reorder_quantity')->get(array('id','unit_name','current_quantity','normal_sale_price','whole_sale_price'));

        return [
            'item_id' => $this->id,
            'item_code' => $this->item_code,
            'item_name' => $this->item_name,
            'category' => $category->category_name,
            'photo' => $url . $this->photo_path,
            'counting_unit' => $counting_units,
        ];
    }
}
