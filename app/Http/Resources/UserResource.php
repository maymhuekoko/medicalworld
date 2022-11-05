<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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

        $url = url("/") . '/photo/' ;


        return [
            'id' => $this->id,
            'user_code' => $this->user_code,
            'email' => $this->email,
            'role' => $this->role,
            'photo_path' => $url . $this->photo_path,
        ];
    }
}
